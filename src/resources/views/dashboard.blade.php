<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-7xl mx-auto p-6 space-y-6">

        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>

        <!-- Filtros -->
        <div x-data="{
            filterType: '{{ $filterType }}',
            filterDate: '{{ $filterDate }}',
        
            get inputType() {
                if (this.filterType === 'day') return 'date';
                if (this.filterType === 'week') return 'date';
                if (this.filterType === 'month') return 'month';
                if (this.filterType === 'year') return 'number';
                return 'month';
            },
        
            resetDate() {
                if (this.filterType === 'day') this.filterDate = '{{ now()->toDateString() }}';
                if (this.filterType === 'week') this.filterDate = '{{ now()->toDateString() }}';
                if (this.filterType === 'month') this.filterDate = '{{ now()->format('Y-m') }}';
                if (this.filterType === 'year') this.filterDate = '{{ now()->year }}';
            }
        }" class="bg-white p-6 rounded-2xl shadow">
            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de filtro
                    </label>

                    <select name="filter_type" x-model="filterType" x-on:change="resetDate()"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="day">Dia</option>
                        <option value="week">Semana</option>
                        <option value="month">Mês</option>
                        <option value="year">Ano</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Período
                    </label>

                    <input x-bind:type="inputType" name="filter_date" x-model="filterDate" min="2000"
                        max="2100"
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-xl hover:bg-blue-700">
                    Filtrar
                </button>

                <a href="{{ route('dashboard') }}"
                    class="bg-gray-100 text-gray-700 font-semibold px-6 py-2 rounded-xl hover:bg-gray-200 text-center">
                    Limpar
                </a>
            </form>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Hoje</p>
                <h2 class="text-2xl font-bold text-blue-600">{{ $todayHours }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Semana atual</p>
                <h2 class="text-2xl font-bold text-green-600">{{ $weeklyHours }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Total no período</p>
                <h2 class="text-2xl font-bold text-indigo-600">{{ $periodHours }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-gray-500 text-sm">Média diária</p>
                <h2 class="text-2xl font-bold text-purple-600">{{ $averageHours }}</h2>
            </div>
        </div>

        <!-- Gráfico -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <h2 class="text-lg font-semibold mb-4">Horas trabalhadas no período</h2>
            <canvas id="hoursChart"></canvas>
        </div>

    </div>

    <script>
        const ctx = document.getElementById('hoursChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Horas',
                    data: @json($data),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
