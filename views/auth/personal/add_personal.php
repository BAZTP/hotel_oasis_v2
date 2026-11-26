<?php require base_path('views/partials/head.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <div class="flex justify-between">
            <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Añadir Personal</h1>
            <div class="mt-4 flex flex-row justify-end gap-x-4">
                <div class="flex gap-x-7">
                    
                    <a href="/auth/personal" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
                </div>
            </div>
        </div>
        
        <form class="mt-4 flex w-full flex-col" action="/auth/personal/crear" method="POST">
            <h1 class="w-full mt-4 border-b py-2 text-1xl font-semibold text-text-50 border-b-accent-800">Datos de Identificación</h1>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                <div class="mt-2 flex flex-col">
                    <label for="cedula" class="px-2 text-m text-text-50">Cédula <span class="text-red-500">*</span>:</label>
                    <input type="text" name="cedula" id="cedula" class="inp" placeholder="Ingrese la cédula" required>
                </div>
            </div>
            <h1 class="w-full border-b py-2 text-1xl font-semibold text-text-50 border-b-accent-800">Datos Personales</h1>
            <div class="mt-2 grid grid-cols-1 gap-2 md:grid-cols-3">
                <div class="mt-1 flex flex-col">
                    <label for="nombre" class="px-2 text-m text-text-50">Nombre <span class="text-red-500">*</span>:</label>
                    <input type="text" name="nombre" id="nombre" class="inp mayusculas" placeholder="Ingrese el Nombre" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
                <div class="mt-1 flex flex-col">
                    <label for="apellido" class="px-2 text-m text-text-50">Apellido <span class="text-red-500">*</span>:</label>
                    <input type="text" name="apellido"  id="apellido" class="inp mayusculas" placeholder="Ingrese el Apellido" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
                <div class="flex flex-col">
                    <label for="fecha_nacimiento" class="text-lg text-text-50">Fecha De Nacimiento <span class="text-red-500">*</span>:</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="inp" placeholder="Fecha de Nacimineto" required>
                </div>
            </div>
            <div class="mt-1 flex flex-col">
                <label for="direccion" class="px-2 text-m text-text-50">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="inp mayusculas" placeholder="Ingrese su dirección">
            </div>
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="mt-1 flex flex-col">
                    <label for="telefono" class="px-2 text-m text-text-50">Teléfono Móvil <span class="text-red-500">*</span>:</label>
                    <input type="text" name="telefono" id="telefono" class="inp" placeholder="Ingrese el Teléfono Móvil" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="mt-1 flex flex-col">
                    <label for="email" class="px-2 text-m text-text-50">Email <span class="text-red-500">*</span>:</label>
                    <input type="email" name="email" class="inp" placeholder="Ingrese el Correo Electrónico" required>
                </div>
            </div>
            <h1 class="w-full mt-4 border-b py-2 text-1xl font-semibold text-text-50 border-b-accent-800">Datos Laborales</h1>
            <div class="mt-2 grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label for="tipo_cargo" class="text-m text-text-50">
                        <span>Tipo de Cargo: <span class="text-red-500">*</span></span>
                        <select name="tipo_cargo" id="tipo_cargo" class="inp" required onchange="actualizarTipoSueldo()">
                            <option value="" selected disabled>Tipo de Cargo</option>
                            <?php foreach ($tipo_cargo as $tipo_cargos): ?>
                                <option value="<?= $tipo_cargos['TIP_CAR_ID'] ?>" data-valor="<?= $tipo_cargos['TIP_CAR_SUELD'] ?>">
                                    <?= $tipo_cargos['TIP_CAR_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="flex flex-col">
                    <label for="sueldo" class="px-2 text-m text-text-50">Tipo de Sueldo:</label>
                    <div class="relative">
                        <span class="absolute z-50 left-2 top-1/2 transform -translate-y-1/2 text-black">$</span>
                        <input type="text" name="sueldo" id="sueldo" class="inp pl-8" placeholder="0" value="0" readOnly>
                    </div>
                </div>
            </div>
            
            <h1 class="w-full mt-4 border-b py-2 text-1xl font-semibold text-text-50 border-b-accent-800">Datos Bancarios</h1>
            <div class="mt-2 grid grid-cols-1 gap-2 md:grid-cols-3">
                <div class="mt-1 flex flex-col">
                    <label for="tipo_banco" class="text-m text-text-50">
                        <span>Banco:<span class="text-red-500">*</span></span>
                        <select name="tipo_banco" id="tipo_banco" class="inp" required>
                            <option value="" selected disabled>Banco</option>
                            <?php foreach ($tipo_banco as $tipo_bancos): ?>
                                <option value="<?= $tipo_bancos['TIP_BANCO_ID'] ?>">
                                    Banco - <?= $tipo_bancos['TIP_BANCO_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="mt-1 flex flex-col">
                    <label for="tipo_cuenta" class="text-m text-text-50">
                        <span>Tipo de Cuenta:<span class="text-red-500">*</span></span>
                        <select name="tipo_cuenta" id="tipo_cuenta" class="inp" required>
                            <option value="" selected disabled>Tipo de Cuenta</option>
                            <?php foreach ($tipo_cuenta as $tipo_cuentas): ?>
                                <option value="<?= $tipo_cuentas['TIP_CUENT_ID'] ?>">
                                    Cuenta - <?= $tipo_cuentas['TIP_CUENT_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="mt-1 flex flex-col">
                    <label for="cuenta_bancaria" class="px-2 text-m text-text-50">Nro. Cuenta <span class="text-red-500">*</span>:</label>
                    <input type="text" name="cuenta_bancaria" class="inp" placeholder="Ingrese el Número de Cuenta Bancaria" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
            </div>
            <h1 class="w-full mt-4 border-b py-2 text-1xl font-semibold text-text-50 border-b-accent-800">Datos de Contacto de Emergencia</h1>
            <div class="mt-2 grid grid-cols-1 gap-2 md:grid-cols-3">
                <div class="mt-1 flex flex-col">
                    <label for="nombre_emer" class="px-2 text-m text-text-50">Nombre <span class="text-red-500">*</span>:</label>
                    <input type="text" name="nombre_emer" class="inp mayusculas" placeholder="Ingrese el Nombre" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>
                <div class="mt-1 flex flex-col">
                    <label for="telefono_emer" class="px-2 text-m text-text-50">Teléfono Móvil <span class="text-red-500">*</span>:</label>
                    <input type="text" name="telefono_emer" class="inp" placeholder="Ingrese el Teléfono Móvil" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="mt-1 flex flex-col">
                    <label for="tipo_relacion" class="text-m text-text-50">
                        <span>Relación:</span>
                        <select name="tipo_relacion" id="tipo_relacion" class="inp" >
                            <option value="" selected disabled>Relación</option>
                            <?php foreach ($tipo_relacion as $tipo_relaciones): ?>
                                <option value="<?= $tipo_relaciones['REL_EMER_ID'] ?>">
                                    <?= $tipo_relaciones['REL_EMER_DESCR'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </div>
            <div class="mt-5">
                <button type="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">
                    Añadir Personal
                </button>
            </div>
            <div id="error-message" class="text-red-500"></div>
        </form>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php if (isset($error)):
        switch($error):
            case '1': ?>
                <script src="/js/alertas/validacion_cedula/alertNoEcuador.js"></script>
            <?php break; ?>
            <?php case '2': ?>
                <script src="/js/alertas/validacion_cedula/alertFaltaDigitos.js"></script>
            <?php break; ?>
            <?php case '3': ?>
                <script src="/js/alertas/validacion_cedula/alertNoProvincia.js"></script>
            <?php break; ?>
            <?php case '4': ?>
                <script src="/js/alertas/validacion_cedula/alertCedulaIncorrecta.js"></script>
            <?php break; ?>
            <?php case '5': ?>
                <script src="/js/alertas/validacion_cedula/cedulaRepetida.js"></script>
            <?php break; ?>
        <?php endswitch;
    endif; ?>
<script src="/js/auth/personal/add_personal.js"></script>
<?php require base_path('views/partials/end.php'); ?>