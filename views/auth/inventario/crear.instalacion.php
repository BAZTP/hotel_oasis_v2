<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Seleccionar Inventario Instalación</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
            <a href="/auth/inventario/instalacion" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>
        <form class="mt-4 flex w-full flex-col" method="POST" action="/auth/inventario/instalacioncrear" onsubmit="return handleSubmit(event)">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label for="seleccionar_instalacion" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Seleccionar Instalaciones:</span>
                        <select name="seleccionar_instalacion" id="seleccionar_instalacion" class="inp appearance-none">
                            <option value="" selected disabled>Seleccionar instalaciones</option>
                            <?php foreach ($seleccionar_instalacion as $seleccionar_instalaciones): ?>
                                <option value="<?= $seleccionar_instalaciones['INS_ID'] ?>">
                                     <?= $seleccionar_instalaciones['TIP_INS_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="flex flex-col">
                    <label for="seleccionar_inventario" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Seleccionar del Inventario General:</span>
                        <select name="seleccionar_inventario" id="seleccionar_inventario" class="inp appearance-none" >
                            <option value="" selected disabled>Seleccionar del Inventario General</option>
                            <?php foreach ($seleccionar_inventario as $seleccionar_inventarios): ?>
                                <option value="<?= $seleccionar_inventarios['INV_GEN_ID'] ?>">
                                     <?= $seleccionar_inventarios['INV_GEN_DES'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="flex flex-col">
                    <label for="stock" class="text-lg text-text-50 col-span-2 md:col-span-3">
                        <span>Stock:</span>
                        <input type="number" name="stock" id="stock" class="inp" placeholder="Stock">
                    </label>
                 </div>

            </div>
    
            <button type="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Crear</button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleSubmit(event) {
        event.preventDefault();

        const seleccionarInstalacion = document.getElementById('seleccionar_instalacion').value;
        const seleccionarInventario = document.getElementById('seleccionar_inventario').value;
        const stock = document.getElementById('stock').value;

        if (seleccionarInstalacion === '' || seleccionarInventario === '' || stock === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, completa todos los campos",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        } 
        if (stock <= 0) {
            Swal.fire({
                title: "Error",
                text: "El valor del stock debe ser positivo",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
            return;
        }

        if (seleccionarInstalacion === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona una instalación",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        if (seleccionarInventario === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona un inventario",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }
        if (stock === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, ingrese el stock",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
            return false;
        }

        const formData = new FormData(document.querySelector('form'));

        fetch('/auth/inventario/instalacioncrear', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    title: "Enviado!",
                    text: data.message,
                    icon: "success",
                    showConfirmButton: false,
                    timer: 3000
                }).then(() => {
                    window.location.href = '/auth/inventario/instalacion';
                });
            } else {
                Swal.fire({
                    title: "Error",
                    text: data.message,
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error. Por favor, inténtalo de nuevo",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
        });
        }
    
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
