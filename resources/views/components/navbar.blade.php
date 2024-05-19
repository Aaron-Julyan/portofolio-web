<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">
            <i class="bi bi-archive-fill ms-2"></i>
            Portofolio Web
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <div class="container mt-2">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="/search" method="get" class="d-flex" role="search">
                            @csrf
                            <input class="form-control" name="search" type="search"
                                placeholder="Search Post or User...">
                            <button class="btn me-3 btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (auth()->check())
                                Welcome, {{ auth()->user()->name }}
                                {{-- Welcome, {{ auth()->check()}} --}}
                            @endif

                        </a>
                        <ul class="dropdown-menu dropdown-menu-start">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="post">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i>
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link me-2" aria-current="page" href="/login">
                            <i class="bi bi-box-arrow-in-left"></i>
                            Log In
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
