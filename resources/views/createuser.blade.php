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
        <h1 class="mt-5 mb-4">Create New User Group</h1>
        <hr>
        <form action="/createuser" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <small class="text-danger">*required field</small>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username*</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                    id="username" placeholder="Insert Username" required value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password*</label>
                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" placeholder="Insert Password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Group Name*</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    id="group_name" placeholder="Insert Group Name" required value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Group Email*</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    id="group_email" placeholder="Insert Group Email" required value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category*</label>
                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category"
                    name="category" placeholder="Insert Category" required value="{{ old('category') }}">
                <div id="categoryHelp" class="form-text" style="font-size:12px;">*ex: Lab Game Dev, Jurusan
                    Informatika, Kelompok Penelitian X</div>
                @error('category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="3" placeholder="Insert Description" required
                    value="{{ old('description') }}"></input>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Upload Profile Image*</label>
                <img class="img-preview img-fluid mb-3 col-sm-3">
                <input class="form-control" type="file" id="file" name="file" onchange="previewImage()"
                    @error('file') is-invalid @enderror>
                @error('file')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div class="mb-3">
                <label for="add_member_btn" class="form-label">Anggota</label>
                <div id="categoryHelp" class="form-text" style="font-size:12px;">*anda akan dijadikan sebagai superadmin
                </div>
            </div>
            <div class="user-box d-inline-flex align-items-center border p-2 rounded-3 mb-3">
                <img src="https://picsum.photos/500/500" alt="Profile Picture" class="rounded-circle" width="40"
                    height="40">
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold">John Doe</div>
                    <div class="text-muted">Admin</div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <input class="form-control" id="search_bar" type="search" placeholder="Cari Anggota..."
                        aria-label="search">
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div> --}}
            <button class="w-100 btn btn-md btn-primary mt-3" type="submit">Submit</button>
        </form>
    </div>

    <script>
        document.getElementById('add_member_btn').addEventListener('click', function() {
            document.getElementById('search_bar').style.display = 'block';
        });

        function previewImage() {
            const image = document.querySelector('#file');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }

            // Memeriksa rasio gambar sebelum diunggah
            fileInput.addEventListener('change', function() {
                const img = new Image();
                img.src = URL.createObjectURL(this.files[0]);
                img.onload = function() {
                    const width = img.naturalWidth;
                    const height = img.naturalHeight;
                    if (width !== height) {
                        alert('Please upload an image with a 1:1 aspect ratio.');
                        fileInput.value = ''; // Mengosongkan input file
                        imgPreview.src = ''; // Menghapus tampilan preview
                    }
                };
            });
        }
    </script>
</body>

</html>
