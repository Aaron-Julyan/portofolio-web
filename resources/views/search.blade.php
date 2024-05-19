<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">
    {{-- fontawesome export --}}
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Icons import -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    {{-- model viewer import --}}
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>

    <!-- link CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.min.css">

    <!-- link JavaScript SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.all.min.js"></script>

    <title>Portofolio Web</title>
    {{-- <meta http-equiv="Content-Security-Policy" content="frame-src 'self' https://youtube.com;"> --}}
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    {{-- navbar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
                <i class="bi bi-archive-fill ms-2"></i>
                Portofolio Web
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <div class="container mt-2">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="/search" method="get" class="d-flex" role="search">
                                @csrf
                                <input class="form-control" name="search" type="search"
                                    placeholder="Search Post or User..."
                                    value="{{ isset($searchvalue) ? $searchvalue : '' }}">
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

    <div class="container-fluid gedf-wrapper">
        {{-- <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-center">
                <button type="button" id="btnViewPost" class="btn btn-secondary btn-lg btn-block mb-3">View Post</button>
                <button type="button" id="btnVisitProfile" class="btn btn-secondary btn-lg btn-block mb-3">Visit
                    Profile</button>
            </div>
        </div> --}}
        @if ($count == '0')
            <h5 class="mt-3">No Results for {{ $searchvalue }}</h5>
        @else
            <h5 class="mt-3">Showing {{ $count }} Results for {{ $searchvalue }}</h5>
            <div class="row">
                <div class="gedf-main">
                    @if ($datapost->isNotEmpty())
                        <h4>Posts</h4>
                        <div class="row row-cols-sm-1 row-cols-md-3">
                            @foreach ($datapost as $post)
                                <div class="col">
                                    <div class="card gedf-card mt-3">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @if ($post->user->status == 'user')
                                                        <a href="/viewprofile/{{ $post->user->id }}"
                                                            style="text-decoration: none; color: inherit;"
                                                            title="Click to View Post {{ $post->user->name }}">
                                                            <img class="rounded-circle" width="60" height="60"
                                                                src="{{ $post->user->file }}" alt="">
                                                        </a>
                                                    @elseif ($post->user->status == 'group')
                                                        <a href="/viewprofile/{{ $post->user->id }}"
                                                            style="text-decoration: none; color: inherit;"
                                                            title="Click to View Post {{ $post->user->name }}">
                                                            <img class="rounded-circle" width="60" height="60"
                                                                src="{{ asset('storage/' . $post->user->file) }}"
                                                                alt="">
                                                        </a>
                                                    @endif
                                                    <a href="/viewprofile/{{ $post->user->id }}"
                                                        style="text-decoration: none; color: inherit;"
                                                        title="Click to View Post {{ $post->user->name }}">
                                                        <div class="me-3">
                                                            <div class="h5 m-0">{{ $post->user->name }}</div>
                                                            <div class="p text-muted">
                                                                {{ $post->user->category ? $post->user->category : 'No Category' }}
                                                            </div>
                                                            <div class="text-muted h7"> <i
                                                                    class="fa fa-clock-o ms-1"></i>{{ $post->created_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="ml-auto">
                                                    @if ($postcontributor[$post->id]->isNotEmpty())
                                                        <button class="btn btn-outline-success viewContributorsBtn"
                                                            data-post-id="{{ $post->id }}"
                                                            title="View Contributors"><i
                                                                class="bi bi-person-lines-fill"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <a class="card-body" href="/viewpost/{{ $post->slug }}"
                                            style="text-decoration: none; color: inherit;"
                                            title="Click to View Post {{ $post->slug }}">
                                            <div>
                                                <span class="badge text-bg-secondary ">{{ $post->department }}</span>
                                                <span class="badge text-bg-secondary ">{{ $post->categories }}</span>
                                                <span
                                                    class="badge text-bg-secondary ">{{ $post->subcategories }}</span>
                                            </div>
                                            <div>
                                                @if ($postkeyword[$post->id]->isNotEmpty())
                                                    @foreach ($postkeyword[$post->id] as $keyword)
                                                        <span
                                                            class="badge text-bg-secondary">{{ $keyword->keyword }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <p class="card-text mt-3">
                                                {{ $post->excerpt }}
                                            </p>
                                            <div class="row">
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}"
                                                    class="img-fluid">
                                            </div>
                                        </a>
                                        <div class="card-footer">
                                            <a href="/viewpost/{{ $post->slug }}" class="card-link"><i
                                                    class="fa fa-comment"></i>
                                                View Post & Comment</a>
                                        </div>
                                    </div>
                                </div>

                                {{-- modal tiap post, kalo mau kasar (soalnya ke load semua) --}}
                                <div class="modal fade" id="contributorsModal{{ $post->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="contributorsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="contributorsModalLabel">Contributors List
                                                </h5>
                                                {{-- ga usah close icon disini --}}
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    @foreach ($postcontributor[$post->id] as $contributor)
                                                        <div class="row mb-3">
                                                            <div class="col-auto">
                                                                @if ($contributor->status == 'user')
                                                                    <td> <img class="rounded-circle" width="60"
                                                                            height="60"
                                                                            src="{{ $contributor->user->file }}"
                                                                            alt=""> </td>
                                                                @elseif ($contributor->status == 'group')
                                                                    <td> <img class="rounded-circle" width="60"
                                                                            height="60"
                                                                            src="{{ asset('storage/' . $contributor->user->file) }}"
                                                                            alt="">
                                                                    </td>
                                                                @endif
                                                            </div>
                                                            <div class="col">
                                                                <h5>{{ $contributor->name }}</h5>
                                                                <p>{{ $contributor->email }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="gedf-main mt-3">
                    @if ($datauser->isNotEmpty())
                        <h4>Profiles</h4>
                        <div class="row row-cols-sm-1 row-cols-md-3">
                            @foreach ($datauser as $user)
                                <div class="col">
                                    <div class="card gedf-card mt-3"
                                        onclick="location.href='/viewprofile/{{ $user->id }}';"
                                        style="cursor: pointer;" title="Click to View Profile {{ $user->name }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-start align-items-right">
                                                <div class="mr-2">
                                                    @if ($user->status == 'user')
                                                        <img class="rounded-circle" width="50" height="50"
                                                            src="{{ $user->file }}" alt="">
                                                    @elseif ($user->status == 'group')
                                                        <img class="rounded-circle" width="50" height="50"
                                                            src="{{ asset('storage/' . $user->file) }}"
                                                            alt="">
                                                    @endif
                                                </div>
                                                <div class="ml-2 me-3">
                                                    <div class="h5 m-0">{{ $user->name }}</div>
                                                    <div class="h7 text-muted">
                                                        {{ $user->category ? $user->category : 'No Category' }}</div>
                                                </div>
                                            </div>
                                            <hr>
                                            <p class="card-text">
                                                {{ $user->description ? $user->description : 'No Description' }}
                                            </p>
                                            <a href="/viewprofile/{{ $user->id }}" class="card-link">View
                                                Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                {{-- @auth
                    <div class="d-flex justify-content-end position-fixed bottom-0 start-0 m-3">
                        <a class="btn btn-primary" href="/createpost">
                            <i class="bi bi-plus-circle-fill"></i>
                            Create Post
                        </a>
                    </div>
                @endauth --}}
            </div>
        @endif
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        //untuk menampilkan dan menutup modal contributor
        $(document).ready(function() {
            $('.viewContributorsBtn').click(function() {
                var postId = $(this).data('post-id');
                $('#contributorsModal' + postId).modal('show');
            });

            $('.modal-footer button[data-dismiss="modal"]').click(function() {
                $(this).closest('.modal').modal('hide');
            });
        });

        $(document).ready(function() {
            $("#showFilterButton").click(function() {
                $(".tagfilter").show();
                $("#showFilterButton").hide();
                $("#hideFilterButton").show();
            });

            $("#hideFilterButton").click(function() {
                $(".tagfilter").hide();
                $("#showFilterButton").show();
                $("#hideFilterButton").hide();
            });
        });
    </script>
</body>

</html>
