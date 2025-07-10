<style>
    body {
        background: #E6F0FA;
    }
    .header-wave {
        position: relative;
        background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%);
        overflow: hidden;
        border-radius: 0 0 32px 32px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
    }
    .wave-svg {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        width: 100%; height: 70px;
        z-index: 0;
    }
    .wibesand-logo {
        font-weight: bold;
        font-size: 2rem;
        color: #FFC107;
        letter-spacing: 2px;
        display: flex;
        align-items: center;
    }
    .wibesand-logo .logo-icon {
        width: 36px; height: 36px; margin-right: 10px;
        background: #1976D2;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }
    .encabezado-titulo {
        text-align: center;
        font-size: 2.7rem;
        font-weight: 800;
        color: #222;
        margin-bottom: 0.3rem;
    }
    .encabezado-punto {
        display: flex; justify-content: center;
    }
    .encabezado-punto svg {
        margin-top: 0.2rem;
    }
    .bienvenida-section {
        display: flex; align-items: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.14);
        padding: 18px 30px;
        margin: -32px auto 24px auto;
        max-width: 540px;
        position: relative;
        z-index: 2;
    }
    .bienvenida-icon {
        background: #ECEFF1;
        border-radius: 50%;
        width: 48px; height: 48px;
        display: flex; align-items: center; justify-content: center;
        margin-right: 18px;
    }
    .bienvenida-txt {
        font-size: 1.5rem;
        font-weight: bold;
        color: #222;
    }
    .main-content {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        padding: 32px 16px 24px 16px;
        margin-bottom: 28px;
        border: 1px solid #E0E0E0;
    }
    .card-home {
        border-radius: 12px;
        border: 1px solid #E0E0E0;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        background: #fff;
        padding: 22px 18px 16px 18px;
        margin-bottom: 16px;
        display: flex; flex-direction: column; align-items: flex-start;
        min-height: 170px;
    }
    .card-home .icon {
        background: #ECEFF1;
        border-radius: 50%;
        width: 42px; height: 42px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 10px;
    }
    .card-home .icon svg {
        width: 22px; height: 22px;
    }
    .card-home .titulo {
        font-size: 1.1rem;
        color: #90A4AE;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .card-home .numero {
        font-size: 2.3rem;
        font-weight: 800;
        color: #222;
        margin-bottom: 6px;
    }
    .card-home .detalle-link {
        color: #2196F3;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        margin-left: auto;
        display: flex; align-items: center;
    }
    .card-home .detalle-link:hover {
        text-decoration: underline;
    }
    .card-home .mini-chart {
        margin-top: 6px;
        width: 100%;
        height: 32px;
    }
    .acciones-rapidas-section {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(176,190,197,0.12);
        border: 1px solid #E0E0E0;
        padding: 24px 12px 16px 12px;
        margin-bottom: 24px;
    }
    .acciones-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1976D2;
        margin-bottom: 18px;
        text-align: left;
    }
    .acciones-row {
        display: flex;
        gap: 10px;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .accion-btn {
        flex: 1;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        background: #42A5F5;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 18px 0 10px 0;
        font-size: 1.07rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(176,190,197,0.20);
        transition: background 0.2s;
        margin: 0 2px;
        cursor: pointer;
        position: relative;
    }
    .accion-btn .accion-icon {
        background: #2196F3;
        border-radius: 50%;
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 7px;
    }
    .accion-btn .accion-icon svg {
        width: 20px; height: 20px;
    }
    .accion-btn:hover {
        background: #1976D2;
    }
    .search-icon {
        position: absolute;
        top: 10px; right: 10px;
        color: #2196F3;
        background: #E6F0FA;
        border-radius: 50%;
        width: 26px; height: 26px;
        display: flex; align-items: center; justify-content: center;
    }
    @media (max-width: 768px) {
        .acciones-row {
            flex-direction: column;
            gap: 12px;
        }
        .main-content {
            padding: 18px 4px;
        }
    }
</style>

<div class="header-wave py-4 px-4 mb-0">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div class="wibesand-logo">
            <span class="logo-icon">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="width:32px; height:32px; border-radius:50%; object-fit:cover; background:#1976D2;" />
            </span>
            Pool Control
        </div>
        <div></div>
    </div>
    <div class="encabezado-titulo">Resumen General</div>
    <div class="encabezado-punto">
        <svg width="16" height="16"><circle cx="8" cy="8" r="8" fill="#2196F3"/></svg>
    </div>
    <svg class="wave-svg" viewBox="0 0 1440 70" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0,30 C360,90 1080,-30 1440,30 L1440,70 L0,70 Z" fill="#B3D4FC"/></svg>
</div>

<div class="bienvenida-section">
    <span class="bienvenida-icon">
        <svg width="28" height="28" fill="#B0BEC5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M12 14c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/></svg>
    </span>
    <span class="bienvenida-txt">Bienvenido {{ Auth::user()->name ?? 'Usuario' }}!</span>
</div>

<div class="main-content container-fluid">
    <div class="row text-center">
        <div class="col-12 col-md-4 mb-3">
            <div class="card-home">
                <span class="icon"><svg fill="#B0BEC5" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05C15.99 13.33 18 14.42 18 16.5V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></span>
                <div class="titulo">Usuarios</div>
                <div class="numero">{{ $totalUsuarios ?? '5' }}</div>
                <a href="{{ route('usuarios.list') }}" class="detalle-link">Ver detalles &rarr;</a>
                <div class="mini-chart">
                    <svg width="100%" height="32"><polyline fill="none" stroke="#2196F3" stroke-width="3" points="5,27 20,20 40,25 60,18 80,14 95,20"/><polyline fill="none" stroke="#4CAF50" stroke-width="3" points="5,28 20,25 40,22 60,25 80,22 95,18"/></svg>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <div class="card-home">
                <span class="icon"><svg fill="#B0BEC5" viewBox="0 0 24 24"><path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm-6 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm0-10V4h4v2h-4z"/></svg></span>
                <div class="titulo">Membresías Activas</div>
                <div class="numero">{{ $totalMembresias ?? '2' }}</div>
                <a href="{{ route('membresias.list') }}" class="detalle-link">Ver membresías &rarr;</a>
                <div class="mini-chart">
                    <svg width="100%" height="32"><polyline fill="none" stroke="#2196F3" stroke-width="3" points="5,25 20,18 40,22 60,15 80,10 95,15"/><polyline fill="none" stroke="#4CAF50" stroke-width="3" points="5,28 20,25 40,25 60,28 80,25 95,20"/></svg>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <div class="card-home">
                <span class="icon"><svg fill="#B0BEC5" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 18H5V8h14v13zm0-15H5V5h14v1z"/></svg></span>
                <div class="titulo">Clases Programadas</div>
                <div class="numero">{{ $totalClases ?? '3' }}</div>
                <a href="{{ route('clases.list') }}" class="detalle-link">Ver clases &rarr;</a>
                <div class="mini-chart">
                    <svg width="100%" height="32"><polyline fill="none" stroke="#2196F3" stroke-width="3" points="5,28 20,24 40,18 60,24 80,20 95,12"/><polyline fill="none" stroke="#4CAF50" stroke-width="3" points="5,30 20,28 40,25 60,28 80,25 95,20"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="acciones-rapidas-section container-fluid">
    <div class="acciones-title">Acciones Rápidas</div>
    <div class="acciones-row">
        <a href="{{ route('usuarios.nueva') }}" class="accion-btn"><span class="accion-icon"><svg fill="#fff" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg></span>Nuevo Usuario</a>
        <a href="{{ route('membresias.nueva') }}" class="accion-btn"><span class="accion-icon"><svg fill="#fff" viewBox="0 0 24 24"><path d="M20 6h-4V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zm-6 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm0-10V4h4v2h-4z"/></svg></span>Nueva Membresía</a>
        <a href="{{ route('clases.nueva') }}" class="accion-btn"><span class="accion-icon"><svg fill="#fff" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 18H5V8h14v13zm0-15H5V5h14v1z"/></svg></span>Nueva Clase</a>
        <a href="#" class="accion-btn"><span class="accion-icon"><svg fill="#fff" viewBox="0 0 24 24"><path d="M3 17v2h6v-2H3zm0-5v2h12v-2H3zm0-5v2h18V7H3z"/></svg></span>Reportes</a>
    </div>
    <span class="search-icon"><svg fill="#2196F3" width="18" height="18" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></span>
</div>

    

    
    
    
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}
</style>
