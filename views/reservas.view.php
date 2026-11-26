<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/header.php'); ?>
<link rel="stylesheet" href="/css/styles.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <section class="relative flex flex-col items-center px-6 py-16 text-center md:px-12 bg-neutral-200">
        <h1 class="text-3xl md:text-4xl">Reservaciones</h1>
        <p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl">
            Elige la suite, nosotros nos encargamos de los detalles.
        </p>
        <br><br>
        <div class="ofertas-container">
            <div class="oferta">
                <div class="image-container">
                    <img src="images/hab1.jpg" alt="Simple">
                    <div class="overlay">
                        <span>Habitación Individual</span>
                    </div>
                </div>
                <div class="oferta-info">
                    <ul>
                        <li>- Una cama King Size, baño privado.</li>
                        <li>- Escritorio, TV por cable y WIFI.</li>
                        <li>- Precio: $60.</li>
                    </ul>
                </div>
            </div>
            <div class="oferta">
                <div class="image-container">
                    <img src="images/hab2.jpg" alt="Doble">
                    <div class="overlay">
                        <span>Habitación Doble</span>
                    </div>
                </div>
                <div class="oferta-info">
                    <ul>
                        <li>- Dos camas King Size, baño privado.</li>
                        <li>- Escritorio, TV por cable y WIFI.</li>
                        <li>- Precio: $80.</li>
                    </ul>
                </div>
            </div>
            <div class="oferta">
                <div class="image-container">
                    <img src="images/hab3.jpeg" alt="Triple">
                    <div class="overlay">
                        <span>Habitación Triple</span>
                    </div>
                </div>
                <div class="oferta-info">
                    <ul>
                        <li>- Una cama King Size, dos camas Twin Size.</li>
                        <li>- Baño privado, TV por cable y WIFI.</li>
                        <li>- Precio: $150.</li>
                    </ul>
                </div>
            </div>
            <div class="oferta">
                <div class="image-container">
                    <img src="images/hab4.jpg" alt="Familiar">
                    <div class="overlay">
                        <span>Habitación Familiar</span>
                    </div>
                </div>
                <div class="oferta-info">
                    <ul>
                        <li>- Dos camas King Size, baño privado.</li>
                        <li>- Escritorio, TV por cable y WIFI.</li>
                        <li>- Precio: $120.</li>
                    </ul>
                </div>
            </div>
            <div class="oferta">
                <div class="image-container">
                    <img src="images/hab5.jpg" alt="Suite Simple">
                    <div class="overlay">
                        <span>Suite Simple</span>
                    </div>
                </div>
                <div class="oferta-info">
                    <ul>
                        <li>- Cama King Size, baño privado con jacuzzi.</li>
                        <li>- Escritorio, TV por cable y WIFI.</li>
                        <li>- Precio: $200.</li>
                    </ul>
                </div>
            </div>
            <div class="oferta">
                <div class="image-container">
                    <img src="images/hab6.jpg" alt="Suite Presidencial">
                    <div class="overlay">
                        <span>Suite Presidencial</span>
                    </div>
                </div>
                <div class="oferta-info">
                    <ul>
                        <li>- Dos habitaciones con camas King Size, baño privado.</li>
                        <li>- Sala de estar, comedor, cocina equipada.</li>
                        <li>- Precio: $500.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="button-container" style="position: relative;">
            <button class="reservar" id="reservarAhoraBtn">Reservar Ahora</button>
        </div>

    </section>
</main>

<!-- Modal -->
<div id="reservaModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1>Reserva tu Habitación</h1>
    <form id="form" class="mt-4 flex w-full flex-col" method="POST" action="/reservas">
      <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
        <div class="flex flex-col">
          <label for="initial_date" class="text-lg text-text-50">Fecha De Entrada:</label>
          <input type="date" name="initial_date" id="initial_date" class="inp" placeholder="Fecha de Entrada" min="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="flex flex-col">
          <label for="final_date" class="text-lg text-text-50">Fecha De Salida:</label>
          <input type="date" name="final_date" id="final_date" class="inp" placeholder="Fecha de Salida" min="<?= date('Y-m-d') ?>" required>
        </div>
      </div>
      <div class="mt-2 grid grid-cols-4 gap-x-2 relative w-full">
        <label for="room" class="flex flex-col text-lg text-text-50 col-span-2 md:col-span-3">
          <span>Habitación/Salón:</span>
          <select name="principal_room" id="room" class="inp appearance-none" onchange="handleSelectRoom(this)" required>
            <option value="" selected disabled>Seleccione Una Habitación/salón</option>
            <?php foreach ($tipo_habitaciones as $tipo_habitacion): ?>
              <option data-cant="<?= htmlspecialchars($tipo_habitacion['cantidad']) ?>" value="<?= htmlspecialchars($tipo_habitacion['TIP_HAB_ID'] . '-hab') ?>">
                Habitación - <?= htmlspecialchars($tipo_habitacion['TIP_HAB_DES'] . ' - Capacidad: ' . $tipo_habitacion['TIP_HAB_CAP'] . ' - Activas: ' . $tipo_habitacion['cantidad']) ?>
              </option>
            <?php endforeach; ?>
            <?php foreach ($tipo_salones as $tipo_salon): ?>
              <option data-cant="<?= htmlspecialchars($tipo_salon['cantidad']) ?>" value="<?= htmlspecialchars($tipo_salon['TIP_SAL_ID'] . '-sal') ?>">
                Salón - <?= htmlspecialchars($tipo_salon['TIP_SAL_DES'] . ' - Activos: ' . $tipo_salon['cantidad']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
        <label for="number_rooms" class="relative flex flex-col text-lg text-text-50 col-span-2 md:col-span-1">
          <span>Cantidad Reservada:</span>
          <input type="number" name="principal_num_rooms" id="number_rooms" class="inp" min="1" required>
        </label>
      </div>
      <div id="more_rooms" class="mt-2 grid-cols-4 gap-2 relative w-full hidden"></div>
      <button type="button" class="w-full text-text-50 bg-secondary-600 hover:bg-secondary-700 active:bg-accent-500 rounded-b-md mt-2 py-2" id="add_room">Añadir habitación +</button>
      <div class="flex flex-col relative w-full">
        <label for="client" class="relative flex flex-col text-lg text-text-50">
          <span>Cliente:</span>
          <input type="text" id="client" class="inp" placeholder="Nombre del Cliente" required>
        </label>
        <div id="search_result" class="flex flex-col text-text-950 bg-white rounded-md drop-shadow-md w-full mt-2 max-h-96 overflow-auto"></div>
      </div>
      <div id="client_select" class="hidden text-text-50 rounded-md p-2 bg-accent-950 border-2 border-accent-500">
        <input type="hidden" id="client_id" name="client_id">
        <p class="flex justify-center gap-x-4"><span class="font-semibold">Cédula: </span><span id="client_ced"></span></p>
        <p class="flex justify-center gap-x-4"><span class="font-semibold">Nombre: </span><span id="client_name"></span></p>
        <p class="flex justify-center gap-x-4"><span class="font-semibold">Número Celular: </span><span id="client_phone"></span></p>
        <button type="button" class="text-accent-500 hover:text-accent-700 active:text-accent-300" id="clear_client">Limpiar</button>
      </div>
      <button type="submit" id="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Reservar</button>
    </form>
  </div>
</div>
    <!-- Modal -->
    <div class="hidden relative z-50" id="client_modal" role="dialog">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:my-8 sm:max-w-lg">
                    <form id="client_form" action="reservas.php" method="POST">
                        <div class="flex flex-col gap-y-2 p-4">
                            <h1 class="text-2xl font-semibold text-text-50">Registrar Cliente</h1>
                            <div class="flex flex-row gap-x-2 justify-between">
                                <label for="cedula" class="flex flex-col text-text-50">
                                    <span>Cédula:</span>
                                    <input type="text" id="cedula" name="cedula" class="inp" placeholder="Cédula" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                </label>
                                <label for="nombre" class="flex flex-col text-text-50">
                                    <span>Nombre:</span>
                                    <input type="text" id="nombre" name="nombre" class="inp" placeholder="Nombre" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                                </label>
                            </div>
                            <label for="telefono" class="flex flex-col text-text-50">
                                <span>Número Celular:</span>
                                <input type="text" id="telefono" name="telefono" class="inp" placeholder="Número Celular" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </label>
                            <label for="email" class="flex flex-col text-text-50">
                                <span>Email:</span>
                                <input type="email" id="email" name="email" class="inp" placeholder="Email" required>
                            </label>
                            <label for="direccion" class="flex flex-col text-text-50">
                                <span>Dirección:</span>
                                <input type="text" id="direccion" name="direccion" class="inp" placeholder="Dirección" required>
                            </label>
                            <div class="flex flex-row gap-x-2">
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-text-50 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-text-300 active:bg-text-500 sm:mt-0 sm:w-auto" id="close_modal">Cancelar</button>
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-accent-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-accent-400 active:bg-accent-700 sm:ml-3 sm:w-auto">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
};

let totalRooms = 0;
const ROOM_DEFAULTS = getRoomDefault();

const handleAddRoom = () => {
    const moreRooms = document.getElementById('more_rooms');
    moreRooms.classList.remove('hidden');
    moreRooms.classList.add('grid');
    totalRooms++;

    const options = ROOM_DEFAULTS.map(r => {
        return `<option data-cant="${r.cant ?? ''}" value="${r.value}" ${r.selected ? 'selected' : ''} ${r.disabled ? 'disabled' : ''}>${r.text}</option>`;
    });
    const selectEl = `
        <label id="room_label_${totalRooms}" class="flex flex-col text-lg text-text-50 col-span-2 md:col-span-3">
            <select name="room_${totalRooms}" onchange="handleSelectMoreRooms(this, ${totalRooms})" class="inp appearance-none" required>
                ${options.join('')}
            </select>
        </label>
    `;
    const inputEl = `
        <label id="quantity_label_${totalRooms}" class="relative flex gap-x-2 items-center text-lg text-text-50 col-span-2 md:col-span-1">
            <input type="number" name="quantity_${totalRooms}" class="inp" min="1" required>
            <button onclick="handleRemoveRoom(${totalRooms})" type="button" class="h-full aspect-square bg-secondary-600 hover:bg-secondary-700 active:bg-accent-500 rounded-md grid place-items-center transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
        </label>
    `;
    moreRooms.insertAdjacentHTML('beforeend', selectEl);
    moreRooms.insertAdjacentHTML('beforeend', inputEl);
};

const handleRemoveRoom = (id) => {
    document.getElementById(`room_label_${id}`)?.remove();
    document.getElementById(`quantity_label_${id}`)?.remove();
    totalRooms--;
    if (totalRooms === 0) {
        const moreRooms = document.getElementById('more_rooms');
        moreRooms.classList.remove('grid');
        moreRooms.classList.add('hidden');
    }
};

let timeOut;
let hasFound = false;

const handleSearchUser = (e) => {
    const search = e.target.value.trim();
    if (search.length < 2) {
        if (hasFound) {
            document.getElementById('search_result').innerHTML = '';
            hasFound = false;
        }
        clearTimeout(timeOut);
        return;
    }

    clearTimeout(timeOut);
    timeOut = setTimeout(async () => {
        const url = new URLSearchParams({ search });
        const response = await fetch(`/reservas/clientes/search?${url}`, {
            headers: { 'Content-Type': 'application/json' },
            method: 'GET'
        });
        const data = await response.json();
        if (data.success) {
            showClients(data.data);
        }
    }, 350);
};

const showClients = (data) => {
    hasFound = true;
    const searchResult = document.getElementById('search_result');
    if (data.length === 0) {
        searchResult.innerHTML = '<p class="text-text-400 px-4 py-2">No se encontraron resultados</p>' +
            '<button type="button" onclick="handleOpenClientModal()" class="text-accent-600 font-semibold px-4 py-2 text-left hover:underline">+ Crear Cliente</button>';
        return;
    }

    const clients = data.map(client => `
        <div id="search_${client['CLI_ID']}"
            data-name="${client['CLI_NOM']}"
            data-ced="${client['CLI_CED']}"
            data-phone="${client['CLI__NUM']}"
            class="w-full capitalize relative flex items-center justify-between h-12 border-b border-gray-200">
            <p class="text-text-950 px-4 text-ellipsis overflow-hidden whitespace-nowrap">${client['CLI_NOM']} - ${client['CLI_CED']}</p>
            <button type="button" onclick="handleAddClient(${client['CLI_ID']})" class="h-full aspect-square bg-neutral-300 hover:bg-neutral-400 flex items-center justify-center font-bold">+</button>
        </div>
    `);
    searchResult.innerHTML = clients.join('');
};

const handleAddClient = (id) => {
    const el = document.getElementById(`search_${id}`);
    document.getElementById('client_id').value = id;
    document.getElementById('client_name').textContent = el.dataset.name;
    document.getElementById('client_ced').textContent = el.dataset.ced;
    document.getElementById('client_phone').textContent = el.dataset.phone;
    document.getElementById('search_result').innerHTML = '';
    hasFound = false;
    const clientSearch = document.getElementById('client');
    clientSearch.value = '';
    clientSearch.disabled = true;
    const clientSelect = document.getElementById('client_select');
    clientSelect.classList.remove('hidden');
    clientSelect.classList.add('flex', 'flex-col');
};

const handleClearClient = () => {
    document.getElementById('client_id').value = '';
    document.getElementById('client_name').textContent = '';
    document.getElementById('client_ced').textContent = '';
    document.getElementById('client_phone').textContent = '';
    document.getElementById('client').disabled = false;
    const clientSelect = document.getElementById('client_select');
    clientSelect.classList.remove('flex', 'flex-col');
    clientSelect.classList.add('hidden');
};

const handleOpenClientModal = () => {
    const modal = document.getElementById('client_modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
};

const handleCloseClientModal = () => {
    document.getElementById('search_result').innerHTML = '';
    hasFound = false;
    document.getElementById('client').value = '';
    const modal = document.getElementById('client_modal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
};

const handleSelectRoom = (e) => {
    const cantidad = e.options[e.selectedIndex].dataset.cant;
    document.getElementById('number_rooms').max = cantidad;
};

const handleSelectMoreRooms = (e, id) => {
    const cantidad = e.options[e.selectedIndex].dataset.cant;
    const numRooms = document.getElementById('quantity_label_' + id).querySelector('input');
    numRooms.max = cantidad;
};

const handleSubmit = async (e) => {
    e.preventDefault();
    const clientId = document.getElementById('client_id').value;
    if (!clientId) {
        Swal.fire({
            title: 'Cliente requerido',
            text: 'Por favor busca y selecciona un cliente (o crea uno nuevo) antes de reservar.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    const formData = new FormData(e.target);
    const response = await fetch('/reservas', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(formData)),
        headers: { 'Content-Type': 'application/json' }
    });
    const data = await response.json();
    if (data.success) {
        Swal.fire({
            title: 'Reserva creada',
            text: data.success,
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            window.location.href = '/reservas';
        });
    } else if (data.error) {
        Swal.fire({
            title: 'Error al crear la reserva',
            text: data.error,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
};

const handleClientModalSubmit = async (e) => {
    e.preventDefault();
    const formData = {
        cedula: document.getElementById('cedula').value,
        nombre: document.getElementById('nombre').value,
        telefono: document.getElementById('telefono').value,
        email: document.getElementById('email').value,
        direccion: document.getElementById('direccion').value
    };
    const response = await fetch('/reservas/clientes/crear', {
        method: 'POST',
        body: JSON.stringify(formData),
        headers: { 'Content-Type': 'application/json' }
    });
    const data = await response.json();
    if (data.success) {
        Swal.fire({
            title: 'Cliente creado',
            text: data.success,
            icon: 'success',
            confirmButtonText: 'Aceptar'
        }).then(() => {
            handleCloseClientModal();
            document.getElementById('client_form').reset();
        });
    } else if (data.error) {
        Swal.fire({
            title: 'Error al crear el cliente',
            text: data.error,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('reservaModal');
    const btn = document.getElementById('reservarAhoraBtn');
    const span = document.querySelector('#reservaModal .close');

    btn.onclick = () => { modal.style.display = 'block'; };
    span.onclick = () => { modal.style.display = 'none'; };
    window.onclick = (event) => {
        if (event.target === modal) modal.style.display = 'none';
    };

    const initialDate = document.getElementById('initial_date');
    const finalDate = document.getElementById('final_date');
    initialDate.addEventListener('change', () => {
        if (finalDate.value <= initialDate.value && finalDate.value !== '') {
            Swal.fire({
                title: 'Fecha final inválida',
                text: 'La fecha final no puede ser menor ni igual a la fecha inicial',
                icon: 'warning'
            });
            finalDate.value = '';
        }
        const date = new Date(initialDate.value);
        date.setDate(date.getDate() + 1);
        finalDate.min = date.toISOString().split('T')[0];
    });

    document.getElementById('add_room').addEventListener('click', handleAddRoom);
    document.getElementById('client').addEventListener('keyup', handleSearchUser);
    document.getElementById('clear_client').addEventListener('click', handleClearClient);
    document.getElementById('form').addEventListener('submit', handleSubmit, false);
    document.getElementById('close_modal').addEventListener('click', handleCloseClientModal);
    document.getElementById('client_form').addEventListener('submit', handleClientModalSubmit, false);
});
</script>
<?php require 'partials/footer.php'; ?>
<?php require base_path('views/partials/end.php'); ?>
