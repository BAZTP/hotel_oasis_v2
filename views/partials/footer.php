<?php
$route = [
	[
        'name' => 'Facebook',
        'path' => 'https://facebook.com/',
        'svg' => 'Facebook'
    ],
    [
        'name' => 'Instagram',
        'path' => 'https://www.instagram.com/',
        'svg' => 'Instagram'
    ],
    [
        'name' => 'Twitter',
        'path' => 'https://twitter.com/',
        'svg' => 'Twitter'
    ]
    ,
    [
        'name' => 'Youtube',
        'path' => 'https://www.youtube.com/',
        'svg' => 'Youtube'
    ]
];
?>
<footer class="relative bg-primary-950 items-center h-auto px-8 flex justify-between">
    <div>
        <a href="/" class="flex items-center gap-x-2 relative h-full">
            <img class="h-28 w-auto aspect-square" src="/images/logo.png" alt="Logo Hotel Oasis">
            <h1 class="text-3xl font-bold text-text-100">Hotel Oasis</h1>
        </a>
    </div>
    <div>
        <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-text-50">
            Hotel Oasis &copy; 2024. Todos los derechos reservados.
        </p>
        <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-text-50">
            Dirección: Occidental, Quito, Ecuador
        </p>
        <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-text-50">
            Teléfono: +123456789
        </p>
        <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl text-text-50">
            Email: info@hoteloasis.com
        </p>
        <a href="/auth" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 "></a>
    </div>
    <div class="text-text-50">
        <nav class="flex flex-col items-center justify-center w-full h-full">
            <div class="grid grid-cols-3 gap-3 place-items-center transition-all duration-300">
                <?php foreach ($route as $item): ?>
                    <a href="<?= $item['path'] ?>" class="aspect-square w-full bg-background-950 rounded-lg flex flex-col gap-y-2 items-center justify-center border-2 border-accent-600 text-text-50
                    <?= $currentPath === $item['path']
                        ? 'bg-background-600'
                        : ''
                    ?>">
                        <?php require base_path('views/partials/icons/' . $item['svg'] . '.php') ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
    </div>
    
</footer>