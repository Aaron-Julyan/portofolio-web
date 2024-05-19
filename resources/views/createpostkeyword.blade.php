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
        <h1 class="mt-5 mb-4">Add Post Keyword</h1>
        <hr>
        <form method="post" action="/createpostkeyword" enctype="form-data">
            @csrf
            <div class="mb-3">
                <small class="text-danger">*required field</small>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <input type="hidden" name="postid" value="{{ $postid }}">
            <p>{{ $postid }} (Nanti hapus)</p>

            <div class="mb-3">
                <div class="row mb-3">
                    <div class="col">
                        @if ($postkeyword->count() == 5)
                            <div class="text-danger h7">Max Keyword Per Post: 5 Keywords</div>
                        @else
                            <label for="keyword" class="form-label">Keyword*</label>
                            <input type="text" name="keyword"
                                class="form-control @error('keyword') is-invalid @enderror" id="keyword"
                                placeholder="Masukkan keyword" required value="{{ old('keyword') }}">
                            <small class="form-text text-muted">Input one keyword at a time</small>
                        @endif
                    </div>
                </div>
                @error('keyword')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if ($postkeyword->count() != 5)
                <div class="mb-3 d-grid">
                    <button type="submit" class="btn btn-primary">Add Keyword</button>
                </div>
            @endif
        </form>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 80%;">Keyword</th>
                        <th scope="col">Delete Keyword</th>
                    </tr>
                </thead>
                @if ($postkeyword->isEmpty())
                    <tbody class="table-group-divider">
                        <tr>
                            <td class="table-danger" colspan="3">No Keyword Added</td>
                        </tr>
                    </tbody>
                @else
                    @foreach ($postkeyword as $keyword)
                        <tbody class="table-group-divider">
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $keyword->keyword }}</td>
                                <td>
                                    <form action="/createpostkeyword/{{ $keyword->id }}" method="post"
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
            <a href="/finishpost" class="btn btn-primary">Finish Post</a>
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
