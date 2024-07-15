// const { series } = require("gulp");

let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // cambia la seccion cuando se presione lso tabs
    botonesPaginador(); // agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    consultarAPI(); // consulta la API en el back de PHP

    idCliente();
    nombreCliente(); // añade el nombre del cliente al objeto de cita
    seleccionarFecha(); // aniade la fecha de la cita al objeto
    seleccionarHora(); // aniade la hora de la cita al objeto
    mostrarResumen();
}

function mostrarSeccion() {
    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }



    // seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // Quitar la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (event) {
            paso = parseInt(event.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        });
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    } else if (paso === 2) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}


function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}

async function consultarAPI() {
    try {
        const url = '${location.origin}/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);


    } catch (error) {
        console.log(error);
    }
}


function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    // identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    // comprobar si u nservicio ya fue agregado
    if (servicios.some(agregado => agregado.id === id)) {
        // eliminardo 
        divServicio.classList.remove('seleccionado');
    } else {
        // agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }

}

function idCliente() {
    cita.id = document.querySelector('#id').value;
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;

    console.log(nombre);
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (event) {

        const dia = new Date(event.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            event.target.value = [];
            mostrarAlerta('Fines de semana no disponible', 'error', '.formulario');
        } else {
            cita.fecha = event.target.value;
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (event) {

        const horaCita = event.target.value;
        const hora = horaCita.split(":")[0];
        if (hora < 9 || hora > 23) {
            event.target.value = '';
            mostrarAlerta('Hora no valida', 'error', '.formulario');
        } else {
            cita.hora = event.target.value;
            // console.log(cita);
        }
    });
}



function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    // previene que se cree la alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }

    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    // eliminar la alerta
    if (desaparece) {
        setTimeout(() => {
            alerta.remove();
        },  4000);
    }
}

    function mostrarResumen() {
        const resumen = document.querySelector('.contenido-resumen');
        // limpiar el contenido de resumen
            while(resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }

        if (Object.values(cita).includes('') || cita.servicios.length === 0) {
            mostrarAlerta('faltan datos de servicio u horario.', 'error', 
            '.contenido-resumen', false);
            return;
        } 

            // Formatear el DIV de resumen
            const { nombre, fecha, hora, servicios } = cita;

            // Heading para servicio en resumen
            const headingServicio = document.createElement('H3');
            headingServicio.textContent = 'Resumen de servicios';
            resumen.appendChild(headingServicio);

            // iterar y mostrar los servicios
            servicios.forEach(servicio => {
            const { id, precio, nombre} = servicio;
            const contenedorServicio = document.createElement('DIV');
            contenedorServicio.classList.add('contenedor-servicio');

            const textoServicio = document.createElement('P');
            textoServicio.textContent = nombre;

            const precioServicio = document.createElement('P');
            precioServicio.innerHTML = `<span>Precio: </span> $ ${precio}`;

            contenedorServicio.appendChild(textoServicio);
            contenedorServicio.appendChild(precioServicio);

            resumen.appendChild(contenedorServicio);
        });

        // Heading para servicio en resumen
        const headingCita = document.createElement('H3');
        headingCita.textContent = 'Resumen de citas';
        resumen.appendChild(headingCita);

        // formato de fecha en latino
        const fechaObj = new Date(fecha);
        const mes =  fechaObj.getMonth();
        const dia =  fechaObj.getDate() + 2;
        const year = fechaObj.getFullYear();

        const fechaUTC = new Date( Date.UTC(year, mes, dia));

        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'}
        const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones);

        const nombreCliente = document.createElement('P');
        nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

        const fechaCita = document.createElement('P');
        fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

        const horaCita = document.createElement('P');
        horaCita.innerHTML = `<span>Hora: </span> ${hora} hs`;

        // Boton para crear una cita
        const botonReservar = document.createElement('BUTTON');
        botonReservar.classList.add('boton');
        botonReservar.textContent = 'Reservar Cita';
        botonReservar.onclick = reservarCita; 

        resumen.appendChild(nombreCliente);
        resumen.appendChild(fechaCita);
        resumen.appendChild(horaCita);
        resumen.appendChild(botonReservar);
    }

    async function reservarCita() {
        const { nombre, fecha, hora, servicios, id} = cita;

        const idServicios = servicios.map( servicio => servicio.id ) 
        // map busca las coincidencias y devuelve un arreglo modificado, Foreach modifica el propio arreglo
        // console.log(idServicios);
        

        const datos = new FormData();

        datos.append('fecha', fecha);
        datos.append('hora', hora);
        datos.append('usuariosid', id);
        datos.append('servicios', idServicios);

        // console.log(FormData);

        try {
        // peticion hacia la api

        const url = '${location.origin}/api/citas';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        console.log(resultado.resultado);

        if(resultado.resultado) {
            Swal.fire({
                icon: "succes",
                title: "Cita creada",
                text: "Tu cita fue creada correctamente",
                footer: 'Juan Mohr JR Developer',
                button: 'OK'
            }).then(() => {
                window.location.reload();
            });
        } 
        } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Hay algo mal que no esta bien!",
                    text: "Tu cita no se pudo crear, fijate lo que haces lpm!",
                    footer: 'Juan Mohr JR Developer',
                    button: ':('
                  });
        }



        // console.log(...datos);  // es una forma de ver los datos a enviar en un arreglo
        // ya que FormData no te los deja ver. 
    }


    