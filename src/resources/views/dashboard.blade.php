<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="max-w-6xl mx-auto p-6 space-y-6">

        <h1 class="text-2xl font-bold">Dashboard</h1>

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Horas trabalhadas por dia</h2>

            <canvas id="hoursChart"></canvas>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('hoursChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Horas trabalhadas',
                    data: @json($data),
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
