@extends('components.main')

@section('container')
    <div class="container">
        <div class="row mt-5">
            <div class="">
                {{-- check user nya --}}
                <a href="javascript:void(0);" onclick="history.back();" class="btn btn-outline-dark" style="max-width: 150px;">
                    <i class="bi bi-arrow-left-square"></i>
                    Back
                </a>
                @if ($currentuser == $post->user_id)
                    <form action="/createpost/{{ $post->id }}" method="post" class="d-inline" id="deleteForm">
                        @method('delete')
                        @csrf
                        <button class="btn btn-outline-danger" style="max-width: 150px;" onclick="confirmDelete(event)"
                            title="Delete Post"><i class="bi bi-trash"></i>
                            Delete Post</button>
                    </form>
                    <a href="/createpost/{{ $post->id }}/edit" class="btn btn-outline-primary"
                        style="max-width: 120px;">
                        <i class="bi bi-pencil"></i>
                        Edit Post
                    </a>
                @endif
                @if ($postcontributor->isNotEmpty())

                    <button class="btn btn-outline-success viewContributorsBtn" data-post-id="{{ $post->id }}"
                        title="View Contributors" style="max-width: 200px;"><i class="bi bi-person-lines-fill"></i> Show
                        Contibutors</button>
                @endif
                <div class="mt-3">
                    <span class="badge text-bg-secondary ">{{ $post->department }}</span>
                    <span class="badge text-bg-secondary ">{{ $post->categories }}</span>
                    <span class="badge text-bg-secondary ">{{ $post->subcategories }}</span>
                </div>
                <div>
                    @if ($postkeyword->isNotEmpty())
                        @foreach ($postkeyword as $keyword)
                            <span class="badge text-bg-secondary">{{ $keyword->keyword }}</span>
                        @endforeach
                    @endif
                </div>
            </div>

            <article class="my-3 fs-5">
                {!! $post->description !!}
            </article>

            <div class="">
                @if ($albums->isNotEmpty())
                    <div class="row">
                        @foreach ($albums as $singleimage)
                            <div class="col-md-4 mb-4">
                                <div class="image-container">
                                    <img src="{{ asset('storage/album-images/' . $singleimage->file) }}" class="img-fluid">
                                </div>
                            </div>

                            {{-- Cek apakah sudah 3 foto --}}
                            @if ($loop->iteration % 3 == 0)
                    </div>
                    <div class="row">
                @endif
                @endforeach
            </div>
            @endif

            @foreach ($postfile as $files)
                @if ($files->filetype == 'Link')
                    <div class="row mb-3">
                        <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                        <a href="{{ $files->file }}" class="btn btn-outline-secondary" title="{{ $files->file }}"><i
                                class="bi bi-link-45deg"></i>Link:
                            {{ $files->file }}</a>
                    </div>
                    <hr>
                @elseif ($files->filetype == 'Image')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <img src="{{ asset('storage/public-images/' . $files->file) }}" class="img-fluid">
                    </div>
                    <hr>
                    {{-- punya album --}}
                    {{-- @elseif ($files->filetype == 'Album')
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <img src="{{ asset('storage/album-images/' . $files->file) }}" class="img-fluid">
                            </div>
                        </div> --}}
                    {{-- @elseif($files->filetype == 'Album')
                        <div id="carouselExampleIndicators" class="carousel slide mb-3" data-ride="carousel"
                            style="max-width: 600px; max-height: 800px; margin: auto">
                            <ol class="carousel-indicators">
                                @foreach ($postfile[$post->id] as $index => $files)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($postfile[$post->id] as $index => $files)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        @if ($files->file)
                                            <img class="d-block w-100"
                                                src="{{ asset('storage/album-images/' . $files->file) }}"
                                                alt="Slide {{ $index + 1 }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div> --}}
                @elseif($files->filetype == 'Video')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <video controls>
                            <source src="{{ asset('storage/public-videos/' . $files->file) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <hr>
                @elseif($files->filetype == 'Audio')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <audio controls>
                            <source src="{{ asset('storage/public-audios/' . $files->file) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <hr>
                @elseif($files->filetype == 'Object')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <model-viewer alt="3d" src="{{ asset('storage/public-objects/' . $files->file) }}"
                            style="width: 100vw; height: 33vw; border: 1px solid #ccc; margin: auto; background-color: #f0f0f0;" ar
                            shadow-intensity="2" camera-controls auto-rotate touch-action="pan-y"></model-viewer>
                    </div>
                    {{-- style="width: 60vw; height: 33.75vw; border: 1px solid #ccc; margin: auto;" --}}
                @elseif($files->filetype == 'Document')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <iframe src="{{ asset('storage/public-documents/' . $files->file) }}" width="800"
                            height="800"></iframe>
                    </div>
                    <hr>
                @endif
            @endforeach
        </div>
        <hr>

        {{-- user profile information --}}
        <div class="justify-content-between align-items-center">
            <!-- Foto circle -->
            <div class="d-flex align-items-center" onclick="location.href='/viewprofile/{{ $post->user->id }}';" style="cursor: pointer;">
                @if ($post->user->status == 'user')
                    <img class="rounded-circle" width="100" height="100" src="{{ $post->user->file }}" alt="">
                @elseif ($post->user->status == 'group')
                    <img class="rounded-circle" width="100" height="100"
                        src="{{ asset('storage/' . $post->user->file) }}" alt="">
            @endif
                <!-- Nama user dan jurusan -->
                <div class="me-3">
                    <div class="h5 m-0">{{ $post->user->name }}</div>
                    <div class="h7 text-muted">
                        {{ $post->user->category ? $post->user->category : 'No Category' }}</div>
                    <p class="card-text">
                        {{ $post->user->description ? $post->user->description : 'No Description' }}</p>
                    <div>
                        <a href="#" type="button" class="btn btn-outline-secondary">
                            <i class="bi bi-envelope-at"></i>
                            {{ $post->user->email }}
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            {{-- comments --}}
            <div class="h5">Comments</div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row">
                <div class="col-auto">
                    @unless (auth()->check())
                        <img class="rounded-circle img-fluid" width="60" height="60"
                            src="{{ asset('storage/icon_profile.png') }}" alt="">
                    @else
                        @if (auth()->user()->status == 'user')
                            <img class="rounded-circle img-fluid" width="60" height="60"
                                src="{{ auth()->user()->file }}" alt="">
                        @elseif (auth()->user()->status == 'group')
                            <img class="rounded-circle img-fluid" width="60" height="60"
                                src="{{ asset('storage/' . auth()->user()->file) }}" alt="">
                        @endif
                    @endunless
                </div>
                <div class="col">
                    <form method="post" action="/createcomment" enctype="form-data">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="row mt-2 d-flex align-items-center justify-content-between">
                            @unless (auth()->check())
                                <div class="col-3">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Nama" required
                                        value="{{ old('name') }}">
                                </div>
                            @endunless
                            <div class="col">
                                <input type="text" name="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Tambahkan komentar..." required value="{{ old('description') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-success">Submit</button>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="col my-3 yellow-bg">
                <div class="row">
                    @foreach ($postcomment as $comment)
                        <div class="col-auto">
                            @if ($comment->user_id)
                                @if ($comment->user->status == 'user')
                                    <img class="rounded-circle img-fluid" width="60" height="60"
                                        src="{{ $comment->user->file }}" alt="">
                                @elseif ($comment->user->status == 'group')
                                    <img class="rounded-circle img-fluid" width="60" height="60"
                                        src="{{ asset('storage/' . $comment->user->file) }}" alt="">
                                @endif
                            @else
                                <img class="rounded-circle img-fluid" width="60" height="60"
                                    src="{{ asset('storage/icon_profile.png') }}" alt="">
                            @endif
                        </div>
                        <div class="col">
                            <div class="row d-flex">
                                <div class="col">
                                    <h5>{{ $comment->name }}</h5>
                                </div>
                                <div class="col">
                                    <h6 class="text-muted">
                                        <i class="fa fa-clock-o ms-1"></i>Commented
                                        {{ $comment->created_at->diffForHumans() }}
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <p>{{ $comment->description }}</p>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal fade" id="contributorsModal" tabindex="-1" role="dialog"
            aria-labelledby="contributorsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contributorsModalLabel">Contributors List</h5>
                        {{-- ga usah close icon disini --}}
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            @foreach ($postcontributor as $contributor)
                                <div class="row mb-3">
                                    <div class="col-auto">
                                        @if ($contributor->status == 'user')
                                            <td> <img class="rounded-circle" width="60" height="60"
                                                    src="{{ $contributor->user->file }}" alt=""> </td>
                                        @elseif ($contributor->status == 'group')
                                            <td> <img class="rounded-circle" width="60" height="60"
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .image-container {
            border: 1px solid black;
            /* Tambahkan border hitam */
            overflow: hidden;
            /* Agar gambar yang besar tetap di dalam kotak */
            padding-top: 56.25%;
            /* Rasio 16:9 (9 / 16 * 100%) */
            position: relative;
            /* Untuk mengatur posisi overlay */
        }

        .image-container img {
            position: absolute;
            /* Agar gambar mengambil posisi absolut */
            top: 0;
            left: 0;
            width: 100%;
            /* Agar gambar mengisi lebar kotak */
            height: 100%;
            /* Agar gambar mengisi tinggi kotak */
            object-fit: cover;
            /* Agar gambar terlihat sepenuhnya tanpa memengaruhi rasio */
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
                $('#contributorsModal').modal('show');
            });

            $('.modal-footer button[data-dismiss="modal"]').click(function() {
                $(this).closest('.modal').modal('hide');
            });
        });
    </script>
@endsection
