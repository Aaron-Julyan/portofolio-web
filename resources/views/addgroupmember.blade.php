<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <!-- Icons import -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>Create New Post</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    {{-- trix editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- <div class="gedf-main mt-5">
            <div class="card gedf-card px-3 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Foto circle -->
                    <div class="d-flex align-items-center">
                        @if ($datauser->status == 'user')
                            <img class="rounded-circle" width="100" height="100" src="{{ $datauser->file }}" alt="">
                        @elseif ($datauser->status == 'group')
                            <img class="rounded-circle" width="100" height="100"
                                src="{{ asset('storage/' . $datauser->file) }}" alt="">
                        @endif
                        <!-- Nama user dan jurusan -->
                        <div class="me-3">
                            <div class="h5 m-0">{{ $datauser->name }}</div>
                            <div class="h7 text-muted">
                                {{ $datauser->category ? $datauser->category : 'No Category' }}</div>
                            <p class="card-text">
                                {{ $datauser->description ? $datauser->description : 'No Description' }}</p>
                            <div>
                                <a href="#" type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-envelope-at"></i>
                                    {{ $datauser->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="mx-3"> --}}
            <h4 class="mt-5 mb-4">Add Group Member</h4>
            <hr>

            <form method="post" action="/addgroupmember" enctype="form-data">
                @csrf
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- <input type="hidden" name="postid" value="{{ $postid }}">
                <p>{{ $postid }} (Nanti hapus)</p> --}}

                <div class="mb-3">
                    <label class="form-label">Select Member</label>
                    @if ($alluser->isEmpty())
                        <select class="form-select" name="selectedId" onchange="">
                            <option value="0">No User to Add</option>
                        </select>
                    @else
                        <select class="form-select" name="selectedId" onchange="">
                            <option value="0">Please Select User
                                @foreach ($alluser as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} |
                                {{ $user->email }} | {{ $user->category }}
                    @endforeach
                    </select>
                    @endif
                    <label class="form-label mt-3">Select Role</label>
                    <select class="form-select" name="selectedRole" onchange="">
                        <option value="">Not Selected
                        <option value="Member">Member
                        <option value="Admin">Admin
                    </select>
                </div>
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Add Group Member</button>
                </div>
            </form>
        {{-- </div> --}}

        {{-- list member --}}
        {{-- <div class="gedf-main mt-3">
            <div class="card gedf-card px-3 py-3">
                <div class="row">
                    <h4>Group Member</h4>
                    <div class="row row-cols-sm-1 row-cols-md-3">
                        @if ($usersWithStatus->isEmpty())
                            <p>No Member Shown</p>
                        @else
                            @foreach ($usersWithStatus as $user)
                                <div class="col">
                                    <div class="card gedf-card mt-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="mr-2">
                                                    <img class="rounded-circle" height="50" width="50"
                                                        src="{{ asset('storage/' . $user->file) }}" alt="">
                                                </div>
                                                <div class="ml-2 me-3">
                                                    <div class="h5 m-0">{{ $user->name }}</div>
                                                    <div class="h7 text-muted">
                                                        {{ $user->category ? $user->category : 'No Category' }}</div>
                                                    @if ($user->permission_status == 'Admin')
                                                        <div class="badge text-bg-success">
                                                            {{ $user->permission_status }}
                                                        </div>
                                                    @else
                                                        <div class="badge text-bg-secondary">
                                                            {{ $user->permission_status }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <p class="card-text">
                                                {{ $user->description ? $user->description : 'No Description' }}
                                            </p>
                                            <a href="/viewprofile/{{ $user }}" class="card-link">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</body>

</html>
