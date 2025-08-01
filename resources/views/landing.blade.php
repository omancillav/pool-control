<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pool Control</title>
  <link href="{{ asset('css/landing.css') }}" rel="stylesheet">
</head>

<body>
  <header>
    <div class="nav-container">
      <div class="logo">
          <img src="{{ asset('img/logo.webp') }}" alt="">
          <span>Pool Control</span>
          </div>
        <nav>
          <a href="#features">Funciones</a>
          <a href="#benefits">Beneficios</a>
          <a href="#contact">Contacto</a>
          <a href="/aviso-de-privacidad" target="_blank">Privacidad</a>
        </nav>
        <div class="auth-buttons">
          <a href="/login" class="btn outline">Iniciar sesión</a>
          <a href="/register" class="btn primary" style="margin-left: 0.5rem;">Registrarse</a>
        </div>
      </div>
  </header>

  <section class="hero">
    <div class="floating-elements"></div>
    <div class="hero-content">
      <h1>Control Total de tu Alberca</h1>
      <p class="subtitle">Gestiona usuarios, asistencia y membresías con la plataforma más intuitiva del mercado. Optimiza tu negocio y mejora la experiencia de tus clientes.</p>
      <div class="hero-buttons">
        <a href="#features" class="btn primary">Explorar Funciones</a>
        <a href="/register" class="btn outline">Comenzar Gratis</a>
      </div>
    </div>
  </section>

  <section id="features" class="fade-in">
    <h2 class="section-title">Funciones Principales</h2>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">👥</div>
        <h3>Gestión de Usuarios</h3>
        <p>Sistema completo de perfiles con vinculación de tarjetas, historial de clases y datos de contacto organizados de manera intuitiva.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📊</div>
        <h3>Control de Asistencia</h3>
        <p>Registro automático de asistencia con estadísticas en tiempo real, patrones de uso y alertas de ausentismo.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💳</div>
        <h3>Membresías Inteligentes</h3>
        <p>Manejo flexible de pagos, renovaciones automáticas y notificaciones preventivas para una gestión sin complicaciones.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">💰</div>
        <h3>Finanzas Claras</h3>
        <p>Dashboard financiero completo con ingresos, gastos, proyecciones y análisis de rentabilidad por período.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">📈</div>
        <h3>Reportes Avanzados</h3>
        <p>Informes detallados de performance, tendencias de uso y métricas clave para tomar decisiones informadas.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">🔔</div>
        <h3>Notificaciones Smart</h3>
        <p>Alertas automáticas para vencimientos, recordatorios de clase y comunicación directa con tus clientes.</p>
      </div>
    </div>
  </section>

  <section id="benefits" class="benefits fade-in">
    <div class="benefits-content">
      <h2 class="section-title">¿Por qué Pool Control?</h2>
      <p>Transforma tu alberca en un negocio profesional y eficiente. Elimina el papeleo, reduce errores y ofrece una experiencia premium a tus clientes mientras aumentas tus ingresos.</p>
      <p>Con Pool Control, no solo administras una alberca, construyes un negocio sostenible y escalable que trabaja para ti las 24 horas del día.</p>
    </div>
  </section>

  <section id="contact" class="contact fade-in">
    <h2 class="section-title">Comienza Hoy</h2>
    <div class="contact-content">
      <p>¿Listo para revolucionar tu alberca? Únete a cientos de instructores que ya confían en Pool Control para gestionar sus negocios.</p>
    </div>
    <div style="margin-top: 2rem;">
      <a href="/register" class="btn primary">Crear Cuenta Gratis</a>
    </div>
  </section>

  <footer>
    <p>&copy; 2024 Pool Control. Diseñado con dedicación para profesionales de la natación.</p>
  </footer>

  <script>
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Scroll animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
      observer.observe(el);
    });

    // Header background on scroll
    window.addEventListener('scroll', () => {
      const header = document.querySelector('header');
      if (window.scrollY > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.98)';
      } else {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
      }
    });
  </script>
</body>

</html>