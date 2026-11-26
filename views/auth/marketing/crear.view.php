<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <div class="flex justify-between items-center">
            <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Gestión de Servicios del Hotel</h1>
            <a href="/auth/marketing" class="btn bg-secondary-800 text-white px-4 py-2 rounded-md hover:bg-red-700">
                Regresar
            </a>
        </div>
        
        <form class="mt-4 flex w-full flex-col" id="serviceForm" method="POST" action="/auth/marketing/crear">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <!-- Tipo de Servicio -->
                <div class="flex flex-col">
                    <label for="tipo_servicios" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Tipo de Servicio:</span>
                        <select name="tipo_servicios" id="tipo_servicios" class="inp appearance-none" required>
                            <option value="" selected disabled>Tipo de Servicio</option>
                            <?php foreach ($tipos_servicios as $tipo_servicio): ?>
                                <option value="<?= $tipo_servicio['TIP_SERV_ID'] ?>">
                                    Servicio - <?= $tipo_servicio['TIP_SERV_DET'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                
                <!-- Detalle del Servicio -->
                <div class="flex flex-col">
                    <label class="text-lg text-text-50">Detalle del Servicio</label>
                    <input type="text" id="detalleservicio" name="detalleservicio" class="inp uppercase" placeholder="DETALLE DEL SERVICIO" required pattern="^[A-ZÁÉÍÓÚÑ\s]*$" title="Solo se permiten letras mayúsculas y espacios.">
                </div>
                
                <!-- Descripción -->
                <div class="flex flex-col">
                    <label class="text-lg text-text-50">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="inp uppercase h-32" placeholder="DESCRIPCIÓN" required pattern="^[A-ZÁÉÍÓÚÑ\s,]*$" title="Solo se permiten letras mayúsculas, comas y espacios."></textarea>
                </div>
                
                <!-- Fecha -->
                <div class="flex flex-col">
                    <label for="initial_date" class="text-lg text-text-50">Fecha:</label>
                    <input type="datetime-local" name="initial_date" id="initial_date" class="inp" placeholder="Fecha" min="<?= date('Y-m-d') ?>" required>
                </div>
                
                <!-- Costo -->
                <div class="flex flex-col">
                    <label class="text-lg text-text-50">Costo</label>
                    <input type="text" id="costo" name="costo" class="inp" placeholder="Costo" required pattern="^\d+(\.\d{1,2})?$" title="Solo números positivos con hasta dos decimales.">
                </div>
            </div>
            
            <button type="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Guardar</button>
        </form>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<script>
    // Función para mostrar alerta de éxito
    function showSuccessAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Guardado con éxito',
            text: 'El servicio se ha guardado correctamente.',
        });
    }

    // Capturar el evento submit del formulario
    document.getElementById('serviceForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        // Validar la fecha
        var initialDate = document.getElementById('initial_date').value;
        var currentDate = new Date().toISOString().slice(0, 16);

        if (initialDate <= currentDate) {
            Swal.fire({
                icon: 'error',
                title: 'Fecha inválida',
                text: 'Debe seleccionar una fecha posterior al día vigente.',
            });
            return;
        }

        // Realizar la solicitud de envío del formulario usando Fetch API
        fetch(this.action, {
            method: this.method,
            body: new FormData(this)
        }).then(response => {
            if (response.ok) {
                showSuccessAlert(); // Mostrar alerta de éxito
                this.reset(); // Resetear el formulario después de enviar
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al guardar el servicio.',
                });
            }
        }).catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al enviar el formulario.',
            });
        });
    });

    // Convertir texto a mayúsculas en tiempo real
    document.getElementById('detalleservicio').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    document.getElementById('descripcion').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
