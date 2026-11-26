
const handleDeleteService = (index) => {
    const service = document.getElementById(`service_${index}`);
    service.remove();
}

let timeOut;
let hasFound = false;
const handleSearchService = async (e) => {
    const search = e.value;
    if(search.length < 3){
        if(hasFound){
            const searchResult = document.getElementById('search_result');
            searchResult.innerHTML = '';
            hasFound = false;
            if(timeOut){
                clearTimeout(timeOut);
            }
        }
        return;
    }

    clearTimeout(timeOut);

    timeOut = setTimeout(async () => {
        const url = new URLSearchParams({ search });
        const response = await fetch(`/auth/servicios/search?${url}`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET'
        });
        const data = await response.json();
        if(data.success){
            showServices(data.data);
        }
    }, 1000);
}

const showServices = (data) => {
    hasFound = true;
    const searchResult = document.getElementById('search_result');

    if(data.length === 0){
        searchResult.innerHTML = '<p class="text-text-950 px-4 py-2">No se encontraron resultados</p>';
        return;
    }
    const services = data.map(service => {
        return `
            <div 
				id="search_${service['SER_ID']}"
				data-des="${service['SER_DES']}"
				data-vu="${service['SER_VAL_UNI']}"
				class="w-full capitalize relative flex items-center justify-between h-12">
				<p class="text-text-950 px-4 text-ellipsis w-fit">${service['SER_DES']} - ${service['SER_VAL_UNI']} USD</p>
				<button type="button" onclick="handleAddService(${service['SER_ID']})" class="h-full aspect-square bg-neutral-400 flex items-center justify-center first:rounded-tr-md last:rounded-br-md">
					+
				</button>
			</div>
        `;}
    );

searchResult.innerHTML = services.join('');
}

const handleAddService = (id) => {
    if(document.getElementById('default_msg')){
        document.getElementById('default_msg').remove();
    }
    const services = document.getElementById('services');
    const service = document.getElementById(`search_${id}`);
    console.log(service);
    const serviceDiv = `
        <div id="service_${services.children.length+1}" class="flex flex-row bg-background-950 text-text-50 items-center justify-between rounded-md border-2 border-accent-500 p-2">
            <input type="hidden" name="servicio_${service.children.length+1}" value="${id}">
            <p> ${service.dataset.des} - ${service.dataset.vu} USD</p>
            <button type="button" onclick="handleDeleteService(${services.children.length+1})" class="h-full text-text-50 bg-accent-950 hover:bg-accent-900 active:bg-accent-800 rounded-md p-1">Eliminar</button>
        </div>
    `;
    services.insertAdjacentHTML('beforeend', serviceDiv);
    const searchResult = document.getElementById('search_result');
    searchResult.innerHTML = '';
    hasFound = false;
    const search = document.getElementById('servicio');
    search.value = '';
}

const handleUpdateModal = async (id, tipo) => {
    if(tipo === 0){
        const url = new URLSearchParams({ id });
        const response = await fetch(`/auth/tipohabitacion/search?${url}`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET'
        });
        const data = await response.json();
        if(data.success){
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            const main = document.getElementById('modal_main');

            const form = `
                <input type="hidden" name="id" value="${id}">
                <input type="hidden" name="salon" value="1">
                <h2 class="text-xl font-medium leading-6 text-text-50" id="modal_title">Tipo de Habitación/Salón</h2>
                <label for="description" class="font-semibold text-lg text-text-50">Descripción:</label>
                <input type="text" id="description" name="description" class="inp" required value="${data.data.tipoHabitacion.TIP_HAB_DES}">
                <label for="services" class="relative flex flex-col text-text-50">
                    <span class="font-semibold text-lg">Servicios:</span>
                    <input type="text" id="servicio" class="inp" placeholder="Nombre del servicio" onkeyup="handleSearchService(this)">
                </label>
                <div id="search_result" class="flex flex-col text-text-950 bg-white rounded-md drop-shadow-md w-full mt-2 max-h-96 overflow-auto">
                </div>
                <div id="services" class="grid grid-cols-1 gap-2 md:grid-cols-2 p-4 bg-background-900 border-2 border-accent-500">
                    <p id="default_msg" class="text-text-50">No hay servicios registrados</p>
                </div>
                `;
            main.innerHTML = form;
            if(data.data.servicios.length > 0){
                const services = document.getElementById('services');
                services.innerHTML = '';
                data.data.servicios.forEach((servicio, index) => {
                    const service = `
                        <div id="service_${index}" class="flex flex-row bg-background-950 text-text-50 items-center justify-between rounded-md border-2 border-accent-500 p-2">
                            <input type="hidden" name="servicio_${index}" value="${servicio.SER_ID}">
                            <p> ${servicio.SER_DES} - ${servicio.SER_VAL_UNI} </p>
                            <button type="button" onclick="handleDeleteService(${index})" class="h-full text-text-50 bg-accent-950 hover:bg-accent-900 active:bg-accent-800 rounded-md p-1">Eliminar</button>
                        </div>
                    `;
                    services.insertAdjacentHTML('beforeend', service);
                });
            }
        }
    }else{
        const url = new URLSearchParams({ id });
        const response = await fetch(`/auth/tiposalon/search?${url}`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET'
        });
        const data = await response.json();
        if(data.success) {
            const modal = document.getElementById('modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            const main = document.getElementById('modal_main');

            const form = `
                <input type="hidden" name="id" value="${id}">
                <input type="hidden" name="salon" value="0">
                <h2 class="text-xl font-medium leading-6 text-text-50" id="modal_title">Tipo de Habitación/Salón</h2>
                <label for="description" class="font-semibold text-lg text-text-50">Descripción:</label>
                <input type="text" id="description" name="description" class="inp" value="${data.data.tipoSalon.TIP_SAL_DES}" required>
                <label for="services" class="relative flex flex-col text-text-50">
                    <span class="font-semibold text-lg">Servicios:</span>
                    <input type="text" id="servicio" class="inp" placeholder="Nombre del servicio" onkeyup="handleSearchService(this)">
                </label>
                <div id="search_result" class="flex flex-col text-text-50 bg-white rounded-md drop-shadow-md w-full mt-2 max-h-96 overflow-auto">
                </div>
                <div id="services" class="grid grid-cols-1 gap-2 md:grid-cols-2 p-4 bg-background-900 border-2 border-accent-500">
                    <p id="default_msg" class="text-text-50">No hay servicios registrados</p>
                </div>
                `;
            main.innerHTML = form;
            if (data.data.servicios.length > 0) {
                const services = document.getElementById('services');
                services.innerHTML = '';
                data.data.servicios.forEach((servicio, index) => {
                    const service = `
                        <div id="service_${index}" class="flex flex-row bg-background-950 items-center justify-between rounded-md border-2 border-accent-500 p-2">
                            <input type="hidden" name="servicio_${index}" value="${servicio.SER_ID}">
                            <p> ${servicio.descripcion} - ${servicio.SER_VAL_UNI}</p>
                            <button type="button" onclick="handleDeleteService(${index})" class="h-full text-text-50 bg-accent-950 hover:bg-accent-900 active:bg-accent-800 rounded-md p-1">Eliminar</button>
                        </div>
                    `;
                    services.insertAdjacentHTML('beforeend', service);
                });
            }
        }
    }
}

const handleCloseModal = () => {
    const modal = document.getElementById('modal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
    const main = document.getElementById('modal_main');
    main.innerHTML = '';
}

const handleSumbit = async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const response = await fetch('/auth/tipohabsal/actualizar',{
        headers: {
            'Content-Type': 'application/json'
        },
        method: 'PUT',
        body: JSON.stringify(Object.fromEntries(formData))
    });
    const data = await response.json();
    if(data.success){
        Swal.fire({
            title: 'Tipo de Habitación/Salón actualizado',
            text: data.success,
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.reload();
        });
    } else if(data.error){
        await Swal.fire({
            title: 'Error al actualizar el tipo de Habitación/Salón',
            text: data.error,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
}

window.addEventListener('load', () => {
    const closeModalBtn = document.getElementById('btnClose');
    closeModalBtn.addEventListener('click', handleCloseModal);
    const form = document.getElementById('form');
    form.addEventListener('submit', handleSumbit, false);
});