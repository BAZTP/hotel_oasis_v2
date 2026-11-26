const FilterDivs = (reservasDiv, status) => {
    for(let i = 0; i <reservasDiv.children.length; i++){
        if(reservasDiv.children[i].classList.contains('hidden') && reservasDiv.children[i].classList.contains(status)){
            reservasDiv.children[i].classList.remove('hidden');
            reservasDiv.children[i].classList.add('flex');
            reservasDiv.children[i].classList.add('flex-row');
        }else if(reservasDiv.children[i].classList.contains('flex') && !reservasDiv.children[i].classList.contains(status)){
            reservasDiv.children[i].classList.remove('flex');
            reservasDiv.children[i].classList.remove('flex-row');
            reservasDiv.children[i].classList.add('hidden');
        }
    }
}

const handleDelete = async (id) => {
    const modal = document.getElementById('modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    const deleteValue = document.getElementById('delete_reserva_id');
    deleteValue.value = id;
}

const handleClose = () => {
    const modal = document.getElementById('modal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
    const deleteValue = document.getElementById('delete_reserva_id');
    deleteValue.value = '';
}

const handleStatusSelected = () => {
    const statusSelect = document.getElementById('status');
    const statusValue = statusSelect.value;
    const reservasDiv = document.getElementById('reservas_div');
    switch (statusValue) {
        case "0":
            for(i = 0; i <reservasDiv.children.length; i++){
                if(reservasDiv.children[i].classList.contains('hidden')){
                    reservasDiv.children[i].classList.remove('hidden');
                    reservasDiv.children[i].classList.add('flex');
                    reservasDiv.children[i].classList.add('flex-row');
                }
            }
            break;
        case "1":
            FilterDivs(reservasDiv, '1');
            break;
        case "2":
            FilterDivs(reservasDiv, '2');
            break;
        case "3":
            FilterDivs(reservasDiv, '3');
            break;
        case "4":
            FilterDivs(reservasDiv, '4');
            break;
        default:
            break;

    }
}

let timeOut

const handleSearch = (e) => {
    const search = e.target.value;

    if (search.length === 0) handleStatusSelected()
    else if(e.key !== 'Enter') return
    else if (search.length < 3) {
        return;
    }

    clearTimeout(timeOut);

    timeOut = setTimeout(async () => {
        const reservasDiv = document.getElementById('reservas_div');
        for(let i = 0; i <reservasDiv.children.length; i++){
            if((!reservasDiv.children[i].dataset.name.toUpperCase().includes(search.toUpperCase()) && !reservasDiv.children[i].dataset.ced.includes(search)) && reservasDiv.children[i].classList.contains('flex')) {
                reservasDiv.children[i].classList.remove('flex');
                reservasDiv.children[i].classList.remove('flex-row');
                reservasDiv.children[i].classList.add('hidden');
            }
        }
    }, 1000);
}

window.addEventListener('load', function() {
    const closeBtn = document.getElementById('btnClose');
    closeBtn.addEventListener('click', handleClose);

    const statusSelect = document.getElementById('status');
    statusSelect.addEventListener('change', handleStatusSelected);

    const searchName = document.getElementById('search_name');
    searchName.addEventListener('keyup', handleSearch);
});