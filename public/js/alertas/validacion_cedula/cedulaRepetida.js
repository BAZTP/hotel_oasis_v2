Swal.fire({
    position: 'top-center',
    icon: 'error',
    title: 'Cédula existente en la base de datos',
    text: 'Por favor ingrese una cédula que no exista en la base de datos',
    showConfirmButton: false,
    timer: 3000
});