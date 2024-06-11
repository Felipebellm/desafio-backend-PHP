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

        <form id="currencyForm" action="/fetch-currency" method="POST">
            @csrf
            <div class="mb-3">
                <label for="code" class="form-label">Codes (comma separated)</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="e.g. GBP, USD, EUR">
            </div>
            <div class="mb-3">
                <label for="number_list" class="form-label">Numbers</label>
                <div id="numberContainer">
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" name="number_list[]" placeholder="Enter a number">
                        <button type="button" class="btn btn-outline-secondary" id="addNumber">Add Another Number</button>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
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
    <script>
        document.getElementById('addNumber').addEventListener('click', function() {
            let numberContainer = document.getElementById('numberContainer');
            let newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-2');
            newInputGroup.innerHTML = `
                <input type="number" class="form-control" name="number_list[]" placeholder="Enter a number">
                <button type="button" class="btn btn-outline-danger removeNumber">Remove</button>
            `;
            numberContainer.appendChild(newInputGroup);
        });
    
        document.getElementById('numberContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('removeNumber')) {
                e.target.parentElement.remove();
            }
        });
    </script>
</body>
</html>