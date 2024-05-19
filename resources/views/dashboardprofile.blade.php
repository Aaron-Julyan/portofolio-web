@extends('components.main')

@section('container')
    <div class="container-fluid gedf-wrapper">
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
            <div class="col mt-3">
                <a href="/dashboard" type="button" class="btn btn-outline-primary" style="max-width: 200px;">Post</a>
                <a href="/dashboardprofile" type="button" class="btn btn-primary" style="max-width: 200px;">Profile</a>
                <button id="showFilterButton" type="button" class="btn btn-outline-success" style="max-width: 200px;"><i
                        class="bi bi-eye-fill"></i> Show
                    Filter</button>
                <button id="hideFilterButton" type="button" class="btn btn-success"
                    style="max-width: 200px; display: none;"><i class="bi bi-eye-slash"></i> Hide Filter</button>
            </div>

            <div class="tagfilter" style="display: none;">
                @if ($tagcategories->isNotEmpty())
                    <div class="mt-3">
                        <h5>View Profile by Categories</h5>
                        @foreach ($tagcategories as $categories)
                            @if ($sendvalue != 'No Value' && $categories == $sendvalue)
                                <a href="/dashboardprofile/{{ $categories }}" type="button"
                                    class="btn btn-primary">{{ $categories }}</a>
                            @else
                                <a href="/dashboardprofile/{{ $categories }}" type="button"
                                    class="btn btn-outline-primary">{{ $categories }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($sendvalue != 'No Value')
                <h5 class="mt-3">Post Showed by: {{ $sendvalue }}</h5>
            @endif

            {{-- code kunjungi profil --}}
            <div class="gedf-main mt-3">
                {{-- ga mungkin empty sih --}}
                @if ($datauser->isEmpty())
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mt-3">
                            <i class="bi bi-person-x" style="font-size: 3rem;"></i>
                            <h5>No User Shown
                            </h5>
                        </div>
                    </div>
                @else
                    <div class="row row-cols-sm-1 row-cols-md-3">
                        @foreach ($datauser as $user)
                            <div class="col">
                                <div class="card gedf-card mt-3" onclick="location.href='/viewprofile/{{ $user->id }}';" style="cursor: pointer;" title="Click to View Profile {{ $user->name }}">
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
@endsection
