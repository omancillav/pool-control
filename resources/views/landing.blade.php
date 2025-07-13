<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pool Control - Sistema de Gestión de Alberca</title>
  <style>
    :root {
      --primary: #0066cc;
      --primary-dark: #004499;
      --primary-light: #3399ff;
      --secondary: #0099ff;
      --accent: #66ccff;
      --text: #1a1a1a;
      --text-light: #666;
      --bg: #fafbff;
      --white: #ffffff;
      --shadow: rgba(0, 102, 204, 0.1);
      --shadow-hover: rgba(0, 102, 204, 0.2);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: var(--bg);
      color: var(--text);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* ANIMATIONS */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }
    }

    @keyframes wave {

      0%,
      100% {
        transform: translateX(0px);
      }

      50% {
        transform: translateX(20px);
      }
    }

    @keyframes pulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.05);
      }
    }

    /* HEADER */
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: saturate(180%) blur(20px);
      box-shadow: 0 2px 20px rgba(0, 102, 204, 0.08);
      z-index: 1000;
      transition: all 0.3s ease;
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.75rem 2rem;
    }

    .logo {
      font-weight: 700;
      font-size: 1.2rem;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .logo::before {
      content: "🏊‍♂️";
      font-size: 1.5rem;
      animation: float 3s ease-in-out infinite;
    }

    nav {
      display: flex;
      gap: 1.5rem;
      margin: 0 auto;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    nav a {
      text-decoration: none;
      color: var(--text);
      font-weight: 500;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      position: relative;
    }

    nav a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      transition: width 0.3s ease;
    }

    nav a:hover::after {
      width: 100%;
    }

    nav a:hover {
      color: var(--primary);
    }

    .btn {
      display: inline-block;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      font-size: 0.85rem;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      border: 2px solid transparent;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s ease;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn.primary {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      box-shadow: 0 4px 15px var(--shadow);
    }

    .btn.primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px var(--shadow-hover);
    }

    .btn.outline {
      border: 2px solid var(--primary);
      color: var(--primary);
      background: transparent;
    }

    .btn.outline:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-2px);
    }

    /* HERO SECTION */
    .hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 0 2rem;
      position: relative;
      background: linear-gradient(135deg, #0066cc 0%, #0099ff 50%, #66ccff 100%);
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><path d="M0,20 Q250,80 500,20 T1000,20 V100 H0 Z"/></svg>') repeat-x;
      animation: wave 8s ease-in-out infinite;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
      animation: fadeInUp 1s ease-out;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: white;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .hero .subtitle {
      font-size: 1.3rem;
      margin-bottom: 2.5rem;
      color: rgba(255, 255, 255, 0.9);
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .hero-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
      margin-top: 2rem;
    }

    .hero-buttons .btn {
      padding: 1rem 2rem;
      font-size: 1rem;
    }

    .hero-buttons .btn.outline {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(255, 255, 255, 0.3);
      color: white;
      backdrop-filter: blur(10px);
    }

    .hero-buttons .btn.outline:hover {
      background: rgba(255, 255, 255, 0.2);
      border-color: white;
    }

    /* FLOATING ELEMENTS */
    .floating-elements {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 1;
    }

    .floating-elements::before,
    .floating-elements::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      animation: float 6s ease-in-out infinite;
    }

    .floating-elements::before {
      width: 200px;
      height: 200px;
      top: 20%;
      left: 10%;
      animation-delay: -2s;
    }

    .floating-elements::after {
      width: 150px;
      height: 150px;
      bottom: 20%;
      right: 10%;
      animation-delay: -4s;
    }

    /* SECTIONS */
    section {
      padding: 6rem 2rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 3rem;
      color: var(--text);
      position: relative;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      border-radius: 2px;
    }

    /* FEATURES GRID */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2rem;
      margin-top: 3rem;
    }

    .feature-card {
      background: white;
      padding: 2rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px var(--shadow);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .feature-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px var(--shadow-hover);
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      font-size: 1.5rem;
    }

    .feature-card h3 {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--text);
    }

    .feature-card p {
      color: var(--text-light);
      line-height: 1.6;
    }

    /* BENEFITS SECTION */
    .benefits {
      background: linear-gradient(135deg, #f8fbff 0%, #e6f3ff 100%);
      position: relative;
    }

    .benefits::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--accent), transparent);
    }

    .benefits-content {
      max-width: 800px;
      margin: 0 auto;
      padding: 6rem 2rem;
      text-align: center;
    }

    .benefits p {
      font-size: 1.1rem;
      color: var(--text-light);
      margin-bottom: 2rem;
    }

    /* CONTACT SECTION */
    .contact {
      text-align: center;
    }

    .contact-content {
      max-width: 700px;
      margin: 0 auto;
    }

    .contact p {
      font-size: 1.1rem;
      color: var(--text-light);
      margin-bottom: 2rem;
    }

    .contact a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .contact a:hover {
      color: var(--secondary);
    }

    /* FOOTER */
    footer {
      background: var(--text);
      color: white;
      padding: 2rem;
      text-align: center;
      margin-top: 4rem;
    }

    /* RESPONSIVE */
    .auth-buttons {
      margin-left: auto;
    }

    @media (max-width: 1024px) {
      nav {
        display: none;
      }
      
      .nav-container {
        justify-content: space-between;
      }
    }

    @media (max-width: 768px) {
      .nav-container {
        padding: 0.75rem 1rem;
      }
      
      .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
      }

      nav {
        display: none;
      }

      .hero h1 {
        font-size: 2.5rem;
      }

      .hero .subtitle {
        font-size: 1.1rem;
      }

      .hero-buttons {
        flex-direction: column;
        align-items: center;
      }

      .hero-buttons .btn {
        width: 100%;
        max-width: 300px;
      }

      .features-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .section-title {
        font-size: 2rem;
      }

      section {
        padding: 4rem 1rem;
      }

      .benefits {
        padding: 4rem 1rem;
      }
    }

    /* SCROLL ANIMATIONS */
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease;
    }

    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }

    @media (max-width: 480px) {
      .features-grid {
        grid-template-columns: 1fr;
      }
    }

    /* HOVER EFFECTS */
    .btn {
      position: relative;
      overflow: hidden;
    }

    .btn:hover {
      animation: pulse 0.6s ease;
    }
  </style>
</head>

<body>
  <header>
    <div class="nav-container">
      <div class="logo">Pool Control</div>
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
      <p>Contáctanos en <a href="mailto:info@poolcontrol.com">info@poolcontrol.com</a> o comienza tu prueba gratuita.</p>
    </div>
    <div style="margin-top: 2rem;">
      <a href="/register" class="btn primary">Crear Cuenta Gratis</a>
    </div>
  </section>

  <footer>
    <p>&copy; 2024 Pool Control. Todos los derechos reservados. Hecho con 💙 para instructores de natación.</p>
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