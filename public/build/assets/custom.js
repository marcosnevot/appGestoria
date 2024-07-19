document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar todos los elementos de servicio y el contenedor de detalles del servicio
    const serviceList = document.querySelectorAll('.service');
    const serviceDetailsContainer = document.querySelector('.service-details-container');

    // Función para obtener la descripción del servicio según su ID
    function getServiceDescription(serviceId) {
        switch (serviceId) {
            case '1':
                return `<ul>
                    <li>Confección de los impresos para la presentación de las declaraciones fiscales mensuales y trimestrales y los resúmenes anuales.</li>
                    <li>Alta de Empresas y Autónomos en la Agencia Tributaria y en Seguridad Social.</li>
                    <li>Confección Impuesto sobre la Renta y Patrimonio.</li>
                    <li>Impuesto sobre Sociedades.</li>
                    <li>Alta en el Impuesto de Actividades Económicas.</li>
                    <li>Estudio y confección de Módulos.</li>
                    <li>Solicitud de aplazamientos.</li>
                    <li>Asesoramiento permanente en materia fiscal.</li>
                    <li>Información periódica de las obligaciones fiscales.</li>
                </ul>`;
            case '2':
                return `<ul>
                    <li>Confección informatizada de la contabilidad de la empresa</li>
                    <li>Revisión, regulación y cierre de la contabilidad</li>
                    <li>Confección de libros registro</li>
                    <li>Proceso de datos en Módulos</li>
                    <li>Análisis de viabilidad y Rentabilidad</li>
                    <li>Asesoramiento permanente en materia contable</li>
                </ul>`;
            case '3':
                return `<ul>
                    <li>Cálculo y confección de nóminas y seguros sociales</li>
                    <li>Tramitación de solicitudes de alta, baja y variación de datos del trabajador</li>
                    <li>Asesoramiento sobre tipos de contrato y bonificaciones</li>
                    <li>Confección de contrato de trabajo y prórrogas</li>
                    <li>Partes de accidentes de trabajo (Delt@)</li>
                    <li>Finiquitos, notificaciones de fin de contrato y certificados de empresa</li>
                    <li>Vida laboral de empresa y certificados</li>
                    <li>Solicitud de prestaciones de la Seguridad Social</li>
                </ul>`;
            case '4':
                return `<ul>
                    <li>Constitución de Sociedades Mercantiles y Cooperativas</li>
                    <li>Legalización de los Libros Contables y de Actas en el Registro Mercantil o Registro de Cooperativas</li>
                    <li>Ampliación o reducción de Capital</li>
                    <li>Depósito de las Cuentas Anuales en el Registro Mercantil o Registro de Cooperativas</li>
                    <li>Informes y peritaciones judiciales</li>
                </ul>`;
            default:
                return "";
        }
    }

    // Función para actualizar los detalles del servicio
    function updateServiceDetails(title, description) {
        const serviceDetailsTitle = serviceDetailsContainer.querySelector('.service-details-title');
        const serviceDetailsDescription = serviceDetailsContainer.querySelector('.service-details-description');
        serviceDetailsTitle.textContent = title;
        serviceDetailsDescription.innerHTML = description;
        serviceDetailsContainer.classList.add('active');
    }

    // Inicializar el primer servicio como activo y mostrar sus detalles
    const firstService = serviceList[0];
    firstService.classList.add('active');
    updateServiceDetails(
        firstService.querySelector('.service-title').textContent,
        getServiceDescription(firstService.dataset.serviceId)
    );

    // Asignar eventos de clic a cada servicio
    serviceList.forEach(service => {
        service.addEventListener('click', function () {
            // Remover la clase activa de todos los servicios y agregarla al seleccionado
            serviceList.forEach(item => item.classList.remove('active'));
            this.classList.add('active');

            // Actualizar los detalles del servicio seleccionado
            updateServiceDetails(
                this.querySelector('.service-title').textContent,
                getServiceDescription(this.dataset.serviceId)
            );

            // Animación para el contenedor de detalles del servicio
            serviceDetailsContainer.classList.add('animate');
            setTimeout(() => serviceDetailsContainer.classList.remove('animate'), 500);
        });
    });
});

// Intersection Observer para animar la aparición de servicios en la vista
document.addEventListener('DOMContentLoaded', function () {
    const services = document.querySelectorAll('.service');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            entry.target.classList.toggle('appear', entry.isIntersecting);
        });
    }, { threshold: 0.9 });

    services.forEach(service => observer.observe(service));
});

// Intersection Observer para animar la aparición de varios contenedores en la vista
document.addEventListener('DOMContentLoaded', function () {
    const containersToObserve = [
        ...document.querySelectorAll('.service-details-container'),
        ...document.querySelectorAll('.contact-form'),
        ...document.querySelectorAll('.contact-map'),
        ...document.querySelectorAll('.aboutus-container')
    ];

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('appeared')) {
                entry.target.classList.add('appear', 'appeared');
            }
        });
    }, { threshold: 0.2 });

    containersToObserve.forEach(container => observer.observe(container));
});



// Manejo de la sumisión del formulario de contacto con jQuery
$(document).ready(function () {
    // Clave del sitio de reCAPTCHA
    const siteKey = '6LcaAhQqAAAAAFamvFY3b9SVjFLXSgnFyILDgAzr'; // Reemplaza con tu clave del sitio

    // Asegúrate de que el script de reCAPTCHA se haya cargado
    if (typeof grecaptcha === 'undefined') {
        console.error('reCAPTCHA no está definido. Asegúrate de que el script se cargue correctamente.');
        Swal.fire('Error', 'No se pudo cargar reCAPTCHA. Intenta nuevamente.', 'error');
        return;
    }

    $('#contactForm').submit(function (event) {
        event.preventDefault(); // Evitar el envío estándar del formulario

        // Ejecuta reCAPTCHA y obtiene el token
        grecaptcha.ready(function () {
            grecaptcha.execute(siteKey, { action: 'submit' }).then(function (token) {
                // Coloca el token en un campo oculto del formulario
                $('#recaptcha_token').val(token);

                // Obtener el token CSRF
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                console.log('Token CSRF:', csrfToken);
                console.log('Token reCAPTCHA:', token);

                // Crear un objeto FormData con los datos del formulario
                var formData = new FormData($('#contactForm')[0]);
                formData.append('_token', csrfToken); // Agregar el token CSRF

                // Enviar el formulario vía AJAX
                $.ajax({
                    type: 'POST',
                    url: $('#contactForm').attr('action'), // Obtener la URL del formulario
                    data: formData, // Datos del formulario incluyendo el token de reCAPTCHA
                    processData: false, // No procesar los datos (necesario para enviar archivos)
                    contentType: false, // No configurar el tipo de contenido (necesario para enviar archivos)

                    success: function (response) {
                        Swal.fire('Éxito', 'Tu mensaje ha sido enviado correctamente.', 'success');
                        $('#contactForm')[0].reset();
                        $('#recaptcha_token').val('');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        // Mostrar errores de validación utilizando SweetAlert2
                        mostrarErrores(JSON.parse(xhr.responseText).errors);
                    }
                });
            }).catch(function (error) {
                console.error('Error al obtener el token de reCAPTCHA:', error);
                Swal.fire('Error', 'No se pudo obtener el token de reCAPTCHA. Intenta nuevamente.', 'error');
            });
        });
    });

    // Función para mostrar los errores en forma de alerta con SweetAlert2
    function mostrarErrores(errors) {
        let errorMessage = '<ul>';
        for (const key in errors) {
            if (errors.hasOwnProperty(key)) {
                errors[key].forEach(error => {
                    errorMessage += `<li>${error}</li>`;
                });
            }
        }
        errorMessage += '</ul>';

        // Mostrar la alerta de error utilizando SweetAlert2
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            html: errorMessage
        });
    }
});






