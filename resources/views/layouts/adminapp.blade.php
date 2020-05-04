<!DOCTYPE html>

<?php 
    if(empty(session('user'))){
        header("Location: /Login");
        die();
    };
    
    if(session('user')->right->admin == false){
        header("Location: /");
        die();
    };
?>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <script src="https://kit.fontawesome.com/df02488eec.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/events" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret">Events</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/schedules" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret">Schedules</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/artists" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret">Artists</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/admin/reviews" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret">Reveiws</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/logout" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
