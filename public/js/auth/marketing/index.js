// auth/servicios/index.js

function showConfirmModal(id) {
    document.getElementById('delete_servicio_id').value = id;
    document.getElementById('modal').classList.remove('hidden');
}

function handleClose() {
    document.getElementById('modal').classList.add('hidden');
}

let timeout;
let hasFound = false;

const handleSearchServicio = async (e) => {
    const search = e.target.value;
    console.log(search);

    if (search.length < 3) {
        if (hasFound) {
            const searchResult = document.getElementById('search_result');
            searchResult.innerHTML = '';
            hasFound = false;
            if (timeout) {
                clearTimeout(timeout);
            }
        }
        return;
    }

    clearTimeout(timeout);

    timeout = setTimeout(async () => {
        const url = new URLSearchParams({ search });
        const response = await fetch(`/auth/marketing/search?${url}`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET'
        });
        const data = await response.json();
        if (data.success) {
            showServicios(data.data);
        }
    }, 1000);
}

const handleDeleteServicio = (id) => {
    const servicio = document.getElementById(`servicio_${id}`);
    servicio.remove();
    totalServicios--;
    if (totalServicios === 0) {
        const defaultMsg = document.getElementById('default_msg');
        defaultMsg.classList.remove('hidden');
    }
}

let totalServicios = 0;

const handleAddServicio = (id) => {
    const serviciosDiv = document.getElementById('servicios');
    const servicio = `
        <div id="servicio_${totalServicios}" class="flex flex-row bg-background-950 items-center justify-between rounded-md border-2 border-accent-500 p-2">
            <input type="hidden" name="servicio_${totalServicios}" value="${id}">
            <p> ${document.getElementById(`search_${id}`).dataset.descripcion} - ${document.getElementById(`search_${id}`).dataset.costo}</p>
            <button type="button" onclick="handleDeleteServicio(${totalServicios})" class="h-full text-text-50 bg-accent-950 hover:bg-accent-900 active:bg-accent-800 rounded-md p-1">Eliminar</button>
        </div>
    `;
    serviciosDiv.insertAdjacentHTML('beforeend', servicio);

    const searchResult = document.getElementById('search_result');
    searchResult.innerHTML = '';
    hasFound = false;
    const servicioSearch = document.getElementById('servicio');
    servicioSearch.value = '';
    const defaultMsg = document.getElementById('default_msg');
    defaultMsg.classList.add('hidden');
    totalServicios++;
}

const showServicios = (data) => {
    hasFound = true;
    const searchResult = document.getElementById('search_result');
    if (data.length === 0) {
        searchResult.innerHTML = '<p class="text-center">No se encontraron resultados</p>';
        return;
    }

    const servicios = data.map(servicio => {
        return `
            <div 
                id="search_${servicio['TIP_SERV_ID']}"
                data-descripcion="${servicio['TIP_SERV_DET']}"
                data-costo="${servicio['TIP_SERV_COSTO']}"
                class="w-full capitalize relative flex items-center justify-between h-12">
                <p class="text-text-400 px-4 text-ellipsis w-fit">${servicio['TIP_SERV_DET']} - ${servicio['TIP_SERV_COSTO']}</p>
                <button type="button" onclick="handleAddServicio(${servicio['TIP_SERV_ID']})" class="h-full aspect-square bg-neutral-400 flex items-center justify-center first:rounded-tr-md last:rounded-br-md">
                    +
                </button>
            </div>`;
    });

    searchResult.innerHTML = servicios.join('');
}

window.addEventListener('load', () => {
    const servicioSearch = document.getElementById('servicio');
    servicioSearch.addEventListener('keyup', handleSearchServicio);
});
