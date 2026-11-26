-- ========================================================
-- Script de Migración y Tablas Faltantes - Base de Datos OASIS
-- Compatible con MySQL / MariaDB (phpMyAdmin o MySQL Workbench)
-- ========================================================

USE `oasis`;

-- Desactivar el modo seguro de actualización temporalmente (para evitar Error 1175 en Workbench)
SET SQL_SAFE_UPDATES = 0;

-- --------------------------------------------------------
-- 1. Ampliar campos de usuarios para permitir correos y hashes largos
-- --------------------------------------------------------
ALTER TABLE `seg_usuario` 
    MODIFY COLUMN `USU_NOM` VARCHAR(100) NOT NULL,
    MODIFY COLUMN `USU_CON_HAS` VARCHAR(255) NOT NULL,
    MODIFY COLUMN `USU_ROL` VARCHAR(50) NOT NULL;

-- --------------------------------------------------------
-- 2. Tabla: pers_tipo_cuenta (Tipos de cuenta bancaria del personal)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pers_tipo_cuenta` (
    `TIP_CUENT_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `TIP_CUENT_DES` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `pers_tipo_cuenta` (`TIP_CUENT_ID`, `TIP_CUENT_DES`) VALUES 
(1, 'Ahorros'),
(2, 'Corriente');

-- --------------------------------------------------------
-- 3. Tabla: pers_estado (Estados del personal: Activo, Inactivo, etc.)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pers_estado` (
    `PERS_EST_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `PERS_EST_DESC` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `pers_estado` (`PERS_EST_ID`, `PERS_EST_DESC`) VALUES 
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Vacaciones');

-- --------------------------------------------------------
-- 4. Tablas intermedias de servicios por defecto en habitaciones y salones
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `adm_def_tip_hab_ser` (
    `DEF_TIP_HAB_SER_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `TIP_HAB_ID` INT NOT NULL,
    `SER_ID` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `adm_def_tip_sal_ser` (
    `DEF_TIP_SAL_SER_ID` INT AUTO_INCREMENT PRIMARY KEY,
    `TIP_SAL_ID` INT NOT NULL,
    `SER_ID` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 5. Tablas para el módulo de Ingresos (Caja y cobros)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ing_reg_ingresos` (
    `ing_reg_id` INT AUTO_INCREMENT PRIMARY KEY,
    `ing_reg_ced` VARCHAR(20) NOT NULL,
    `ing_reg_nom` VARCHAR(100) NOT NULL,
    `ing_reg_direccion` VARCHAR(255) NULL,
    `ing_reg_telefono` VARCHAR(20) NULL,
    `ing_reg_email` VARCHAR(100) NULL,
    `ing_reg_metodo_pago` VARCHAR(50) NOT NULL,
    `ing_reg_monto_total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `ing_reg_monto_pagar` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `ing_reg_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ing_reg_reservas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ing_reg_id` INT NOT NULL,
    `res_reserva_id` INT NOT NULL,
    `ing_reserva_monto` DECIMAL(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ing_reg_servicios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `ing_reg_id` INT NOT NULL,
    `tip_serv_id` INT NOT NULL,
    `ing_servicio_monto` DECIMAL(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 6. Agregar columnas faltantes en tablas existentes
-- --------------------------------------------------------

-- En pers_personal (Estado y Tipo de Cuenta)
ALTER TABLE `pers_personal` 
    ADD COLUMN IF NOT EXISTS `PERS_EST_ID` INT NOT NULL DEFAULT 1,
    ADD COLUMN IF NOT EXISTS `TIP_CUENT_ID` INT NOT NULL DEFAULT 1;

UPDATE `pers_personal` 
SET `PERS_EST_ID` = 1 
WHERE `PERS_ID` > 0 AND (`PERS_EST_ID` IS NULL OR `PERS_EST_ID` = 0);

UPDATE `pers_personal` 
SET `TIP_CUENT_ID` = 1 
WHERE `PERS_ID` > 0 AND (`TIP_CUENT_ID` IS NULL OR `TIP_CUENT_ID` = 0);

-- En inventarios (Stock general, por habitación, instalación y salón)
ALTER TABLE `adm_inv_gen` 
    ADD COLUMN IF NOT EXISTS `INV_GEN_STOCK` INT NOT NULL DEFAULT 0;

ALTER TABLE `adm_inv_hab` 
    ADD COLUMN IF NOT EXISTS `INV_HAB_STOCK` INT NOT NULL DEFAULT 0;

ALTER TABLE `adm_inv_ins` 
    ADD COLUMN IF NOT EXISTS `INV_INS_STOCK` INT NOT NULL DEFAULT 0;

ALTER TABLE `adm_inv_sal` 
    ADD COLUMN IF NOT EXISTS `INV_SAL_STOCK` INT NOT NULL DEFAULT 0;

-- En promociones de servicios (Estado de la promoción)
ALTER TABLE `mark_prom_serv` 
    ADD COLUMN IF NOT EXISTS `prom_serv_est` VARCHAR(20) NOT NULL DEFAULT 'activo';

-- En clientes (Dirección del cliente)
ALTER TABLE `mark_cliente` 
    ADD COLUMN IF NOT EXISTS `direccion` VARCHAR(255) NULL DEFAULT 'Sin dirección';

-- En egresos (Estado del egreso: activo/inactivo)
ALTER TABLE `egr_egreso` 
    ADD COLUMN IF NOT EXISTS `EGR_ESTADO` VARCHAR(20) NOT NULL DEFAULT 'activo';

UPDATE `egr_egreso` 
SET `EGR_ESTADO` = 'activo' 
WHERE `EGR_ID` > 0 AND (`EGR_ESTADO` IS NULL OR `EGR_ESTADO` = '');

-- En tipos de egreso (Asegurar nombre de columna EGR_TIPO_ID)
-- Si la columna se llamaba EGR_ID, la renombramos a EGR_TIPO_ID:
ALTER TABLE `egr_tipo_egreso` 
    CHANGE COLUMN `EGR_ID` `EGR_TIPO_ID` INT AUTO_INCREMENT;

-- En detalles de pago de personal (para Ver Rol de Pago)
ALTER TABLE `pers_pagos_detalles`
    ADD COLUMN IF NOT EXISTS `PERS_DETALLES_FECHA` DATE NULL DEFAULT NULL;

-- Ampliar descripción de auditoría de seguridad
ALTER TABLE `seg_registro_accion`
    MODIFY COLUMN `ACC_DES` VARCHAR(255) NULL;

-- --------------------------------------------------------
-- 7. Usuario Super Administrador
-- --------------------------------------------------------
INSERT INTO `seg_usuario` (`PERS_ID`, `USU_NOM`, `USU_CON_HAS`, `USU_ROL`) 
VALUES (1, 'admin@oasis.com', 'admin123', 'auth')
ON DUPLICATE KEY UPDATE `USU_CON_HAS` = 'admin123', `USU_ROL` = 'auth';

UPDATE `seg_usuario` 
SET `USU_ROL` = 'auth' 
WHERE `USU_ID` > 0 AND `USU_NOM` = 'luis';

-- Restaurar el modo seguro de actualización
SET SQL_SAFE_UPDATES = 1;
