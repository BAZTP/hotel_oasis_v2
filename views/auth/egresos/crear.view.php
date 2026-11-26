<?php
require base_path('views/partials/head.php');
require base_path('views/partials/auth_header.php');

// Obtener la fecha actual
$fechaActual = date('Y-m-d');
?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Crear Egreso</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
                <a href="/auth/egresos" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>

        <!-- Mostrar alertas de éxito o error -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/auth/egresos/crear" enctype="multipart/form-data" class="mt-8" onsubmit="return handleSubmit(event)">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div>
                    <label for="proveedor" class="text-lg text-text-50">Proveedor:</label>
                    <input type="text" id="proveedor" name="proveedor" required class="mt-1 block w-full rounded-md inp">
                </div>
                <div>
                    <label for="ruc" class="text-lg text-text-50">RUC:</label>
                    <input type="text" id="ruc" name="ruc" required class="mt-1 block w-full rounded-md inp">
                </div>
                <div>
                    <label for="descripcion" class="text-lg text-text-50">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required class="mt-1 block w-full rounded-md inp">
                </div>
                <div>
                    <label for="monto" class="text-lg text-text-50">Monto:</label>
                    <input type="number" id="monto" name="monto" step="0.01" min="0" required class="mt-1 block w-full rounded-md inp">
                </div>
                <div>
                    <label for="fecha" class="text-lg text-text-50">Fecha:</label>
                    <input type="text" id="fecha" name="fecha" value="<?= $fechaActual ?>" readonly class="mt-1 block w-full rounded-md inp">
                </div>
                <div>
                    <label for="tipo" class="text-lg text-text-50">Tipo:</label>
                    <select id="tipo" name="tipo" required class="mt-1 block w-full rounded-md inp">
                        <?php foreach ($tiposEgreso as $tipoEgreso): ?>
                            <option value="<?= $tipoEgreso['EGR_TIPO_ID'] ?>"><?= $tipoEgreso['EGR_NOM'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="archivo" class="text-lg text-text-50">Adjuntar archivo:</label>
                    <input type="file" id="archivo" name="archivo" class="mt-1 block w-full rounded-md inp">
                    <p class="text-sm text-text-300">Archivos permitidos: PDF, JPEG, PNG, hasta 5MB.</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="w-full sm:w-auto flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Añadir Egreso
                </button>
            </div>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleSubmit(event) {
        event.preventDefault();
        const proveedor = document.getElementById('proveedor').value;
        const ruc = document.getElementById('ruc').value;
        const descripcion = document.getElementById('descripcion').value;
        const monto = document.getElementById('monto').value;
        const tipo = document.getElementById('tipo').value;

        if (proveedor === '' || ruc === '' || descripcion === '' || monto === '' || tipo === '') {
            Swal.fire({
                title: "Error",
                text: "Todos los campos son obligatorios.",
                icon: "error",
                showConfirmButton: true
            });
            return false;
        }

        // Validar el RUC
        if (!validateRuc(ruc)) {
            Swal.fire({
                title: "RUC inválido",
                text: "El RUC debe tener exactamente 13 dígitos y terminar en '001'.",
                icon: "error",
                showConfirmButton: true
            });
            return false;
        }

        // Validar monto positivo
        if (parseFloat(monto) < 0) {
            Swal.fire({
                title: "Monto inválido",
                text: "El monto no puede ser negativo.",
                icon: "error",
                showConfirmButton: true
            });
            return false;
        }

        Swal.fire({
            title: "Enviado!",
            text: "Formulario enviado correctamente",
            icon: "success",
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            document.querySelector('form').submit();
        });

        return false;
    }

    // Función para validar el RUC
    function validateRuc(ruc) {
        return (ruc.length === 13 && ruc.endsWith('001'));
    }
</script>

<?php
require base_path('views/partials/auth_footer.php');
require base_path('views/partials/end.php');
require base_path('views/partials/routes_aside.php');
?>
