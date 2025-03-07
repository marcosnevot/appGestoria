document.addEventListener("DOMContentLoaded", function () {
  // Cargar tsParticles en el contenedor "tsparticles"
  tsParticles.load("tsparticles", {
    /* Aquí va tu configuración */
    background: {
      color: {
        value: "#f8f8f8" // mismo color de fondo de la sección
      }
    },
    fullScreen: {
      enable: false // Desactiva el modo fullscreen
    },
    fpsLimit: 60,
    interactivity: {
      events: {
        onHover: {
          enable: true,
          mode: "repulse"  // las partículas se repelen al pasar el mouse
        },
        onClick: {
          enable: true,
          mode: "push"     // añade más partículas al hacer click
        },
        resize: true
      },
      modes: {
        repulse: { distance: 100 },
        push: { quantity: 4 }
      }
    },
    particles: {
      number: {
        value: 70,       // cantidad de partículas
        density: {
          enable: true,
          value_area: 800
        }
      },
      color: {
        value: "#FFA500" // color de las partículas
      },
      shape: {
        type: "circle",
      },
      opacity: {
        value: 0.5,
        random: false
      },
      size: {
        value: 4,
        random: true
      },
      line_linked: {
        enable: false
      },
      move: {
        enable: true,
        speed: 2,
        direction: "none",    // "none", "top", "top-right", etc.
        random: false,
        straight: false,
        out_mode: "out",
        bounce: false
      }
    },
    retina_detect: true
  });

  // Seleccionar TODOS los elementos que lleven tus clases de animación
  const animatedElements = document.querySelectorAll('.fade-in, .slide-in-right, .slide-in-left');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
        observer.unobserve(entry.target); // Deja de observar para no repetir la animación
      }
    });
  }, { threshold: 0.1 });

  // Aplica el observer a cada elemento animado
  animatedElements.forEach(el => observer.observe(el));

  // Servicios Section

  // Seleccionamos los elementos
  const servicesSection = document.querySelector(".services-section");
  const cards = [...document.querySelectorAll(".service-card")];

  // Estados y flags
  let currentCardIndex = 0;         // Índice de la tarjeta actual a mostrar
  let allCardsVisible = false;      // Si todas las tarjetas están visibles
  let sectionHijackActive = false;  // ¿Hemos activado el "hijack" de la sección?
  let isScrollLockedDown = false;   // ¿Estamos bloqueando el scroll hacia abajo?
  let pinnedTop = 0;                // Posición exacta a la que se fija la sección
  let lockRAF;                      // ID del requestAnimationFrame

  // Acumuladores y umbrales para controlar el scroll necesario
  let scrollAccumulator = 0;
  const FIRST_CARD_THRESHOLD = 400;      // Umbral para la primera tarjeta
  const SUBSEQUENT_CARD_THRESHOLD = 500;   // Umbral para las tarjetas siguientes

  // Nuevo acumulador y umbral para desbloquear el scroll después de la última tarjeta
  let finalAccumulator = 0;
  const FINAL_UNLOCK_THRESHOLD = 800;      // Movimiento extra requerido para desbloquear

  // Inicializamos las tarjetas con GSAP (ocultas y desplazadas hacia abajo)
  gsap.set(cards, { opacity: 0, y: 500 });

  // Función que "congela" el scroll mientras la sección está bloqueada
  function lockScrollPosition() {
    if (sectionHijackActive && isScrollLockedDown) {
      // Forzamos la posición de scroll de forma inmediata
      window.scrollTo(0, pinnedTop);
      lockRAF = requestAnimationFrame(lockScrollPosition);
    } else {
      cancelAnimationFrame(lockRAF);
    }
  }

  // Listener de scroll para "vigilar" la posición de la sección
  const onScrollCheckSection = () => {
    const rect = servicesSection.getBoundingClientRect();

    // Activamos el efecto de bloqueo en cuanto la sección toca (o casi toca) el tope (5px de margen)
    if (!sectionHijackActive && rect.top <= 5) {
      pinnedTop = window.pageYOffset + rect.top; // Se fija la posición actual
      sectionHijackActive = true;
      isScrollLockedDown = true;
      lockScrollPosition();
    }

    // Si el usuario sube demasiado (la sección se aleja del tope) y aún no se han mostrado todas las tarjetas,
    // reiniciamos el efecto.
    if (rect.top > 5 && !allCardsVisible) {
      sectionHijackActive = false;
      isScrollLockedDown = false;
      currentCardIndex = 0;    // Reiniciamos las tarjetas si se quiere repetir el efecto
      scrollAccumulator = 0;   // Reiniciamos el acumulador de tarjetas
      finalAccumulator = 0;    // Reiniciamos el acumulador final
    }
  };

  // Agregamos el listener de scroll (fase por defecto es suficiente)
   window.addEventListener("scroll", onScrollCheckSection);

  // Listener de wheel: usamos "capture" para interceptarlo lo antes posible
  const onWheel = (e) => {
    if (sectionHijackActive && isScrollLockedDown) {
      if (e.deltaY > 0) { // Si el usuario intenta bajar
        e.preventDefault(); // Bloqueamos el scroll nativo

        // Si aún no se han mostrado todas las tarjetas...
        if (currentCardIndex < cards.length) {
          scrollAccumulator += e.deltaY;
          // Seleccionamos el umbral adecuado para la primera o siguientes tarjetas
          let threshold = (currentCardIndex === 0) ? FIRST_CARD_THRESHOLD : SUBSEQUENT_CARD_THRESHOLD;
          if (scrollAccumulator >= threshold) {
            scrollAccumulator = 0;
            showCard(currentCardIndex);
            currentCardIndex++;
          }
        }
        // Si ya se han mostrado todas las tarjetas, acumulamos scroll extra antes de desbloquear
        else if (currentCardIndex === cards.length) {
          finalAccumulator += e.deltaY;
          if (finalAccumulator >= FINAL_UNLOCK_THRESHOLD) {
            allCardsVisible = true;
            isScrollLockedDown = false;
          }
        }
      }
      // Permitir scroll hacia arriba sin bloqueo (podrías implementar lógica reversa si lo deseas)
    }
  };

  // Agregamos el listener de wheel en fase de captura
  window.addEventListener("wheel", onWheel, { passive: false, capture: true });

  // Además, para mayor seguridad, forzamos la posición en cada evento "scroll" (además del lock loop)
  window.addEventListener("scroll", () => {
    if (sectionHijackActive && isScrollLockedDown && window.pageYOffset > pinnedTop) {
      window.scrollTo(0, pinnedTop);
    }
  });

  // Animación GSAP para mostrar la tarjeta
  const showCard = (index) => {
    gsap.to(cards[index], {
      opacity: 1,
      y: 0,
      duration: 1.2,      // Ajusta la duración según la experiencia deseada
      ease: "power2.out"
    });
  };




  // Sección opiniones

  /**
   * Clase que representa cada burbuja flotante (opinión).
   */
  class FloatingBubble {
    /**
     * @param {HTMLElement} element - El elemento DOM de la burbuja.
     * @param {HTMLElement} container - El contenedor donde se mueve la burbuja.
     */
    constructor(element, container) {
      this.element = element;
      this.container = container;

      // Dimensiones de la burbuja y del contenedor.
      this.width = this.element.offsetWidth;
      this.height = this.element.offsetHeight;
      // Calculamos el radio (se asume que la burbuja es un círculo).
      this.radius = this.width / 2;
      this.containerWidth = this.container.clientWidth;
      this.containerHeight = this.container.clientHeight;

      // Posición inicial aleatoria (asegurando que la burbuja esté enteramente dentro del contenedor).
      this.x = Math.random() * (this.containerWidth - this.width);
      this.y = Math.random() * (this.containerHeight - this.height);

      // Velocidad aleatoria (en píxeles por frame). Ajusta "speedFactor" para modificar la velocidad.
      const speedFactor = 0.8;
      this.vx = (Math.random() - 0.5) * speedFactor * 2;
      this.vy = (Math.random() - 0.5) * speedFactor * 2;

      this.updatePosition();
    }

    /**
     * Actualiza la posición de la burbuja y comprueba colisiones con los bordes del contenedor.
     * @param {number} containerWidth - Ancho actual del contenedor.
     * @param {number} containerHeight - Alto actual del contenedor.
     */
    update(containerWidth, containerHeight) {
      this.containerWidth = containerWidth;
      this.containerHeight = containerHeight;

      // Actualizamos la posición en base a la velocidad.
      this.x += this.vx;
      this.y += this.vy;

      // Colisión con las paredes laterales:
      if (this.x <= 0) {
        this.x = 0;
        this.vx = Math.abs(this.vx);
      } else if (this.x + this.width >= containerWidth) {
        this.x = containerWidth - this.width;
        this.vx = -Math.abs(this.vx);
      }

      // Colisión con las paredes superior e inferior:
      if (this.y <= 0) {
        this.y = 0;
        this.vy = Math.abs(this.vy);
      } else if (this.y + this.height >= containerHeight) {
        this.y = containerHeight - this.height;
        this.vy = -Math.abs(this.vy);
      }

      this.updatePosition();
    }

    /**
     * Actualiza la transformación CSS para mover el elemento.
     */
    updatePosition() {
      this.element.style.transform = `translate(${this.x}px, ${this.y}px)`;
    }
  }

  // Seleccionamos el contenedor y todas las burbujas.
  const container = document.getElementById('bubbles-container');
  const bubbleElements = container.querySelectorAll('.bubble');
  const bubbles = [];

  // Inicializamos cada burbuja y forzamos su posición absoluta.
  bubbleElements.forEach(element => {
    element.style.position = 'absolute';
    bubbles.push(new FloatingBubble(element, container));
  });

  /**
   * Función de animación: actualiza la posición de las burbujas y gestiona las colisiones entre ellas.
   */
  function animate() {
    // Dimensiones actualizadas del contenedor.
    const containerWidth = container.clientWidth;
    const containerHeight = container.clientHeight;

    // Actualizamos la posición de cada burbuja (incluyendo colisiones con los bordes).
    bubbles.forEach(bubble => bubble.update(containerWidth, containerHeight));

    // --- Detección de colisiones entre burbujas ---
    for (let i = 0; i < bubbles.length; i++) {
      for (let j = i + 1; j < bubbles.length; j++) {
        const bubbleA = bubbles[i];
        const bubbleB = bubbles[j];

        // Calculamos el centro de cada burbuja.
        const ax = bubbleA.x + bubbleA.radius;
        const ay = bubbleA.y + bubbleA.radius;
        const bx = bubbleB.x + bubbleB.radius;
        const by = bubbleB.y + bubbleB.radius;

        // Vector de distancia entre los centros.
        const dx = ax - bx;
        const dy = ay - by;
        const distance = Math.sqrt(dx * dx + dy * dy);
        const minDistance = bubbleA.radius + bubbleB.radius;

        // Si la distancia es menor que la suma de los radios, se produce colisión.
        if (distance < minDistance) {
          // Calculamos el vector normal (dirección de la colisión).
          const nx = dx / distance;
          const ny = dy / distance;

          // Velocidad relativa en la dirección de la colisión.
          const dvx = bubbleA.vx - bubbleB.vx;
          const dvy = bubbleA.vy - bubbleB.vy;
          const dot = dvx * nx + dvy * ny;

          // Si las burbujas se están acercando (dot < 0), se aplica la respuesta de colisión.
          if (dot < 0) {
            // Para masas iguales y colisión perfectamente elástica:
            bubbleA.vx -= dot * nx;
            bubbleA.vy -= dot * ny;
            bubbleB.vx += dot * nx;
            bubbleB.vy += dot * ny;
          }

          // Separamos las burbujas para evitar que se solapen (ajustamos sus posiciones en función del solapamiento).
          const overlap = minDistance - distance;
          bubbleA.x += (nx * overlap) / 2;
          bubbleA.y += (ny * overlap) / 2;
          bubbleB.x -= (nx * overlap) / 2;
          bubbleB.y -= (ny * overlap) / 2;

          // Actualizamos inmediatamente la posición en el DOM.
          bubbleA.updatePosition();
          bubbleB.updatePosition();
        }
      }
    }

    // Solicitamos el siguiente frame.
    requestAnimationFrame(animate);
  }

  // Iniciamos la animación.
  animate();

  // Listener para redimensionar el contenedor y reajustar las posiciones de las burbujas.
  window.addEventListener('resize', () => {
    const containerWidth = container.clientWidth;
    const containerHeight = container.clientHeight;

    bubbles.forEach(bubble => {
      bubble.containerWidth = containerWidth;
      bubble.containerHeight = containerHeight;
      if (bubble.x + bubble.width > containerWidth) {
        bubble.x = containerWidth - bubble.width;
      }
      if (bubble.y + bubble.height > containerHeight) {
        bubble.y = containerHeight - bubble.height;
      }
      bubble.updatePosition();
    });
  });

  // Selecciona todos los elementos con clase .texto
  const textos = document.querySelectorAll('.texto');

  textos.forEach(function (el) {
    // Guarda los valores originales para restaurarlos después
    const originalDisplay = el.style.display;
    const originalWebkitLineClamp = el.style.webkitLineClamp;

    // Desactiva temporalmente el truncamiento para medir la altura total
    el.style.display = 'block';
    el.style.webkitLineClamp = 'unset';

    // Forzamos el reflow para asegurarnos de obtener la altura completa
    const fullHeight = el.scrollHeight;

    // Obtenemos el line-height computado
    const computedStyle = window.getComputedStyle(el);
    const lineHeight = parseFloat(computedStyle.lineHeight);

    // Calculamos el número de líneas reales (redondeamos)
    const lines = Math.round(fullHeight / lineHeight);

    // Restauramos el truncamiento
    el.style.display = originalDisplay;
    el.style.webkitLineClamp = originalWebkitLineClamp;

    // Asignamos la clase correspondiente
    if (lines <= 2) {
      el.classList.add('lines-2');
    } else if (lines === 3) {
      el.classList.add('lines-3');
    } else if (lines >= 4) {
      el.classList.add('lines-4');
    }
  });

});

