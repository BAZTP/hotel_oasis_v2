<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/header.php'); ?>
<link rel="stylesheet" href="/css/styles.css">

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
   <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-text-50">
        Hotel Oasis Resort ofrece una variedad de servicios para que disfrutes de tu estancia al máximo
        aquí en nuestras instalaciones. Desde habitaciones de lujo hasta servicios de spa y restaurantes
        con la mejor comida de la región. ¡Descubre todo lo que tenemos para ti!
    </p>
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Servicios</h1>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php if (!empty($servicios)): ?>
                <?php foreach ($servicios as $servicio): ?>
                    <div class="card"> <!-- Aplicar la clase 'card' -->
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($servicio['TIP_SERV_DET']) ?></h2>
                            <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($servicio['PROM_SERV_DET']) ?></p>
                            <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($servicio['PROM_SERV_DESC']) ?></p>
                            <p class="text-sm text-gray-500 mb-2">Fecha: <?= htmlspecialchars($servicio['PROM_SERV_FEC']) ?></p>
                            <p class="text-sm text-gray-500 mb-2">Costo: <?= htmlspecialchars($servicio['PROM_SERV_COSTO']) ?></p>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay servicios disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</main>


<script>
    function openReservationModal(button) {
        const servicioId = button.getAttribute('data-id');
        const serId = button.getAttribute('data-serid');
        const servicioDet = button.getAttribute('data-det');
        const servicioDesc = button.getAttribute('data-desc');
        const servicioFec = button.getAttribute('data-fec');
        const servicioCosto = button.getAttribute('data-costo');

        document.getElementById('servicio_id').value = servicioId;
        document.getElementById('ser_id').value = serId;
        document.getElementById('servicio_det').value = servicioDet;
        document.getElementById('servicio_desc').value = servicioDesc;
        document.getElementById('servicio_fec').value = servicioFec;
        document.getElementById('servicio_costo').value = servicioCosto;

        document.getElementById('reservationModal').classList.remove('hidden');
    }

    function closeReservationModal() {
        document.getElementById('reservationModal').classList.add('hidden');
    }
</script>
<?php require 'partials/footer.php'; ?>
<?php require base_path('views/partials/end.php'); ?>
