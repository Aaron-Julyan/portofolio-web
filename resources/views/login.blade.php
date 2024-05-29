<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <!-- Icons import -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    
    <div class="login-container border p-4 bg-white rounded-3" style="width: 350px;">
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
        @endif

        @if(session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('loginError') }}
        </div>
        @endif


        <div class="text-center">
            <p class="fw-bold fs-3">Portofolio Website</p>
        </div>
        <hr class="divider my-3">

        <main class="form-login">
            <form action="/login" method="post">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" @error('username') is-invalid @enderror id="username" aria-describedby="usernameHelp" autofocus required value="{{ old('username') }}">
                    <div id="usernameHelp" class="form-text" style="font-size:12px;">*user must be registered by lecturer or student</div>
                    @error('username') 
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>
            </form>
        </main>

        <hr class="divider my-3">
        <div class="text-center">
            <p>or</p>
        </div>
    <a href="{{ route('google.login') }}" class="btn btn-danger btn-block w-100">
            <i class="fab fa-google-plus me-2"></i>Log In with Google Petra
        </a>
    </div>
</body>

</html>
