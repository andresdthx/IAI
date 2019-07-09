<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.0.6/dist/vue-multiselect.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>

    <script>

        if ( (window.location.pathname.split('/')[1] == 'subproyectos' || window.location.pathname.split('/')[1] == 'todos_mis_activos') 
              && window.location.hash != '#reload')  {
            window.history.replaceState({}, '', '#reload');
            window.location.reload();
        }
        
    </script>

<body style="{{Auth::user() ? '': 'background-color: #990000' }}">

    <div id="app">
    @if(Route::getFacadeRoot()->current()->uri() != 'manual_usuario' and Auth::user())
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
        
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div style="margin-left: 45px;">
                            <img  style="margin-top: 5px;" src="{{asset('images/escuela.png')}}" alt="" width="140"> 
                            <!-- <img  style="margin-top: 10px;" src="{{asset('images/ip_data.png')}}" alt="" width="110">  -->
                        </div>
                    </a>

                </div>

                <div class="navbar-collapse" id="app-navbar-collapse">

                    <ul class="nav navbar-nav navbar-right ">

                        <li onclick="clickMenuItem('glosario')">

                        </li>

                        <li onclick="clickMenuItem('manual_usuario')">

                        </li>

                        <li style="background-color: #f9f9f9; position: relative">

                        <!-- <search-bar></search-bar> -->
                            <form autocomplete="off" action="/busqueda" style="cursor: initial" >

                            <span>
                                <i id="img-search"style="font-size: 20px; position: relative; top: 0px" class="fa fa-search"></i> 

                                <input class="search-bar"  
                                       type="text" 
                                       placeholder="Buscar..." 
                                       name="search" 
                                       value="">
                            
                            </span>
 
                            </form>

                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                <img  src="{{asset('images/user.png')}}" >
                                <!-- <span class="menu-text">{{Auth::user()->name}}</span> -->
                                <!-- <i style="color: #88A6B0" class="fa fa-caret-down" aria-hidden="true"></i> -->
                            </a>

                           

                            <ul class="dropdown-menu">
                                <li class="drop-down-item">
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                                <li class="drop-down-item" ><a href="/user/perfil">Perfil</a></li>
                            </ul>

                        </li>

                    </ul>
                    
                </div>
            </div>
        </nav>

         
        <div id="container" class="{{ Auth::user() ? 'container-app' : '' }}">
            @if (Auth::user())
                
                <div class="app-menu-bar" id="menu-bar">

                    <div class="app-menu-bar-body" id="menu-body">

                        <div onclick="clickMenuItem('')" id="home">
                            <p>
                                <img src="{{asset('images/home.png')}}">
                                <span>Inicio</span>
                            </p>
                        </div>

                    
                        <div id="proyectos">
                            <p style="line-height:0px; padding-top: 5px">
                                
                                <span><img src="{{asset('images/grupos.png')}}"/>Grupos de </span>
                                <span style="padding-left: 36px">investigación</span>
                                <span id="up-down" style="font-size: 13px" class="glyphicon glyphicon-chevron-down"></span>
                               
                            </p>
                        </div>

                        <div style="all:unset; display: none" id="submenu_proyectos">
                            <div onclick="clickMenuItem('mis_proyectos')" style="height: 45px; line-height: 45px;" id="mis_proyectos">  
                                <p style="padding-left: 85px; font-size: 16px">
                                    <span>Mis grupos</span>
                                </p>
                            </div>

                            <div onclick="clickMenuItem('todos_los_proyectos')" style="height: 45px; line-height: 45px;" id="todos_los_proyectos">  
                                <p style="padding-left: 85px; font-size: 16px">
                                    <span>Todos los grupos</span>
                                </p>
                            </div>
                            <div onclick="clickMenuItem('todos_los_semilleros')" style="height: 45px; line-height: 45px;" id="todos_los_semilleros">  
                                <p style="padding-left: 85px; font-size: 16px">
                                    <span>Semilleros</span>
                                </p>
                            </div>
                        </div>

                        <div id="proyectosAll" onclick="clickMenuItem('proyectosAll')">
                            <p>
                                <img src="{{asset('images/proyectos.png')}}" id="proyectosAll">
                                <span>Proyectos</span>
                            </p>
                        </div>

                        <div id="todos_mis_activos" onclick="clickMenuItem('todos_mis_activos')">
                            <p>
                                <img src="{{asset('images/menu-activos.png')}}" id="activos">
                                <span>Activos</span>
                            </p>
                        </div>

                        <div onclick="clickMenuItem('report')" id="report">
                            <p>
                                <img src="{{asset('images/report.png')}}">
                                <span>Reporte general</span>
                            </p>
                        </div>
                        
                        @if (Auth::user()->hasRole('admin'))
                        <div onclick="clickMenuItem('users')" id="users">
                            <p>
                                <img src="{{asset('images/users.png')}}">
                                <span>Usuarios</span>
                            </p>
                        </div>
                        @endif

                        <div class="nav2">
                            <div onclick="clickMenuItem('glosario')">
                                <span>
                                    <img src="{{asset('images/menu-glosario.png')}}">
                                    <span class="menu-text">Glosario</span>
                                </span>
                            </div>
    
                            <div onclick="clickMenuItem('manual_usuario')">
                                <span>
                                    <img src="{{asset('images/menu-ayuda.png')}}">
                                    <span class="menu-text">Manual de usuario</span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

            <div class="app-menu-content" style="min-height: 100vh;">
                @yield('content')
            </div>
                
            </div>
        </div>
       
    @else
    <div style="min-height: 95vh;">
        @yield('content')
    </div>
    @endif

    <div class="{{ Auth::user() ? 'footer-app-login' : 'footer-app-logout' }}">
        <div class="footer-container">

            <div class="footer-img">
                <img src="{{asset('images/logo_footer.png')}}" width="100px"/>
            </div>

            <div class="foott">
                <ul>
                    <li>Escuela Colombiana de Ingeniería Julio Garavito</li>
                    <li>AK.45 #205-59 (Autopista Norte)</li>
                    <li>Contact Center: 57(1) 668 3600</li>
                    <li>Información detallada en:</li>
                    <li>www.escuelaing.edu.co/es/</li>
                    <li>Bogotá - Colombia</li>
                </ul>
                <ul>
                    <li><b>Recolección y autorización para el manejo de datos personales</b></li>
                    <li>Personería Jurídica 086 de enero 19 de 1973</li>
                    <li>Acreditación institucional de alta calidad</li>
                    <li>Resolución 002710 del 18 de marzo de 2019. (Vigencia 6 años)</li>
                    <li>Vigilada Mineducación</li>
                </ul>
                
            </div>   

        </div>

        <div class="footer-om" style="padding-bottom: 15px;">
            <hr style="border-top: 1px solid #4D4D4D;">
            <span style="color: #4D4D4D; padding-left: 70px; font-weight: bold">© 2018 OlarteMoure & Asociados ALL RIGHTS RESERVED</span>

            <div style=" display:  inline-block; float: right; padding-right: 70px;">

                <a style="padding-left: 10px;" href="https://www.facebook.com/EscuelaIng/" target="_blank">
                    <i style="color: black" class="fa fa-facebook"></i>
                </a>

                <a style="padding-left: 10px;" href="https://twitter.com/Escuelaing" target="_blank">
                    <i style="color: black;" class="fa fa-twitter"></i>
                </a>

                <a style="padding-left: 10px;" href="https://www.instagram.com/escuelaing/?hl=en" target="_blank">
                    <i style="color: black;" class="fa fa-instagram"></i>
                </a>

                <a style="padding-left: 10px;" href="https://www.youtube.com/user/escuelacolingenieria" target="_blank">
                    <i style="color: black;" class="fa fa-youtube"></i>
                </a>

                <a style="padding-left: 10px;" href=" https://www.linkedin.com/school/escuela-colombiana-de-ingenieria/" target="_blank">
                    <i style="color: black;" class="fa fa-linkedin"></i>
                </a>
                
                <a title="Canal I+i" style="padding-left: 10px;" href=" https://www.linkedin.com/school/escuela-colombiana-de-ingenieria/" target="_blank">
                    <img src="{{asset('images/logo_canal.png')}}" width="20px"/>
                </a>

            </div>

        </div>

    </div>

   
</div>
    

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>

        var allItems = ['mis_proyectos', 'users', 'activos', 'home', 'todos_mis_activos', 'todos_los_semilleros', 'proyectosAll'];

        function clickMenuItem(item) {
            if (item == 'manual_usuario') {
                window.open(`/${item}`,'_blank' );
            } else {
                window.location.href= `/${item}`
            }
        }

        function phoneMode(width) {
            if (width < 870) {
                $('#container').removeClass('container-app', 'container-app-min');
                $(`#container`).addClass('container-app-min');
                $('#menu-bar').css('display', 'none');
            } else {
                $('#container').removeClass('container-app', 'container-app-min');
                $(`#container`).addClass('container-app');
                $('#menu-bar').css('display', 'block');
            }
        }

        $("#proyectos").click(function(){ 

            if ( $('#submenu_proyectos').css('display') == 'none') {
               $('#submenu_proyectos').css('display', 'block');
               $(`#proyectos`).addClass('active-app-menu-bar');
               $('#up-down').addClass('glyphicon-chevron-up');
               $('#up-down').removeClass('glyphicon-chevron-down');

            } else {
               $('#submenu_proyectos').css('display', 'none');
               $(`#proyectos`).removeClass('active-app-menu-bar');

               $('#up-down').removeClass('glyphicon-chevron-up');
               $('#up-down').addClass('glyphicon-chevron-down');
            }
        })

        $( document ).ready(function() {

            // phoneMode($(window).width());
            // $(window).resize(function() {
            //     phoneMode($(window).width());
            // });

            let item = window.location.href.split('/')[3].slice(0, -1);
            if (item == '') {
                item = 'home';
            }
            console.log(item);

            if (item.includes('proyectos') && item != "proyectosAll") {
               $('#submenu_proyectos').css('display', 'block');
               $(`#proyectos`).addClass('active-app-menu-bar');
               $('#up-down').addClass('glyphicon-chevron-up');
               $('#up-down').removeClass('glyphicon-chevron-down');
            }

            if (item.includes('activo') && item != 'todos_mis_activos') {

                $("#img-search").css("top", "3px");
                $("#img-search").css("width", "30px");

            }

            $(`#${item}`).addClass('active-app-menu-bar');
            
            _.each(allItems, x  => {
                if (x != item) {
                    $(`#${x}`).removeClass('active-app-menu-bar');
                }
            });

        });

    </script>

</body>
</html>
