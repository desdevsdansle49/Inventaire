<!DOCTYPE html>
<html lang="en">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<style>
    @font-face {
        font-family: 'QuickSand';
        src: url('Quicksand-VariableFont_wght.tff');
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
        font-family: 'QuickSand', sans-serif;
    }

    h2 {

        font-family: 'QuickSand', sans-serif;
    }

    table {
        table-layout: fixed;
        width: 200px;
    }

    th,
    td {
        width: 100px;
        overflow: hidden;
    }

    .th1 {
        width: 10px;
    }

    .th2 {
        width: 110px;
    }

    .th3 {
        width: 50px;
    }

    .th4 {
        width: 100px;
    }

    .th5 {
        width: 50px;
    }

    .th6 {
        width: 10px;
    }
</style>

<body>
    <div class="d-flex pb-2 mb-4 pt-2 bg-dark h2">
        <img width="10%" height="10%" src="{{ asset('logo-police.png') }}" />
        <a class="ps-5" href="/">Liste</a>
        <a class="ps-5" href="/stats">Stats</a>
    </div>


    @yield('content')

    @livewireScripts



    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>
