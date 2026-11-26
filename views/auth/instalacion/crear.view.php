<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Instalaciones Horario</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
            <a href="/auth/instalacion" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>
        <form class="mt-4 flex w-full flex-col" method="POST" action="/auth/instalacion/crear" onsubmit="return handleSubmit(event)">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label for="tipo_instalaciones" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Seleccionar Instalación:</span>
                        <select name="tip_instal" id="instal" class="inp appearance-none">
                            <option value="" selected disabled>Seleccionar Instalación</option>
                            <?php foreach ($tipo_instalaciones as $tipo_instalacion): ?>
                                <option value="<?= $tipo_instalacion['TIP_INS_ID'] ?>">
                                    <?= $tipo_instalacion['TIP_INS_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <div class="flex flex-col">
                    <label for="start_time" class="text-lg text-text-50">Hora de Inicio:</label>
                    <input type="time" name="start_time" id="start_time" class="inp" >
                </div>

                <div class="flex flex-col">
                    <label for="end_time" class="text-lg text-text-50">Hora de Fin:</label>
                    <input type="time" name="end_time" id="end_time" class="inp" >
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

        const instalacion = document.getElementById('instal').value;
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;

        if (instalacion === '' || startTime === '' || endTime === '') {
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

        if (instalacion === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona una instalación.",
                icon: "error",
                showConfirmButton: true
            });
        } else if (startTime === '' || endTime === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona las horas de inicio y fin.",
                icon: "error",
                showConfirmButton: true
            });
        } else if (startTime >= endTime) {
            Swal.fire({
                title: "Error",
                text: "La hora de inicio debe ser anterior a la hora de fin.",
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
