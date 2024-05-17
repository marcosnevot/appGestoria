<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Alás, Vigil y Nevot Asesores</title> <!-- Modifica el título según sea necesario -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logoApp3.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @vite(['resources/css/app.css','resources/css/navigation.css','resources/css/aboutus.css','resources/css/services.css','resources/css/home.css', 'resources/css/contact.css',"resources/css/footer.css",'resources/js/app.js'])
</head>

<body class="font-sans">
<div class="container bg-gray-100 gray:bg-gray-900">
        <!-- Barra de Navegación -->
        @include('layouts.navigation')

        <!-- Contenido de la Página -->
        <main> 

            @include('layouts.home') <!-- Esta sección será reemplazada por el contenido específico de cada página -->
        </main>

        <script>
            // JavaScript para la funcionalidad del menú hamburguesa
            document.querySelector('.menu-btn').addEventListener('click', function() {
                document.querySelector('.nav-links').classList.toggle('active');
            });


            let prevScrollPos = window.pageYOffset;

            window.onscroll = function() {
                let currentScrollPos = window.pageYOffset;

                if (prevScrollPos > currentScrollPos) {
                    document.querySelector('.navbar').classList.remove('hidden'); // Mostrar el navbar al desplazarse hacia arriba
                } else {
                    document.querySelector('.navbar').classList.add('hidden'); // Ocultar el navbar al desplazarse hacia abajo
                }

                prevScrollPos = currentScrollPos;
            }

            function scrollToSection(event, sectionId) {
                event.preventDefault();
                var section = document.getElementById(sectionId);
                if (section) {
                    section.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }

            const sedeIzquierda = document.getElementById('sede-izquierda');
            const sedeDerecha = document.getElementById('sede-derecha');

            sedeIzquierda.addEventListener('mouseenter', function() {
                sedeIzquierda.style.flexBasis = '60%';
                sedeDerecha.style.flexBasis = '40%';
            });

            sedeDerecha.addEventListener('mouseenter', function() {
                sedeIzquierda.style.flexBasis = '40%';
                sedeDerecha.style.flexBasis = '60%';
            });

            document.querySelector('.sede-container').addEventListener('mouseleave', function() {
                sedeIzquierda.style.flexBasis = '50%';
                sedeDerecha.style.flexBasis = '50%';
            });

            function toggleSedeContent(sede) {
                const contenido = sede.querySelector('.sede-contenido');
                const contenidoEmpresa = contenido.querySelector('.empresa');
                const contenidoInfo = contenido.querySelector('.info');

                contenidoEmpresa.classList.toggle('hidden');
                contenidoInfo.classList.toggle('hidden');
            }

            function resetSedeContent(sede) {
                const contenido = sede.querySelector('.sede-contenido');
                const contenidoEmpresa = contenido.querySelector('.empresa');
                const contenidoInfo = contenido.querySelector('.info');

                contenidoEmpresa.classList.remove('hidden');
                contenidoInfo.classList.add('hidden');
            }

            sedeIzquierda.addEventListener('mouseenter', function() {
                toggleSedeContent(this);
            });

            sedeIzquierda.addEventListener('mouseleave', function() {
                resetSedeContent(this);
            });

            sedeDerecha.addEventListener('mouseenter', function() {
                toggleSedeContent(this);
            });

            sedeDerecha.addEventListener('mouseleave', function() {
                resetSedeContent(this);
            });


            document.addEventListener('DOMContentLoaded', function() {
                const serviceList = document.querySelectorAll('.service');
                const serviceDetailsContainer = document.querySelector('.service-details-container');

                // Agregar la clase activa al primer servicio y mostrar su vista previa
                const firstService = serviceList[0];
                firstService.classList.add('active');
                const firstServiceId = firstService.dataset.serviceId;
                const firstTitle = firstService.querySelector('.service-title').textContent;
                const firstDescription = getServiceDescription(firstServiceId);
                updateServiceDetails(firstTitle, firstDescription);

                // Asignar eventos de clic a cada servicio
                serviceList.forEach(function(service) {
                    service.addEventListener('click', function() {
                        // Limpiar la clase activa de todos los servicios
                        serviceList.forEach(function(item) {
                            item.classList.remove('active');
                        });

                        // Agregar la clase activa al servicio seleccionado
                        this.classList.add('active');

                        // Obtener el ID del servicio seleccionado
                        const serviceId = this.dataset.serviceId;
                        // Obtener el título y la descripción del servicio seleccionado
                        const title = this.querySelector('.service-title').textContent;
                        const description = getServiceDescription(serviceId);
                        // Actualizar la vista detallada con el título y la descripción
                        updateServiceDetails(title, description);

                        serviceDetailsContainer.classList.add('animate');
                        setTimeout(function() {
                            serviceDetailsContainer.classList.remove('animate');
                        }, 500);
                    });
                });

                function getServiceDescription(serviceId) {
                    // Simular una función que devuelve la descripción del servicio según su ID
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

                function updateServiceDetails(title, description) {
                    // Actualizar el título y la descripción de la vista detallada
                    const serviceDetailsTitle = serviceDetailsContainer.querySelector('.service-details-title');
                    const serviceDetailsDescription = serviceDetailsContainer.querySelector('.service-details-description');
                    serviceDetailsTitle.textContent = title;
                    serviceDetailsDescription.innerHTML = description;
                    // Mostrar la vista detallada
                    serviceDetailsContainer.classList.add('active');
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Select all service elements
                const services = document.querySelectorAll('.service');

                // Create a new Intersection Observer
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        // If the service is intersecting with the viewport
                        if (entry.isIntersecting) {
                            // Add the 'appear' class to the service
                            entry.target.classList.add('appear');
                        } else {
                            // Remove the 'appear' class if the service is not intersecting
                            entry.target.classList.remove('appear');
                        }
                    });
                }, {
                    threshold: 0.9
                }); // Define the threshold for when to trigger the intersection

                // Observe each service element
                services.forEach(service => {
                    observer.observe(service);
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const serviceDetailsContainers = document.querySelectorAll('.service-details-container');
                const contactContainer = document.querySelectorAll('.contact-container');
                const contactFormContainer = document.querySelectorAll('.contact-form');
                const contactMapContainer = document.querySelectorAll('.contact-map');

                const aboutusContainer = document.querySelectorAll('.aboutus-container');

                // Crear un nuevo Intersection Observer
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        // Si el contenedor de detalles del servicio está intersectando con la ventana gráfica
                        if (entry.isIntersecting && !entry.target.classList.contains('appeared')) {
                            // Agregar la clase 'appear' al contenedor de detalles del servicio
                            entry.target.classList.add('appear');
                            // Marcar el contenedor como aparecido para evitar que la animación se repita
                            entry.target.classList.add('appeared');
                        }
                    });
                }, {
                    threshold: 0.2
                }); // Definir el umbral para cuando se debe activar la intersección

                // Observar cada contenedor de detalles del servicio
                serviceDetailsContainers.forEach(container => {
                    observer.observe(container);
                });
                contactFormContainer.forEach(container => {
                    observer.observe(container);
                });
                contactMapContainer.forEach(container => {
                    observer.observe(container);
                });
                aboutusContainer.forEach(container => {
                    observer.observe(container);
                });
            });


            $(document).ready(function() {
                $('#contactForm').submit(function(event) {
                    // Evita que el formulario se envíe de forma predeterminada
                    event.preventDefault();

                    // Serializa los datos del formulario
                    var formData = $(this).serialize();

                    // Envía la solicitud AJAX
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        success: function(response) {
                            // Recarga la página después de enviar el formulario
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Maneja cualquier error que pueda ocurrir
                            alert('Ocurrió un error al enviar el formulario.');
                        }
                    });
                });
            });
        </script>

    </div>
</body>

</html>