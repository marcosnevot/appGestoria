<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="navbar-logo">
            <img src="{{ asset('images/fondoBlancoHorizontal.png') }}" alt="Logo de la gestoría">
        </a>

        <!-- Menú principal -->
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="nav-link">Inicio</a></li>
            <li><a href="{{ route('home') }}" class="nav-link">Empresa</a></li>
            <li><a href="{{ route('home') }}" class="nav-link">Servicios</a></li>
            <li><a href="{{ route('home') }}" class="nav-link">Contacto</a></li>
        </ul>

        <!-- Botón del menú móvil -->
        <button class="menu-toggle" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>



@push('styles')
    @vite(['resources/css/layouts/navigation.css'])
@endpush

@push('scripts')
    @vite(['resources/js/layouts/navigation.js'])
@endpush
