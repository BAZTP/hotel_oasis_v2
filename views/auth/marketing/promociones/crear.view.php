<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <div class="flex justify-between items-center">
            <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Añadir Promoción de Marketing</h1>
            <a href="/auth/marketing/promociones" class="btn bg-secondary-800 text-white px-4 py-2 rounded-md hover:bg-red-700">
                Regresar
            </a>
        </div>
        
        <form class="mt-4 flex w-full flex-col" id="promoForm" method="POST" action="/auth/marketing/promociones/crear">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <!-- Título -->
                <div class="flex flex-col">
                    <label for="PROMO_TIT" class="text-lg text-text-50">Título</label>
                    <input type="text" id="PROMO_TIT" name="PROMO_TIT" class="inp" placeholder="Título de la promoción" required>
                </div>
                
                <!-- Detalle -->
                <div class="flex flex-col">
                    <label for="PROMO_DET" class="text-lg text-text-50">Detalle</label>
                    <textarea id="PROMO_DET" name="PROMO_DET" class="inp" placeholder="Detalle de la promoción" required></textarea>
                </div>
                
                <!-- Descuento -->
                <div class="flex flex-col">
    <label for="PROMO_DESCU" class="text-lg text-text-50">Descuento (%)</label>
    <input type="number" id="PROMO_DESCU" name="PROMO_DESCU" class="inp" placeholder="Descuento" min="0.01" step="0.01" required>
</div>
                
                <!-- Selector de Evento o Servicio -->
                <div class="flex flex-col">
                    <label class="text-lg text-text-50">Seleccionar Tipo</label>
                    <div>
                        <input type="radio" id="tipo_evento" name="tipo" value="evento" required >
                        <label class="text-text-50"for="tipo_evento" >Evento</label>
                    </div>
                    <div>
                        <input type="radio" id="tipo_servicio" name="tipo" value="servicio" required>
                        <label class="text-text-50" for="tipo_servicio">Servicio</label>
                    </div>
                </div>
                
                <!-- Tipo de Evento -->
                <div class="flex flex-col hidden" id="div_evento">
                    <label for="TIP_EVEN_ID" class="text-lg text-text-50">Tipo de Evento</label>
                    <select name="TIP_EVEN_ID" id="TIP_EVEN_ID" class="inp">
                        <option value="" selected disabled>Seleccione un tipo de evento</option>
                        <?php foreach ($tipo_eventos as $evento): ?>
                            <option value="<?= $evento['TIP_EVEN_ID'] ?>"><?= $evento['TIP_EVEN_DET'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Tipo de Servicio -->
                <div class="flex flex-col hidden" id="div_servicio">
                    <label for="TIP_SERV_ID" class="text-lg text-text-50">Tipo de Servicio</label>
                    <select name="TIP_SERV_ID" id="TIP_SERV_ID" class="inp">
                        <option value="" selected disabled>Seleccione un tipo de servicio</option>
                        <?php foreach ($tipo_servicios as $servicio): ?>
                            <option value="<?= $servicio['TIP_SERV_ID'] ?>"><?= $servicio['TIP_SERV_DET'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="mt-4 bg-secondary-800 text-white px-4 py-2 rounded-md hover:bg-secondary-700">
                Guardar Promoción
            </button>
        </form>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<script>
    // Función para convertir el texto a mayúsculas
    function convertToUpperCase(event) {
        event.target.value = event.target.value.toUpperCase();
    }

    // Añadir el event listener a los campos de texto relevantes
    document.getElementById('PROMO_TIT').addEventListener('input', convertToUpperCase);
    document.getElementById('PROMO_DET').addEventListener('input', convertToUpperCase);
    function validateDiscount(value) {
        // Verifica si el valor es mayor que 0 y tiene como máximo dos decimales
        const numberValue = parseFloat(value);
        if (isNaN(numberValue) || numberValue <= 0 || value != value.match(/^\d+(\.\d{1,2})?$/)) {
            return false;
        }
        return true;
    }

    // Función para mostrar alerta de éxito
    function showSuccessAlert() {
        Swal.fire({
            icon: 'success',
            title: 'Guardado con éxito',
            text: 'La promoción se ha guardado correctamente.',
        });
    }

    // Capturar el evento submit del formulario
    document.getElementById('promoForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

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
                    text: 'Hubo un problema al guardar la promoción.',
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

    // Mostrar u ocultar campos de tipo de evento o servicio según selección
    document.querySelectorAll('input[type=radio][name=tipo]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'evento') {
                document.getElementById('div_evento').classList.remove('hidden');
                document.getElementById('div_servicio').classList.add('hidden');
            } else if (this.value === 'servicio') {
                document.getElementById('div_evento').classList.add('hidden');
                document.getElementById('div_servicio').classList.remove('hidden');
            }
        });
    });
</script>
