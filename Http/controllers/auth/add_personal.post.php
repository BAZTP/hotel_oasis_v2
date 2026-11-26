<?php
use Core\Database;
use Core\DatabaseException;

function validarCI($strCedula) {
    if (!is_numeric($strCedula)) {
        ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'warning',
                title: 'Es una cédula extranjera. \n¿Desea continuar?',
                showConfirmButton: true
            });
        </script>
        <?php
        // $_SESSION['error'] = '1'; // No es numérica
        // redirect('/auth/personal/crear');
        return false;
    }

    $total_caracteres = strlen($strCedula); // Total de caracteres
    if ($total_caracteres != 10) {
        ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'warning',
                title: 'Falta digitos',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
        <?php
        // $_SESSION['error'] = '2'; // Longitud incorrecta
        // redirect('/auth/personal/crear');
        return false;
    }

    $nro_region = substr($strCedula, 0, 2); // Región
    if ($nro_region < 1 || $nro_region > 24) {
        ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'warning',
                title: 'Este número de cédula no corresponde a ninguna \nprovincia del ecuador',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
        <?php
        // $_SESSION['error'] = '3'; // Región no válida
        // redirect('/auth/personal/crear');
        return false;
    }

    $ult_digito = substr($strCedula, -1); // Último dígito
    $suma_pares = 0;
    $suma_impares = 0;

    for ($i = 0; $i < 9; $i++) {
        $num = substr($strCedula, $i, 1);
        if ($i % 2 == 0) { // Índices pares
            $num = $num * 2;
            if ($num > 9) {
                $num -= 9;
            }
            $suma_impares += $num;
        } else { // Índices impares
            $suma_pares += $num;
        }
    }

    $suma_total = $suma_pares + $suma_impares;
    $decena_superior = (ceil($suma_total / 10) * 10);
    $digito_validador = $decena_superior - $suma_total;
    if ($digito_validador == 10) {
        $digito_validador = 0;
    }

    if ($digito_validador != $ult_digito) {
        ?>
        <script>
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: 'Cédula incorrecta por favor ingrese una cédula valida',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
        <?php
        // $_SESSION['error'] = '4'; // Cédula no válida
        // redirect('/auth/personal/crear');
        return false;
    }

    // Si se llega hasta aquí, la cédula es válida
    return true;
}

$attributes = [
    'nombre' => strtoupper($_POST['nombre']),
    'apellido' => strtoupper($_POST['apellido']),
    'fecha_nacimiento' => $_POST['fecha_nacimiento'],
    'direccion' => strtoupper($_POST['direccion']) ?? null,
    'telefono' => $_POST['telefono'],
    'email' => $_POST['email'],
    'cedula' => $_POST['cedula'],
    'tipo_cargo' => strtoupper($_POST['tipo_cargo']) ?? null,
    'sueldo' => $_POST['sueldo'] ?? null,
    'nombre_emer' => strtoupper($_POST['nombre_emer']),
    'telefono_emer' => $_POST['telefono_emer'],
    'tipo_relacion' => $_POST['tipo_relacion'] ?? null,
    'tipo_banco' => strtoupper($_POST['tipo_banco']),
    'tipo_cuenta' => strtoupper($_POST['tipo_cuenta']),
    'cuenta_bancaria' => $_POST['cuenta_bancaria'],
];

// Recolección de atributos adicionales
foreach ($_POST as $key => $value) {
    if (str_contains($key, 'field_')) {
        $attributes['additional_fields'][$key] = $value;
    }
}

validarCI($attributes['cedula']);

try {
    $db = Database::getInstance();
    
    
    $result = $db->prepare(
        "
            INSERT INTO pers_personal 
            (
            PERS_NOM, 
            PERS_APE,
            PERS_FECH_NACI, 
            PERS_DIRECCION,
            PERS_TELF, 
            PERS_EMAIL, 
            PERS_CED, 
            TIP_CAR_ID, 
            PERS_SUEL, 
            PERS_NOM_EMER,
            PERS_NUM_EMER,
            REL_EMER_ID,
            PERS_NUM_CUENT_BK,
            TIP_BANCO_ID,
            TIP_CUENT_ID
            )
            VALUES 
            (
            :nombre, 
            :apellido, 
            :fecha_nacimiento, 
            :direccion, 
            :telefono, 
            :email, 
            :cedula, 
            :tipo_cargo,
            :sueldo, 
            :nombre_emer, 
            :telefono_emer, 
            :tipo_relacion, 
            :cuenta_bancaria, 
            :tipo_banco, 
            :tipo_cuenta
            );
        "
    );

    $result->bind(':nombre', $attributes['nombre']);
    $result->bind(':apellido', $attributes['apellido']);
    $result->bind(':fecha_nacimiento', $attributes['fecha_nacimiento']);
    $result->bind(':direccion', $attributes['direccion']);
    $result->bind(':telefono', $attributes['telefono']);
    $result->bind(':email', $attributes['email']);
    $result->bind(':cedula', $attributes['cedula']);
    $result->bind(':tipo_cargo', $attributes['tipo_cargo']);
    $result->bind(':sueldo', $attributes['sueldo']);
    $result->bind(':nombre_emer', $attributes['nombre_emer']);
    $result->bind(':telefono_emer', $attributes['telefono_emer']);
    $result->bind(':tipo_relacion', $attributes['tipo_relacion']);
    $result->bind(':cuenta_bancaria', $attributes['cuenta_bancaria']);
    $result->bind(':tipo_banco', $attributes['tipo_banco']);
    $result->bind(':tipo_cuenta', $attributes['tipo_cuenta']);
    
    $result->execute();
    redirect('/auth/personal');
    ?>
    <script>
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Cédula ingresada con éxito',
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            
        });
    </script>
    <?php

    
} catch (DatabaseException $e) {
    die($e->getMessage());
}
redirect('/auth/personal');
