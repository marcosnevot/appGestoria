<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título Dinámico -->
    <title>@yield('title', 'Alás, Vigil y Nevot Asesores')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/fondoBlancoAV2.png') }}">

    <!-- Tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.9.3/tsparticles.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>

<body>
    <!-- Navbar -->
    @include('layouts.navigation')

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Estilos Globales -->
    @vite(['resources/css/app.css'])
    @stack('styles')
    <!-- Scripts Globales -->
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>

</html>