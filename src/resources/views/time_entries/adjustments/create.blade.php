<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">Solicitar Ajuste de Ponto</h1>
            <p class="text-gray-500">Informe os horários corretos e a justificativa para análise do administrador.</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
            <form method="POST" action="{{ route('ponto.ajuste.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data do ponto</label>
                    <input type="date" name="work_date" value="{{ old('work_date', now()->toDateString()) }}"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                    @error('work_date')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Entrada</label>
                        <input type="time" name="requested_clock_in" value="{{ old('requested_clock_in') }}"
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Início intervalo</label>
                        <input type="time" name="requested_break_start" value="{{ old('requested_break_start') }}"
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fim intervalo</label>
                        <input type="time" name="requested_break_end" value="{{ old('requested_break_end') }}"
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Saída</label>
                        <input type="time" name="requested_clock_out" value="{{ old('requested_clock_out') }}"
                            class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Justificativa</label>
                    <textarea name="reason" rows="4"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Ex: Esqueci de registrar a saída no final do expediente." required>{{ old('reason') }}</textarea>

                    @error('reason')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-xl hover:bg-blue-700">
                        Enviar solicitação
                    </button>

                    <a href="{{ route('ponto.index') }}"
                        class="bg-gray-100 text-gray-700 font-semibold px-6 py-2 rounded-xl hover:bg-gray-200">
                        Voltar
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
