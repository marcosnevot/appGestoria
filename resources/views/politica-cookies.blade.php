<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Cookies - Alás, Vigil y Nevot Asesores</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logoApp3.png') }}">
    @vite(['resources/css/politica-privacidad.css'])
</head>
<body>
    <h1>Política de Cookies</h1>

    <p style="font-size: 1.1rem; line-height: 1.8;">
        Esta web solo utiliza las cookies técnicas estrictamente necesarias para su correcto funcionamiento.
    </p>

    <h2>¿Qué son las cookies?</h2>
    <p>
        Las cookies son pequeños archivos de texto que los sitios web pueden colocar en su dispositivo para mejorar su experiencia de navegación, 
        personalizar el contenido o analizar el tráfico.
    </p>

    <h2>¿Qué tipo de cookies utilizamos?</h2>
    <p>
        En este sitio web, solo utilizamos cookies técnicas esenciales para el correcto funcionamiento de la página. Estas cookies no recopilan 
        información personal ni requieren consentimiento explícito según la normativa vigente.
    </p>

    <h2>Gestión de cookies</h2>
    <p>
        Dado que solo utilizamos cookies estrictamente necesarias, no es posible deshabilitarlas desde este sitio web sin afectar su funcionamiento.
        Puedes configurar tu navegador para bloquear o eliminar las cookies si lo prefieres, pero esto podría afectar la funcionalidad de la página.
    </p>

    <h2>Consulta nuestras políticas</h2>
    <p>
        Para más información, consulta también nuestras:
        <ul>
            <li><a href="{{ route('politica-privacidad') }}" style="color: #FFA500; font-weight: bold; text-decoration: underline;">Política de Privacidad</a></li>
            <li><a href="{{ route('aviso-legal') }}" style="color: #FFA500; font-weight: bold; text-decoration: underline;">Aviso Legal</a></li>
        </ul>
    </p>
</body>
</html>
