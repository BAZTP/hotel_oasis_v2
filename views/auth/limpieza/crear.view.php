<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Crear Limpieza</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
            <a href="/auth/limpieza" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>
        <form class="mt-4 flex w-full flex-col" method="POST" action="/auth/limpieza/crear" onsubmit="return handleSubmit(event)">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label for="tipo_habitaciones" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Seleccionar Habitación:</span>
                        <select name="tipo_habitaciones" id="tipo_habitaciones" class="inp appearance-none">
                            <option value="" selected disabled>Seleccionar Habitación</option>
                            <?php foreach ($tipo_habitaciones as $tipo_habitacion): ?>
                                <option value="<?= $tipo_habitacion['HAB_ID'] ?>">
                                    Habitación - <?= $tipo_habitacion['HAB_ID'] ?>
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
                <div class="flex flex-col">
                    <label for="initial_date" class="text-lg text-text-50">Fecha de Limpieza:</label>
                    <input type="date" name="initial_date" id="initial_date" class="inp" placeholder="Fecha de Limpieza" min="<?= date('Y-m-d') ?>">
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

        const tipoHabitaciones = document.getElementById('tipo_habitaciones').value;
        const tipoPersonales = document.getElementById('tipo_personales').value;
        const initialDate = document.getElementById('initial_date').value;

        if (tipoHabitaciones === '' || tipoPersonales === '' || initialDate === '') {
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

        if (tipoHabitaciones === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona una habitación.",
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
        } else if (initialDate === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona una fecha de limpieza.",
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
<script src="/js/auth/limpieza/index.js"></script>
<?php require base_path('views/partials/end.php'); ?>
