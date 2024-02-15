<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
</head>
<body>

    <h2>Cadastro de Produto</h2>

    <form action="/salvarProduto" method="post">
        @csrf

        <label for="name">Nome do Produto:</label>
        <input type="text" id="nome" name="name" required>

        <br>

        <label for="valor">Valor do Produto (R$):</label>
        <input type="number" id="valor" name="valor" step="0.01" required>

        <br>

        <input type="submit" value="Cadastrar Produto">
    </form>

</body>
</html>
