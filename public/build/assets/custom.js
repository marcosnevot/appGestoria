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
    $('#contactForm').submit(function (event) {
        event.preventDefault(); // Evitar el envío estándar del formulario

        // Obtener el token de reCAPTCHA
        const recaptcha = $('#g-recaptcha-response').val();
        
        // Verificar si el reCAPTCHA ha sido marcado
        if (!recaptcha) {
            alert('Por favor, marca el reCAPTCHA antes de enviar el formulario.');
            return;
        }

        // Obtener los datos del formulario
        const formData = $(this).serialize() + '&g-recaptcha-response=' + recaptcha;

        // Enviar el formulario via AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'), // Obtener la URL del formulario
            data: formData, // Datos del formulario incluyendo el token de reCAPTCHA
            success: function (response) {
                location.reload(); // Ejemplo: recargar la página después de enviar correctamente
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Ocurrió un error al enviar el formulario.');
            }
        });
    });
});





