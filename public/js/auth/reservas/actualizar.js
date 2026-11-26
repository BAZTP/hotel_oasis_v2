
const handleSumbit = async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const response = await fetch('/auth/reservas/check-in/registrar', {
        headers: {
            'Content-Type': 'application/json'
        },
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData))
    });
    const data = await response.json();
    if(data.success) {
        Swal.fire({
            title: 'Check-in registrado',
            text: data.success,
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = '/auth/reservas';
        });
    } else if(data.error) {
        await Swal.fire({
            title: 'Error al registrar el check-in',
            text: data.error,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

window.addEventListener('load', () => {
    const form = document.getElementById('form');
    form.addEventListener('submit', handleSumbit, false);
});