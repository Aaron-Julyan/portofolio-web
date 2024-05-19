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
        <h1 class="mt-5 mb-4">Buat User Baru</h1>
        <hr>
        <form action="/register" method="POST">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" placeholder="Masukkan password">
            </div>
            <div class="mb-3">
                <label for="group_name" class="form-label">Nama Kelompok</label>
                <input type="text" class="form-control" id="group_name" placeholder="Masukkan nama kelompok">
            </div>
            <div class="mb-3">
                <label for="group_email" class="form-label">Email</label>
                <input type="text" class="form-control" id="group_email" placeholder="Masukkan email kelompok">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="category" placeholder="Masukkan kategori">
                <div id="categoryHelp" class="form-text" style="font-size:12px;">*contoh: Lab Game Dev, Jurusan
                    Informatika, Kelompok Penelitian Technopreneurship</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Masukkan deskripsi"></textarea>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Foto Profil</label>
                <input class="form-control" type="file" id="profile_picture">
            </div>
            <div class="mb-3">
                <label for="add_member_btn" class="form-label">Anggota</label>
                <div id="categoryHelp" class="form-text" style="font-size:12px;">*anda akan dijadikan sebagai superadmin
                </div>
            </div>
            <div class="user-box d-inline-flex align-items-center border p-2 rounded-3 mb-3">
                <img src="https://picsum.photos/500/500" alt="Profile Picture" class="rounded-circle" width="40" height="40">
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
            </div>
            <div class="mb-3 d-grid">
                <button type="button" class="btn btn-primary" type="button" id="submit_new_user">Submit</button>
            </div>
        </form>

    </div>

    <script>
        document.getElementById('add_member_btn').addEventListener('click', function() {
            document.getElementById('search_bar').style.display = 'block';
        });
    </script>
</body>

</html>
