
const getRoomDefault = () => {
	const room = document.getElementById('room');
	const options = room.querySelectorAll('option');
	let roomDefault = [];
	for (const option of options) {
		roomDefault.push({
			value: option.value,
			text: option.text,
			selected: option.selected,
			disabled: option.disabled,
			cant: option.dataset.cant
		});
	}

	return roomDefault;
}

let totalRooms = 0;
const ROOM_DEFAULTS = getRoomDefault();

const handleAddRoom = () => {
	const moreRooms = document.getElementById('more_rooms');
	const room = document.getElementById('room');
	moreRooms.classList.remove('hidden');
	moreRooms.classList.add('grid');
	totalRooms++

	const options = ROOM_DEFAULTS.map(r => {
		return `<option data-cant="${r.cant}" value="${r.value}" ${r.selected ? 'selected' : ''} ${r.disabled ? 'disabled' : ''}>${r.text}</option>`;
	})
	const selectEl = `
		<label for="room"
		 id="room_label_${totalRooms}"
		 class="flex flex-col text-lg text-text-50 col-span-2 md:col-span-3">
			<select id="room" name="room_${totalRooms}" onchange="handleSelectMoreRooms(this, ${totalRooms})" class="inp appearance-none" required>
				${options.join('')}
			</select>
		</label>
	`;
	const inputEl = `
		<label for="quantity"
		 	id="quantity_label_${totalRooms}"
		 	class="relative flex gap-x-2 items-center text-lg text-text-50 col-span-2 md:col-span-1">
			<input type="number" name="quantity_${totalRooms}" id="quantity" class="inp" min="1" required>
			<button onclick="handleRemoveRoom(${totalRooms})" type="button" class="h-full aspect-square bg-secondary-600 hover:bg-secondary-700 active:bg-accent-500 rounded-md grid place-items-center transition-colors duration-200" id="more_rooms_btn">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
				  <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
				</svg>
			</button>
		</label>
	`;

	moreRooms.insertAdjacentHTML('beforeend', selectEl);
	moreRooms.insertAdjacentHTML('beforeend', inputEl);
}

const handleRemoveRoom = (id) => {
	const roomLabel = document.getElementById(`room_label_${id}`);
	const quantityLabel = document.getElementById(`quantity_label_${id}`);
	roomLabel.remove();
	quantityLabel.remove();
	totalRooms--
	if (totalRooms === 0) {
		const moreRooms = document.getElementById('more_rooms');
		moreRooms.classList.remove('grid');
		moreRooms.classList.add('hidden');
	}
}

let timeOut
let hasFound = false;
const handleSearchUser = async (e) => {
	const search = e.target.value;
	console.log(search);
	if(search.length < 3) {
		if (hasFound) {
			const searchResult = document.getElementById('search_result');
			searchResult.innerHTML = '';
			hasFound = false;
			if (timeOut) {
				clearTimeout(timeOut);
			}
		}
		return;
	}

	clearTimeout(timeOut);

	timeOut = setTimeout(async () => {
		const url = new URLSearchParams({ search });
		const response = await fetch(`/auth/clientes/search?${url}`, {
			headers: {
				'Content-Type': 'application/json'
			},
			method: 'GET'
		});
		const data = await response.json();
		if (data.success) {
			showClients(data.data);
		}
	}, 1000);
}

const handleAddClient = (id) => {
	const client = document.getElementById('client_id');
	const clientName = document.getElementById('client_name');
	const clientCed = document.getElementById('client_ced');
	const clientPhone = document.getElementById('client_phone');
	client.value = id;
	clientName.textContent = document.getElementById(`search_${id}`).dataset.name;
	clientCed.textContent = document.getElementById(`search_${id}`).dataset.ced;
	clientPhone.textContent = document.getElementById(`search_${id}`).dataset.phone;
	const searchResult = document.getElementById('search_result');
	searchResult.innerHTML = '';
	hasFound = false;
	const clientSearch = document.getElementById('client');
	clientSearch.value = '';
	clientSearch.disabled = true;
	const clientSelect = document.getElementById('client_select');
	clientSelect.classList.remove('hidden');
	clientSelect.classList.add('flex');
	clientSelect.classList.add('flex-col');
}

const haddleClearClient = () => {
	const client = document.getElementById('client_id');
	const clientName = document.getElementById('client_name');
	const clientCed = document.getElementById('client_ced');
	const clientPhone = document.getElementById('client_phone');
	client.value = '';
	clientName.textContent = '';
	clientCed.textContent = '';
	clientPhone.textContent = '';
	const clientSearch = document.getElementById('client');
	clientSearch.disabled = false;
	const clientSelect = document.getElementById('client_select');
	clientSelect.classList.remove('flex');
	clientSelect.classList.remove('flex-col');
	clientSelect.classList.add('hidden');
}

const handleOpenClientModal = () => {
	const modal = document.getElementById('client_modal');
	modal.classList.remove('hidden');
	modal.classList.add('flex');
}

const handleCloseClientModal = () => {
	const modal = document.getElementById('client_modal');
	modal.classList.remove('flex');
	modal.classList.add('hidden');
}

const showClients = (data) => {
	hasFound = true;
	const searchResult = document.getElementById('search_result');
	if (data.length === 0) {
		searchResult.innerHTML = '<p class="text-text-400 px-4 py-2">No se encontraron resultados</p>' +
			'<button type="button" onclick="handleOpenClientModal()" class="text-text-400 px-4 py-2 ">Crear Cliente</button>';
		return;
	}


	const clients = data.map(client => {
		return `
			<div 
				id="search_${client['CLI_ID']}"
				data-name="${client['CLI_NOM']}"
				data-ced="${client['CLI_CED']}"
				data-phone="${client['CLI__NUM']}"
				class="w-full capitalize relative flex items-center justify-between h-12">
				<p class="text-text-400 px-4 text-ellipsis w-fit">${client['CLI_NOM']} - ${client['CLI_CED']}</p>
				<button type="button" onclick="handleAddClient(${client['CLI_ID']})" class="h-full aspect-square bg-neutral-400 flex items-center justify-center first:rounded-tr-md last:rounded-br-md">
					+
				</button>
			</div>
		`}
	);

	searchResult.innerHTML = clients.join('');
}

const handleSubmit = async (e) => {
	e.preventDefault();
	const formData = new FormData(form);
	const response = await fetch(`/auth/reservas/crear`, {
		method: 'POST',
		body: JSON.stringify(Object.fromEntries(formData)),
		headers: {
			'Content-Type': 'application/json'
		}
	});
	const data = await response.json();
	if (data.success) {
		Swal.fire({
			title: 'Reserva creada',
			text: data.success,
			icon: 'success',
			confirmButtonText: 'Aceptar'
		})
	}else if (data.error) {
		await Swal.fire({
			title: 'Error al crear la reserva',
			text: data.error,
			icon: 'error',
			confirmButtonText: 'Aceptar'
		});
	}
}

const handleSelectRoom = (e) => {
	const cantidad = e.options[e.selectedIndex].dataset.cant;
	const numRooms = document.getElementById('number_rooms');
	numRooms.max = cantidad;
}

const handleSelectMoreRooms = (e, id) => {
	const cantidad = e.options[e.selectedIndex].dataset.cant;
	const numRooms = document.getElementById('quantity_label_'+id).querySelector('input');
	numRooms.max = cantidad;
}

const handleClientModalSubmit = async (e) => {
	e.preventDefault();
	const form = document.getElementById('client_form');
	const formData = new FormData(form);
	const response = await fetch(`/auth/clientes/crear`, {
		method: 'POST',
		body: JSON.stringify(Object.fromEntries(formData)),
		headers: {
			'Content-Type': 'application/json'
		}
	});
	const data = await response.json();
	if (data.success) {
		Swal.fire({
			title: 'Cliente creado',
			text: data.success,
			icon: 'success',
			confirmButtonText: 'Aceptar'
		});
	}else if (data.error) {
		await Swal.fire({
			title: 'Error al crear el cliente',
			text: data.error,
			icon: 'error',
			confirmButtonText: 'Aceptar'
		});
	}

}


window.addEventListener('load', () => {
	const initialDate = document.getElementById('initial_date');
	const finalDate = document.getElementById('final_date');
	initialDate.addEventListener('change', () => {
		if (finalDate.value <= initialDate.value && finalDate.value !== "") {
			swal.fire({
				title: 'Fecha final inválida',
				text: 'La fecha final no puede ser menor ni igual a la fecha inicial',
				icon: 'warning',
			});
			finalDate.value = "";
		}
		// Add 1 day to initial date
		const date = new Date(initialDate.value);
		date.setDate(date.getDate() + 1);
		finalDate.min = date.toISOString().split('T')[0];
	});

	const btnAddRoom = document.getElementById('add_room');
	btnAddRoom.addEventListener('click', handleAddRoom);

	const clientSearch = document.getElementById('client');
	clientSearch.addEventListener('keyup', handleSearchUser);

	const clearClient = document.getElementById('clear_client');
	clearClient.addEventListener('click', haddleClearClient);

	const form = document.getElementById('form');
	form.addEventListener('submit', handleSubmit, false);

	const closeClientModal = document.getElementById('close_modal');
	closeClientModal.addEventListener('click', handleCloseClientModal);

	const clientForm = document.getElementById('client_form');
	clientForm.addEventListener('submit', handleClientModalSubmit, false);
});
