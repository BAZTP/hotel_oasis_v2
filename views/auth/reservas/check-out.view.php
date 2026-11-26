<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="flex flex-col gap-y-2 w-full relative max-w-5xl mx-auto">
        <div class="flex flex-row gap-x-2 justify-between">
            <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800"> <?= $reserva['HAB_ID']? 'Reserva de Habitación '.$reserva['RES_ID'] : 'Reserva de Salon '.$reserva['RES_ID']?></h1>
            <a href="/auth/reservas" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
        </div>
        <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
            <h2 class="w-fit font-semibold text-text-50 py-2 text-2xl">Cliente:</h2>
            <p class="text-text-50"> <span class="font-semibold">Nombre:</span> <?=$reserva['CLI_NOM']?></p>
            <p class="text-text-50"> <span class="font-semibold">Cédula:</span> <?=$reserva['CLI_CED']?></p>
            <p class="text-text-50"> <span class="font-semibold">Número celular:</span> <?=$reserva['CLI__NUM']?></p>
            <p class="text-text-50"> <span class="font-semibold">Email:</span> <?=$reserva['CLI_EMAIL']?></p>
        </div>
        <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
            <h2 class="w-fit font-semibold text-text-50 py-2 text-2xl">Reserva:</h2>
            <p class="text-text-50"> <span class="font-semibold">Fecha de Reserva:</span> <?=$reserva['RES_FECH']?></p>
            <p class="text-text-50"> <span class="font-semibold">Fecha de Inicio:</span> <?=$reserva['RES_FECH_INI']?></p>
            <p class="text-text-50"> <span class="font-semibold">Fecha de Fin:</span> <?=$reserva['RES_FECH_FIN']?></p>
        </div>
        <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
            <h2 class="w-fit font-semibold text-text-50 py-2 text-2xl">Check-out:</h2>
            <form class="flex flex-col items-center" method="post" action="/auth/reservas/check-out/registrar">
                <input type="hidden" name="reserva_id" value="<?= $reserva['RES_ID'] ?>">
                <?php if($reserva['HAB_ID']): ?>
                    <input type="hidden" name="hab_id" value="<?= $reserva['HAB_ID']?>">
                    <div class="grid grid-cols-1 gap-2 w-full md:grid-cols-2 p-4 bg-background-900 border-2 border-accent-500">
                      <?php $i = 0; foreach ($clientes as $cliente): ?>
                          <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
                              <h3 class="w-fit font-semibold text-text-50 text-xl">Cliente <?=$cliente['CLI_ID']?>:</h3>
                              <p class="text-text-50"> <span class="font-semibold">Nombre:</span> <?=$cliente['CLI_NOM']?></p>
                              <p class="text-text-50"> <span class="font-semibold">Cédula:</span> <?=$cliente['CLI_CED']?></p>
                              <input type="hidden" name="client_<?=$i?>" value="<?=$cliente['CLI_ID']?>">
                          </div>
                      <?php $i++; endforeach; ?>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="sal_id" value="<?= $reserva['SAL_ID']?>">
                <?php endif; ?>
                <button type="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Registrar</button>
            </form>
        </div>

    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
