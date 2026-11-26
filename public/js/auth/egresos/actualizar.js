let timeout;
let hasFound = false;

const handleSearchEgreso = async (e) => {
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
        const response = await fetch(`/auth/egresos/search?${url}`, {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'GET'
        });
        const data = await response.json();
        if (data.success) {
            showEgresos(data.data);
        }
    }, 1000);
}

const handleDeleteEgreso = (id) => {
    const egreso = document.getElementById(`egreso_${id}`);
    egreso.remove();
    totalEgresos--;
    if (totalEgresos === 0) {
        const defaultMsg = document.getElementById('default_msg');
        defaultMsg.classList.remove('hidden');
    }
}

let totalEgresos = 0;

const handleAddEgreso = (id) => {
    const egresosDiv = document.getElementById('egresos');
    const egreso = `
        <div id="egreso_${totalEgresos}" class="flex flex-row bg-background-950 items-center justify-between rounded-md border-2 border-accent-500 p-2">
            <input type="hidden" name="egreso_${totalEgresos}" value="${id}">
            <p> ${document.getElementById(`search_${id}`).dataset.descripcion} - ${document.getElementById(`search_${id}`).dataset.monto}</p>
            <button type="button" onclick="handleDeleteEgreso(${totalEgresos})" class="h-full text-text-50 bg-accent-950 hover:bg-accent-900 active:bg-accent-800 rounded-md p-1">Eliminar</button>
        </div>
    `;
    egresosDiv.insertAdjacentHTML('beforeend', egreso);

    const searchResult = document.getElementById('search_result');
    searchResult.innerHTML = '';
    hasFound = false;
    const egresoSearch = document.getElementById('egreso');
    egresoSearch.value = '';
    const defaultMsg = document.getElementById('default_msg');
    defaultMsg.classList.add('hidden');
    totalEgresos++;
}

const showEgresos = (data) => {
    hasFound = true;
    const searchResult = document.getElementById('search_result');
    if (data.length === 0) {
        searchResult.innerHTML = '<p class="text-center">No se encontraron resultados</p>';
        return;
    }

    const egresos = data.map(egreso => {
        return `
            <div 
				id="search_${egreso['EGR_ID']}"
				data-descripcion="${egreso['EGR_DES']}"
				data-monto="${egreso['EGR_MON']}"
				data-fecha="${egreso['EGR_FEC']}"
				data-tipo="${egreso['EGR_TIP_ID']}"
				class="w-full capitalize relative flex items-center justify-between h-12">
				<p class="text-text-400 px-4 text-ellipsis w-fit">${egreso['EGR_DES']} - ${egreso['EGR_MON']}</p>
				<button type="button" onclick="handleAddEgreso(${egreso['EGR_ID']})" class="h-full aspect-square bg-neutral-400 flex items-center justify-center first:rounded-tr-md last:rounded-br-md">
					+
				</button>
			</div>`;
    });

    searchResult.innerHTML = egresos.join('');
}

window.addEventListener('load', () => {
    const egresoSearch = document.getElementById('egreso');
    egresoSearch.addEventListener('keyup', handleSearchEgreso);
});
