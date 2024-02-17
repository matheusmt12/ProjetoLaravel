<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            padding: 30px;
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
            font-weight: bold;
            color: #555;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 5px;
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
</head>
<body>

    <form action="/editSalvar" method="post">
        @csrf
        <h2>Editar Venda</h2>

        <label for="name">Cliente:</label>
        <select name="name" id="name">
            <option value="" >Sem Nome</option>
            @foreach($pessoas as $pessoa)
                <option value="{{ $pessoa->name }}">{{ $pessoa->name }}</option>
            @endforeach
        </select>

        <input type="hidden" value="{{$vendas->id}}" name="id">

        <label for="valor">Valor da Venda (R$):</label>
        <input type="number" id="valor" name="valor" value="{{$vendas->valor}}" step="0.01" required>
        <label for="valor">Tipo de Pagamento</label>
        <select id="tipoPagamento" name="tipoPagamento" required>
            <option value="vista">À Vista</option>
            <option value="prazo">A Prazo</option>
        </select>

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" value="{{$vendas->data}}" readonly>

        <br>
        <input type="submit" value="Salvar">
    </form>

</body>
</html>
