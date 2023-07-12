<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Area</title>

    @vite('resources/css/app.css')
</head>

<body class="text-center text-white bg-dark">

@yield('body')

@vite('resources/js/app.js')
@livewireScripts
</body>

</html>
