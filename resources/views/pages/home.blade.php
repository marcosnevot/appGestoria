@extends('layouts.app')

@section('title', 'Inicio - Alás, Vigil y Nevot Asesores')

@section('content')

<!--  Sección Hero con imágenes de las sedes -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-box hero-left"
            style='background: url(images/sede-barbastro.jpg) center/cover no-repeat;'>
            <div class="overlay"></div>
            <div class="hero-text">
                <h2>BARBASTRO</h2>
                <p>Atención profesional y cercana</p>
            </div>
        </div>

        <div class="hero-box hero-right"
            style='background: url(images/sede-monzon.jpg) center/cover no-repeat;'>
            <div class="overlay"></div>
            <div class="hero-text">
                <h2>MONZÓN</h2>
                <p>Asesoría integral para tu empresa</p>
            </div>
        </div>

    </div>
</section>


<!--  Sección About Us -->
<section class="about-section with-particles">
    <!-- Contenedor de partículas -->
    <div id="tsparticles"></div>
    <!-- Contenido principal (texto + imagen) -->
    <div class="about-container">
        <div class="about-block">
            <!-- Texto a la izquierda -->
            <div class="about-text fade-in">
                <h2>Tu confianza,<br> nuestro compromiso.</h2>
                <p>
                    Desde 1993, facilitamos cada una de tus gestiones con la máxima
                    eficiencia y profesionalidad.<br><br>
                    Nuestro equipo está aquí para apoyarte
                    en el logro de tus objetivos y ayudarte a superar cualquier desafío.
                    Confía en nosotros y descubre la tranquilidad de trabajar con expertos
                    comprometidos con tu éxito.
                </p>
            </div>
            <!-- Imagen a la derecha -->
            <div class="about-img slide-in-right">
                <img src="/images/asesoria.jpg" alt="Asesoría profesional">
            </div>
        </div>
    </div>
</section>




<section class="about-section">
    <div class="about-block dark-bg">
        <div class="dark-inner-container">
            <!-- Imagen a la izquierda -->
            <div class="about-img slide-in-left">
                <img src="/images/oficina.jpg" alt="Clientes satisfechos">
            </div>
            <!-- Texto a la derecha -->
            <div class="about-text fade-in">
                <h2>Esto es lo que buscas</h2>
                <p>
                    Nos dedicamos a brindar soluciones integrales de asesoría y gestión
                    fiscal, contable y laboral. <br><br>Con sedes en Barbastro y Monzón,
                    ponemos a tu disposición un equipo de profesionales que entiende
                    tus necesidades y te ofrece un trato cercano.
                    <br><br>Nuestro compromiso es ayudarte a crecer, optimizar recursos
                    y responder de manera eficaz a cada reto que surja en el camino.
                </p>
            </div>
        </div>
    </div>
</section>

<!--  Sección Services -->
<section class="services-section">
    <div class="services-container">
        <!-- 🔹 Título de la sección -->
        <div class="services-title">
            <h2>Soluciones a la carta</h2>
            <p>
                Desde la gestión fiscal hasta la administración laboral,
                ponemos a tu disposición un servicio personalizado y profesional,
                garantizando el control total de tu empresa mientras te enfocas en alcanzar tus objetivos.
            </p>
        </div>



        <!-- 🔹 Contenedor de tarjetas (En una sola fila) -->
        <div class="services-grid">
            <div class="service-card">
                <h3>Gestión Fiscal</h3>
                <p>Reduce tu carga tributaria con una planificación eficiente. <br>Nos encargamos de impuestos, declaraciones y asesoramiento continuo.</p>
            </div>
            <div class="service-card">
                <h3>Gestión Contable</h3>
                <p>Control preciso de tus finanzas para maximizar rentabilidad.<br>Digitalizamos y optimizamos tu contabilidad con total seguridad.</p>
            </div>
            <div class="service-card">
                <h3>Gestión Laboral</h3>
                <p>Administra tu equipo sin complicaciones. <br>Nos ocupamos de nóminas, contratos y seguridad social con total cumplimiento legal.</p>
            </div>
            <div class="service-card">
                <h3>Asesoría a Particulares</h3>
                <p>Soluciones legales y fiscales a tu medida. <br>Desde la constitución de sociedades hasta la gestión de trámites personales.</p>
            </div>
        </div>


        <!-- 🔹 Botón central -->
        <div class="services-button">
            <button>Servicios</button>
        </div>
    </div>
</section>

<!-- Sección Opiniones -->
<section id="testimonials-section" class="testimonials-section">
    <div class="testimonials-wrapper">

        <!-- Lado Izquierdo: Título, Descripción y CTA -->
        <div class="testimonials-info">
            <div class="info-decor">
                <!-- Opcional: un ícono decorativo para reforzar la identidad -->
                <span class="info-icon">💬</span>
            </div>
            <h2 class="section-title">¿Qué dicen nuestros clientes?</h2>
            <p class="testimonials-text">
                <strong>Tu opinión importa.</strong> Cada valoración nos impulsa a mejorar y a ofrecer un servicio a la altura de tus expectativas.<br><br>
                La confianza de nuestros clientes es nuestra mayor recompensa.
            </p>

            <!-- Imagen de Google Verified -->
            <div class="google-verified">
                <img src="{{ asset('images/google-verified.png') }}" alt="Opiniones verificadas por Google">
            </div>
        </div>


        <!-- Lado Derecho: Opiniones en burbujas -->
        <div class="testimonials-container">
            <div id="bubbles-container">
                @if (count($opiniones) === 0)
                <p>No hay opiniones disponibles.</p>
                @endif
                @foreach ($opiniones as $opinion)
                <div class="bubble">
                    <div class="bubble-content">
                        <img src="{{ $opinion['profile_photo_url'] }}" alt="{{ $opinion['author_name'] }}" class="avatar">
                        <div class="info">
                            <div class="estrellas">{!! str_repeat('<span class="estrella">⭐</span>', $opinion['rating']) !!}</div>
                            <p class="nombre">{{ $opinion['author_name'] }}</p>
                            <p class="texto">{{ $opinion['text'] }}</p>
                            <p class="fecha">{{ \Carbon\Carbon::parse($opinion['time'])->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

<!-- Sección de Contacto -->
<section id="contact-section" class="contact-section bg-dark">
    <div class="contact-container">
        <h2 class="section-title-dark-bg">Contáctanos</h2>
        <p class="contact-subtitle">
            Descubre nuestras sedes y ponte en contacto para recibir una asesoría de excelencia.
        </p>
        <div class="contact-cards">
            <!-- Tarjeta Sede BARBASTRO -->
            <div class="contact-card">
                <!-- Mapa interactivo -->
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d740.8078276298558!2d0.12638626962190705!3d42.038219998201555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a784e1e0113bd5%3A0x96b3dd913c107fb0!2sAl%C3%A1s%2C%20Vigil%20Y%20Nevot%2C%20Asesores!5e0!3m2!1ses!2ses!4v1715867422760!5m2!1ses!2ses"
                        frameborder="0"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <!-- Información de contacto -->
                <div class="contact-info">
                    <h3 class="sede-title">BARBASTRO</h3>
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Dirección</span>
                                <span class="detail">C. Baños Árabes, 6, 2ºA, 22300 Barbastro, Huesca, España</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Teléfono</span>
                                <span class="detail">974315330</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Email</span>
                                <span class="detail">barbastro@asesores.com</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Horarios</span>
                                <span class="detail">
                                    Lunes a Jueves: 9:30 - 13:30 y 16:15 - 19:30<br>
                                    Viernes: 8:30 - 15:00
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-cta">
                        <a href="{{ url('/contacto') }}" class="btn">Contacta con nosotros</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Sede MONZÓN -->
            <div class="contact-card">
                <!-- Mapa interactivo -->
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2969.043783198343!2d0.1959342!3d41.9134175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a777e4408eba0f%3A0x5b8e07b652d1fc04!2sNevot%20Asesores%20SL!5e0!3m2!1ses!2ses!4v1738953983762!5m2!1ses!2ses"
                        frameborder="0"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <!-- Información de contacto -->
                <div class="contact-info">
                    <h3 class="sede-title">MONZÓN</h3>
                    <div class="contact-items">
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Dirección</span>
                                <span class="detail">C. del Barón de Eroles, 40, Bajos, 22400 Monzón, Huesca, España</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Teléfono</span>
                                <span class="detail">974404858</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Email</span>
                                <span class="detail">monzon@asesores.com</span>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-text">
                                <span class="label">Horarios</span>
                                <span class="detail">
                                    Lunes a Jueves: 9:00 - 13:30 y 16:00 - 19:30<br>
                                    Viernes: 9:00 - 13:30 y 16:00 - 18:00
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="contact-cta">
                        <a href="{{ url('/contacto') }}" class="btn">Contacta con nosotros</a>
                    </div>
                </div>
            </div>



        </div>
    </div>
</section>



@endsection


@push('styles')
@vite(['resources/css/pages/home/home.css','resources/css/pages/home/home-contact.css','resources/css/pages/home/home-services.css','resources/css/pages/home/home-about-us.css', 'resources/css/pages/home/home-testimonials.css'])
@endpush

@push('scripts')
@vite(['resources/js/pages/home.js'])
@endpush