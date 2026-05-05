<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <h1 class="text-2xl font-bold">Admin - Registros de Ponto</h1>

        <div class="bg-white p-6 rounded-2xl shadow">
            <table class="w-full text-sm text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Usuário</th>
                        <th>Data</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($entries as $entry)
                        <tr class="border-t">
                            <td>{{ $entry->user->name }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($entry->work_date)->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ optional($entry->clock_in)->format('H:i') }}
                            </td>

                            <td>
                                {{ optional($entry->clock_out)->format('H:i') }}
                            </td>

                            <td class="font-bold">
                                {{ $entry->worked_hours }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $entries->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
