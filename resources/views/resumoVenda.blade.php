<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Venda</title>
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

        #content {
            width: 80%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            text-align: left;
            padding: 20px;
            margin-top: 20px;
        }

        h2, p {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        @media (max-width: 600px) {
            body {
                overflow-x: hidden;
            }

            #content {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div id="content">
        <h2>Detalhes da Venda</h2>


        <p><strong>Nome da Pessoa:</strong> {{ $name ? $name : 'Não informado' }}</p>
        <p><strong>Valor da Compra:</strong> R$ {{ $valor }}</p>

        <table>
            <thead>
                <tr>
                    <th>Parcelas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @forelse($parcelas as $parcela)
                            <p>Data: {{ $parcela->data_vencimento }}, Valor: R$ {{ $parcela->valor_parcela }}</p>
                        @empty
                            À vista
                        @endforelse
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
