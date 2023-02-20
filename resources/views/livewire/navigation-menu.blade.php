<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('logo-police.png') }}" alt="Police Nationale" height="50" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="h3 collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-sm-0 gap-3">
                <li class="nav-item">
                    <a class="nav-link @if ($routename == '/') active @endif" href="/">Inventaire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($routename == 'stats') active @endif" href="stats">Statistique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($routename == 'logs') active @endif" href="logs">Historique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if ($routename == 'create') active @endif" href="create">Ajout</a>
                </li>
            </ul>
            {{-- <div class="d-flex" role="debug">
                <h1 class="navbar-brand mb-0">{{ $routename }}</h1>
            </div> --}}
        </div>
    </div>
</nav>
