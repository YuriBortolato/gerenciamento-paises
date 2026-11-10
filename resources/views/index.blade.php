<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Países</title>

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

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                class="btn btn-outline-light btn-sm"
                type="submit"
            >
                Sair
            </button>
        </form>
    </div>
</nav>

<main class="container py-4">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div
        class="d-flex justify-content-between
               align-items-center flex-wrap gap-3 mb-4"
    >
        <div>
            <h1 class="h2 mb-1">Países</h1>

            <p class="text-secondary mb-0">
                {{ $countries->count() }} registros cadastrados
            </p>
        </div>

        <div class="d-flex gap-2">
            <form
                action="{{ route('countries.import') }}"
                method="POST"
            >
                @csrf

                <button
                    class="btn btn-success"
                    type="submit"
                >
                    Importar países
                </button>
            </form>

            <a
                href="{{ route('countries.create') }}"
                class="btn btn-primary"
            >
                Novo país
            </a>
        </div>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-dark">
                <tr>
                    <th>Bandeira</th>
                    <th>Nome</th>
                    <th>ISO</th>
                    <th>Capital</th>
                    <th>Região</th>
                    <th>População</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($countries as $country)
                    <tr>
                        <td>
                            @if ($country->flag_url)
                                <img
                                    src="{{ $country->flag_url }}"
                                    alt="Bandeira de {{ $country->name }}"
                                    width="48"
                                    class="border"
                                >
                            @else
                                <span class="text-secondary">
                                    Sem bandeira
                                </span>
                            @endif
                        </td>

                        <td>{{ $country->name }}</td>

                        <td>
                            {{ strtoupper($country->cca2) }}
                        </td>

                        <td>
                            {{ $country->capital ?? '-' }}
                        </td>

                        <td>{{ $country->region }}</td>

                        <td>
                            {{ number_format(
                                $country->population,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="text-end text-nowrap">

                            <a
                                href="{{ route('countries.show', $country->id) }}"
                                class="btn btn-info btn-sm"
                            >
                                Detalhes
                            </a>

                            <a
                                href="{{ route(
                                    'countries.edit',
                                    $country->id
                                ) }}"
                                class="btn btn-warning btn-sm"
                            >
                                Editar
                            </a>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteCountryModal"
                                data-country-name="{{ $country->name }}"
                                data-delete-url="{{ route(
                                    'countries.destroy',
                                    $country->id
                                ) }}"
                            >
                                Excluir
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="text-center py-4"
                        >
                            Nenhum país cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</main>

<div
    class="modal fade"
    id="deleteCountryModal"
    tabindex="-1"
    aria-labelledby="deleteCountryModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h2
                    class="modal-title fs-5"
                    id="deleteCountryModalLabel"
                >
                    Confirmar exclusão
                </h2>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Fechar"
                ></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">
                    Deseja realmente excluir
                    <strong id="deleteCountryName"></strong>?
                </p>

                <p class="text-danger mb-0">
                    Essa operação não poderá ser desfeita.
                </p>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancelar
                </button>

                <form
                    id="deleteCountryForm"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Excluir país
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

<script>
    const deleteModal = document.getElementById(
        'deleteCountryModal'
    );

    deleteModal.addEventListener(
        'show.bs.modal',
        function (event) {
            const button = event.relatedTarget;

            const countryName = button.getAttribute(
                'data-country-name'
            );

            const deleteUrl = button.getAttribute(
                'data-delete-url'
            );

            document.getElementById(
                'deleteCountryName'
            ).textContent = countryName;

            document.getElementById(
                'deleteCountryForm'
            ).action = deleteUrl;
        }
    );
</script>

</body>
</html>