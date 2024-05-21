@extends('components.main')

@section('container')
    <div class="container-fluid gedf-wrapper">
        <div class="row">
            <div class="gedf-main">
                {{-- new user created --}}
                @if (session('edited'))
                    <div class="alert alert-warning">{{ session('edited') }}</div>
                @elseif (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card gedf-card px-3 py-3 mt-3">
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
                                <div class="p text-muted">
                                    {{ $datauser->category ? $datauser->category : 'No Category' }}</div>
                                <p class="card-text">
                                    {{ $datauser->description ? $datauser->description : 'No Description' }}</p>
                                <a href="mailto:{{ $datauser->email }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-envelope"></i> {{ $datauser->email }}
                                    </a>
                            </div>
                        </div>
                        <div class="ms-4">
                            <a href="/profile/{{ $datauser->id }}/edit" class="btn btn-primary" title="Edit Profile"><i
                                    class="bi bi-pencil"></i> Edit Profile</a>
                        </div>
                    </div>
                </div>

                <!--- Post !--->
                @if ($datapost->isEmpty())
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mt-3">
                            <i class="bi bi-emoji-frown" style="font-size: 3rem;"></i>
                            <h3>No Post Shown</h3>
                            {{-- <div class="">
                                <a href="/createpost">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-plus-circle-fill"></i>
                                        Create New Post
                                    </button>
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="/groupmember">
                                    <button class="btn btn-primary">
                                        <i class="bi bi-people-fill"></i>
                                        Check Member List
                                    </button>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                @else
                    <div class="row row-cols-sm-1 row-cols-md-3">
                        @foreach ($datapost as $post)
                            <div class="col">
                                <div class="card gedf-card mt-3">
                                    {{-- <div class="card-header">
                                <div class="h-7 text-muted">Postingan berkolaborasi dengan
                                    <a href="/profile">Kolaborator</a>
                                </div>
                                </div> --}}
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if ($datauser->status == 'user')
                                                    <a href="/viewprofile/{{ $datauser->id }}"
                                                        style="text-decoration: none; color: inherit;"
                                                        title="Click to View Post {{ $datauser->name }}">
                                                        <img class="rounded-circle" width="60" height="60"
                                                            src="{{ $datauser->file }}" alt="">
                                                    </a>
                                                @elseif ($datauser->status == 'group')
                                                    <a href="/viewprofile/{{ $datauser->id }}"
                                                        style="text-decoration: none; color: inherit;"
                                                        title="Click to View Post {{ $datauser->name }}">
                                                        <img class="rounded-circle" width="60" height="60"
                                                            src="{{ asset('storage/' . $datauser->file) }}" alt="">
                                                    </a>
                                                @endif
                                                <a href="/viewprofile/{{ $datauser->id }}"
                                                    style="text-decoration: none; color: inherit;"
                                                    title="Click to View Post {{ $datauser->name }}">
                                                    <div class="me-3">
                                                        <div class="h5 m-0">{{ $datauser->name }}</div>
                                                        <div class="p text-muted">
                                                            {{ $datauser->category ? $datauser->category : 'No Category' }}
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
                                                        data-post-id="{{ $post->id }}" title="View Contributors"><i
                                                            class="bi bi-person-lines-fill"></i></button>
                                                @endif
                                                <a href="/createpost/{{ $post->id }}/edit"
                                                    class="btn btn-outline-primary" title="Edit Post"><i
                                                        class="bi bi-pencil"></i></a>
                                                <form action="/createpost/{{ $post->id }}" method="post"
                                                    class="d-inline" id="deleteForm">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-outline-danger" onclick="confirmDelete(event)"
                                                        title="Delete Post"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="card-body" onclick="location.href='/viewpost/{{ $post->slug }}';" style="cursor: pointer;"> --}}
                                    <a class="card-body" href="/viewpost/{{ $post->slug }}"
                                        style="text-decoration: none; color: inherit;"
                                        title="Click to View Post {{ $post->slug }}">
                                        <div>
                                            <span class="badge text-bg-secondary ">{{ $post->department }}</span>
                                            <span class="badge text-bg-secondary ">{{ $post->categories }}</span>
                                            <span class="badge text-bg-secondary ">{{ $post->subcategories }}</span>
                                        </div>
                                        <div>
                                            @if ($postkeyword[$post->id]->isNotEmpty())
                                                @foreach ($postkeyword[$post->id] as $keyword)
                                                    <span class="badge text-bg-secondary">{{ $keyword->keyword }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="card-text mt-3">
                                            {{ $post->excerpt }}
                                        </p>
                                        <div class="row">
                                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="img-fluid">
                                            {{-- uncomment class container ini kalo mau kotak nya sama semua --}}
                                            {{-- <div class="thumbnail-container">
                                            </div> --}}
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
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="contributorsModalLabel">Contributors List</h5>
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

            {{-- ga dipake soalnya udah ada di action button --}}
            {{-- <div class="row mt-3">
                @if ($datauser->status == 'group')
                    <h4>Member</h4>
                    @foreach ($members as $user)
                        <div class="card gedf-card mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-start align-items-right">
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
                                    </div>
                                </div>
                                <hr>
                                <p class="card-text">
                                    {{ $user->description ? $user->description : 'No Description' }}
                                </p>
                                <a href="/viewprofile/{{ $user->id }}" class="card-link">View Profile</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div> --}}

            <div>
                {{-- @if ($datapost->isEmpty())
                    @if ($datauser->status == 'group')
                        <div class="mt-3">
                            <a class="" href="/groupmember">
                                <button class="btn btn-primary">
                                    <i class="bi bi-people-fill"></i>
                                    Check Member List
                                </button>
                            </a>
                        </div>
                    @endif
                    @if ($datauser->status == 'user')
                        <div class="col-12 mt-3">
                            <a href="/createuser">
                                <button class="btn btn-block btn-primary">
                                    <i class="bi bi-person-fill"></i>
                                    Create User Group
                                </button>
                            </a>
                        </div>
                    @endif
                @else
                @endif --}}
                <div class="btn-group dropup d-flex justify-content-end position-fixed bottom-0 start-0 m-3">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Action Button
                    </button>
                    <ul class="dropdown-menu text-start">
                        <li><a class="dropdown-item" href="/createpost"> Create New Post <i
                                    class="bi bi-plus-circle-fill"></i></a></li>
                        {{-- hapus aja button nya kalo ga bisa dipake pythonnya --}}
                        {{-- <li><a class="dropdown-item" href="/testpython"> Python Test </a></li> --}}
                        @if ($datauser->status == 'user')
                            <li><a class="dropdown-item" href="/createuser"> Create User Group <i
                                        class="bi bi-person-fill"></i></a></li>
                        @endif
                        @if ($datauser->status == 'group')
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/groupmember/{{ $datauser->id }}"> Check Member List <i
                                        class="bi bi-people-fill"></i></a></li>
                        @endif
                    </ul>
                </div>
                {{-- <div class="row d-flex">
                                @if ($datauser->status == 'group')
                                    <a class="" href="/groupmember">
                                        <div class="d-flex justify-content-end position-fixed bottom-0 start-0 m-3">
                                            <button class="btn btn-primary">
                                                <i class="bi bi-person-fill"></i>
                                                Check Member List
                                            </button>
                                        </div>
                                    </a>
                                @endif
    
                                <div class="d-flex justify-content-end position-fixed bottom-0 start-0 m-3">
                                    <div>
                                        <a href="/createpost">
                                            <button class="btn btn-primary">
                                                <i class="bi bi-plus-circle-fill"></i>
                                                Create Post
                                            </button>
                                        </a>
                                    </div>
    
                                    <div class="ms-3">
                                        <a href="/createuser">
                                            <button class="btn btn-primary">
                                                <i class="bi bi-plus-circle-fill"></i>
                                                Create User Group
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
            </div>
        </div>
    </div>
    <style>
        /* uncomment class container gambar kalo mau kotak nya sama semua */
        .thumbnail-container {
            position: relative;
            width: 100%;
            /* Sesuaikan lebar container */
            padding-top: 56.25%;
            /* Rasio 16:9 (9 / 16 * 100) */
            overflow: hidden;
        }

        .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
            object-fit: cover;
            /* Memastikan gambar mengisi container */
        }
    </style>
    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Menghentikan pengiriman form secara langsung

            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this post?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit(); // Menyerahkan form jika pengguna mengonfirmasi
                }
            });
        }

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

        // "View Contributors" dengan fetch data (ga berfungsi)
        // document.getElementById("viewContributorsBtn").addEventListener("click", function(event) {
        //     event.preventDefault(); // Mencegah aksi default dari link

        //     // Mengirim permintaan AJAX untuk mengambil data kontributor dari controller
        //     fetch("/postcontributor")
        //         .then(response => response.json()) // Mengubah respons menjadi JSON
        //         .then(data => {
        //             // Membuat pesan teks modal SweetAlert berdasarkan data kontributor
        //             var message = "<ul>";
        //             data.forEach(contributor => {
        //                 message += "<strong>Name:</strong> " + contributor.user_id "<hr>";
        //                 // message += "<li><img src='" + contributor.image_url +
        //                 //     "' width='50' height='50' style='border-radius: 50%; margin-right: 10px;'>" +
        //                 //     "<strong>Name:</strong> " + contributor.name +
        //                 //     " | <strong>Role:</strong> " + contributor.role + "</li>" +
        //                 //     "<hr>"; // Menambahkan garis pembatas setelah setiap data
        //             });
        //             message += "</ul>";

        //             // Menampilkan modal SweetAlert dengan pesan teks yang berisi data kontributor
        //             Swal.fire({
        //                 title: "Contributors",
        //                 html: message, // Gunakan html untuk memasukkan pesan dalam bentuk HTML
        //                 icon: "info"
        //             });
        //         })
        //         .catch(error => {
        //             console.error("Error:", error);
        //             // Menampilkan pesan kesalahan jika terjadi kesalahan saat mengambil data
        //             alert("Failed to fetch contributors. Please try again.");
        //         });
        // });
    </script>
@endsection
