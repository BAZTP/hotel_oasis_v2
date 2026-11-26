
function buscarEmpleado() {
    const input = document.getElementById('search_term');
    const filter = input.value.toLowerCase();
    const estadoSelect = document.getElementById('status');
    const estado = estadoSelect.value;
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
    
        // Mostrar la fila si coincide el término de búsqueda y el estado seleccionado es "Todos" o coincide con el estado de la fila
        if (match && (estado === '0' || td[7].innerText === estadoSelect.options[estadoSelect.selectedIndex].text)) {
          tr[i].style.display = '';
        } else {
          tr[i].style.display = 'none';
        }
      }
}

function showConfirmModal(insId) {
    document.getElementById('delete_personal_id').value = insId;
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function openUpdateModal(id, tipo, estado, horaInicio, horaFin) {
    document.getElementById('updateId').value = id;
    document.getElementById('updateTipo').value = tipo;
    document.getElementById('updateEstado').value = estado;
    document.getElementById('updateHoraInicio').value = horaInicio;
    document.getElementById('updateHoraFin').value = horaFin;

    document.getElementById('updateModal').classList.remove('hidden');
}

// Función para cerrar el modal de actualización
function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}

document.getElementById('status').addEventListener('change', buscarEmpleado);