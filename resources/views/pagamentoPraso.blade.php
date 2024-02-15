<!-- resources/views/pagamento.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Pagamento</title>
</head>
<body>

    <h2>Formulário de Pagamento</h2>

    <form action="/pagamento" method="post" id="formPagamento">
        @csrf

        <label for="valorCompra">Valor da Compra:</label>
        <input type="number" id="valorCompra" name="valorCompra" step="0.01" value="{{ $valor }}" readonly>
        <input type="hidden" value={{$idVenda}} name="idVenda"  >
        <br>

        <label for="parcelas">Número de Parcelas:</label>
        <input type="text" id="parcelas" name="parcelas" placeholder="Informe o número de parcelas" required>

        <button type="button" onclick="gerarParcelas()">Gerar Parcelas</button>

        <br>

        <div id="listaParcelas"></div>

        <br>

        <input type="submit" value="Processar Pagamento">
    </form>

    <script>
    function gerarParcelas() {
        var valorCompra = parseFloat(document.getElementById('valorCompra').value);
        var numParcelasInput = document.getElementById('parcelas');
        var numParcelas = parseInt(numParcelasInput.value);

        // Adicione a validação diretamente no HTML
        if (isNaN(valorCompra) || isNaN(numParcelas) || numParcelas <= 0) {
            alert('Por favor, insira um valor válido e um número de parcelas maior que zero.');
            return;
        }

        var valorParcela = valorCompra / numParcelas;
        var listaParcelas = document.getElementById('listaParcelas');
        listaParcelas.innerHTML = '';

        var currentDate = new Date(); // Data atual

        for (var i = 1; i <= numParcelas; i++) {
            // Adiciona um mês a cada parcela
            currentDate.setMonth(currentDate.getMonth() + 1);

            var parcela = document.createElement('div');
            parcela.innerHTML = 'Parcela ' + i + ': R$ <input type="number" step="0.01" value="' + valorParcela.toFixed(2) + '" name="parcela_valor[]">' +
                                ' Data Vencimento: <input type="date" value="' + formatDate(currentDate) + '" name="parcela_data[]">';
            listaParcelas.appendChild(parcela);
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
