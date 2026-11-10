<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Detalhes do País</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">
            Gerenciamento de Países
        </span>

        <a
            href="{{ route('countries.index') }}"
            class="btn btn-outline-light btn-sm"
        >
            Voltar
        </a>
    </div>
</nav>

<main class="container py-5">

    <div class="card shadow-sm mx-auto" style="max-width: 800px;">

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-4 text-center">

                    @if($country->flag_url)
                        <img
                            src="{{ $country->flag_url }}"
                            alt="{{ $country->name }}"
                            class="img-fluid border rounded shadow-sm"
                        >
                    @endif

                </div>

                <div class="col-md-8">

                    <h1 class="mb-4">
                        {{ $country->name }}
                    </h1>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Código ISO</strong>
                            <p class="mb-0">
                                {{ strtoupper($country->cca2) }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Capital</strong>
                            <p class="mb-0">
                                {{ $country->capital ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Região</strong>
                            <p class="mb-0">
                                {{ $country->region }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>População</strong>
                            <p class="mb-0">
                                {{ number_format(
                                    $country->population,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </p>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('countries.edit', $country->id) }}"
                            class="btn btn-warning"
                        >
                            Editar
                        </a>

                        <a
                            href="{{ route('countries.index') }}"
                            class="btn btn-secondary"
                        >
                            Voltar
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

</body>
</html>