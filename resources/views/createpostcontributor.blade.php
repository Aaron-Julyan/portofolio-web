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

    <!-- link CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.min.css">

    <!-- link JavaScript SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.all.min.js"></script>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Add Post Contributor</h1>
        <hr>

        <form method="post" action="/createpostcontributor" enctype="form-data">
            @csrf

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <input type="hidden" name="postid" value="{{ $postid }}">
            {{-- <p>{{ $postid }} (Nanti hapus)</p> --}}

            <div class="mb-3">
                <label for="add_member_btn" class="form-label">Select Contributor</label>
                <div class="row mb-3">
                    <div class="col">
                        @if ($alluser->isEmpty())
                            <select class="form-select" name="selectedId" onchange="">
                                <option value="0">No User to Add</option>
                            </select>
                        @else
                            <select class="form-select" name="selectedId" onchange="">
                                @foreach ($alluser as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} |
                                        {{ $user->email }} | {{ $user->category }}
                                @endforeach
                            </select>
                        @endif
                    </div>
                    {{-- <div class="col-auto">
                        <button class="btn btn-outline-primary" type="submit">Add Contributor</button>
                    </div> --}}
                </div>
            </div>
            <div class="mb-3 d-grid">
                <button type="submit" class="btn btn-primary">Add Contributor</button>
            </div>
        </form>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 15%;">Contributor Image</th>
                        <th scope="col" style="width: 65%;">Contributor Name</th>
                        <th scope="col">Delete Contributor</th>
                    </tr>
                </thead>
                @if ($postcontributor->isEmpty())
                    <tbody class="table-group-divider">
                        <tr>
                            <td class="table-danger" colspan="5">No Contributor Added</td>
                        </tr>
                    </tbody>
                @else
                    @foreach ($postcontributor as $contributor)
                        <tbody class="table-group-divider">
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                @if ($contributor->user->status == 'user')
                                    <td> <img class="rounded-circle" width="60" height="60"
                                            src="{{ $contributor->user->file }}" alt=""> </td>
                                @elseif ($contributor->user->status == 'group')
                                    <td> <img class="rounded-circle" width="60" height="60"
                                            src="{{ asset('storage/' . $contributor->user->file) }}" alt="">
                                    </td>
                                @endif
                                <td>{{ $contributor->user->name }}</td>
                                <td>
                                    <form action="/createpostcontributor/{{ $contributor->id }}" method="post"
                                        id="deleteForm">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="confirmDelete(event)"
                                            title="">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                @endif
            </table>
        </div>

        <div class="mb-3 d-grid">
            <a href="/createpostkeyword" class="btn btn-primary">Next (Add Post Keyword)</a>
        </div>

    </div>

    <script>
        function confirmDelete(event) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        };
    </script>
</body>

</html>
