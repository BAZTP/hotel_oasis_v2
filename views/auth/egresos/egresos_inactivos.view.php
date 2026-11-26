<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Egresos Inactivos</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <form action="/auth/egresos/inactivos" method="GET" class="relative flex h-10 w-full max-w-sm items-center">
                <input id="search_name" name="search" type="text" class="rounded-r-none inp" placeholder="Buscar egresos inactivos por Proveedor" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="grid aspect-square h-full place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            <a href="/auth/egresos" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Volver a Egresos Activos</a>
        </div>

        <?php if (count($egresos) > 0): ?>
            <div class="mt-4 grid grid-cols-1 gap-2 text-neutral-50 md:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3">
                <?php foreach ($egresos as $egreso): ?>
                    <div class="relative flex h-28 w-full flex-row justify-between rounded-md px-3 py-3 drop-shadow-md bg-background-900">
                        <div class="relative flex grow">
                            <div class="aspect-square h-full w-auto rounded-lg bg-accent-800">
                                <!-- Personaliza el ícono si es necesario -->
                            </div>
                            <div class="relative px-2 text-text-300">
                                <p class="text-lg font-semibold text-text-200">Proveedor: <?= $egreso['EGR_PROVEEDOR'] ?></p>
                                <p class="text-sm">RUC: <?= $egreso['EGR_RUC'] ?></p>
                                <p class="text-sm">Monto: <?= $egreso['EGR_MON'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="flex items-center justify-center w-full h-screen text-4xl font-semibold text-text-200">No hay egresos inactivos</p>
        <?php endif; ?>

    </div>

</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
