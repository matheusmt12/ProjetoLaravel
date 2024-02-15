<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
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

        input[type="text"],
        input[type="number"],
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
    </style>
</head>
<body>

    <form action="/produto/editSalvar" method="post">
        @csrf
        <h2>Editar Produto</h2>

        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="name" value="{{$produto->name}}" required>
        @if($errors->has('name'))
            {{$errors->first('name')}}
            <br>
        @endif
        <input type="hidden" value="{{$produto->id}}" name="id">

        <label for="valor">Valor do Produto (R$):</label>
        <input type="number" id="valor" name="valor" value="{{$produto->valor}}" step="0.01" required>

        <input type="submit" value="Salvar">
    </form>

</body>
</html>
