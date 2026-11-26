let timeOut
let hasFound = false;
const handleSearchEmployed = async (e) => {
    const search = e.target.value;
    console.log(search);
    if(search.length < 3) {
        if (hasFound) {
            const searchResult = document.getElementById('search_resultado');
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
        const response = await fetch(`/auth/evaluacion/evaluar/search?${url}`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET'
        });
        const data = await response.json();
        if (data.success) {
            showEmployed(data.data);
        }
    }, 1000);
}

const handleAddEmployed = (id) => {
	const employedId = document.getElementById('idpersona');
	const employedCed = document.getElementById('cedula');
	const employedName = document.getElementById('nombre');
	const employedApe = document.getElementById('apellido');
	const employedCar = document.getElementById('cargo');
	employedId.value = id;
	employedCed.value = document.getElementById(`search_${id}`).dataset.ced;
	employedName.value = document.getElementById(`search_${id}`).dataset.name;
	employedApe.value = document.getElementById(`search_${id}`).dataset.ape;
	employedCar.value = document.getElementById(`search_${id}`).dataset.car;
	const searchResult = document.getElementById('search_resultado');
	searchResult.innerHTML = '';
	hasFound = false;
	const employedSearch = document.getElementById('search');
	employedSearch.value = '';
	employedSearch.disabled = false;
}
const showEmployed = (data) => {
    hasFound = true;
    const searchResult = document.getElementById('search_resultado');
    if(data.length === 0) {
        searchResult.innerHTML = '<p class="text-center">No se encontraron resultados</p>';
        return;
    }

    const employes = data.map(employed => {
        return `
            <div 
				id="search_${employed['PERS_ID']}"
				data-ced="${employed['PERS_CED']}"
				data-name="${employed['PERS_NOM']}"
				data-ape="${employed['PERS_APE']}"
				data-car="${employed['TIP_CAR_DES']}"
				class="w-full capitalize relative flex items-center justify-between h-12">
				<p class="text-text-400 px-4 text-ellipsis w-fit">${employed['PERS_NOM']} - ${employed['PERS_APE']} - ${employed['PERS_CED']}</p>
				<button type="button" onclick="handleAddEmployed(${employed['PERS_ID']})" class="h-full aspect-square bg-neutral-400 flex items-center justify-center first:rounded-tr-md last:rounded-br-md">
					+
				</button>
			</div>`

    });
    searchResult.innerHTML = employes.join('');
}
window.addEventListener('load', () => {
    const employedSearch = document.getElementById('search');
    employedSearch.addEventListener('keyup', handleSearchEmployed);
});

document.addEventListener("DOMContentLoaded", function() {
    function employed_evaluate(event) {
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
    document.getElementById("guardar").onclick = employed_evaluate;
});

document.getElementById('evaluacion').addEventListener('input', function (e) {
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
            e.target.value = "";
        });
    } else if (value > max) {
        Swal.fire({
            title: "Error! ",
            text: "No se Puede Ingresar un Valor Mayor a 10",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then(()=>{
            e.target.value = "";
        });
        
    }
});