<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem</title>
    <link rel="stylesheet" href="https://jsdelivr.net">
    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <div class="card login-card shadow">
        <div class="card-header bg-primary text-white text-center py-4">
            <h4 class="mb-0 font-weight-bold">MASUK</h4>
            <small class="text-white-50"> login sebagai Superadmin atau Kasir</small>
        </div>
        <div class="card-body p-4">

            @if($errors->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('loginError') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="font-weight-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm">Masuk Sekarang</button>
            </form>

        </div>

    </div>

    <script src="https://jsdelivr.net"></script>
    <script src="https://jsdelivr.net"></script>
</body>
</html>
