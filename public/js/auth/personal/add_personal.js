function actualizarTipoSueldo() {
    const tipoCargoSelect = document.getElementById('tipo_cargo');
    const tipoSueldoInput = document.getElementById('sueldo');
    const tipoCargoId = tipoCargoSelect.value;

    if (tipoCargoId) {
        fetch(`?tipo_cargo_id=${tipoCargoId}`)
            console.log(`El valor es ${tipoCargoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.tipo_sueldo) {
                    tipoSueldoInput.value = data.tipo_sueldo;
                } else {
                    tipoSueldoInput.value = "No disponible";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tipoSueldoInput.value = "Error al obtener el tipo de sueldo";
            });
    } else {
        tipoSueldoInput.value = "";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    var fecha_nacimiento = document.getElementById("fecha_nacimiento");
    var today = new Date();
    var minDate = new Date(today.getFullYear() - 70, today.getMonth(), today.getDate());
    var minDateString = minDate.toISOString().split('T')[0];
    var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    var maxDateString = maxDate.toISOString().split('T')[0];
    fecha_nacimiento.setAttribute('min', minDateString);
    fecha_nacimiento.setAttribute('max', maxDateString);
});

// document.addEventListener('DOMContentLoaded', (event) => {
//     const input = document.getElementById('sueldo');
    
//     // Ocultar el valor inicial visualmente
//     input.value = '';
    
//     // Cuando el usuario empiece a escribir, dejar que vea lo que está escribiendo
//     input.addEventListener('input', function() {
//       if (this.value === '') {
//         this.value = '0';
//       }
//     });
// });

document.addEventListener('DOMContentLoaded', (event) => {
    const inputs = document.querySelectorAll('.mayusculas');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            input.value = input.value.toUpperCase();
        });
    });
});

document.getElementById("tipo_cargo").addEventListener("change", function() {
    var selectedOption = this.options[this.selectedIndex];
    var valorIngreso = selectedOption.getAttribute("data-valor");
    document.getElementById("sueldo").value = valorIngreso;
});



document.getElementById('cedula').addEventListener('blur', function (e) {
    let cedula = e.target.value;

    if (cedula.length < 10 && isNaN(cedula)) {
        Swal.fire({
            title: "Error!",
            text: "No Permitido Cédulas Extranjeras",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then((result) => {
            if (!result.isConfirmed) {
                e.target.value = "";
            }
        });
        return;
    }

    if (cedula.length < 10) {
        Swal.fire({
            title: "Error!",
            text: "Faltan dígitos",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            e.target.value = "";
        });
        return;
    }

    let nro_region = cedula.substring(0, 2);
    if (nro_region < 1 || nro_region > 24) {
        Swal.fire({
            title: "Error!",
            text: "Este número de cédula no corresponde a ninguna provincia del Ecuador",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            e.target.value = "";
        });
        return;
    }

    let ult_digito = parseInt(cedula.substring(9, 10));
    let suma_pares = 0;
    let suma_impares = 0;

    for (let i = 0; i < 9; i++) {
        let num = parseInt(cedula.charAt(i));
        if (i % 2 === 0) {
            num = num * 2;
            if (num > 9) {
                num -= 9;
            }
            suma_impares += num;
        } else {
            suma_pares += num;
        }
    }

    let suma_total = suma_pares + suma_impares;
    let decena_superior = Math.ceil(suma_total / 10) * 10;
    let digito_validador = decena_superior - suma_total;
    if (digito_validador === 10) {
        digito_validador = 0;
    }

    if (digito_validador !== ult_digito) {
        Swal.fire({
            title: "Error!",
            text: "Cédula incorrecta, por favor ingrese una cédula válida",
            icon: "error",
            showConfirmButton: false,
            timer: 3000
        }).then(() => {
            e.target.value = "";
        });
        return;
    }

    // Si la cédula es correcta
    Swal.fire({
        title: "¡Correcto!",
        text: "La cédula es válida",
        icon: "success",
        showConfirmButton: false,
        timer: 3000
    });
});

document.getElementById('cedula').addEventListener('input', function (e) {
    let cedula = e.target.value;

    if (isNaN(cedula)) {
        Swal.fire({
            title: "Error!",
            text: "Es una cédula extranjera. ¿Desea continuar?",
            icon: "warning",
            showConfirmButton: true
        }).then((result) => {
            if (!result.isConfirmed) {
                e.target.value = "";
            }
        });
    }
});

function cedulaRepetida() {
    Swal.fire({
        position: 'top-center',
        icon: 'error',
        title: 'Cédula existente en la base de datos',
        text: 'Por favor ingrese una cédula que no exista en la base de datos',
        showConfirmButton: false,
        timer: 3000
    });
}
