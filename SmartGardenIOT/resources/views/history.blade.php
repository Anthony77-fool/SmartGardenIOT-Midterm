<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Garden IoT HISTORY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-emerald-50 p-6 font-sans text-emerald-900">

    <div class="max-w-6xl mx-auto mb-6">
        <a href="{{ url('/') }}" class="flex items-center text-emerald-700 hover:text-emerald-500 font-semibold transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 gap-6">
        
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-emerald-100">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold italic">Growth Environment Trends</h2>
                    <p class="text-emerald-600 text-sm">Last 24 Data Points</p>
                </div>
            </div>
            
            <div class="h-80 w-full bg-emerald-50/20 rounded-2xl p-4">
                <canvas id="historyTrendChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="p-6 border-b border-emerald-50 bg-emerald-900 text-white flex justify-between items-center">
                <h3 class="font-bold">Detailed Sensor Log</h3>
                <span class="text-xs text-emerald-200">Total Records: {{ $history->total() }}</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-emerald-50 text-emerald-700 text-xs uppercase tracking-widest">
                            <th class="px-6 py-4 font-bold">Timestamp</th>
                            <th class="px-6 py-4 font-bold">Moisture (%)</th>
                            <th class="px-6 py-4 font-bold">Temp (°C)</th>
                            <th class="px-6 py-4 font-bold">Humidity (%)</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50">
                        @foreach($history as $read)
                        @php
                            $status = $read->soil_percent < 30 ? 'Thirsty' : ($read->soil_percent > 85 ? 'Overwatered' : 'Optimal');
                            $color = $read->soil_percent < 30 ? 'bg-amber-100 text-amber-700' : ($read->soil_percent > 85 ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700');
                        @endphp
                        <tr class="hover:bg-emerald-50/30 transition">
                            <td class="px-6 py-4 text-sm font-medium">{{ $read->created_at->format('M d, Y - h:i A') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $read->soil_percent }}%</td>
                            <td class="px-6 py-4 text-sm">{{ $read->temp }}°C</td>
                            <td class="px-6 py-4 text-sm">{{ $read->humidity }}%</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 {{ $color }} text-[10px] font-bold rounded-full uppercase">{{ $status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 bg-white border-t border-emerald-50">
                {{ $history->links() }}
            </div>
        </div>

    </div>

    <script>
        window.addEventListener('load', () => {
            const ctx = document.getElementById('historyTrendChart').getContext('2d');
            
            // Injecting data from PHP to JS
            const labels = @json($chartData->map(fn($d) => $d->created_at->format('H:i')));
            const moistureData = @json($chartData->pluck('soil_percent'));
            const tempData = @json($chartData->pluck('temp'));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Moisture %',
                            data: moistureData,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Temp °C',
                            data: tempData,
                            borderColor: '#f59e0b',
                            borderDash: [5, 5],
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: false }
                    }
                }
            });
        });
    </script>
</body>
</html>