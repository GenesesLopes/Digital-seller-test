<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Digital Seller</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet" />       
    </head>
    <body>
        <div id="app">
            @yield('content')
        </div>
        <script src="https://use.fontawesome.com/00046d1603.js"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>