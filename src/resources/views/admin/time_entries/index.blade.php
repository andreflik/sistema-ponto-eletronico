<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

    <style>
        .flatpickr-current-month input.cur-year {
            border: none !important;
            background: transparent !important;
            font-weight: 600;
            font-size: 16px;
            padding: 0 4px;
            width: 70px;
            box-shadow: none !important;
        }

        .flatpickr-current-month .numInputWrapper span {
            display: none;
        }
    </style>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <h1 class="text-2xl font-bold">Admin - Registros de Ponto</h1>

        <div class="bg-white p-6 rounded-2xl shadow">
            <form method="GET" action="{{ route('admin.pontos') }}" class="flex flex-col md:flex-row md:items-end gap-4">

                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Usuário
                    </label>

                    <select name="user_id"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos os usuários</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected((string) $selectedUserId === (string) $user->id)>
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Data inicial
                    </label>

                    <input type="text" id="start_date" name="start_date" value="{{ $startDate }}"
                        placeholder="Data inicial"
                        class="w-40 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Data final
                    </label>

                    <input type="text" id="end_date" name="end_date" value="{{ $endDate }}"
                        placeholder="Data final"
                        class="w-40 border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="h-[42px] bg-blue-600 text-white font-semibold px-6 py-2 rounded-xl hover:bg-blue-700 transition">
                    Filtrar
                </button>

                <a href="{{ route('admin.pontos') }}"
                    class="h-[42px] bg-gray-100 text-gray-700 font-semibold px-6 py-2 rounded-xl hover:bg-gray-200 text-center transition flex items-center justify-center">
                    Limpar
                </a>

                <a href="{{ route('admin.pontos.pdf', request()->query()) }}" target="_blank" data-no-loading="true"
                    class="h-[42px] bg-red-600 text-white font-semibold px-6 py-2 rounded-xl hover:bg-red-700 text-center transition flex items-center justify-center">
                    PDF
                </a>

                <a href="{{ route('admin.pontos.excel', request()->query()) }}" data-no-loading="true"
                    class="h-[42px] bg-green-600 text-white font-semibold px-6 py-2 rounded-xl hover:bg-green-700 text-center transition flex items-center justify-center">
                    Excel
                </a>

            </form>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow overflow-x-auto">
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

    <script>
        const dateConfig = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            locale: "pt",
            monthSelectorType: "dropdown",
            disableMobile: true
        };

        flatpickr("#start_date", dateConfig);
        flatpickr("#end_date", dateConfig);
    </script>

</x-app-layout>
