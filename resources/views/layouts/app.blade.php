<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>T-Master</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Cuprum" rel="stylesheet">
    <link href="https://tmaster.herokuapp.com/css/app.css" rel="stylesheet">
    <link href="https://tmaster.herokuapp.com/css/main.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                  <!-- <img src="{{asset('img/logo.svg')}}" id="logo"> -->
                  <svg height="40px" width="65.339px" viewBox="0 0 65.339 40">
                    <g>
                    	<path fill="#0F1B5F" d="M29.839,2.232h-8.621c-0.616,0-0.827-0.5-0.472-1.116S21.891,0,22.507,0h8.621
                    		c0.616,0,0.827,0.5,0.472,1.116S30.456,2.232,29.839,2.232z"/>
                    	<path fill="#0F1B5F" d="M49.348,2.232H33.25c-0.616,0-0.828-0.5-0.472-1.116C33.134,0.5,33.922,0,34.538,0h16.101
                    		c0.614,0,0.827,0.5,0.471,1.116S49.965,2.232,49.348,2.232z"/>
                    	<path fill="#0F1B5F" d="M43.63,8.063H27.083c-0.616,0-0.827-0.5-0.472-1.116c0.356-0.616,1.144-1.115,1.76-1.115H44.92
                    		c0.616,0,0.827,0.499,0.471,1.115S44.246,8.063,43.63,8.063z"/>
                    	<path fill="#0F1B5F" d="M39.279,13.896h-3.445c-0.616,0-0.828-0.5-0.473-1.116c0.356-0.616,1.145-1.116,1.761-1.116h3.445
                    		c0.616,0,0.827,0.5,0.471,1.116C40.683,13.396,39.895,13.896,39.279,13.896z"/>
                    	<path fill="#0F1B5F" d="M64.966,2.482c-0.545-1.191-1.659-2.137-2.836-2.409c-0.038-0.009-0.165-0.04-0.259-0.054
                    		C61.78,0.005,61.351,0,61.34,0h-7.403c-0.616,0-1.404,0.5-1.76,1.116c-0.356,0.616-0.145,1.116,0.472,1.116h4.797
                    		c-0.454,0.69-0.852,1.59-1.126,2.764c0,0-0.167,0.711-0.196,0.837h-7.884c-0.616,0-1.404,0.499-1.761,1.115
                    		c-0.355,0.616-0.146,1.116,0.471,1.116h8.632c-0.056,0.214-0.834,2.767-1.215,3.583c-0.001,0.006-0.005,0.012-0.008,0.017h-10.36
                    		c-0.616,0-1.404,0.5-1.759,1.116c-0.356,0.616-0.146,1.116,0.471,1.116h10.278c-0.457,0.581-0.979,1.128-1.582,1.656
                    		c-0.876,0.771-1.585,1.431-2.191,2.042l1.072,1.151c2.259,2.426,3.502,5.587,3.502,8.903c0,4.729-2.565,9.102-6.697,11.411
                    		l-0.09,0.051c0.84,0.304,1.734,0.522,2.676,0.65l0.493,0.067l0.379-0.324c0.187-0.158,4.595-3.937,7.005-8.388
                    		c2.068-3.817,2.857-7.68,2.411-11.809c-0.175-1.621-0.036-2.942,0.466-4.417c0.345-1.019,0.889-2.17,1.667-3.522
                    		c0.248-0.433,1.024-1.69,1.126-1.852C64.374,7.712,66.107,4.986,64.966,2.482z M58.805,13.123
                    		c-1.924-0.187-2.649-0.988-1.659-2.647l2.461,0.946L58.805,13.123z"/>
                    </g>
                    <g>
                    	<path fill="#9D0D15" d="M4.496,17.209H0.645c-0.617,0-0.828-0.5-0.472-1.117c0.356-0.616,1.144-1.115,1.76-1.115h3.851
                    		c0.616,0,0.828,0.499,0.472,1.115C5.9,16.709,5.112,17.209,4.496,17.209z"/>
                    	<path fill="#9D0D15" d="M24.895,17.209H7.733c-0.616,0-0.827-0.5-0.472-1.117c0.356-0.616,1.144-1.115,1.76-1.115h17.161
                    		c0.616,0,0.828,0.499,0.472,1.115S25.511,17.209,24.895,17.209z"/>
                    	<path fill="#9D0D15" d="M15.741,22.907H4.496c-0.617,0-0.828-0.5-0.473-1.116c0.356-0.616,1.144-1.116,1.76-1.116H17.03
                    		c0.616,0,0.827,0.5,0.471,1.116S16.358,22.907,15.741,22.907z"/>
                    	<path fill="#9D0D15" d="M21.219,28.605H10.727c-0.616,0-0.828-0.501-0.473-1.117c0.356-0.615,1.145-1.116,1.76-1.116h10.492
                    		c0.616,0,0.827,0.501,0.472,1.116C22.622,28.104,21.835,28.605,21.219,28.605z"/>
                    	<path fill="#9D0D15" d="M50.028,34.296c-0.248-0.478-0.062-1.067,0.417-1.313c0.386-0.201,0.844-0.118,1.138,0.173
                    		c0.878-1.728,1.36-3.663,1.36-5.667c0-3.174-1.192-6.2-3.354-8.522c-2.359-2.535-5.697-3.989-9.159-3.989
                    		c-0.073,0-0.146,0.001-0.221,0.002c-0.018-0.001-0.035-0.002-0.054-0.002H29.489c-0.616,0-1.404,0.499-1.76,1.115
                    		c-0.356,0.616-0.145,1.116,0.472,1.116h5.107c-1.333,0.927-2.478,2.105-3.365,3.466h-9.652c-0.616,0-1.405,0.5-1.76,1.116
                    		s-0.145,1.115,0.472,1.115h9.787c-0.431,1.09-0.711,2.254-0.819,3.466h-1.86c-0.616,0-1.405,0.501-1.76,1.116
                    		c-0.355,0.616-0.145,1.117,0.472,1.117h3.148C28.536,34.982,33.908,40,40.431,40c2.136,0,4.246-0.549,6.1-1.587
                    		c1.635-0.914,3.011-2.164,4.066-3.637C50.36,34.699,50.151,34.534,50.028,34.296z M45.412,35.262
                    		c-0.494,0.255-1.102,0.063-1.357-0.43c-0.256-0.493-0.063-1.102,0.431-1.356c0.493-0.257,1.1-0.063,1.356,0.43
                    		C46.096,34.397,45.905,35.005,45.412,35.262z M47.722,30.112c-0.523,0.271-1.167,0.066-1.438-0.456
                    		c-0.271-0.523-0.066-1.166,0.456-1.437c0.523-0.271,1.167-0.069,1.438,0.454C48.45,29.196,48.246,29.841,47.722,30.112z"/>
                    </g>
                  </svg>
                  БФБ
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                  <li><a href="/">Соревнования</a></li>
                  <li><a href="/players">Игроки</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}" class="login">Вход</a></li>
                        <li><a href="{{ route('register') }}" class="register">Регистрация</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }}
                                <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/{{Auth::user()->id}}/account">Профиль</a></li>
                                <li><a href="/account/edit">Настройки</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выход
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <section class="container">
        @yield('content')
    </section>
</div>
<footer class="footer">&copy; 2006-2017, Белорусская Федерация Боулинга</footer>

<!-- Scripts -->
<script src="https://tmaster.herokuapp.com/js/app.js"></script>
@yield('scripts')
<!-- <script src="https://tmaster.herokuapp.com/js/resultTabs.js"></script>
<script src="https://tmaster.herokuapp.com/js/apply.js'"></script>
<script src="https://tmaster.herokuapp.com/js/newTournament.js'"></script>
<script src="https://tmaster.herokuapp.com/js/statistics.js'"></script>
<script src="https://tmaster.herokuapp.com/js/run.js'"></script>
<script src="https://tmaster.herokuapp.com/js/account.js'"></script> -->
</body>
</html>
