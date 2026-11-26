<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="flex flex-col gap-y-2 w-full relative max-w-5xl mx-auto">
        <div class="flex flex-row gap-x-2 justify-between">
            <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">
                <?= $reserva['HAB_ID'] ? 'Reserva de Habitación ' . $reserva['RES_ID'] : 'Reserva de Salon ' . $reserva['RES_ID'] ?>
            </h1>
            <a href="/auth/reservas" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
        </div>
        <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
            <h2 class="w-fit font-semibold text-text-50 py-2 text-2xl">Cliente:</h2>
            <p class="text-text-50"> <span class="font-semibold">Nombre:</span> <?= $reserva['CLI_NOM'] ?></p>
            <p class="text-text-50"> <span class="font-semibold">Cédula:</span> <?= $reserva['CLI_CED'] ?></p>
            <p class="text-text-50"> <span class="font-semibold">Número celular:</span> <?= $reserva['CLI__NUM'] ?></p>
            <p class="text-text-50"> <span class="font-semibold">Email:</span> <?= $reserva['CLI_EMAIL'] ?></p>
        </div>
        <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
            <h2 class="w-fit font-semibold text-text-50 py-2 text-2xl">Reserva:</h2>
            <p class="text-text-50"> <span class="font-semibold">Fecha de Reserva:</span> <?= $reserva['RES_FECH'] ?></p>
            <p class="text-text-50"> <span class="font-semibold">Fecha de Inicio:</span> <?= $reserva['RES_FECH_INI'] ?></p>
            <p class="text-text-50"> <span class="font-semibold">Fecha de Fin:</span> <?= $reserva['RES_FECH_FIN'] ?></p>
        </div>

        <div class="flex flex-col text-text-50 rounded-md py-2 px-4 bg-accent-950 border-2 border-accent-500">
            <h2 class="w-fit font-semibold text-text-50 py-2 text-2xl">Check-in:</h2>
            <form id="form" class="flex w-full flex-col">
                <input type="hidden" name="reserva_id" value="<?= $reserva['RES_ID'] ?>">
                <label for="seleccion" class="text-text-50"><?= $reserva['HAB_ID'] ? 'Habitación' : 'Salon' ?></label>
                <select name="seleccion" id="seleccion" class="inp" required>
                    <option value="" selected disabled>Seleccione una opción</option>
                    <?php if ($reserva['HAB_ID']):
                        foreach ($select as $habitacion) : ?>
                            <option value="<?= "hab_" . $habitacion['HAB_ID'] ?>" <?= $habitacion['HAB_ID'] == $reserva['HAB_ID'] ? "selected" : "" ?>>Habitación <?= $habitacion['HAB_ID'] ?></option>
                        <?php endforeach;
                    else:
                        foreach ($select as $salon) : ?>
                            <option value="sal_<?= $salon['SAL_ID'] ?>" <?= $salon['SAL_ID'] == $reserva['SAL_ID'] ? "selected" : "" ?>>Salon <?= $salon['SAL_ID'] ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
                <button type="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Registrar</button>
            </form>
        </div>

    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/reservas/actualizar.js"></script>
<?php require base_path('views/partials/end.php'); ?>
