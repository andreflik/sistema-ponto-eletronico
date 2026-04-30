<x-app-layout>
    <div x-data="{ loading: false }" class="max-w-6xl mx-auto p-6 space-y-8">

        <!-- Loading -->
        <div x-show="loading" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div class="bg-white rounded-2xl shadow-lg px-8 py-6 text-center">
                <div
                    class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto mb-4">
                </div>
                <p class="text-gray-700 font-semibold">Registrando ponto...</p>
            </div>
        </div>

        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Meu Ponto</h1>
            <p class="text-gray-500">Registre seu ponto e acompanhe seu histórico.</p>
        </div>

        <!-- Relógio Atual -->
        <div x-data="{ time: new Date().toLocaleTimeString('pt-BR') }" x-init="setInterval(() => time = new Date().toLocaleTimeString('pt-BR'), 1000)"
            class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Horário atual</h2>
                <p class="text-gray-500 text-sm">Use este horário como referência para registrar seu ponto.</p>

                <div class="mt-3">
                    @if ($status['color'] === 'green')
                        <span
                            class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-semibold text-green-700">
                            🟢 {{ $status['label'] }}
                        </span>
                    @elseif ($status['color'] === 'yellow')
                        <span
                            class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-1 text-sm font-semibold text-yellow-700">
                            🟡 {{ $status['label'] }}
                        </span>
                    @elseif ($status['color'] === 'red')
                        <span
                            class="inline-flex items-center rounded-full bg-red-100 px-4 py-1 text-sm font-semibold text-red-700">
                            🔴 {{ $status['label'] }}
                        </span>
                    @else
                        <span
                            class="inline-flex items-center rounded-full bg-blue-100 px-4 py-1 text-sm font-semibold text-blue-700">
                            🔵 {{ $status['label'] }}
                        </span>
                    @endif

                    <p class="text-sm text-gray-500 mt-2">
                        {{ $status['message'] }}
                    </p>
                </div>
            </div>

            <div class="text-4xl font-bold text-blue-600">
                <span x-text="time"></span>
            </div>
        </div>
        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Entrada -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-green-100 flex items-center justify-center text-3xl mb-4">
                    🟢
                </div>

                <h2 class="text-lg font-bold text-green-600">Entrada</h2>
                <p class="text-gray-500 text-sm mb-5">Registrar entrada</p>

                <form method="POST" action="{{ route('ponto.clockin') }}" x-on:submit="loading = true">
                    @csrf
                    <button type="submit"
                        class="w-full bg-green-600 text-white font-semibold py-3 rounded-xl hover:bg-green-700 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                        @disabled($todayEntry->clock_in)>
                        Marcar Entrada
                    </button>
                </form>
            </div>

            <!-- Intervalo Início -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 text-center">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-yellow-100 flex items-center justify-center text-3xl mb-4">
                    ☕
                </div>

                <h2 class="text-lg font-bold text-yellow-600">Início Intervalo</h2>
                <p class="text-gray-500 text-sm mb-5">Registrar início do intervalo</p>

                <form method="POST" action="{{ route('ponto.breakstart') }}" x-on:submit="loading = true">
                    @csrf
                    <button type="submit"
                        class="w-full bg-yellow-500 text-white font-semibold py-3 rounded-xl hover:bg-yellow-600 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                        @disabled(!$todayEntry->clock_in || $todayEntry->break_start)>
                        Iniciar Intervalo
                    </button>
                </form>
            </div>

            <!-- Intervalo Fim -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-3xl mb-4">
                    ▶️
                </div>

                <h2 class="text-lg font-bold text-blue-600">Fim Intervalo</h2>
                <p class="text-gray-500 text-sm mb-5">Registrar fim do intervalo</p>

                <form method="POST" action="{{ route('ponto.breakend') }}" x-on:submit="loading = true">
                    @csrf
                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-3 rounded-xl hover:bg-blue-700 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                        @disabled(!$todayEntry->break_start || $todayEntry->break_end)>
                        Finalizar Intervalo
                    </button>
                </form>
            </div>

            <!-- Saída -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-red-100 flex items-center justify-center text-3xl mb-4">
                    🔴
                </div>

                <h2 class="text-lg font-bold text-red-600">Saída</h2>
                <p class="text-gray-500 text-sm mb-5">Registrar saída</p>

                <form method="POST" action="{{ route('ponto.clockout') }}" x-on:submit="loading = true">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 text-white font-semibold py-3 rounded-xl hover:bg-red-700 disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed"
                        @disabled(!$todayEntry->clock_in || ($todayEntry->break_start && !$todayEntry->break_end) || $todayEntry->clock_out)>
                        Marcar Saída
                    </button>
                </form>
            </div>

        </div>

        <!-- Histórico -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Histórico de Registros</h2>

            <table class="w-full text-sm text-center">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="py-3">Data</th>
                        <th>Entrada</th>
                        <th>Intervalo Início</th>
                        <th>Intervalo Fim</th>
                        <th>Saída</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($entries as $entry)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-2">
                                {{ \Carbon\Carbon::parse($entry->work_date)->format('d/m/Y') }}
                            </td>

                            <td class="text-green-600 font-semibold">
                                {{ optional($entry->clock_in)->format('H:i') }}
                            </td>

                            <td class="text-yellow-600 font-semibold">
                                {{ optional($entry->break_start)->format('H:i') }}
                            </td>

                            <td class="text-blue-600 font-semibold">
                                {{ optional($entry->break_end)->format('H:i') }}
                            </td>

                            <td class="text-red-600 font-semibold">
                                {{ optional($entry->clock_out)->format('H:i') }}
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
