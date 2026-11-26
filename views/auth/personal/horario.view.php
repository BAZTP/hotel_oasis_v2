<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Marcar</h1>

    <!-- Reloj Digital -->
    <div id="clock" class="text-4xl font-bold text-center text-white py-4"></div>

    <!-- Formulario para ingresar la cédula -->
    <div class="flex justify-center space-x-4 py-4">
        <input type="text" id="cedula" class="h-10 w-40 rounded-l-md p-2 outline-0 bg-background-white text-text-black" placeholder="Ingrese cédula">
    </div>

    <!-- Mostrar Nombre del Personal -->
    <div class="text-center text-white py-4">
        <span id="nombrePersonal" class="text-2xl font-semibold"></span>
    </div>

    <!-- Botones de Registro de Asistencia -->
    <div class="flex justify-center space-x-4 py-4">
        <button id="btnLlegada" onclick="registrarEvento('llegada')" class="px-4 py-2 bg-green-500 text-white rounded">Registrar Llegada</button>
        <button id="btnInicioAlmuerzo" onclick="registrarEvento('inicio_almuerzo')" class="px-4 py-2 bg-yellow-500 text-white rounded" disabled>Iniciar Almuerzo</button>
        <button id="btnFinAlmuerzo" onclick="registrarEvento('fin_almuerzo')" class="px-4 py-2 bg-yellow-500 text-white rounded" disabled>Finalizar Almuerzo</button>
        <button id="btnSalida" onclick="registrarEvento('salida')" class="px-4 py-2 bg-red-500 text-white rounded" disabled>Registrar Salida</button>
    </div>

    <!-- Tabla de Registros de Hoy -->
    <div class="w-full mt-8 flex justify-center">
        <table class="min-w-full divide-y divide-background-800" id="tablaRegistros">
            <thead class="bg-background-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Cédula</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Hora Llegada</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Inicio Almuerzo</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Fin Almuerzo</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Hora Salida</th>
                </tr>
            </thead>
            <tbody id="tbodyRegistros">
                <!-- Los registros se agregarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>

<script>
function updateClock() {
    const now = moment().tz("America/Guayaquil");
    const clock = document.getElementById('clock');
    clock.innerText = now.format('HH:mm:ss');
}

setInterval(updateClock, 1000);
updateClock();

let asistenciaId = null;

function registrarEvento(tipo) {
    const cedula = document.getElementById('cedula').value.trim();
    if (!cedula) {
        Swal.fire('Error', 'Por favor, ingrese la cédula', 'error');
        return;
    }

    const now = moment().tz("America/Guayaquil");
    const timeString = now.format('YYYY-MM-DD HH:mm:ss');

    fetch('/auth/personal/horario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ tipo, timeString, cedula }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('nombrePersonal').innerText = data.nombre;
            Swal.fire('Éxito', `Hora de ${tipo.replace('_', ' ')} registrada: ${timeString}`, 'success');
            desbloquearSiguienteBoton(tipo);
            actualizarTabla(data.registros);
        } else {
            Swal.fire('Error', `Error: ${data.message}`, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Hubo un problema al registrar el evento.', 'error');
    });
}

function desbloquearSiguienteBoton(tipo) {
    switch (tipo) {
        case 'llegada':
            document.querySelector('button[onclick="registrarEvento(\'inicio_almuerzo\')"]').disabled = false;
            document.querySelector('button[onclick="registrarEvento(\'llegada\')"]').disabled = true;
            document.querySelector('button[onclick="registrarEvento(\'llegada\')"]').classList.remove('bg-green-500');
            document.querySelector('button[onclick="registrarEvento(\'llegada\')"]').classList.add('bg-gray-500');
            break;
        case 'inicio_almuerzo':
            document.querySelector('button[onclick="registrarEvento(\'fin_almuerzo\')"]').disabled = false;
            document.querySelector('button[onclick="registrarEvento(\'inicio_almuerzo\')"]').disabled = true;
            document.querySelector('button[onclick="registrarEvento(\'inicio_almuerzo\')"]').classList.remove('bg-yellow-500');
            document.querySelector('button[onclick="registrarEvento(\'inicio_almuerzo\')"]').classList.add('bg-gray-500');
            break;
        case 'fin_almuerzo':
            document.querySelector('button[onclick="registrarEvento(\'salida\')"]').disabled = false;
            document.querySelector('button[onclick="registrarEvento(\'fin_almuerzo\')"]').disabled = true;
            document.querySelector('button[onclick="registrarEvento(\'fin_almuerzo\')"]').classList.remove('bg-yellow-500');
            document.querySelector('button[onclick="registrarEvento(\'fin_almuerzo\')"]').classList.add('bg-gray-500');
            break;
        case 'salida':
            document.querySelector('button[onclick="registrarEvento(\'salida\')"]').disabled = true;
            document.querySelector('button[onclick="registrarEvento(\'salida\')"]').classList.remove('bg-red-500');
            document.querySelector('button[onclick="registrarEvento(\'salida\')"]').classList.add('bg-gray-500');
            break;
    }
}

function actualizarTabla(registros) {
    const tbody = document.getElementById('tbodyRegistros');
    tbody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos registros

    registros.forEach(registro => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">${registro.PERS_CED}</td>
            <td class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">${registro.PERS_NOM}</td>
            <td class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">${registro.ASIST_HORA_LLEGADA || ''}</td>
            <td class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">${registro.ASIST_HORA_ALMU_INI || ''}</td>
            <td class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">${registro.ASIST_HORA_ALMU_FIN || ''}</td>
            <td class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">${registro.ASIST_HORA_SALIDA || ''}</td>
        `;
        tbody.appendChild(tr);
    });
}
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
