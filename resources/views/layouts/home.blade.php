<!DOCTYPE html>
<html lang="en">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <!-- CSS only -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

</head>

<style>
    @font-face {
        font-family: 'Quicksand-Light';
        src: url("{{ asset('fonts/Quicksand-Light.woff2') }}") format('woff2'),
            url("{{ asset('fonts/Quicksand-Light.woff') }}") format('woff');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }


    tr:nth-child(even) {
        background-color: aliceblue;
    }

    body {
        background-color: darkgrey;
    }

    a {
        color: white;
        text-decoration: none;
        font-family: 'Quicksand-Light', sans-serif;
    }

    h2 {

        font-family: 'Quicksand-Light', sans-serif;
    }

    table {
        table-layout: fixed;
        width: 200px;
    }


    th,
    td {
        width: 100px;
        overflow: hidden;
        vertical-align: middle;
    }

    .th1 {
        width: 10px;
    }

    .th2 {
        width: 110px;
    }

    .th3 {
        width: 60px;
    }

    .th4 {
        width: 100px;
    }

    .th5 {
        width: 70px;
    }

    .th6 {
        width: 40px;
    }

    .th7 {
        width: 40px;
    }

    .th8 {
        width: 5px;
    }
</style>

<body>
    <!-- Header -->
    @livewire('navigation-menu')

    <!-- Content -->
    @yield('content')

    @livewireScripts

    <!-- JavaScript Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>

</body>

</html>
