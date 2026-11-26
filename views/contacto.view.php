<?php require 'partials/head.php'; ?>
<?php require 'partials/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="relative bg-background-950 min-h-[calc(100vh-5rem)] flex items-start py-16 px-8">
  <form class="container max-w-xl mx-auto bg-background-900 py-8 px-8 rounded-lg drop-shadow-lg w-full" action="/contacto" method="POST">
    <h1 class="text-3xl font-semibold text-text-50">Registro para que puedas reservar nuestros servicios</h1>
    <p class="text-text-200 mt-2 font-light ">Por favor, llena el siguiente formulario.</p>
    <span class="w-2/5 mx-auto h-px bg-text-200 block my-8"></span>
    <div class="flex flex-col relative w-full gap-y-3">
      <div class="relative w-full flex items-center gap-x-3">
        <label for="nombre" class="text-text-200 text-base flex flex-col gap-y-2 relative w-2/3">
          <input class="inp" type="text" placeholder="Nombre" name="nombre" required>
        </label>
        <label for="estado" class="text-text-200 text-base flex flex-col gap-y-2 relative w-1/3">
          <select name="estado" id="estado" class="inp appearance-none" required>
            <option value="" selected disabled>Estado del Cliente</option>
            <option value="1">Primera Vez</option>
            <option value="2">Nuevo</option>
          </select>
        </label>
      </div>
      <label for="cedula" class="text-text-200 text-base flex flex-col gap-y-2 relative">
        <input class="inp" type="text" placeholder="Cédula" name="cedula" required>
      </label>
      <label for="email" class="text-text-200 text-base flex flex-col gap-y-2 relative">
        <input class="inp" type="email" placeholder="Email" name="email" required>
      </label>
      <label for="telefono" class="text-text-200 text-base flex flex-col gap-y-2 relative">
        <input class="inp" type="tel" placeholder="Teléfono" name="telefono" required/>
      </label>
      <label for="direccion" class="text-text-200 text-base flex flex-col gap-y-2 relative">
        <input class="inp" type="text" placeholder="Dirección" name="direccion">
      </label>
    </div>
    <button type="submit" class="bg-primary-400 px-4 py-2 w-full mt-4 rounded text-text-50 font-medium transition duration-200 hover:bg-primary-500 drop-shadow">Registrarse</button>
    
    <?php if (isset($errors) && count($errors) > 0): ?>
      <div class="text-red-600 text-lg text-center mt-6">
        <?php echo implode(', ', $errors); ?>
      </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Registro exitoso',
          text: '¡Cliente registrado exitosamente! Ahora puedes hacer una reserva.'
        });
      </script>
    <?php endif; ?>
  </form>
</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const cedulaInput = document.querySelector('input[name="cedula"]');
  const celularInput = document.querySelector('input[name="telefono"]');
  
  cedulaInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, ''); // Solo números permitidos
    if (this.value.length > 10) {
      this.value = this.value.slice(0, 10); // Limita a 10 dígitos
    }
  });

  celularInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, ''); // Solo números permitidos
    if (this.value.length > 10) {
      this.value = this.value.slice(0, 10); // Limita a 10 dígitos
    }
  });
  
  function transformToUppercase(event) {
    event.target.value = event.target.value.toUpperCase();
  }

  document.querySelector('input[name="nombre"]').addEventListener('input', transformToUppercase);
  document.querySelector('input[name="direccion"]').addEventListener('input', transformToUppercase);

  function validateCedula(cedula) {
    if (!/^\d{10}$/.test(cedula)) return false;

    const coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    let suma = 0;
    
    for (let i = 0; i < coeficientes.length; i++) {
      let valor = parseInt(cedula.charAt(i), 10) * coeficientes[i];
      suma += Math.floor(valor / 10) + (valor % 10);
    }
    
    const digitoControl = (10 - (suma % 10)) % 10;
    
    return digitoControl === parseInt(cedula.charAt(9), 10);
  }

  document.querySelector('form').addEventListener('submit', function(event) {
    const cedula = cedulaInput.value;
    if (!validateCedula(cedula)) {
      event.preventDefault(); // Evita el envío del formulario
      Swal.fire({
        icon: 'error',
        title: 'Número de cédula inválido',
        text: 'Por favor, ingresa un número de cédula válido.'
      });
    }
  });
});
    </script>
<?php require 'partials/footer.php'; ?>
<?php require 'partials/end.php'; ?>
