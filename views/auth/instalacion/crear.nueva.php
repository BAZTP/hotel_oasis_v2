<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Crear Instalación</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
            <a href="/auth/instalacion" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>
        <form class="mt-4 flex w-full flex-col" method="POST" action="/auth/instalacion/crearnueva" onsubmit="return handleSubmit(event)">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label class="text-lg text-text-50">Nueva Instalación</label>
                    <input type="text" id="nuevainstalacion" name="nuevainstalacion" class="inp" placeholder="Nueva instalación" style="text-transform:uppercase;">
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

        const nuevainstalacion = document.getElementById('nuevainstalacion').value.toUpperCase();
        const regex = /^[A-ZÁÉÍÓÚÑ\s]+$/;

        if (nuevainstalacion === '') {
            Swal.fire({
                title: "Error",
                text: "El campo Nueva instalación no puede estar vacío.",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
        } else if (!regex.test(nuevainstalacion)) {
            Swal.fire({
                title: "Error",
                text: "El campo Nueva instalación solo puede contener letras .",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            Swal.fire({
                title: "Enviado!",
                text: "Formulario enviado correctamente",
                icon: "success",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                document.querySelector('form').submit();
            });
        }

        return false; 
    }
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
