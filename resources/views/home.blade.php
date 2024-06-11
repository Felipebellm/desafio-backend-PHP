<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Moedas ISO 4217</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Pesquisa de Moedas ISO 4217</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/fetch-currency" class="mt-3">
            @csrf
            <div class="form-group">
                <label for="code">Código ISO (Ex: GBP):</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code') }}">
            </div>
            <div class="form-group">
                <label for="number">Número ISO (Ex: 826):</label>
                <input type="number" id="number" name="number" class="form-control" value="{{ old('number') }}">
            </div>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

        @if (isset($results))
            <div id="results" class="mt-5">
                <h3>Resultados da Pesquisa:</h3>
                @foreach ($results as $currency)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $currency['currency'] }} ({{ $currency['code'] }})</h5>
                            <p class="card-text">Número ISO: {{ $currency['number'] }}</p>
                            <p class="card-text">Casas decimais: {{ $currency['decimal'] }}</p>
                            <h6>Locais:</h6>
                            <ul>
                                @foreach ($currency['currency_locations'] as $location)
                                    <li>{{ $location['location'] }} <img src="{{ $location['icon'] }}" alt="{{ $location['location'] }} flag" style="width: 22px; height: auto;"></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>