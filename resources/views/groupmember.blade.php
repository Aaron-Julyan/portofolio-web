@extends('components.main')

@section('container')
    <div class="container-fluid gedf-wrapper">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="gedf-main mt-5">
            <div class="card gedf-card px-3 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Foto circle -->
                    <div class="d-flex align-items-center">
                        @if ($datauser->status == 'user')
                            <img class="rounded-circle" width="100" height="100" src="{{ $datauser->file }}"
                                alt="">
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

                    @if (Auth::check() && (Auth::user()->id == $datauser->id || $isAdmin))
                        <div class="ms-4">
                            <a href="/addgroupmember" class="btn btn-primary" title="Edit Profile"><i
                                    class="bi bi-plus-circle-fill"></i>
                                Add Group Member</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="gedf-main mt-3">
            <div class="card gedf-card px-3 py-3">
                {{-- ini uncomment kalo mau tidak mengisi space kosong --}}
                {{-- <div class="d-flex justify-content-between align-items-center"> --}}
                <div class="row">
                    <h4>Group Member</h4>
                    <div class="row row-cols-sm-1 row-cols-md-3">
                        @if ($usersWithStatus->isEmpty())
                            <p>No Member Shown</p>
                        @else
                            @foreach ($usersWithStatus as $user)
                                <div class="col">
                                    <div class="card gedf-card mt-3">
                                        <div class="card-body" style="cursor: pointer;"
                                            title="Click to View Profile {{ $user->id }}">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="mr-2">
                                                        @if ($user->status == 'user')
                                                            <img class="rounded-circle" width="50" height="50"
                                                                src="{{ $user->file }}" alt="">
                                                        @elseif ($user->status == 'group')
                                                            <img class="rounded-circle" width="50" height="50"
                                                                src="{{ asset('storage/' . $user->file) }}" alt="">
                                                        @endif
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

                                                @if (Auth::check() && (Auth::user()->id === $datauser->id || $isAdmin))
                                                    <div class="me-auto">
                                                        <form action="/addgroupmember/{{ $user->id }}" method="post"
                                                            class="d-inline" id="deleteForm{{ $user->id }}">
                                                            @method('delete')
                                                            @csrf
                                                            <button class="btn btn-outline-danger"
                                                                onclick="confirmDelete(event, {{ $user->id }})"
                                                                title="Delete Post"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                            <hr>
                                            <p class="card-text">
                                                {{ $user->description ? $user->description : 'No Description' }}
                                            </p>
                                            <a href="/viewprofile/{{ $user->id }}" class="card-link">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>

        {{-- ini uncomment kalo mau tidak mengisi space kosong taro di bawah card gedf-card px-3 py-3 --}}
        {{-- <div class="d-flex justify-content-between align-items-center"> --}}
        {{-- <div class="gedf-main mt-3">
            <div class="card gedf-card px-3 py-3">
                <div class="row">
                    <h4>Tambah Anggota Kelompok</h4>
                    <form action="/groupmember/search" method="get" class="d-flex" role="search">
                        @csrf
                        <input class="form-control" name="search" type="search"
                            placeholder="Cari User berdasarkan Name, Category, atau Email..."
                            value="{{ isset($search) ? $search : '' }}">
                        <button class="btn me-3 btn-outline-success" type="submit">Search</button>
                    </form>
                    <div class="mt-3">
                        <h4>Hasil Pencarian</h4>
                    </div>
                    @if ($alluser->isEmpty())
                        <p>No Result</p>
                    @else
                        @foreach ($alluser as $user)
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
        </div> --}}
    </div>

    <script>
        function confirmDelete(event, userId) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this member?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + userId).submit();
                }
            });
        }
    </script>
@endsection
