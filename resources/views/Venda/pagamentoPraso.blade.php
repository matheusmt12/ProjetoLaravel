<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="number"],
        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #parcelasTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        #parcelasTable th,
        #parcelasTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #parcelasTable th {
            background-color: #4caf50;
            color: white;
        }

        #parcelasTable input {
            width: auto;
            margin: 0;
            padding: 5px;
        }
    </style>
</head>
<body>
        @if (isset($erro))
            <script>
                alert("{{ $erro }}");
            </script>
        @endif

    <form action="/pagamento" method="POST" id="formPagamento">
        @csrf
        <h2>Formulário de Pagamento</h2>

        <label for="valorCompra">Valor da Compra:</label>
        <input type="number" id="valorCompra" name="valorCompra" step="0.01" value="{{ old('valor)' , $valor) }}" readonly>
        <input type="hidden" name="name" value="{{old('name' , $name)}}">
        @if (!empty($idVenda))
            <input type="hidden" value="{{$idVenda}}" name="idVenda">
        @endif


        <label for="parcelas">Número de Parcelas:</label>
        <input type="text" id="parcelas" name="parcelas" placeholder="Informe o número de parcelas" required>

        <button type="button" onclick="gerarParcelas()">Gerar Parcelas</button>

        <table id="parcelasTable"></table>

        <input type="submit" value="Processar Pagamento">
        <button type="button" onclick="window.location.href='/'" style="background-color: #aaa; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Voltar</button>

    </form>

    <script>
        function gerarParcelas() {
            var valorCompra = parseFloat(document.getElementById('valorCompra').value);
            var numParcelasInput = document.getElementById('parcelas');
            var numParcelas = parseInt(numParcelasInput.value);


            if (isNaN(valorCompra) || isNaN(numParcelas) || numParcelas <= 0) {
                alert('Por favor, insira um valor válido e um número de parcelas maior que zero.');
                return;
            }

            var valorParcela = valorCompra / numParcelas;
            var table = document.getElementById('parcelasTable');
            table.innerHTML = '';  

            var currentDate = new Date(); 


            if (table.getElementsByTagName('thead').length === 0) {
                var headerRow = table.createTHead().insertRow(0);
                headerRow.style.backgroundColor = '#4caf50';
                headerRow.style.color = 'white';
                var headerCell1 = headerRow.insertCell(0);
                headerCell1.innerHTML = 'Parcela';
                var headerCell2 = headerRow.insertCell(1);
                headerCell2.innerHTML = 'Valor';
                var headerCell3 = headerRow.insertCell(2);
                headerCell3.innerHTML = 'Data Vencimento';
            }

            for (var i = 1; i <= numParcelas; i++) {

                currentDate.setMonth(currentDate.getMonth() + 1);

                var row = table.insertRow(i);
                var cell1 = row.insertCell(0);
                cell1.innerHTML = i;
                var cell2 = row.insertCell(1);
                cell2.innerHTML = 'R$ <input type="number" step="0.01" value="' + valorParcela.toFixed(2) + '" name="parcela_valor[]">';
                var cell3 = row.insertCell(2);
                cell3.innerHTML = '<input type="date" value="' + formatDate(currentDate) + '" name="parcela_data[]">';
            }
        }

        function formatDate(date) {
            var dd = date.getDate();
            var mm = date.getMonth() + 1;
            var yyyy = date.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            return yyyy + '-' + mm + '-' + dd;
        }
    </script>

</body>
</html>
