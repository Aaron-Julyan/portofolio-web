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
    <title>Create New User</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Edit Profile</h1>
        <hr>
        <form method="post" action="/profile/{{ $datauser->id }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    id="group_name" placeholder="Masukkan nama kelompok" value="{{ old('name', $datauser->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if ($datauser->status == 'user')
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                        value="{{ old('email', $datauser->email) }}" readonly>
                    <div id="emailHelp" class="form-text" style="font-size:12px;">*Can't edit email when logged in with
                        email</div>
                @elseif($datauser->status == 'group')
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="group_email" placeholder="Masukkan email kelompok"
                            value="{{ old('email', $datauser->email) }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
            @endif
            <div class="my-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" placeholder="Insert Category"
                    value="{{ old('category', $datauser->category) }}">
                <div id="categoryHelp" class="form-text" style="font-size:12px;">*ex: Lab Game Dev, Jurusan
                    Informatika, Kelompok Penelitian X</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input class="form-control" id="description" name="description" rows="3"
                    placeholder="Insert Description" value="{{ old('description', $datauser->description) }}"></input>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                @if ($datauser->status == 'user')
                    <div id="" class="form-text mb-3" style="font-size:12px;">*Can't edit image when logged in
                        with email</div>
                    <img src="{{ $datauser->file }}" class="img-preview rounded-circle mb-3 d-block" width="100"
                        height="100">
                @else
                    <div class="img-container">
                        <img src="{{ asset('storage/' . $datauser->file) }}"
                            class="img-preview rounded-circle mb-3 d-block" width="100" height="100">
                    </div>
                    <input class="form-control" type="file" id="file" name="file" onchange="previewImage()"
                        @error('file') is-invalid @enderror>
                    <div id="imageHelp" class="form-text" style="font-size:12px;">*Picture with 1:1 ratio is recommended
                    </div>
                    @error('file')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                @endif
                <button class="w-100 btn btn-md btn-primary mt-3" type="submit">Edit Profile</button>
        </form>
    </div>

    <script>
        document.getElementById('add_member_btn').addEventListener('click', function() {
            document.getElementById('search_bar').style.display = 'block';
        });

        function previewImage() {
            const image = document.querySelector('#file');
            const imgContainer = document.querySelector('.img-container');
            let imgPreview = document.querySelector('.img-preview');

            if (!imgPreview) {
                // Create imgPreview if it doesn't exist
                imgPreview = document.createElement('img');
                imgPreview.classList.add('img-preview', 'rounded-circle', 'mb-3', 'd-block');
                imgPreview.width = 100;
                imgPreview.height = 100;
                imgContainer.appendChild(imgPreview);
            }

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
</body>

</html>
