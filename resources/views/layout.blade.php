<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        <div class="nav-bar">
            <ul>
                <!-- <li><a href="/">куда едем?</a></li>
                <li><a href="/hotels">Отели</a></li>
                <li><a href="/exp">Экскурсия</a></li> -->
            </ul>
        </div>
        <div id="app">
            <!-- @yield('content') -->
        </div>  
        
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
