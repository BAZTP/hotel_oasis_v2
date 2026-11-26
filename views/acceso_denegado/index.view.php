<?php
// Obtenemos la URL actual
$current_url = $_SERVER['REQUEST_URI'];
?>
<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative grid place-items-center justify-center w-full px-8 pt-20 pb-16 min-h-dvh  bg-background-950 text-text-50">


<div class="bg-secondary-900 p-8 rounded-lg justify-center shadow-xl w-96">
<img class="h-24 w-auto mx-auto mb-6" src="/images/logo.png" alt="Logo">
        <h2 class="text-3xl font-bold mb-6 text-white text-center">Acceso Denegado</h2>
        
        <p class="text-white text-center mb-6">Lo sentimos, no tienes permiso para acceder a esta página.</p>
        
        
        <div class="text-center">
            <a href="/auth" class="items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">
                Volver a la página principal
            </a>
        </div>
    </div>
</main>


 