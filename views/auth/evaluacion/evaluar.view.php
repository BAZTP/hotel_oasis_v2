<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Evaluación de Desempeño</h1>
        
        <div class="mt-3 flex-row block">
            <div class="mt-1 flex flex-row justify-between">
                <form class="flex items-center" onsubmit="buscarEmpleado(event)" action="/auth/evaluacion/evaluar" method="GET">
                    <div class="block">
                        <div class="flex">
                            <label for="search" class="px-2 text-m text-text-50" hidden>Buscar:</label>
                            <input type="text" name="search" id="search" class="h-10 w-40 rounded-l-md p-2 outline-0 inp sm:w-30 md:w-80" placeholder="Buscar Empleado por Nombre o Cédula">
                        </div>
                        <div id="search_resultado" class="flex flex-col w-auto absolute z-50 bg-white rounded-md drop-shadow-md mt-2 max-h-96 overflow-auto">
                        </div>
                    </div>
                </form>
                <div class="mt-4 flex flex-row justify-between gap-x-4">
                    <div class="flex gap-x-7">
                        <a href="/auth/evaluacion" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
                    </div>
                </div>
            </div>
            

            <form id="form_evaluacion" class="mt-4 flex w-full flex-col" onsubmit="return employed_evaluate(event)" action="/auth/evaluacion/evaluar" method="POST">
                <div class="block">
                    <div class="mt-2 grid grid-cols-1 gap-2 md:grid-cols-3">
                        <div class="mt-1 flex flex-col" style="display: none;">
                            <label class="block text-m text-text-50">Id:</label>
                            <input type="text" id="idpersona" name="idpersona" class="inp" placeholder="Cédula del Empleado">
                        </div>
                        <div class="mt-1 flex flex-col">
                            <label class="block text-m text-text-50">Cédula:</label>
                            <input type="text" id="cedula" name="cedula" class="inp" placeholder="Cédula del Empleado" readOnly>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <label class="block text-m text-text-50">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="inp" placeholder="Nombre del Empleado" readOnly>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <label class="block text-m text-text-50">Apellido:</label>
                            <input type="text" id="apellido" name="apellido" class="inp" placeholder="Apellido del Empleado" readOnly>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <label class="block text-m text-text-50">Cargo:</label>
                            <input type="text" id="cargo" name="cargo" class="inp" placeholder="Cargo del Empleado" readOnly>
                        </div>
                        <div class="flex flex-col">
                            <label for="initial_date" class="text-lg text-text-50">Fecha De Entrada:</label>
                            <input type="date" name="initial_date" id="initial_date" class="inp" placeholder="Fecha de Entrada" value="<?= date(
                                'Y-m-d'
                            ) ?>" readOnly>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <label for="evaluacion" class="block text-m text-text-50">Evaluación:</label>
                            <input type="number" min="0" max="10" step="0.01" id="evaluacion" name="evaluacion" class="inp" placeholder="Evaluación del Empleado">
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 mb-2 mt-5 text-text-50">
                        <button id="guardar" class="grid h-10 w-full place-items-center rounded-full transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/evaluar/evaluacion_form.js"></script>

<?php require base_path('views/partials/end.php'); ?>