<?php require 'partials/head.php'; ?>
<?php require 'partials/header.php'; ?>
<link rel="stylesheet" href="/css/styles.css">
<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
   <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-text-50">
		Explora nuestras increíbles promociones disponibles en Hotel Oasis Resort. Desde descuentos especiales en habitaciones hasta ofertas exclusivas en servicios de spa y restaurantes. ¡No te las pierdas!
	</p>
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Promociones</h1>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            <?php if (!empty($promociones)): ?>
                <?php foreach ($promociones as $promocion): ?>
                    <div class="card"> <!-- Aplicar la clase 'card' -->
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($promocion['PROMO_TIT']) ?></h2>
                            <p class="text-sm text-gray-600 mb-4"><?= htmlspecialchars($promocion['PROMO_DET']) ?></p>
                            <p class="text-sm text-gray-600 mb-4">Descuento: <?= htmlspecialchars($promocion['PROMO_DESCU']) ?></p>
                            <!-- Si tienes más detalles específicos de la promoción, añádelos aquí -->
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay promociones disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php require 'partials/footer.php'; ?>
<?php require 'partials/end.php'; ?>

