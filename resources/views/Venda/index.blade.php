<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vendas</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 16px;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        main {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            overflow: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            border-spacing: 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.3s ease;
        }

        a {
            color: #0056b3;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            text-decoration: underline;
            color: #003366;
        }

        .empty-message {
            text-align: center;
            font-style: italic;
        }

        .create-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Lista de Vendas</h1>
    </header>

    @include('site.layout.nav')

    <main>
        @if($vendas->isEmpty())
            <p class="empty-message">Não há vendas disponíveis.</p>
        @else
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendas as $venda)
                        <tr>
                            <td>{{ $venda->id }}</td>
                            <td>{{ $venda->name }}</td>
                            <td>R$ {{ number_format($venda->valor, 2, ',', '.') }}</td>
                            <td>
                                <a href="/remove/{{ $venda->id }}" onclick="return confirm('Tem certeza que deseja remover?')">Remover</a>|
                                <a href="/detalhes/{{ $venda->id }}">Detalhes</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <a href="/venda" class="create-link">Criar Nova Venda</a>
    </main>
</body>
</html>
