<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950 text-text-50">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Generador de Roles de Pago (PDF)</h1>
    <div class="mt-6 bg-background-900 p-6 rounded-lg max-w-xl">
        <p class="mb-4">Para generar el rol de pago en PDF de un empleado, puedes hacerlo directamente desde el módulo de Roles de Pago seleccionando el empleado y el período.</p>
        <a href="/auth/roles" class="inline-block px-4 py-2 bg-secondary-700 hover:bg-secondary-600 rounded text-white font-medium">
            Ir a Roles de Pago
        </a>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
