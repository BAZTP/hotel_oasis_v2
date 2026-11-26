function buscarEmpleado() {
    const input = document.getElementById('search_term');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('personalTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td');
        let match = false;

        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
        }

        if (match) {
            tr[i].style.display = '';
        } else {
            tr[i].style.display = 'none';
        }
    }
}

function buscarInstalacion() {
    const input = document.getElementById('search_name');
    const filter = input.value.toLowerCase();
    const estadoSelect = document.getElementById('status');
    const estado = estadoSelect.value;
    const table = document.getElementById('instalaciontable');
    const tr = table.getElementsByTagName('tr');
    
    for (let i = 1; i < tr.length; i++) {
    let td = tr[i].getElementsByTagName('td');
    let match = false;
    
    for (let j = 0; j < td.length; j++) {
        if (td[j]) {
            if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                match = true;
                break;
            }
        }
    }
    
    // Mostrar la fila si coincide el término de búsqueda y el estado seleccionado es "Todos" o coincide con el estado de la fila
    if (match && (estado === '0' || td[1].innerText === estadoSelect.options[estadoSelect.selectedIndex].text)) {
        tr[i].style.display = '';
    } else {
        tr[i].style.display = 'none';
    }
    }
    
}

function showConfirmModal(EvaId) {
    document.getElementById('delete_evluacion_id').value = EvaId;
    document.getElementById('modal').classList.remove('hidden');
}

function closeModalDelete() {
    document.getElementById('modal').classList.add('hidden');
}

function openUpdateModal(evaId, persId, cedula, nombre, apellido, cargo, fechaEva, evaluacion) {
    // Obtener los elementos del modal
    var modal = document.getElementById("updateModal");
    var updateIdEva = document.getElementById("updateIdEva");
    var updateId = document.getElementById("updateId");
    var updateCedula = document.getElementById("updateCedula");
    var updateNombre = document.getElementById("updateNombre");
    var updateApellido = document.getElementById("updateApellido");
    var updateCargo = document.getElementById("updateCargo");
    var updateEva = document.getElementById("updateEva");
    

    // Rellenar los campos del modal con la información proporcionada
    updateIdEva.value = evaId;
    updateId.value = persId;
    updateCedula.value = cedula;
    updateNombre.value = nombre;
    updateApellido.value = apellido;
    updateCargo.value = cargo;
    updateEva.value = evaluacion;

    // Mostrar el modal
    modal.classList.remove("hidden");
  }

function closeModal() {
    document.getElementById('updateModal').classList.add('hidden');
  }

  
  document.getElementById('updateEva').addEventListener('input', function (e) {
    
    let value = parseFloat(e.target.value);
    const min = 0.00;
    const max = 10;

    if (value < min) {
        Swal.fire({
            title: "Error! ",
            text: "No se Puede Ingresar un Valor Menor a 0",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then(()=>{
            e.target.value = eva;
        });
    } else if (value > max) {
        Swal.fire({
            title: "Error! ",
            text: "No se Puede Ingresar un Valor Mayor a 10",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then(()=>{
            e.target.value = eva;
        });
        
    }
});

document.addEventListener("DOMContentLoaded", function() {
    function employed_evaluate_update(event) {
        event.preventDefault();
    
        const idPersona = document.getElementById('idpersona').value;
        const evaluacion = document.getElementById('evaluacion').value;
    
        if (idPersona === '' || evaluacion === '') {
            Swal.fire({
                title: "Error",
                text: "Ocurrió un error. Por favor, inténtalo de nuevo.",
                icon: "error",
                showConfirmButton: false,
                timer: 2000
            });
        } else {
            Swal.fire({
                title: "Enviado!",
                text: "Formulario enviado correctamente",
                icon: "success",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                document.getElementById('form_evaluacion').submit();
                // document.querySelector('form').submit();
            });
        }
        
        if (idPersona === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona un empleado.",
                icon: "error",
                showConfirmButton: false,
                timer: 3000
            })
        } else if (evaluacion === '') {
            Swal.fire({
                title: "Error",
                text: "Por favor, ingresa una evaluación.",
                icon: "error",
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            Swal.fire({
                title: "Guardado!",
                text: "Evaluación guardada correctamente",
                icon: "success",
                showConfirmButton: false,
                timer: 3000
            }).then(() => {
                document.getElementById('form_evaluacion').submit();
            });
        }
    
        return false; 
    }
    document.getElementById("actualizar").onclick = employed_evaluate;
});