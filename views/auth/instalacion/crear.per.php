<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Seleccionar Personal</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
            <a href="/auth/instalacion/seleccionarpersonal" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>
        <form class="mt-4 flex w-full flex-col" method="POST" action="/auth/instalacion/seleccionar" onsubmit="return handleSubmit(event)">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label for="tipo_instalaciones" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Seleccionar Instalación:</span>
                        <select name="tipo_instalaciones" id="tipo_instalaciones" class="inp appearance-none">
                            <option value="" selected disabled>Seleccionar Instalación</option>
                            <?php foreach ($tipo_instalaciones as $tipo_instalacion): ?>
                                <option value="<?= $tipo_instalacion['INS_ID'] ?>">
                                     <?= $tipo_instalacion['TIP_INS_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="flex flex-col">
                    <label for="tipo_personales" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Seleccionar Personal:</span>
                        <select name="tipo_personales" id="tipo_personales" class="inp appearance-none">
                            <option value="" selected disabled>Seleccionar Personal</option>
                            <?php foreach ($tipo_personales as $tipo_personal): ?>
                                <option value="<?= $tipo_personal['PERS_ID'] ?>">
                                     <?= $tipo_personal['PERS_NOM'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Crear</button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleSubmit(event) {
        event.preventDefault();

        const tipoInstalaciones = document.getElementById('tipo_instalaciones').value;
        const tipoPersonales = document.getElementById('tipo_personales').value;

        if (tipoInstalaciones === '' || tipoPersonales === '') {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error. Por favor, inténtalo de nuevo.",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            Swal.fire({
                title: "Enviado!",
                text: "Formulario enviado correctamente",
                icon: "success",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                document.querySelector('form').submit();
            });
        }
        
        if (tipoInstalaciones === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona una instalación.",
                icon: "error",
                showConfirmButton: true
            });
        } else if (tipoPersonales === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona un personal.",
                icon: "error",
                showConfirmButton: true
            });
        } else {
            Swal.fire({
                title: "Enviado!",
                text: "Formulario enviado correctamente",
                icon: "success",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                document.querySelector('form').submit();
            });
        }

        return false; 
    }
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
