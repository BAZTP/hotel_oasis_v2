

<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh flex  justify-center bg-background-950 text-text-50">


    <div class="mt-3 flex-row block">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Crear nuevo usuario</h1>
       
        <?php if (isset($_SESSION['errors'])): ?>
            <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
       
        <form  method="POST" action="/auth/register" class="items-center">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white mb-2">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="w-1/1 items-center px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary-500" placeholder="usuario@example.com" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
                <input type="password" id="password" name="password" class="w-1/1 px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary-500" placeholder="Contraseña" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-white mb-2">Rol</label>
                <select id="role" name="role" class="w-1/1 px-3 py-2 text-black bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-secondary-500" required>
                        <option value="auth">Súper Usuario</option>
                        <option value="administracion">Administración</option>
                        <option value="personal">Personal</option>
                        <option value="marketing">Marketing</option>
                        <option value="seguridad">Seguridad</option>
                        <option value="ingresos">Ingresos</option>
                        <option value="egresos">Egresos</option>
                </select>
            </div>

            <button type="submit" class="grid h-10 place-items-center rounded-md p-1 font-normal transition-colors duration-200 w-30 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">
                Crear nuevo Usuario
            </button>
        </form>
       
      
    </div>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>