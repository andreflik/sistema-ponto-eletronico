<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <h1 class="text-2xl font-bold">Admin - Registros de Ponto</h1>

        <div class="bg-white p-6 rounded-2xl shadow">
            <form method="GET" action="{{ route('admin.pontos') }}" class="space-y-4">
                <div>
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

                <div class="flex flex-col md:flex-row gap-3 mt-4">

                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-xl hover:bg-blue-700 transition">
                        Filtrar
                    </button>

                    <a href="{{ route('admin.pontos') }}"
                        class="bg-gray-100 text-gray-700 font-semibold px-6 py-2 rounded-xl hover:bg-gray-200 text-center transition">
                        Limpar
                    </a>

                </div>
            </form>
        </div>

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
