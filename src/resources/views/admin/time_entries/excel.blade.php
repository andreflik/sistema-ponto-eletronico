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
                <td>{{ $entry->worked_hours }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
