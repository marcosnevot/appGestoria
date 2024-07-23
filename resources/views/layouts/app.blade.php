<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título Dinámico -->
    <title>@yield('title', 'Alás, Vigil y Nevot Asesores')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logoApp3.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcaAhQqAAAAAFamvFY3b9SVjFLXSgnFyILDgAzr"></script>
    <script src="{{ asset('js/custom.js') }}"></script>


    @vite(['resources/css/app.css','resources/css/navigation.css','resources/css/aboutus.css','resources/css/services.css','resources/css/home.css', 'resources/css/contact.css',"resources/css/footer.css",'resources/js/custom.js','resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="container bg-gray-100 gray:bg-gray-900">
        <!-- Barra de Navegación -->
        @include('layouts.navigation')

        <!-- Contenido de la Página -->
        <main>
            @include('layouts.home')
        </main>

        <script>
            // JavaScript para la funcionalidad del menú hamburguesa
            document.querySelector('.menu-btn').addEventListener('click', function() {
                document.querySelector('.nav-links').classList.toggle('active');
            });

            // Variables para controlar el desplazamiento del navbar
            let prevScrollPos = window.pageYOffset;

            window.onscroll = function() {
                let currentScrollPos = window.pageYOffset;
                const navbar = document.querySelector('.navbar');

                // Mostrar u ocultar el navbar según el desplazamiento
                if (prevScrollPos > currentScrollPos) {
                    navbar.classList.remove('hidden'); // Mostrar el navbar al desplazarse hacia arriba
                } else {
                    navbar.classList.add('hidden'); // Ocultar el navbar al desplazarse hacia abajo
                }

                prevScrollPos = currentScrollPos;
            };

            // Función para desplazarse suavemente a una sección específica
            function scrollToSection(event, sectionId) {
                event.preventDefault();
                const section = document.getElementById(sectionId);
                if (section) {
                    section.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }

            // Variables para las secciones de "sede"
            const sedeIzquierda = document.getElementById('sede-izquierda');
            const sedeDerecha = document.getElementById('sede-derecha');

            // Función para cambiar el tamaño de las secciones de "sede" al pasar el ratón
            function adjustSedeFlexBasis(leftBasis, rightBasis) {
                sedeIzquierda.style.flexBasis = leftBasis;
                sedeDerecha.style.flexBasis = rightBasis;
            }

            sedeIzquierda.addEventListener('mouseenter', function() {
                adjustSedeFlexBasis('60%', '40%');
            });

            sedeDerecha.addEventListener('mouseenter', function() {
                adjustSedeFlexBasis('40%', '60%');
            });

            document.querySelector('.sede-container').addEventListener('mouseleave', function() {
                adjustSedeFlexBasis('50%', '50%');
            });

            // Función para alternar el contenido de "sede"
            function toggleSedeContent(sede) {
                const contenido = sede.querySelector('.sede-contenido');
                const contenidoEmpresa = contenido.querySelector('.empresa');
                const contenidoInfo = contenido.querySelector('.info');

                contenidoEmpresa.classList.toggle('hidden');
                contenidoInfo.classList.toggle('hidden');
            }

            // Función para restablecer el contenido de "sede"
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
        </script>


    </div>
</body>

</html>