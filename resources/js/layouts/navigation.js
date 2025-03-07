document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    const menuToggle = document.querySelector(".menu-toggle");
    const navbarMenu = document.querySelector(".navbar-menu");

    let lastScrollY = window.scrollY;
    let isScrollingDown = false;

    // ✅ Detectar scroll para ocultar/mostrar el navbar
    window.addEventListener("scroll", function () {
        const currentScrollY = window.scrollY;

        if (currentScrollY > lastScrollY && currentScrollY > 100) {
            // Scroll hacia abajo → Ocultar navbar
            if (!isScrollingDown) {
                navbar.classList.add("hide-navbar");
                isScrollingDown = true;
            }
        } else {
            // Scroll hacia arriba → Mostrar navbar
            if (isScrollingDown) {
                navbar.classList.remove("hide-navbar");
                isScrollingDown = false;
            }
        }

        lastScrollY = currentScrollY;
    });

    // ✅ Alternar el menú móvil
    menuToggle.addEventListener("click", function () {
        navbarMenu.classList.toggle("active");

        // ✅ Animación del botón hamburguesa
        menuToggle.classList.toggle("open");
    });

    // ✅ Cerrar el menú cuando se hace clic en un enlace (móviles)
    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", function () {
            navbarMenu.classList.remove("active");
            menuToggle.classList.remove("open");
        });
    });
});
