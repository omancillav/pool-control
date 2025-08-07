<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Pool control',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Pool</b> Control',
    'logo_img' => 'img/logo.jpg',
    'logo_img_class' => 'brand-image img-circle elevation-2',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Pool Control',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'img/logo.webp',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'img/logo.webp',
            'alt' => 'Preloader Image',
            'effect' => 'animation__shake',
            'width' => 70,
            'height' => 70,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'sidebar-mini layout-fixed layout-navbar-fixed',
    'classes_brand' => 'navbar-primary navbar-dark elevation-1',
    'classes_brand_text' => 'text-white font-weight-bold',
    'classes_content_wrapper' => 'content-wrapper',
    'classes_content_header' => 'content-header',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-1',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light elevation-1',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container-fluid',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-fw fa-users',
            'submenu' => [
                [
                    'text' => 'Lista',
                    'route' => 'usuarios.list',
                    'icon' => 'fas fa-list',
                    'can' => ['admin', 'profesor']
                ],
                [
                    'text' => 'Nuevo',
                    'route' => 'usuarios.nueva',
                    'icon' => 'fas fa-user-plus',
                    'can' => ['admin', 'profesor']
                ],
            ],
        ],
        [
            'text' => 'Membresías',
            'icon' => 'fas fa-fw fa-clipboard',
            'submenu' => [
                [
                    'text' => 'Lista',
                    'route' => 'membresias.list',
                    'icon' => 'fas fa-list',
                    'can' => ['admin', 'cliente']
                ],
                [
                    'text' => 'Nueva',
                    'route' => 'membresias.nueva',
                    'icon' => 'fas fa-plus',
                    'can' => 'admin'
                ],
            ],
        ],
        [
            'text' => 'Clases',
            'icon' => 'fas fa-fw fa-home',
            'submenu' => [
                [
                    'text' => 'Lista',
                    'route' => 'clases.list',
                    'icon' => 'fas fa-list',
                    'can' => ['admin', 'cliente', 'profesor']
                ],
                [
                    'text' => 'Nueva',
                    'route' => 'clases.nueva',
                    'icon' => 'fas fa-plus',
                    'can' => ['admin', 'profesor']
                ],
            ],
        ],
        [
            'text' => 'Reservaciones',
            'icon' => 'fas fa-fw fa-calendar-alt',
            'submenu' => [
                [
                    'text' => 'Reservar Clase',
                    'route' => 'reservaciones.index',
                    'icon' => 'fas fa-calendar-plus',
                    'can' => 'cliente'
                ],
                [
                    'text' => 'Mis Reservaciones',
                    'route' => 'reservaciones.mis-reservaciones',
                    'icon' => 'fas fa-calendar-check',
                    'can' => 'cliente'
                ],
                [
                    'text' => 'Gestión de Reservaciones',
                    'route' => 'reservaciones.gestion',
                    'icon' => 'fas fa-tasks',
                    'can' => ['admin', 'profesor']
                ],
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'PoolControlTheme' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'data:text/css;base64,' . base64_encode('
                        /* Pool Control Custom Theme */
                        .content-wrapper, .main-footer { background-color: #E6F0FA !important; }
                        .main-header.navbar { box-shadow: 0 2px 4px rgba(176, 190, 197, 0.1) !important; padding: 0.5rem 1rem !important; }
                        .main-sidebar { box-shadow: 0 2px 8px rgba(176, 190, 197, 0.12) !important; }
                        .card { border-radius: 12px !important; border: 1px solid #E0E0E0 !important; box-shadow: 0 2px 8px rgba(176, 190, 197, 0.12) !important; }
                        .card-header { background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%) !important; border-radius: 12px 12px 0 0 !important; }
                        .card-title { color: #222 !important; font-weight: bold !important; }
                        .btn-primary { background-color: #1976D2 !important; border-color: #1976D2 !important; border-radius: 6px !important; }
                        .form-control { border-radius: 6px !important; border: 1px solid #E0E0E0 !important; }
                        .table { border-radius: 6px !important; }
                        .content-header { background: linear-gradient(90deg, #E6F0FA 0%, #B3D4FC 100%) !important; border-radius: 12px !important; margin-bottom: 20px !important; }
                        
                        /* Sidebar improvements */
                        .nav-sidebar .nav-link { padding: 0.7rem 1rem !important; font-size: 0.95rem !important; }
                        .nav-sidebar .nav-icon { color: #1976D2 !important; margin-right: 0.5rem !important; font-size: 1.1rem !important; }
                        .nav-sidebar .nav-link .nav-icon { width: 1.6rem !important; }
                        
                        /* Parent menu items */
                        .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active { 
                            background: #1976D2 !important; 
                            color: white !important; 
                            border-radius: 6px !important; 
                            margin: 2px 8px !important; 
                            font-weight: 600 !important;
                        }
                        .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link:hover:not(.active) { 
                            background: rgba(179, 212, 252, 0.2) !important; 
                            color: #222 !important; 
                            border-radius: 6px !important; 
                            margin: 2px 8px !important; 
                            transition: all 0.15s ease !important;
                        }
                        
                        /* Child menu items */
                        .nav-sidebar .nav-treeview > .nav-item > .nav-link { 
                            font-size: 0.9rem !important; 
                            color: #555 !important; 
                        }
                        .nav-sidebar .nav-treeview > .nav-item > .nav-link .nav-icon { 
                            color: #1976D2 !important; 
                            font-size: 0.9rem !important; 
                            margin-right: 0.5rem !important; 
                        }
                        .nav-sidebar .nav-treeview > .nav-item > .nav-link:hover:not(.active) { 
                            background: rgba(179, 212, 252, 0.15) !important; 
                            color: #222 !important; 
                            border-radius: 6px !important; 
                            margin: 2px 8px !important; 
                            transition: all 0.15s ease !important;
                        }
                        .nav-sidebar .nav-treeview > .nav-item > .nav-link.active { 
                            background: rgba(25, 118, 210, 0.2) !important; 
                            color: #1976D2 !important; 
                            border-radius: 6px !important; 
                            margin: 2px 8px !important; 
                            font-weight: 600 !important; 
                            border-left: 3px solid #1976D2 !important;
                        }
                        
                        /* Navbar improvements */
                        .navbar-nav .nav-link { padding: 0.7rem 1rem !important; font-size: 0.95rem !important; }
                        .navbar .navbar-nav .nav-link { color: #222 !important; }
                        .dropdown-toggle::after { margin-left: 0.5rem !important; }
                        
                        /* User dropdown improvements */
                        .navbar-nav .dropdown-menu { margin-top: 0.25rem !important; }
                        .dropdown-item { padding: 0.5rem 1rem !important; }
                    '),
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
