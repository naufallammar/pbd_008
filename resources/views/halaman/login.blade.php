<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dulu</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 1rem;
            overflow: hidden;
        }
        .input-group-text {
            background-color: #f8f9fc;
        }
        .form-control {
            background-color: #f8f9fc;
        }
        .form-control:focus {
            background-color: #ffffff;
            box-shadow: none;
            border-color: #4e73df;
        }
    </style>
</head>
<body>

    <div class="card login-card shadow-lg">
        <div class="card-header bg-white text-center py-4 border-0">
            <h3 class="mb-0 font-weight-bold text-primary">
                <i class="fas fa-store mr-2"></i>Login Dulu
            </h3>
            <p class="text-muted small mb-0 mt-2">Masuk pake Superadmin atau Kasir yaa</p>
        </div>

        <div class="card-body p-4 bg-white border-top">

            @if($errors->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first('loginError') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="font-weight-bold text-secondary small">KETIK USERNAME LU</label>
                    <div class="input-group shadow-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text border-right-0"><i class="fas fa-user text-primary"></i></span>
                        </div>
                        <input type="text" name="username" class="form-control border-left-0" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold text-secondary small">DISINI PASSWORDNYA</label>
                    <div class="input-group shadow-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text border-right-0"><i class="fas fa-lock text-primary"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control border-left-0" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow rounded-pill" style="border-radius: 50rem;">
                    Masuk Sekarang <i class="fas fa-sign-in-alt ml-1"></i>
                </button>
            </form>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
