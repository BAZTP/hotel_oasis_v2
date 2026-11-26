document.addEventListener('DOMContentLoaded', function () {
    // Modal de confirmación de inactivación
    const confirmModal = document.getElementById('confirmModal');
    const inactivateEgresoId = document.getElementById('inactivate_egreso_id');
    
    // Modal de actualización
    const updateModal = document.getElementById('updateModal');
    const updateEgresoId = document.getElementById('update_egreso_id');
    const updateProveedor = document.getElementById('update_proveedor');
    const updateRuc = document.getElementById('update_ruc');
    const updateMonto = document.getElementById('update_monto');

    // Función para mostrar el modal de confirmación con SweetAlert
    window.showConfirmModal = function (id) {
        Swal.fire({
            title: '¿Está seguro que desea Eliminar este egreso?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                inactivateEgresoId.value = id;
                document.getElementById('confirmModalForm').submit(); // Enviar el formulario automáticamente
            }
        });
    };

    // Función para cerrar el modal de confirmación
    window.hideConfirmModal = function () {
        confirmModal.classList.add('hidden');
    };

    // Función para mostrar el modal de actualización
    window.showUpdateModal = function (id, proveedor, ruc, monto) {
        updateEgresoId.value = id;
        updateProveedor.value = proveedor;
        updateRuc.value = ruc;
        updateMonto.value = monto;
        updateModal.classList.remove('hidden');
    };

    // Función para cerrar el modal de actualización
    window.hideUpdateModal = function () {
        updateModal.classList.add('hidden');
    };

    // Validación del formulario de actualización
    updateModal.querySelector('form').addEventListener('submit', function (event) {
        if (!updateProveedor.value || !updateRuc.value || !updateMonto.value) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios.',
            });
        } else if (isNaN(updateMonto.value) || parseFloat(updateMonto.value) <= 0) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El monto debe ser un número positivo.',
            });
        } else if (!/^([0-9]{9,10})$/.test(updateRuc.value)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El RUC debe tener entre 9 y 10 dígitos.',
            });
        }
    });
});
