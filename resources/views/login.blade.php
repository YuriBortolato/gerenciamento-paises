<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Gerenciamento de Países</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-sm" style="width: 420px;">
        <div class="card-body p-4">
            <h1 class="h3 text-center mb-2">
                Gerenciamento de Países
            </h1>

            <p class="text-secondary text-center mb-4">
                Entre para acessar a área gerencial
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">
                        E-mail
                    </label>

                    <input
                        id="email"
                        class="form-control"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Senha
                    </label>

                    <input
                        id="password"
                        class="form-control"
                        type="password"
                        name="password"
                        required
                    >
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    Entrar
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>