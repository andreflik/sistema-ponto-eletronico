    <x-app-layout>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="max-w-7xl mx-auto p-6 space-y-6">

            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500 text-sm">Hoje</p>
                    <h2 class="text-2xl font-bold text-blue-600">{{ $todayHours }}</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500 text-sm">Semana</p>
                    <h2 class="text-2xl font-bold text-green-600">{{ $weeklyHours }}</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500 text-sm">Dias trabalhados</p>
                    <h2 class="text-2xl font-bold text-yellow-600">{{ $daysWorked }}</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-gray-500 text-sm">Média diária</p>
                    <h2 class="text-2xl font-bold text-purple-600">{{ $averageHours }}</h2>
                </div>

            </div>

            <!-- Gráfico -->
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4">Horas trabalhadas por dia</h2>
                <canvas id="hoursChart"></canvas>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                }
            });
        </script>
    </x-app-layout>
