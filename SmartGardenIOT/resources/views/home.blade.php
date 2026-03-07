<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Smart Garden IoT Dashboard</title>

				<!-- CDN for now, but the tailwind on the app.css needs vite -->
				<script src="https://cdn.tailwindcss.com"></script>

				<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>
    <body>

		@php
			$moisture = $latestReading->soil_percent ?? 0;
			$offset = 364.4 - (364.4 * ($moisture / 100));
			
			// Default: Thriving
			$statusText = 'Optimal';
			$statusColor = 'text-emerald-500 bg-emerald-50';
			$healthMessage = 'Your plant is currently thriving in its environment.';
			$cardAccent = 'bg-emerald-800'; // Decorative circle color
			
			if($moisture < 10) {
					$statusText = 'Critical';
					$statusColor = 'text-red-600 bg-red-50';
					$healthMessage = 'Emergency! Your plant is dangerously dry. Water it immediately!';
					$cardAccent = 'bg-red-800';
			} elseif($moisture < 30) {
					$statusText = 'Thirsty';
					$statusColor = 'text-amber-600 bg-amber-50';
					$healthMessage = 'Moisture is getting low. Consider watering your plant soon.';
					$cardAccent = 'bg-amber-700';
			} elseif($moisture > 85) {
					$statusText = 'Overwatered';
					$statusColor = 'text-blue-600 bg-blue-50';
					$healthMessage = 'Soil is very wet. Be careful not to drown the roots!';
					$cardAccent = 'bg-blue-800';
			}
		@endphp

			<div class="min-h-screen bg-emerald-50 p-6 font-sans">
				<div class="mb-8 flex justify-between items-center">
						<div>
								<h1 class="text-2xl font-bold text-emerald-900">Plant Monitoring System</h1>
								<p class="text-emerald-600 text-sm">Real-time vitals for your Smart Garden</p>
						</div>
						<div class="flex items-center space-x-4">
								<span class="px-3 py-1 bg-white rounded-full text-xs font-semibold text-emerald-700 shadow-sm border border-emerald-100">
										System Online: ESP8266-Unit-01
								</span>
						</div>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
						
						<!-- Soil Moisture Card -->
						<div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100 flex flex-col items-center justify-center">
								<h3 class="text-gray-500 font-medium mb-4 uppercase tracking-wider text-xs">Soil Moisture</h3>
								<div class="relative flex items-center justify-center">
										<svg class="w-32 h-32 transform -rotate-90">
												<circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-emerald-50" />
												
												<circle id="moisture-circle" cx="64" cy="64" r="58" 
														stroke="currentColor" 
														stroke-width="8" 
														fill="transparent" 
														stroke-dasharray="364.4" 
														stroke-dashoffset="{{ $offset }}" 
														class="text-emerald-500 transition-all duration-1000 ease-out" 
														stroke-linecap="round" />
										</svg>
										
										<span id="moisture-display" class="absolute text-2xl font-bold text-emerald-900">
												{{ $moisture }}%
										</span>
								</div>

								<p id="moisture-badge" class="mt-4 text-xs font-semibold {{ $statusColor }} px-3 py-1 rounded-full uppercase">
										{{ $statusText }}
								</p>
						</div>

						<!-- Ambient Temperature Card -->
						<div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100 overflow-hidden flex flex-col h-full">
							<h3 class="text-gray-500 font-medium mb-2 uppercase tracking-wider text-xs px-2">Ambient Temperature</h3>
							<div class="flex items-baseline space-x-2 px-2">
									<span id="temp-display" class="text-4xl font-bold text-emerald-900">{{ $latestReading->temp ?? '--' }}°C</span>
							</div>
							<div class="mt-auto h-24 -mx-6 -mb-6">
									<canvas id="tempChart"></canvas>
							</div>
						</div>

						<!-- Air Humidity Card -->
						<div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100 overflow-hidden flex flex-col h-full">
								<h3 class="text-gray-500 font-medium mb-2 uppercase tracking-wider text-xs px-2">Air Humidity</h3>
								<div class="flex items-baseline space-x-2 px-2">
										<span id="humid-display" class="text-4xl font-bold text-emerald-900">{{ $latestReading->humidity ?? '--' }}%</span>
								</div>
								<div class="mt-auto h-24 -mx-6 -mb-6">
										<canvas id="humidChart"></canvas>
								</div>
						</div>
				</div>

				<!-- Second Row Section -->
				<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

						<!-- View History Cards Card -->
						<div id="health-card" class="p-8 rounded-3xl text-white shadow-lg relative overflow-hidden transition-colors duration-500 {{ $statusText === 'Critical' ? 'bg-red-900' : ($statusText === 'Thirsty' ? 'bg-amber-900' : 'bg-emerald-900') }}">
								<div class="relative z-10">
										<h2 id="health-status" class="text-xl font-bold mb-2">Plant Health: {{ $statusText }}</h2>
										<p id="health-message" class="text-white/80 text-sm mb-6">{{ $healthMessage }}</p>
										
										<a href="{{ url('/history') }}" class="inline-block text-center bg-white/20 hover:bg-white/30 border border-white/30 text-white px-6 py-2 rounded-xl text-sm font-bold transition backdrop-blur-sm">
												View History
										</a>
								</div>
								
								<div id="health-accent-circle" class="absolute -right-10 -bottom-10 w-40 h-40 {{ $cardAccent }} rounded-full opacity-50"></div>
						</div>

						<!-- Recent Activity Card -->
						<div class="bg-white p-6 rounded-3xl shadow-sm border border-emerald-100">
								<h3 class="text-emerald-900 font-bold mb-4">Recent Activity</h3>
								<div class="space-y-4">
										<div class="flex justify-between items-center border-b border-gray-50 pb-2">
												<span class="text-sm text-gray-600">Last Watering</span>
												<span class="text-sm font-medium text-emerald-700">
														{{ $lastWatering ? $lastWatering->created_at->diffForHumans() : 'No watering needed yet' }}
												</span>
										</div>
										<div class="flex justify-between items-center border-b border-gray-50 pb-2">
												<span class="text-sm text-gray-600">Sensor Check</span>
												<span class="text-sm font-medium text-emerald-700">Success</span>
										</div>
								</div>
						</div>
				</div>
			</div>

	<script>
			// Global State (Like React Refs/State)
			let tempChartInstance = null;
			let humidChartInstance = null;

			/**
			 * The "useEffect" equivalent - Runs every 5 seconds
			 */
			async function updateDashboard() {
					try {
							const response = await fetch('/api/vitals');
							const data = await response.json();

							if (!data.latest) return;

							// 1. Update Numeric Values
							document.getElementById('temp-display').innerText = `${data.latest.temp}°C`;
							document.getElementById('humid-display').innerText = `${data.latest.humidity}%`;
							document.getElementById('moisture-display').innerText = `${data.latest.soil_percent}%`;

							// 2. Update Soil Moisture SVG Circle
							const offset = 364.4 - (364.4 * (data.latest.soil_percent / 100));
							document.getElementById('moisture-circle').style.strokeDashoffset = offset;

							// 3. Update Health Card Status & Colors
							updateHealthUI(data.latest.soil_percent);

							// 4. Update Charts with new History Arrays
							const temps = data.history.map(h => h.temp);
							const humids = data.history.map(h => h.humidity);
							
							updateChartData(tempChartInstance, temps);
							updateChartData(humidChartInstance, humids);

							console.log("Sync Successful:", new Date().toLocaleTimeString());
					} catch (error) {
							console.error("Dashboard Sync Failed:", error);
					}
			}

			/**
			 * Smoothly updates chart data without flicker
			 */
			function updateChartData(chart, newData) {
					if (!chart) return;
					chart.data.datasets[0].data = newData;
					chart.data.labels = new Array(newData.length).fill('');
					chart.update('none'); // 'none' mode prevents jumping animations
			}

			/**
			 * Logic for dynamic health card styles
			 */
			function updateHealthUI(moisture) {
					const card = document.getElementById('health-card');
					const status = document.getElementById('health-status');
					const msg = document.getElementById('health-message');
					const circle = document.getElementById('health-accent-circle');
					const badge = document.getElementById('moisture-badge');

					let bgColor, circleColor, statusText, message, badgeColor;

					// 1. Determine the "State"
					if (moisture < 10) {
							bgColor = "bg-red-900";
							circleColor = "bg-red-800";
							badgeColor = "text-red-600 bg-red-50";
        			statusText = "Critical"; // Just the text for the badge
							message = "Emergency! Your plant is dangerously dry!";
					} else if (moisture < 30) {
							bgColor = "bg-amber-900";
							circleColor = "bg-amber-700";
							badgeColor = "text-amber-600 bg-amber-50";
        			statusText = "Thirsty";
							message = "Moisture is getting low. Consider watering soon.";
					} else {
							bgColor = "bg-emerald-900";
							circleColor = "bg-emerald-800";
							badgeColor = "text-emerald-500 bg-emerald-50";
        			statusText = "Optimal";
							message = "Your plant is currently thriving in its environment.";
					}

					// 2. Apply the Styles (The "Render")
					card.className = `p-8 rounded-3xl text-white shadow-lg relative overflow-hidden transition-colors duration-500 ${bgColor}`;
					circle.className = `absolute -right-10 -bottom-10 w-40 h-40 ${circleColor} rounded-full opacity-50`;
					status.innerText = `Plant Health: ${statusText}`;
					msg.innerText = message;

					// Update the Small Badge (the one you asked for)
					badge.innerText = statusText;
					badge.className = `mt-4 text-xs font-semibold ${badgeColor} px-3 py-1 rounded-full uppercase transition-colors duration-500`;
			}

			/**
			 * Base function to initialize a Mountain Chart
			 */
			function createMountainChart(canvasId, dataPoints, color) {
					const canvas = document.getElementById(canvasId);
					if (!canvas) return null;

					const ctx = canvas.getContext('2d');
					const cleanData = dataPoints.map(point => parseFloat(point));
					
					// Ensure at least two points for a line
					const displayData = cleanData.length <= 1 ? [cleanData[0] || 0, cleanData[0] || 0] : cleanData;

					const gradient = ctx.createLinearGradient(0, 0, 0, 100);
					gradient.addColorStop(0, color + '66');
					gradient.addColorStop(1, color + '00');

					return new Chart(ctx, {
							type: 'line',
							data: {
									labels: new Array(displayData.length).fill(''),
									datasets: [{
											data: displayData,
											borderColor: color,
											borderWidth: 3,
											backgroundColor: gradient,
											fill: true,
											tension: 0.45,
											pointRadius: 0
									}]
							},
							options: {
									responsive: true,
									maintainAspectRatio: false,
									plugins: { legend: { display: false } },
									scales: {
											x: { display: false },
											y: { 
													display: false,
													suggestedMin: Math.min(...displayData) - 5,
													suggestedMax: Math.max(...displayData) + 5
											}
									},
									layout: { padding: { left: -10, right: -10, bottom: -10 } }
							}
					});
			}

			/**
			 * Init logic on Page Load (The "onMount")
			 */
			window.addEventListener('load', () => {
					// Initial Data from Blade
					const initialTemps = @json($history->pluck('temp')->toArray());
					const initialHumids = @json($history->pluck('humidity')->toArray());

					// Create initial instances
					tempChartInstance = createMountainChart('tempChart', initialTemps, '#10b981');
					humidChartInstance = createMountainChart('humidChart', initialHumids, '#059669');

					// Start Polling every 1 second
					setInterval(updateDashboard, 1000);
			});
	</script>

    </body>
</html>
