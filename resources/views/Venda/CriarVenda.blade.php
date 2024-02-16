<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Venda</title>
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
            max-width: 600px;
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

        select, input[type="number"], input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            display: inline-block;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>


    <form action="/criarVenda" method="post">
        @csrf
        <h2>Formulário de Venda</h2>

        <label for="NomeCliente">Nome do Cliente:</label>
        <select id="NomeCliente" name="name" >
            <option value="">Sem Nome</option>
            @foreach($pessoas as $pessoa)
                <option value="{{ $pessoa->name }}">{{ $pessoa->name }}</option>
            @endforeach
        </select>

        <h3>Produtos</h3>
        <ul id="listaProdutos">
            @foreach($produtos as $produto)
                <li>
                    <input type="text" name="produtos[]" value="{{ $produto->name }}" readonly>
                    <input type="number" name="quantidades[]" placeholder="Quantidade" >
                    <input type="number" name="precos[]" value="{{ $produto->valor }}" readonly>
                    <input type="text" name="valores[]" value="0" readonly>
                </li>
            @endforeach
        </ul>

        <label for="valorTotal">Valor Total:</label>
        <input type="text" id="valorTotal" name="valor" value="0" readonly>

        <label for="tipoPagamento">Tipo de Pagamento:</label>
        <select id="tipoPagamento" name="tipoPagamento" required>
            <option value="vista">À Vista</option>
            <option value="prazo">A Prazo</option>
        </select>

        <input type="submit" value="Enviar">
    </form>

    <script>

    function calcularValor() {
        var valores = document.querySelectorAll('input[name="valores[]"]');
        var total = 0;

        valores.forEach(function(valorInput) {
            total += parseFloat(valorInput.value);
        });

        document.getElementById('valorTotal').value = total.toFixed(2);
    }


    document.addEventListener('input', function(event) {
        if (event.target.name === 'quantidades[]') {
            var produto = event.target.parentNode;
            var quantidade = parseFloat(event.target.value);
            var preco = parseFloat(produto.querySelector('input[name="precos[]"]').value);
            var valor = quantidade * preco;

            produto.querySelector('input[name="valores[]"]').value = valor.toFixed(2);

            calcularValor(); 
        }
    });


    document.addEventListener('submit', function(event) {
        var valorTotal = parseFloat(document.getElementById('valorTotal').value);

        if (valorTotal === 0) {
            alert('Adicione pelo menos um produto antes de enviar o formulário.');
            event.preventDefault(); 
        }
    });
</script>

</body>
</html>
