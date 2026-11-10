@php
    $editing = isset($country);
@endphp

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $editing ? 'Editar país' : 'Novo país' }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">
<main class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body p-4">
            <h1 class="h3 mb-4">
                {{ $editing ? 'Editar país' : 'Cadastrar país' }}
            </h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ $editing
                    ? route('countries.update', $country->id)
                    : route('countries.store') }}"
                method="POST"
            >
                @csrf

                @if ($editing)
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Nome</label>

                        <input
                            id="name"
                            class="form-control"
                            name="name"
                            value="{{ old('name', $country->name ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="cca2" class="form-label">Código ISO</label>

                        <input
                            id="cca2"
                            class="form-control text-uppercase"
                            name="cca2"
                            maxlength="2"
                            value="{{ old('cca2', $country->cca2 ?? '') }}"
                            required
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="capital" class="form-label">Capital</label>

                        <input
                            id="capital"
                            class="form-control"
                            name="capital"
                            value="{{ old('capital', $country->capital ?? '') }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="region" class="form-label">Região</label>

                        <input
                            id="region"
                            class="form-control"
                            name="region"
                            value="{{ old('region', $country->region ?? '') }}"
                            required
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="population" class="form-label">
                        População
                    </label>

                    <input
                        id="population"
                        class="form-control"
                        type="number"
                        name="population"
                        min="0"
                        value="{{ old(
                            'population',
                            $country->population ?? ''
                        ) }}"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="flag_url" class="form-label">
                        URL da bandeira
                    </label>

                    <input
                        id="flag_url"
                        class="form-control"
                        type="url"
                        name="flag_url"
                        value="{{ old(
                            'flag_url',
                            $country->flag_url ?? ''
                        ) }}"
                    >
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit">
                        Salvar
                    </button>

                    <a
                        href="{{ route('countries.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>