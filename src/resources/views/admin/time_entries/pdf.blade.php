<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Pontos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .subtitle {
            margin-bottom: 20px;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            padding: 8px;
            border: 1px solid #d1d5db;
        }

        td {
            padding: 8px;
            border: 1px solid #d1d5db;
            text-align: center;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Relatório de Registros de Ponto</h1>

    <div class="subtitle">
        Período:
        {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Início' }}
        até
        {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Hoje' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Data</th>
                <th>Entrada</th>
                <th>Início Intervalo</th>
                <th>Fim Intervalo</th>
                <th>Saída</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <td>{{ $entry->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->work_date)->format('d/m/Y') }}</td>
                    <td>{{ optional($entry->clock_in)->format('H:i') }}</td>
                    <td>{{ optional($entry->break_start)->format('H:i') }}</td>
                    <td>{{ optional($entry->break_end)->format('H:i') }}</td>
                    <td>{{ optional($entry->clock_out)->format('H:i') }}</td>
                    <td class="total">{{ $entry->worked_hours }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
