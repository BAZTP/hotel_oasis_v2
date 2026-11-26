const showModal = (id) => {
    const modal = document.getElementById('modal');
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        const deleteValue = document.getElementById('delete_instalacion_id');
        if (deleteValue) {
            deleteValue.value = id;
        }
    }
}

const closeModal = () => {
    const modal = document.getElementById('modal');
    if (modal) {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        const deleteValue = document.getElementById('delete_instalacion_id');
        if (deleteValue) {
            deleteValue.value = '';
        }
    }
}

window.addEventListener('load', function() {
    const closeBtn = document.getElementById('btnClose');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
});
