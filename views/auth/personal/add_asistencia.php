<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Añadir Asistencia</h1>
        <div class="mt-3 flex-row block">
            <form id="asistenciaForm" action="/auth/personal/asistencia/crear" method="POST" onsubmit="handleSubmit(event)">
                <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                    <div class="mt-1 flex flex-col">
                        <label for="pers_ced" class="px-2 text-m text-text-50">Cédula:</label>
                        <input type="text" name="pers_ced" id="pers_ced" class="inp" placeholder="Ingrese la cédula" required>
                        <span id="cedulaError" class="text-red-500 text-sm hidden">Error en la cédula.</span>
                    </div>
                    <div class="mt-1 flex flex-col">
                        <label for="asist_hora_llegada" class="px-2 text-m text-text-50">Hora de Llegada :</label>
                        <input type="datetime-local" name="asist_hora_llegada" id="asist_hora_llegada" class="h-10 w-full rounded-md p-2 outline-0 bg-background-0 text-text-30" placeholder="Ingrese la hora de llegada" required>
                    </div>
                    <div class="mt-1 flex flex-col">
                        <label for="asist_hora_almu_ini" class="px-2 text-m text-text-50">Inicio Almuerzo:</label>
                        <input type="datetime-local" name="asist_hora_almu_ini" id="asist_hora_almu_ini" class="h-10 w-full rounded-md p-2 outline-0 bg-background-0 text-text-30" placeholder="Ingrese la hora de inicio del almuerzo" required>
                    </div>
                    <div class="mt-1 flex flex-col">
                        <label for="asist_hora_almu_fin" class="px-2 text-m text-text-50">Fin Almuerzo:</label>
                        <input type="datetime-local" name="asist_hora_almu_fin" id="asist_hora_almu_fin" class="h-10 w-full rounded-md p-2 outline-0 bg-background-0 text-text-30" placeholder="Ingrese la hora de fin del almuerzo" required>
                    </div>
                    <div class="mt-1 flex flex-col">
                        <label for="asist_hora_salida" class="px-2 text-m text-text-50">Hora de Salida :</label>
                        <input type="datetime-local" name="asist_hora_salida" id="asist_hora_salida" class="h-10 w-full rounded-md p-2 outline-0 bg-background-0 text-text-30" placeholder="Ingrese la hora de salida" required>
                    </div>
                    <div class="mt-1 flex flex-col">
                        <label for="asist_hora_extra" class="px-2 text-m text-text-50">Hora Extra:</label>
                        <input type="text" name="asist_hora_extra" id="asist_hora_extra" class="inp" placeholder="Ingrese la hora extra" disabled>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="px-3 py-2 text-base font-medium rounded-md bg-accent-800 text-text-50">
                            Añadir
                        </button>
                        <button type="button" onclick="window.location.href='/auth/personal/asistencia';" class="px-3 py-2 text-base font-medium rounded-md bg-accent-800 text-text-50">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleSubmit(event) {
        event.preventDefault();

        const cedula = document.getElementById('pers_ced').value;
        const llegada = document.getElementById('asist_hora_llegada').value;
        const almuIni = document.getElementById('asist_hora_almu_ini').value;
        const almuFin = document.getElementById('asist_hora_almu_fin').value;
        const salida = document.getElementById('asist_hora_salida').value;

        if (!cedula || !llegada || !almuIni || !almuFin || !salida) {
            Swal.fire({
                title: "Error",
                text: "Todos los campos son obligatorios",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            fetch(event.target.action, {
                method: event.target.method,
                body: new FormData(event.target)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: "Enviado!",
                        text: "Formulario enviado correctamente",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.href = '/auth/personal/asistencia';
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: data.error || "Ocurrió un error. Por favor, inténtalo de nuevo",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al enviar el formulario.",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const dateTimeInputs = document.querySelectorAll('input[type="datetime-local"]');
        dateTimeInputs.forEach(input => {
            const now = new Date();
            const miamiTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000); // Ajuste para Miami (UTC-4)
            input.value = miamiTime.toISOString().slice(0, 16);
        });
    });
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
