<!doctype html>
<html lang="ar" dir="ltr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <title>User Create</title>
    {{-- nanti pindahin css nya --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            background-color: white;
            margin-top: 1em;
            width:350px;
            height:350px; 
        }

        .bold-text {
            font-size: 16px;
            font-weight: bold;
        }

        .regular-text {
            font-size: 12px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .password-input {
            position: relative;
        }

        .show-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .submit-button {
            background-color: #31bafd;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 12px;
        }

        .google-login {
            margin-top: 12px;
        }

        .google-button {
            background-color: white;
            border: 1px solid black;
            color: black;
            padding: 12px;
            margin-top: 8px;
            border-radius: 4px;
            cursor: pointer;
        }

        .container {
            margin-top: 5em;
            width: 100%;
        }

        .divider {
            height: 2px;
            background-color: #000; /* Warna garis divider */
            margin: 10px 0; /* Atur margin sesuai kebutuhan */
        }
    </style>
</head>

<body>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($data as $key => $val)
                    <tr>
                        <th scope="row">{{ ++$key }}</th>
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->email }}</td>
                        <td>
                            <a href="{{ route('user.edit', $val->id) }}" class="btn btn-secondary">Edit</a>
                            <a href="{{ route('user.show', $val->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <div class="login-container">
        <div class="bold-text">Portofolio Website</div>
        <div class="regular-text">Log In</div>
        <input type="text" placeholder="Username">
        <div class="password-input">
            <input type="password" placeholder="Password">
            <span class="show-password">&#x1F441;</span>
        </div>
        <button class="submit-button">Log in</button>
        <hr class="divider">
        <div class="regular-text google-login">Log in menggunakan google petra</div>
        <a href="{{ route('google.login') }}" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2">Log in with google Petra</i>
        </a>
    </div>
    
    
</body>

</html>
