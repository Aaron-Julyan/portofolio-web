<!doctype html>
<html lang="ar" dir="ltr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <title>User Edit</title>
</head>

<body>
    <section class="container mt-5">
        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}
        
        <div class="card">
            <div class="card-header">
                User Edit
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $data->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="mt-2">Name</label>
                        <input type="text" name="name" class="form-control mt-1" value="{{ $data->name }}">
                        @error('name')
                            <p class="text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="mt-2">Email Address</label>
                        <input type="email" name="email" class="form-control mt-1" value="{{ $data->email }}">
                        @error('email')
                            <p class="text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="mt-2">Password</label>
                        <input type="password" name="password" class="form-control mt-1" value="{{ $data->password }}">
                        @error('password')
                            <p class="text text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </section>
</body>

</html>
