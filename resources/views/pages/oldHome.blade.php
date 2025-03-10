<!-- HTML -->
@extends('layouts.app')

@section('title', 'Inicio - Alás, Vigil y Nevot Asesores')

@section('content')
<section id="home">
    <div class="container mx-auto">
        <div class="sede-container" onclick="scrollToSection(event, 'location')">
            <!-- Sede 1: Izquierda -->
            <div class="sede-info sede-izquierda" id="sede-izquierda">
                <div class="sede-contenido">
                    <h2 class="city">BARBASTRO</h2>
                    <p class="empresa"><br></p>
                    <p class="info hidden">
                        C. Baños Árabes, 6, 2ºA, 22300 Barbastro, Huesca | 974315330
                    </p>
                </div>
            </div>

            <!-- Sede 2: Derecha -->
            <div class="sede-info sede-derecha" id="sede-derecha">
                <div class="sede-contenido">
                    <h2 class="city">MONZÓN</h2>
                    <p class="empresa"><br></p>
                    <p class="info hidden">
                        C. del Barón de Eroles, 40, Bajos, 22400 Monzón, Huesca | 974404858
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Sección About Us -->
<section id="aboutus" class="py-12 bg-white">
    <div class="aboutus-container max-w-screen-md mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Alás, Vigil y Nevot Asesores</h2>
            <div class="aboutus-title-line mx-auto my-4"></div>
        </div>
        <div class="text-center">
            <p class="mb-4">Nos especializamos en brindar <b>servicios integrales de asesoría y gestión fiscal, contable y laboral</b>. Con sedes en <b>Barbastro</b> y <b>Monzón</b>, nuestro equipo de profesionales está comprometido con tu éxito, ofreciendo soluciones personalizadas y un trato cercano.</p>
            <p class="mb-4">Facilitamos tus gestiones diarias desde <b>1993</b>, asegurando siempre la máxima eficiencia y profesionalidad. Confía en nosotros para ayudarte a alcanzar tus objetivos y superar cualquier desafío.</p>
        </div>
    </div>
</section>

<!-- Sección Services -->
<section id="services" class="py-12 bg-gray-100">
    <div class="services-title-container text-center">
        <h2>Nuestros Servicios</h2>
        <div class="services-title-line mx-auto"></div>
    </div>

    <div class="services-container mx-auto flex">
        <div class="service-list-container">
            <div class="service-list">
                <div class="service" data-service-id="1">
                    <h3 class="service-title">Gestión Fiscal</h3>
                </div>
                <div class="service" data-service-id="2">
                    <h3 class="service-title">Gestión Contable</h3>
                </div>
                <div class="service" data-service-id="3">
                    <h3 class="service-title">Gestión Laboral</h3>
                </div>
                <div class="service" data-service-id="4">
                    <h3 class="service-title">Asesoría a Particulares</h3>
                </div>
            </div>
        </div>
        <div class="service-details-container">
            <div class="service-details">
                <div class="service-details-header">
                    <h2 class="service-details-title"></h2>
                </div>
                <p class="service-details-description"></p>
            </div>
        </div>

    </div>
</section>

<!-- Sección Contact -->
<section id="contact" class="py-12 bg-white">
    <div class="contact-container">
        <div class="contact-form">
            <div class="contact-title-container text-center">
                <h2>Contacto</h2>
                <div class="contact-title-line"></div>
            </div>
            <form id="contactForm" action="{{ route('form.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Correo Electrónico">
                </div>

                <div class="form-groupH">
                    <input type="text" id="asunto" name="asunto" placeholder="Asunto">

                    <select id="sede" name="sede" required>
                        <option value="" disabled selected>Selecciona una sede</option>
                        <option value="Barbastro">Barbastro</option>
                        <option value="Monzón">Monzón</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="adjuntos">Subir archivos (máx. 2MB cada uno):</label>
                    <input type="file" id="adjuntos" name="adjuntos[]" multiple accept=".pdf, image/*">
                </div>

                <div class="form-group">
                    <textarea id="mensaje" name="mensaje" rows="5" placeholder="Mensaje"></textarea>
                </div>
                <!-- Sección de Info Básica -->
                <div class="basic-info mt-4 text-gray-600 text-sm">
                    <p><strong>Responsable:</strong> NEVOT ASESORES, S.L.</p>
                    <p><strong>Finalidad:</strong> Gestionar su solicitud de información y/o contacto.</p>
                    <p>
                        <strong>Derechos:</strong> Acceder, rectificar y suprimir los datos, así como otros derechos, como se explica en la
                        información adicional que puede consultar en el apartado
                        <a href="{{ route('politica-privacidad') }}" target="_blank" class="text-blue-500 underline">política de privacidad</a> de la web alasvigilnevot.es.
                    </p>
                    <div class="form-group-policy mt-2">
                        <input type="checkbox" id="data-consent" name="data-consent" required>
                        <label for="data-consent">
                            He leído la <a href="{{ route('politica-privacidad') }}" target="_blank">Política de Privacidad</a> y consiento el tratamiento de mis datos personales.
                        </label>
                    </div>

                </div>


                <input type="hidden" name="recaptcha_token" id="recaptcha_token">

                <button type="submit">Enviar</button>
            </form>


        </div>

        <section id="location"></section>

        <div class="contact-map">
            <div class="contact-title-container text-center">
                <h2>Encuéntranos</h2>
                <div class="contact-title-line"></div>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d740.8078276298558!2d0.12638626962190705!3d42.038219998201555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a784e1e0113bd5%3A0x96b3dd913c107fb0!2sAl%C3%A1s%2C%20Vigil%20Y%20Nevot%2C%20Asesores!5e0!3m2!1ses!2ses!4v1715867422760!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <p class="location">Lunes a Jueves 9:00 - 13:30 y 16:00 - 19:30<br> Viernes 9:00 - 13:30 y 16:00 - 18:00</p>
            </div>
            <br>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2969.043784536263!2d0.1933592759068724!3d41.913417471237864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a777e4408eba0f%3A0x5b8e07b652d1fc04!2sNevot%20Asesores%20SL!5e0!3m2!1ses!2ses!4v1715867489306!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <p class="location">Lunes a Jueves 9:30 - 13:30 y 16:15 - 19:30 | Viernes 8:30 - 15:00</p>
            </div>

        </div>

    </div>

</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo del Footer -->
        <div class="footer-logo">
            <img class="logo-img" src="{{ asset('images/fondoNegro2.png') }}" alt="Logo">
        </div>
    </div>
    <div class="text-center mt-4">
        <p class="text-gray-400 text-sm">
            © 2024 Alás, Vigil y Nevot Asesores SL. Todos los derechos reservados.
        </p>
        <nav class="mt-2">
            <a href="{{ route('aviso-legal') }}" class="text-gray-400 hover:text-white underline mx-2">
                Aviso Legal
            </a>
            |
            <a href="{{ route('politica-privacidad') }}" class="text-gray-400 hover:text-white underline mx-2">
                Política de Privacidad
            </a>
            |
            <a href="{{ route('politica-cookies') }}" class="text-gray-400 hover:text-white underline mx-2">
                Política de Cookies
            </a>
        </nav>
    </div>
</footer>

@endsection