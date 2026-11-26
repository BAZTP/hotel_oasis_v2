<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-[calc(100vh-5rem)] bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Registro de Ingresos</h1>

        <form id="formIngreso" method="POST" action="/auth/ingresos/procesar" class="mt-6 flex flex-col w-full">
            
            <!-- Sección para Clientes con Factura -->
            <div id="clienteForm" class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <h3 class="text-2xl text-text-50 col-span-2">Datos del Cliente</h3>
                
                <div class="flex flex-col">
                    <label for="cedula" class="text-lg text-text-50">Cédula:</label>
                    <input type="text" class="inp" id="cedula" name="cedula" autocomplete="off">
                    <div id="clienteList" class="mt-2 bg-white border border-gray-300 rounded-md shadow-md max-h-60 overflow-y-auto absolute z-10 hidden"></div>
                </div>
                <div class="flex flex-col">
                    <label for="nombre" class="text-lg text-text-50">Nombre:</label>
                    <input type="text" class="inp" id="nombre" name="nombre" readonly>
                </div>
                <div class="flex flex-col">
                    <label for="direccion" class="text-lg text-text-50">Dirección:</label>
                    <input type="text" class="inp" id="direccion" name="direccion" readonly>
                </div>
                <div class="flex flex-col">
                    <label for="telefono" class="text-lg text-text-50">Teléfono:</label>
                    <input type="text" class="inp" id="telefono" name="telefono" readonly>
                </div>
                <div class="flex flex-col">
                    <label for="email" class="text-lg text-text-50">Email:</label>
                    <input type="text" class="inp" id="email" name="email" readonly>
                </div>
            </div>

            <!-- Sección de Reservas del Cliente -->
            <div id="reservasForm" class="mt-6">
                <h3 class="text-2xl text-text-50">Reservas del Cliente</h3>
                <div id="reservasList" class="mt-2 flex flex-col gap-4">
                    <!-- Aquí se llenarán las reservas con JavaScript -->
                </div>
            </div>

            <!-- Botón para agregar servicios -->
            <button type="button" id="addServiceBtn" class="mt-4 self-center bg-secondary-800 text-white px-4 py-2 rounded-md hover:bg-red-700">Agregar Servicios</button>

            <!-- Sección de Servicios Seleccionados -->
            <div id="serviciosSeleccionados" class="mt-6 hidden">
                <h3 class="text-2xl text-text-50">Servicios Seleccionados</h3>
                <div id="serviciosList" class="mt-2 flex flex-col gap-4">
                    <!-- Aquí se llenarán los servicios seleccionados con JavaScript -->
                </div>
            </div>

            <!-- Cuadro para Monto Total -->
            <div class="mt-6">
                <label for="montoTotal" class="text-lg text-text-50">Monto Total (sin IVA):</label>
                <input type="text" id="montoTotal" name="montoTotal" class="inp" placeholder="Monto Total" readonly>
            </div>

            <!-- Cuadro para Monto a Pagar -->
            <div class="mt-6">
                <label for="montoPagar" class="text-lg text-text-50">Monto a Pagar (con IVA):</label>
                <input type="text" id="montoPagar" name="montoPagar" class="inp" placeholder="Monto a Pagar" readonly>
            </div>

            <!-- Sección de Método de Pago -->
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 mt-6">
                <div class="flex flex-col">
                    <label for="metodo_pago" class="text-lg text-text-50">Método de Pago:</label>
                    <select name="metodo_pago" id="metodo_pago" class="inp appearance-none" required>
                        <option value="" selected disabled>Seleccione Método de Pago</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="tarjeta">Tarjeta Débito/Crédito</option>
                    </select>
                </div>
            </div>

            <!-- Sección de Datos de Tarjeta -->
            <div id="tarjetaForm" class="grid grid-cols-1 gap-2 md:grid-cols-2 hidden">
                <div class="flex flex-col">
                    <label for="numero_tarjeta" class="text-lg text-text-50">Número de Tarjeta:</label>
                    <input type="text" class="inp" id="numero_tarjeta" name="numero_tarjeta">
                </div>
                <div class="flex flex-col">
                    <label for="fecha_expiracion" class="text-lg text-text-50">Fecha de Expiración:</label>
                    <input type="text" class="inp" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/AA">
                </div>
                <div class="flex flex-col">
                    <label for="cvv" class="text-lg text-text-50">CVV:</label>
                    <input type="text" class="inp" id="cvv" name="cvv">
                </div>
            </div>

            <div class="w-full flex justify-end mt-4">
                <button type="submit" class="h-10 px-6 rounded-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500 text-text-50">Registrar Ingreso</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Datos de los clientes y reservas, pasar desde PHP al JS
        const clientes = <?= json_encode($clientes) ?>;
        const tiposServicios = <?= json_encode($tipos_servicios) ?>;

        document.addEventListener("DOMContentLoaded", () => {
            const cedulaInput = document.getElementById("cedula");
            const clienteList = document.getElementById("clienteList");
            const nombreInput = document.getElementById("nombre");
            const direccionInput = document.getElementById("direccion");
            const telefonoInput = document.getElementById("telefono");
            const emailInput = document.getElementById("email");
            const reservasList = document.getElementById("reservasList");
            const addServiceBtn = document.getElementById("addServiceBtn");
            const serviciosList = document.getElementById("serviciosList");
            const serviciosSeleccionados = document.getElementById("serviciosSeleccionados");
            const montoTotalInput = document.getElementById("montoTotal");
            const montoPagarInput = document.getElementById("montoPagar");

            // Filtrar clientes y mostrar coincidencias
            cedulaInput.addEventListener("input", () => {
                const searchValue = cedulaInput.value.toLowerCase();
                clienteList.innerHTML = "";
                reservasList.innerHTML = "";
                if (searchValue) {
                    const filteredClientes = clientes.filter(cliente => 
                        cliente.CLI_CED.toLowerCase().includes(searchValue) || 
                        cliente.CLI_NOM.toLowerCase().includes(searchValue)
                    );
                    
                    if (filteredClientes.length > 0) {
                        clienteList.classList.remove("hidden");
                        filteredClientes.forEach(cliente => {
                            const item = document.createElement("div");
                            item.textContent = `${cliente.CLI_CED} - ${cliente.CLI_NOM}`;
                            item.className = "p-2 cursor-pointer hover:bg-gray-200";
                            item.addEventListener("click", () => {
                                cedulaInput.value = cliente.CLI_CED;
                                nombreInput.value = cliente.CLI_NOM;
                                direccionInput.value = cliente.direccion; // Cambiado para mostrar la dirección correcta
                                telefonoInput.value = cliente.CLI__NUM; // Asumí que CLI__NUM es teléfono
                                emailInput.value = cliente.CLI_EMAIL;
                                clienteList.classList.add("hidden");
                                mostrarReservas(cliente.CLI_ID);
                            });
                            clienteList.appendChild(item);
                        });
                    } else {
                        clienteList.classList.add("hidden");
                    }
                } else {
                    clienteList.classList.add("hidden");
                }
            });

            // Mostrar reservas del cliente
            function mostrarReservas(clienteId) {
                const cliente = clientes.find(c => c.CLI_ID === clienteId);
                if (cliente && cliente.reservas) {
                    reservasList.innerHTML = ""; // Limpiar reservas
                    if (cliente.reservas.length > 0) {
                        cliente.reservas.forEach(reserva => {
                            const reservaItem = document.createElement("div");
                            reservaItem.className = "relative flex gap-4";
                            reservaItem.innerHTML = `
                                <div class="aspect-square h-full w-auto rounded-lg bg-accent-800">
                                    <!-- Aquí podrías agregar una imagen o ícono representativo -->
                                </div>
                                <div class="relative px-2 text-text-300">
                                    <p class="text-lg font-semibold text-text-200">Habitación ${reserva.HAB_ID} | Activa</p>
                                    <p class="w-full overflow-hidden text-ellipsis whitespace-nowrap text-sm">Cliente: ${cliente.CLI_NOM}</p>
                                    <p class="text-sm">Fecha: ${reserva.RES_FECH}</p>
                                    <p class="text-sm">${reserva.RES_FECH_INI} a ${reserva.RES_FECH_FIN}</p>
                                    <div class="flex flex-col">
                                        <label for="monto_reserva_${reserva.RES_ID}" class="text-lg text-text-50">Monto Reservas:</label>
                                        <input type="text" class="inp monto-reserva" id="monto_reserva_${reserva.RES_ID}" name="monto_reserva_${reserva.RES_ID}" value="${reserva.RES_MONTO ?? ''}" required pattern="^\\d+(\\.\\d{1,2})?$" title="Solo números positivos con hasta dos decimales.">
                                    </div>
                                </div>
                            `;
                            reservasList.appendChild(reservaItem);
                        });
                    } else {
                        reservasList.innerHTML = `
                            <div class="flex items-center justify-center p-4 bg-red-100 border border-red-300 rounded-md text-red-700">
                                <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6m1 2V5h4v4m-1-4H16m1 0V5m-1 0V4m-1 0h-6a1 1 0 00-1 1v1h-4v4h1v5m-1 5v-5H5v5m0-8h1v-3H5m0 3h2v5h-2m8 0V8h-2v5m2 0h-1V8h1v5m-1 5v-2h-1v2"/>
                                </svg>
                                <span class="font-semibold">No hay reservas para este cliente.</span>
                            </div>
                        `;
                    }
                } else {
                    reservasList.innerHTML = `
                        <div class="flex items-center justify-center p-4 bg-gray-100 border border-gray-300 rounded-md text-gray-700">
                            <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6m1 2V5h4v4m-1-4H16m1 0V5m-1 0V4m-1 0h-6a1 1 0 00-1 1v1h-4v4h1v5m-1 5v-5H5v5m0-8h1v-3H5m0 3h2v5h-2m8 0V8h-2v5m2 0h-1V8h1v5m-1 5v-2h-1v2"/>
                        </svg>
                        <span class="font-semibold">No hay reservas disponibles.</span>
                    `;
                }
            }

            // Mostrar servicios disponibles al hacer clic en "Agregar Servicios"
            addServiceBtn.addEventListener('click', () => {
                serviciosSeleccionados.classList.remove('hidden');
                serviciosList.innerHTML = '';

                tiposServicios.forEach(servicio => {
                    const servicioItem = document.createElement('div');
                    servicioItem.className = 'flex items-center gap-2 mb-2';
                    servicioItem.innerHTML = `
                        <input type="checkbox" id="servicio_${servicio.TIP_SERV_ID}" name="servicios[]" value="${servicio.TIP_SERV_ID}" class="inp servicio-checkbox">
                        <label for="servicio_${servicio.TIP_SERV_ID}" class="text-text-50">${servicio.TIP_SERV_DET}</label>
                        <input type="number" step="0.01" min="0" class="inp monto-servicio ml-2" id="monto_servicio_${servicio.TIP_SERV_ID}" name="monto_servicio_${servicio.TIP_SERV_ID}" placeholder="Monto" value="0" disabled>
                    `;
                    serviciosList.appendChild(servicioItem);
                });

                // Al marcar/desmarcar un servicio, habilitar su monto y poner los desmarcados en 0
                serviciosList.querySelectorAll('.servicio-checkbox').forEach(cb => {
                    cb.addEventListener('change', () => {
                        serviciosList.querySelectorAll('.servicio-checkbox').forEach(otherCb => {
                            const montoInput = otherCb.closest('div').querySelector('.monto-servicio');
                            if (otherCb.checked) {
                                montoInput.disabled = false;
                                if (parseFloat(montoInput.value) === 0 || montoInput.value === '') {
                                    montoInput.value = '';
                                    montoInput.focus();
                                }
                            } else {
                                montoInput.value = '0';
                                montoInput.disabled = true;
                            }
                        });
                        actualizarMontoTotal();
                    });
                });

                actualizarMontoTotal();
            });

            // Actualizar monto total al cambiar el monto de las reservas o servicios
            function actualizarMontoTotal() {
                let montoTotal = 0;

                document.querySelectorAll('.monto-reserva').forEach(input => {
                    montoTotal += parseFloat(input.value) || 0;
                });

                document.querySelectorAll('.monto-servicio').forEach(input => {
                    montoTotal += parseFloat(input.value) || 0;
                });

                montoTotalInput.value = montoTotal.toFixed(2);

                const montoConIva = montoTotal * 1.15;
                montoPagarInput.value = montoConIva.toFixed(2);
            }

            // Eventos para actualizar el monto total
            document.addEventListener('input', actualizarMontoTotal, true);

        });

        // Código JavaScript para mostrar/ocultar formulario de tarjeta de crédito según el método de pago seleccionado
        document.getElementById("metodo_pago").addEventListener("change", function() {
            var selectedOption = this.value;
            var tarjetaForm = document.getElementById("tarjetaForm");

            if (selectedOption === "tarjeta") {
                tarjetaForm.classList.remove("hidden");
            } else {
                tarjetaForm.classList.add("hidden");
            }
        });
    </script>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>


<!-- <div class="relative flex grow">
							<div class="aspect-square h-full w-auto rounded-lg bg-accent-800">

							</div>
							<div class="relative px-2 text-text-300">
								<p class="text-lg font-semibold text-text-200">Habitación 4 | Activa</p>
								<p class="w-full overflow-hidden text-ellipsis whitespace-nowrap text-sm">Cliente: Maria Gomez</p>
								<p class="text-sm">Fecha: 2024-07-10</p>
								<p class="text-sm">2024-07-11 a 2024-07-13</p>
							</div>
							<!--                        <div class="relative px-2 text-text-300">-->
							<!--                            <p class="text-lg font-semibold text-text-200">Habitación --><!-- | --><!--</p>-->
							<!--                            <p class="w-full overflow-hidden text-ellipsis whitespace-nowrap text-sm">Cliente: --><!--</p>-->
							<!--                            <p class="text-sm">Fecha: --><!--</p>-->
							<!--                            <p class="text-sm">--><!-- a --><!--</p>-->
							<!--                        </div>-->
						</div>


                        