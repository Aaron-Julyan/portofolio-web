@extends('components.main')

@section('container')
    <div class="container-fluid gedf-wrapper">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-center">
                <button type="button" id="btnViewPost" class="btn btn-secondary btn-lg btn-block mb-3">View Post</button>
                <button type="button" id="btnVisitProfile" class="btn btn-secondary btn-lg btn-block mb-3">Visit
                    Profile</button>
            </div>
        </div> --}}
        <div class="row">
            {{-- code view post --}}
            {{-- <div class="col-md-8 gedf-main mt-3"> --}}

            {{-- <div class="row justify-content-center mt-3">
                <p>Show Option</p>
                <div class="col-lg-12 col-md-6 text-center">
                    <select class="form-select" id="selectOption">
                        <option value="post">Post</option>
                        <option value="profile">Profile</option>
                    </select>
                </div>
            </div> --}}
            <div class="mt-3">
                <a href="/dashboard" type="button" class="btn btn-primary" style="max-width: 200px;">Post</a>
                <a href="/dashboardprofile" type="button" class="btn btn-outline-primary"
                    style="max-width: 200px;">Profile</a>
                <button id="showFilterButton" type="button" class="btn btn-outline-success" style="max-width: 200px;"><i
                        class="bi bi-eye-fill"></i> Show
                    Filter</button>
                <button id="hideFilterButton" type="button" class="btn btn-success"
                    style="max-width: 200px; display: none;"><i class="bi bi-eye-slash"></i> Hide Filter</button>
            </div>

            <div class="tagfilter" style="display: none;">
                @if ($tagdepartment->isNotEmpty())
                    <div class="mt-3">
                        <h5>View Post by Department</h5>
                        @foreach ($tagdepartment as $department)
                            @if ($sendvalue != 'No Value' && $department == $sendvalue)
                                <a href="/dashboard/{{ $department }}" type="button"
                                    class="btn btn-primary">{{ $department }}</a>
                            @else
                                <a href="/dashboard/{{ $department }}" type="button"
                                    class="btn btn-outline-primary">{{ $department }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($tagcategories->isNotEmpty())
                    <div class="mt-3">
                        <h5>View Post by Categories</h5>
                        @foreach ($tagcategories as $categories)
                            @if ($sendvalue != 'No Value' && $categories == $sendvalue)
                                <a href="/dashboard/{{ $categories }}" type="button"
                                    class="btn btn-primary">{{ $categories }}</a>
                            @else
                                <a href="/dashboard/{{ $categories }}" type="button"
                                    class="btn btn-outline-primary">{{ $categories }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($tagcategories->isNotEmpty())
                    <div class="mt-3">
                        <h5>View Post by Subcategories</h5>
                        @foreach ($tagsubcategories as $subcategories)
                            @if ($sendvalue != 'No Value' && $subcategories == $sendvalue)
                                <a href="/dashboard/{{ $subcategories }}" type="button"
                                    class="btn btn-primary">{{ $subcategories }}</a>
                            @else
                                <a href="/dashboard/{{ $subcategories }}" type="button"
                                    class="btn btn-outline-primary">{{ $subcategories }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if ($tagkeywords->isNotEmpty())
                    <div class="mt-3">
                        <h5>View Post by Keywords</h5>
                        @foreach ($tagkeywords as $keywords)
                            @if ($sendvalue != 'No Value' && $keywords == $sendvalue)
                                <a href="/dashboard/keyword/{{ $keywords }}" type="button"
                                    class="btn btn-primary">{{ $keywords }}</a>
                            @else
                                <a href="/dashboard/keyword/{{ $keywords }}" type="button"
                                    class="btn btn-outline-primary">{{ $keywords }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($sendvalue != 'No Value')
                <h5 class="mt-3">Post Showed by: {{ $sendvalue }}</h5>
            @endif

            <div class="gedf-main" id="viewPostContent">
                <!--- Image Post-->
                @if ($datapost->isEmpty())
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mt-3">
                            <i class="bi bi-emoji-frown" style="font-size: 3rem;"></i>
                            <h5>No Post Shown</h5>
                        </div>
                    </div>
                @else
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
                                                        <div class="p text-muted "> <i
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
                                            </div>
                                        </div>
                                    </div>
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

            @auth
                <div class="d-flex justify-content-end position-fixed bottom-0 start-0 m-3">
                    <a class="btn btn-primary" href="/createpost">
                        <i class="bi bi-plus-circle-fill"></i>
                        Create Post
                    </a>
                </div>
            @endauth
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Mengatur visibilitas berdasarkan pilihan dari select option
        // $("#selectOption").change(function() {
        //     var selectedOption = $(this).val();
        //     if (selectedOption === 'post') {
        //         $("#viewPostContent").show();
        //         $("#visitProfileContent").hide();
        //         localStorage.setItem('contentToShow', 'viewPostContent');
        //     } else if (selectedOption === 'profile') {
        //         $("#viewPostContent").hide();
        //         $("#visitProfileContent").show();
        //         localStorage.setItem('contentToShow', 'visitProfileContent');
        //     }
        // });

        // // Mengambil status visibilitas dari local storage saat halaman dimuat
        // $(document).ready(function() {
        //     var contentToShow = localStorage.getItem('contentToShow');
        //     if (contentToShow === 'viewPostContent') {
        //         $("#viewPostContent").show();
        //         $("#visitProfileContent").hide();
        //     } else if (contentToShow === 'visitProfileContent') {
        //         $("#viewPostContent").hide();
        //         $("#visitProfileContent").show();
        //     } else {
        //         // Jika tidak ada status visibilitas yang tersimpan, lakukan sesuai kebutuhan aplikasi
        //     }
        // });

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
    </script>
@endsection
