<?php include __DIR__.'/../config.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr" class="page page-homepage">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
	<title>Predictions</title>
	<!-- Loading third party fonts -->
	<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
	<!-- font-awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link rel="stylesheet" href="/assets/css/desktop-styles.css">
</head>
<body>

	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'header.php' ?>

		<section id="section-predictions" class="section section-predictions">
			<div class="container container-predictions">

				<div class="suburb-container">
					Select a suburb
					<select id="suburbSelect">
						<!-- Suburbs as options -->
						<option>Select a location</option>
						<option>Aberdeen</option>
						<option>Admiralty</option>
						<option>Ap Lei Chau</option>
						<option>Big Wave Bay</option>
						<option>Braemar Hill</option>
						<option>Causeway Bay</option>
						<option>Central Chung Wan</option>
						<option>Chai Wan</option>
						<option>Chung Hom Kok</option>
						<option>Cyberport</option>
						<option>Deep Water Bay</option>
						<option>East Mid-Levels</option>
						<option>Fortress Hill</option>
						<option>Happy Valley</option>
						<option>Jardine's Lookout</option>
						<option>Kennedy Town</option>
						<option>Lung Fu Shan</option>
						<option>Mid-Levels</option>
						<option>Mount Davis</option>
						<option>North Point</option>
						<option>Pok Fu Lam</option>
						<option>Quarry Bay</option>
						<option>Repulse Bay</option>
						<option>Sai Wan Ho</option>
						<option>Sai Wan</option>
						<option>Sai Ying Pun</option>
						<option>Sandy Bay</option>
						<option>Shau Kei Wan</option>
						<option>Shek O</option>
						<option>Shek Tong Tsui</option>
						<option>Siu Sai Wan</option>
						<option>So Kon Po</option>
						<option>Stanley</option>
						<option>Tai Hang</option>
						<option>Tai Tam</option>
						<option>Tin Hau</option>
						<option>Victoria Park</option>
						<option>Wan Chai</option>
						<option>West Mid-Levels</option>
						<option>Wong Chuk Hang</option>
					</select>
				</div>

				<div class="forecast-container">
					<div class="columns today">
						<div class="forecast today">
							<div class="forecast-header">
								<div class="day">Monday</div>
								<div class="date">__</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="location">Hongkong</div>
								<div class="degree">
									<div class="num"><span class="maxTemp">23</span><sup>o</sup>C</div>
									<div class="forecast-icon">
										<img class="weather" src="/assets/icons/cloud-scattered.svg" alt="" width="64" height="64">
									</div>
								</div>
								<span><i class="fa fa-warning"></i> <b class="humidity">__</b></span>
							</div>
						</div>
					</div>
					<div class="columns next">
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Tuesday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-sunny.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Wednesday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-cloudy.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Thursday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-bold.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Friday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-low-rain.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Saturday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-heavy-rain.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Sunday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-sunny.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
						<div class="forecast">
							<div class="forecast-header">
								<div class="day">Sunday</div>
							</div> <!-- .forecast-header -->
							<div class="forecast-content">
								<div class="forecast-icon">
									<img class="weather" src="/assets/icons/cloud-sunny.svg" alt="" width="48" height="48">
								</div>
								<div class="degree"><span class="maxTemp">23</span><sup>o</sup>C</div>
								<small><span class="minTemp">"__"</span></small>
							</div>
						</div>
					</div>
				</div>

				<div class="chart-container">
					<div class="columns">
						<!-- waterfall -->
						<div class="panel panel-waterfall">
							<h6>Wind Speed for 7 Days</h6>
							<canvas id="waterfallCanvas"></canvas>
						</div>

						<!-- rainfall -->
						<div class="panel panel-rainfall">
							<h6>Predicted Rainfall</h6>
							<canvas id="rainfallCanvas"></canvas>
						</div>
					</div>
				</div>
			</div>
		</section>
	
	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'footer.php' ?>

	<!-- Include Chart.js from CDN for Prediction Graph -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- script js -->
	<script src="/assets/js/script.js"></script>

	<script>
		
		// Initialize the prediction graph after the DOM has fully loaded
		document.addEventListener('DOMContentLoaded', function () {

			function getNextWeekDays() {
				const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const nextSevenDays = [];

				for (let i = 0; i < 7; i++) {
					const today = typeof arguments[0] == 'undefined' ? new Date():  new Date(arguments[0]);
					const nextDay = new Date(today);
					nextDay.setDate(today.getDate() + i + 1); // Adding 1 to skip today
					nextSevenDays.push(days[nextDay.getDay()]);
				}

				return nextSevenDays;
			}
			
			function getTodayWeekdayName(date) {
				const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const today = date ? new Date(date) : new Date();
				const weekdayName = days[today.getDay()];
				return weekdayName;
			}


			function getPreviousWeekdays() {
				const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const previousSevenDays = [];

				for (let i = 0; i < 7; i++) {
					const today = typeof arguments[0] == 'undefined' ? new Date():  new Date(arguments[0]);
					const previousDay = new Date(today);
					previousDay.setDate(today.getDate() - i - 1); // Subtracting 1 to skip today
					previousSevenDays.unshift(days[previousDay.getDay()]);
				}

				return previousSevenDays;
			}

			function getTodayWeekdayName() {
				const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const today = typeof arguments[0] == 'undefined' ? new Date():  new Date(arguments[0]);
				const weekdayName = days[today.getDay()];
				return weekdayName;
			}


			function updateInfoBox(suburb) {
				
				const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
				const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
				const data = suburbData[suburb];
				const forecastContainer = document.querySelector('.forecast-container');

				const forecastToday = forecastContainer.querySelector('.forecast.today');
				const forecastLocation = forecastToday.querySelector('.location');
				const forecastTodayDay = forecastToday.querySelector('.day');
				const forecastTodayDate = forecastToday.querySelector('.date');
				const forecastTodayWeather = forecastToday.querySelector('.forecast-icon img.weather');
				const forecastTodayMaxTemp = forecastToday.querySelector('.maxTemp');
				const forecastTodayHumidity = forecastToday.querySelector('.humidity');
				
				const forecasts = forecastContainer.querySelectorAll('.columns.next .forecast');
				
				for (let i = 0; i < forecasts.length; i++) {
					const forecastDay = forecasts[i].querySelector('.day');
					const forecastWeather = forecasts[i].querySelector('.forecast-icon img.weather');
					const forecastMaxTemp = forecasts[i].querySelector('.maxTemp');
					const forecastMinTemp = forecasts[i].querySelector('.minTemp');
				}

    			if (suburbData && suburbData[suburb]) {
					
					fetch("http://127.0.0.1:8000/7_day_weather_forecast/" + encodeURIComponent(suburb.toLowerCase()), {
        				method: 'GET',
        				cache: 'no-cache',
        				headers: {
							'Content-Type': 'application/json'
        				}
					})
					.then(response => response.json())
					.then(data => {
        				console.log('7 days Weather Forecast API Data:', data); // check API

        				if (data) {						
							forecastTodayDay.innerText = data.day_of_week[1];//days[currentDate.getDay()];
							forecastTodayDate.innerText = data.date[1];//`${currentDate.getDate()} ${months[currentDate.getMonth()]}`;
							forecastLocation.innerText = suburb;
							forecastTodayWeather.src = getWeatherIcon(data.weather_code[1]);//'/assets/icons/cloud-' + data.weather_code[0] + '.svg';//['weather'] + '.svg';
							forecastTodayMaxTemp.innerText = data.temperature_max[1]; // data['maxTemp'];
							// forecastTodayWindSpeed.innerText = data['windSpeed'];

							for (let i = 0; i < forecasts.length; i++) {
								const forecastDay = forecasts[i].querySelector('.day');
								const forecastWeather = forecasts[i].querySelector('.forecast-icon img.weather');
								const forecastMaxTemp = forecasts[i].querySelector('.maxTemp');

								forecastDay.innerText = data.date[i+1];
								forecastWeather.src = getWeatherIcon(data.weather_code[i+2]);//'/assets/icons/cloud-' + data['weatherNext7'][i] + '.svg';
								forecastMaxTemp.innerText = data.temperature_max[i];
							}
        				} else {
							console.error('Error: Incomplete weather data received');
        				}
					})
					.catch(error => {
        				console.error('Error fetching weather forecast data:', error);
					});
					


					fetch("http://127.0.0.1:8000/flood_prediction_in_seven_days/" + encodeURIComponent(suburb.toLowerCase()), {
        				method: 'GET',
        				cache: 'no-cache',
        				headers: {
							'Content-Type': 'application/json'
        				}
					})
					.then(response => response.json())
					.then(data => {
        				console.log('7 days Flood Forecast API Data:', data); // check API

        				if (data) {
							to_flood(forecastTodayHumidity,data.flood_prediction[1]);

							for (let i = 0; i < forecasts.length; i++) {
								const forecastMinTemp = forecasts[i].querySelector('.minTemp');
								to_flood(forecastMinTemp, data.flood_prediction[i+2]); 
							}
        				} else {
							console.error('Error: Incomplete weather data received');
        				}
					})
					.catch(error => {
        				console.error('Error fetching flood prediction data:', error);
					});
				}
			}

			function to_flood(html_tag,flood) {
				if (flood) {
					html_tag.innerText = "Flood Warnning";		
					html_tag.style.color = "red"; 
				} else {
					html_tag.innerText = "No Flood";
				}
			}


			function updateWeatherForecast(suburb) {
				fetch("http://127.0.0.1:8000/general_weather_forcast/" + encodeURIComponent(suburb.toLowerCase()), {
					method: 'GET',
					cache: 'no-cache',
					headers: {
						'Content-Type': 'application/json'
					}
				})
				.then(response => response.json())
				.then(data => {
					console.log('Weather Forecast API Data:', data); // check API

					if (data) {
						var forecastContainer = document.querySelector('.forecast-container');
						var forecasts = forecastContainer.querySelectorAll('.columns.next .forecast');

						for (var i = 0; i < forecasts.length; i++) {
							var forecastDay = forecasts[i].querySelector('.day');
							var forecastWeather = forecasts[i].querySelector('.forecast-icon img.weather');
							var forecastMaxTemp = forecasts[i].querySelector('.maxTemp');
							var forecastMinTemp = forecasts[i].querySelector('.minTemp');

							forecastDay.innerText = data.date[i] || 'N/A';
							forecastWeather.src = getWeatherIcon(data.weathercode[i]);
							forecastMaxTemp.innerText = Math.round(data.temperature_max[i]) || '--'; 
							forecastMinTemp.innerText = Math.round(data.temperature_min[i]) || '--'; 
						}
					} else {
						console.error('Error: Incomplete weather data received');
					}
				})
				.catch(error => {
					console.error('Error fetching weather forecast data:', error);
				});
			}

// Helper function to get weather icon based on weather condition
function getWeatherIcon(condition) {
    var iconMap = {
        0: '/assets/icons/cloud-clear.svg',        // Clear sky
        1: '/assets/icons/cloud-sunny.svg',        // Mainly clear
        2: '/assets/icons/cloud-scattered.svg',    // Partly cloudy
        3: '/assets/icons/cloud-cloudy.svg',       // Overcast
        45: '/assets/icons/cloud-bold.svg',        // Fog
        48: '/assets/icons/cloud-bold.svg',        // Depositing rime fog
        51: '/assets/icons/cloud-low-rain.svg',    // Drizzle: Light
        53: '/assets/icons/cloud-low-rain.svg',    // Drizzle: Moderate
        55: '/assets/icons/cloud-low-rain.svg',    // Drizzle: Dense intensity
        56: '/assets/icons/cloud-low-rain.svg',    // Freezing Drizzle: Light
        57: '/assets/icons/cloud-low-rain.svg',    // Freezing Drizzle: Dense intensity
        61: '/assets/icons/cloud-low-rain.svg',    // Rain: Slight
        63: '/assets/icons/cloud-low-rain.svg',    // Rain: Moderate
        65: '/assets/icons/cloud-low-rain.svg',    // Rain: Heavy intensity
        66: '/assets/icons/cloud-low-rain.svg',    // Freezing Rain: Light
        67: '/assets/icons/cloud-low-rain.svg',    // Freezing Rain: Heavy intensity
        71: '/assets/icons/cloud-heavy-rain.svg',  // Snow fall: Slight
        73: '/assets/icons/cloud-heavy-rain.svg',  // Snow fall: Moderate
        75: '/assets/icons/cloud-heavy-rain.svg',  // Snow fall: Heavy intensity
        77: '/assets/icons/cloud-heavy-rain.svg',  // Snow grains
        80: '/assets/icons/cloud-heavy-rain.svg',  // Rain showers: Slight
        81: '/assets/icons/cloud-heavy-rain.svg',  // Rain showers: Moderate
        82: '/assets/icons/cloud-heavy-rain.svg',  // Rain showers: Violent
        85: '/assets/icons/cloud-heavy-rain.svg',  // Snow showers slight
        86: '/assets/icons/cloud-heavy-rain.svg',  // Snow showers heavy
        95: '/assets/icons/cloud-heavy-rain.svg',  // Thunderstorm: Slight or moderate
        96: '/assets/icons/cloud-heavy-rain.svg',  // Thunderstorm with slight hail
        99: '/assets/icons/cloud-heavy-rain.svg'   // Thunderstorm with heavy hail
    };
    return iconMap[condition] || '/assets/icons/cloud-cloudy.svg'; // default
}


			function updateWindSpeed(suburb) {
    fetch("http://127.0.0.1:8000/general_weather_forcast/" + encodeURIComponent(suburb.toLowerCase()), {
        method: 'GET',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Weather Forecast API Data:', data);

        if (data && data.date && data.wind_speed_max) {
            waterfallCanvas.style.visibility = 'visible';
            waterfallChart.data.labels = data.date.slice(1,8);
            waterfallChart.data.datasets[0].data = data.wind_speed_max.slice(1,8);
            waterfallChart.update();
        } else {
            console.error('Error: Incomplete weather data received');
            waterfallCanvas.style.visibility = 'hidden';
        }
    })
    .catch(error => {
        console.error('Error fetching weather forecast data:', error);
        waterfallCanvas.style.visibility = 'hidden';
    });
}
			
function updateRainfall(suburb) {
    fetch("http://127.0.0.1:8000/general_weather_forcast/" + encodeURIComponent(suburb.toLowerCase()), {
        method: 'GET',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Weather Forecast API Data:', data);

        if (data && data.date && data.rain_sum) {
            rainfallCanvas.style.visibility = 'visible';
            rainfallChart.data.labels = data.date.slice(1,8);
            rainfallChart.data.datasets[0].data = data.rain_sum.slice(1,8);
            rainfallChart.update();
        } else {
            console.error('Error: Incomplete weather data received');
            rainfallCanvas.style.visibility = 'hidden';
        }
    })
    .catch(error => {
        console.error('Error fetching weather forecast data:', error);
        rainfallCanvas.style.visibility = 'hidden';
    });
}


			var suburbData; // suburb data for the dashboard

			// retrieve data
			fetch('/api-data.json', {
				"method": 'GET',
				"cache": "no-cache",
				"headers": {
					"Content-Type": "application/json",
				}
			})
			.then( function(response){ return response.json(); })
			.then(function(d){ suburbData = d; })
			.catch(function(error){ console.error('Error fetching JSON:', error); });

			// suburb Select element
			const suburbSelect = document.getElementById('suburbSelect');

			// suburbSelect on change event
			suburbSelect.addEventListener('change', function (e) {
				e.preventDefault();
				var selectedSuburb = this.selectedOptions[0].text;
				updateInfoBox(selectedSuburb);
				updateWindSpeed(selectedSuburb);
				updateRainfall(selectedSuburb);
			});

			// waterfallCanvas canvas element
			const waterfallCanvas = document.getElementById('waterfallCanvas');
			
			//  2d context of waterfallCanvas
			const waterfallCanvasCtx = waterfallCanvas.getContext('2d');

			const waterfallChart = new Chart(waterfallCanvasCtx, {
    type: 'line',
    data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], // default
        datasets: [{
            label: 'Wind Speed (km/h)',
            fill: false,
            backgroundColor: 'rgb(0, 123, 255)',
            borderColor: 'rgb(0, 123, 255)',
            data: [0, 0, 0, 0, 0, 0, 0], // default
            tension: 0.1
        }]
    },
    options: {
        aspectRatio: 1.5,
        layout: {
            padding: {
                top: 0,
                bottom: 0
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Wind Speed (km/h)'
                }
            },
            x: {
                //
            }
        },
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

			// rainfallCanvas canvas element
			const rainfallCanvas = document.getElementById('rainfallCanvas');

			// Select the canvas element in the DOM for the rainfall chart
			const rainfallCanvasCtx = rainfallCanvas.getContext('2d');

			// Create the rainfall chart as a line chart
const rainfallChart = new Chart(rainfallCanvasCtx, {
    type: 'line',
    data: {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], // default
        datasets: [{
            label: 'Predicted Rainfall (mm)',
            fill: false,
            backgroundColor: 'rgb(54, 162, 235)',
            borderColor: 'rgb(54, 162, 235)',
            data: [0, 0, 0, 0, 0, 0, 0], // default
            tension: 0.1
        }]
    },
    options: {
        aspectRatio: 1.5,
        layout: {
            padding: {
                top: 0,
                bottom: 0
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Rainfall (mm)'
                }
            },
            x: {
                //
            }
        },
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});
		});

	</script>

</body>
</html>