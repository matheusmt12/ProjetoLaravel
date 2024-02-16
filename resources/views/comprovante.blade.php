<!DOCTYPE html>
<html>
<head>
    <title>Comprovante de Pagamento</title>
</head>
<body>
    <h1>Comprovante de Pagamento - Venda #{{ $idVenda }}</h1>
    <table>
        <thead>
            <tr>
                <th>Parcela</th>
                <th>Data de Vencimento</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parcelas as $key => $parcela)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $dataVencimento[$key] }}</td>
                    <td>R$ {{ $parcela }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
