

<?php require base_path('views/partials/head.php'); ?>
<main class="relative grid place-items-center justify-center w-full px-8 pt-20 pb-16 min-h-dvh  bg-background-950 text-text-50">


 


    <div class="bg-secondary-900 p-8 rounded-lg justify-center shadow-xl w-96">
        <img class="h-24 w-auto mx-auto mb-6" src="/images/logo.png" alt="Logo">
        <h2 class="text-3xl font-bold mb-6 text-white text-center">Iniciar Sesión</h2>
        
        <!-- PHP para manejar la lógica de inicio de sesión -->
        <?php
        // Simulación de lógica de inicio de sesión
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Aquí validarías el usuario y contraseña, por ejemplo:
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validar usuario y contraseña (ejemplo simplificado)
            if ($email !== 'usuario@example.com' || $password !== 'contraseña') {
                $errors['email'] = 'Credenciales inválidas. Inténtalo de nuevo.';
            }
        }
        ?>

        <form method="POST" action="/auth/login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white mb-2">Correo Electrónico o Usuario</label>
                <input type="text" id="email" name="email" class="inp" placeholder="admin@oasis.com o usuario">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
                <input type="password" id="password" name="password" class="inp" placeholder="Contraseña">
            </div>
            
            <?php if (!empty($errors)): ?>
            <div class="mb-4">
                <p class="text-sm text-red-400"><?php echo $errors['email']; ?></p>
            </div>
            <?php endif; ?>

            <button type="submit" class="w-full border bg-secondary-600 text-white py-2 px-4 rounded-md hover:bg-secondary-800 ">
                Ingresar
            </button>
        </form>
        
        
    </div>
</main>
    <?php require base_path('views/partials/end.php'); ?>
