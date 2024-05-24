<?php include __DIR__.'/config.php'; ?>
<?php

$api_data = getWeatherApi('Hong Kong');
$time_now = date('Y-m-d H:00');
$time_1h = date('Y-m-d H:00', strtotime('+1h'));
$time_2h = date('Y-m-d H:00', strtotime('+2h'));
$time_3h = date('Y-m-d H:00', strtotime('+3h'));
$time_4h = date('Y-m-d H:00', strtotime('+4h'));
$time_5h = date('Y-m-d H:00', strtotime('+5h'));

?>
<!DOCTYPE html>
<html lang="en" dir="ltr" class="page page-homepage">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
	<title>Hong Kong Flood Hub</title>
	<!-- Loading third party fonts -->
	<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
	<!-- Loading main css file -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<!-- font-awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link rel="stylesheet" href="/assets/css/desktop-styles.css">
</head>
<body>

	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'header.php' ?>

		<section id="section-dashboard" class="section section-dashboard">
			<div class="container container-dashboard">
				<div class="columns">
					<div class="sidebar">

						<!-- Suburb Filter -->
						<div class="panel panel-filter">
							<select id="suburbSelect">
								<option value="">Select a location</option>
								<option value="22.247778, 114.151667">Aberdeen</option>
								<option value="22.279636, 114.165487">Admiralty</option>
								<option value="22.241667, 114.155556">Ap Lei Chau</option>
								<option value="22.245833, 114.2475">Big Wave Bay</option>
								<option value="22.286418, 114.206442">Braemar Hill</option>
								<option value="22.28066, 114.18096">Causeway Bay</option>
								<option value="22.281944, 114.158056">Central Chung Wan</option>
								<option value="22.2642,114.2365">Chai Wan</option>
								<option value="22.21728, 114.20467">Chung Hom Kok</option>
								<option value="22.261806, 114.130214">Cyberport</option>
								<option value="22.241661, 114.182619">Deep Water Bay</option>
								<option value="22.2833,114.1500">East Mid-Levels</option>
								<option value="22.28858, 114.19417">Fortress Hill</option>
								<option value="22.266667, 114.183333">Happy Valley</option>
								<option value="22.26827, 114.19244">Jardine's Lookout</option>
								<option value="22.2813,114.1277">Kennedy Town</option>
								<option value="22.2799, 114.1351">Lung Fu Shan</option>
								<option value="22.28262, 114.14261">Mid-Levels</option>
								<option value="22.277028, 114.124789">Mount Davis</option>
								<option value="22.287111, 114.191667">North Point</option>
								<option value="22.260017, 114.137703">Pok Fu Lam</option>
								<option value="22.28313, 114.21279">Quarry Bay</option>
								<option value="22.2366,114.1974">Repulse Bay</option>
								<option value="22.281612, 114.222101">Sai Wan Ho</option>
								<!-- not sure about the coordinates ↓ -->
								<option value="22.285, 114.132">Sai Wan</option>
								<option value="22.28591, 114.14283">Sai Ying Pun</option>
								<option value="22.266667, 114.125667">Sandy Bay</option>
								<option value="22.27945, 114.23022">Shau Kei Wan</option>
								<option value="22.230556, 114.251944">Shek O</option>
								<option value="22.2866,114.1352">Shek Tong Tsui</option>
								<option value="22.28524, 114.15139">Sheung Wan</option>
								<option value="22.2617, 114.2492">Siu Sai Wan</option>
								<option value="22.27414, 114.18937">So Kon Po</option>
								<option value="22.216667, 114.216667">Stanley</option>
								<option value="22.2820,114.1925">Tai Hang</option>
								<option value="22.23789, 114.22368">Tai Tam</option>
								<option value="22.2824,114.1925">Tin Hau</option>
								<option value="22.281944, 114.188056">Victoria Park</option>
								<option value="22.275556, 114.143889">Victoria Peak</option>
								<option value="22.279722, 114.171667">Wan Chai</option>
								<option value="22.2849,114.1458">West Mid-Levels</option>
								<option value="22.24818, 114.16765">Wong Chuk Hang</option>
							</select>
						</div>

						<!-- info -->
						<div class="panel panel-info">
							<h3 class="location-title" id="locationTitle">Select a Suburb</h3>
							<p class="update-time" id="updateTime">Updated: --/--/---- --:--</p>
							<div class="info-details">
								<p><strong>Water Level:</strong> <span id="waterLevel">--</span> m</p>
								<p><strong>Rainfall:</strong> <span id="rainfall">--</span> mm</p>
								<p id="nearestRescuePoint"><strong>Nearest Rescue Point:</strong> --</p>
								<p><strong id="floodingForecast">No Flooding Forecast</strong></p>
							</div>
						</div>

						<!-- forecast -->
						<div class="panel panel-forecast">
							<div class="columns">
								<div class="weather-stripe weather-now">
									<div class="weather-time"><?php echo $api_data && isset($api_data[$time_now], $api_data[$time_now]['time_epoch']) ? date('ga', $api_data[$time_now]['time_epoch']) : 'Now' ; ?></div>
									<img class="weather-img" src="<?php echo $api_data && isset($api_data[$time_now], $api_data[$time_now]['condition'], $api_data[$time_now]['condition']['icon']) ? $api_data[$time_now]['condition']['icon'] : '' ; ?>" alt="-" width="16" height="16">
									<div><span class="weather-temp"><?php echo $api_data && isset($api_data[$time_now], $api_data[$time_now]['temp_c']) ? $api_data[$time_now]['temp_c'] : '-' ; ?></span><sup>o</sup></div>
								</div>
								<div class="weather-stripe weather-1h">
								<div class="weather-time"><?php echo $api_data && isset($api_data[$time_1h], $api_data[$time_1h]['time_epoch']) ? date('ga', $api_data[$time_1h]['time_epoch']) : '1st' ; ?></div>
									<img class="weather-img" src="<?php echo $api_data && isset($api_data[$time_1h], $api_data[$time_1h]['condition'], $api_data[$time_1h]['condition']['icon']) ? $api_data[$time_1h]['condition']['icon'] : '' ; ?>" alt="-" width="16" height="16">
									<div><span class="weather-temp"><?php echo $api_data && isset($api_data[$time_1h], $api_data[$time_1h]['temp_c']) ? $api_data[$time_1h]['temp_c'] : '-' ; ?></span><sup>o</sup></div>
								</div>
								<div class="weather-stripe weather-2h">
								<div class="weather-time"><?php echo $api_data && isset($api_data[$time_2h], $api_data[$time_2h]['time_epoch']) ? date('ga', $api_data[$time_2h]['time_epoch']) : '2nd' ; ?></div>
									<img class="weather-img" src="<?php echo $api_data && isset($api_data[$time_2h], $api_data[$time_2h]['condition'], $api_data[$time_2h]['condition']['icon']) ? $api_data[$time_2h]['condition']['icon'] : '' ; ?>" alt="-" width="16" height="16">
									<div><span class="weather-temp"><?php echo $api_data && isset($api_data[$time_2h], $api_data[$time_2h]['temp_c']) ? $api_data[$time_2h]['temp_c'] : '-' ; ?></span><sup>o</sup></div>
								</div>
								<div class="weather-stripe weather-3h">
								<div class="weather-time"><?php echo $api_data && isset($api_data[$time_3h], $api_data[$time_3h]['time_epoch']) ? date('ga', $api_data[$time_3h]['time_epoch']) : '3rd' ; ?></div>
									<img class="weather-img" src="<?php echo $api_data && isset($api_data[$time_3h], $api_data[$time_3h]['condition'], $api_data[$time_3h]['condition']['icon']) ? $api_data[$time_3h]['condition']['icon'] : '' ; ?>" alt="-" width="16" height="16">
									<div><span class="weather-temp"><?php echo $api_data && isset($api_data[$time_3h], $api_data[$time_3h]['temp_c']) ? $api_data[$time_3h]['temp_c'] : '-' ; ?></span><sup>o</sup></div>
								</div>
								<div class="weather-stripe weather-4h">
								<div class="weather-time"><?php echo $api_data && isset($api_data[$time_4h], $api_data[$time_4h]['time_epoch']) ? date('ga', $api_data[$time_4h]['time_epoch']) : '4th' ; ?></div>
									<img class="weather-img" src="<?php echo $api_data && isset($api_data[$time_4h], $api_data[$time_4h]['condition'], $api_data[$time_4h]['condition']['icon']) ? $api_data[$time_4h]['condition']['icon'] : '' ; ?>" alt="-" width="16" height="16">
									<div><span class="weather-temp"><?php echo $api_data && isset($api_data[$time_4h], $api_data[$time_4h]['temp_c']) ? $api_data[$time_4h]['temp_c'] : '-' ; ?></span><sup>o</sup></div>
								</div>
								<div class="weather-stripe weather-5h">
								<div class="weather-time"><?php echo $api_data && isset($api_data[$time_5h], $api_data[$time_5h]['time_epoch']) ? date('ga', $api_data[$time_5h]['time_epoch']) : '5th' ; ?></div>
									<img class="weather-img" src="<?php echo $api_data && isset($api_data[$time_5h], $api_data[$time_5h]['condition'], $api_data[$time_5h]['condition']['icon']) ? $api_data[$time_5h]['condition']['icon'] : '' ; ?>" alt="-" width="16" height="16">
									<div><span class="weather-temp"><?php echo $api_data && isset($api_data[$time_5h], $api_data[$time_5h]['temp_c']) ? $api_data[$time_5h]['temp_c'] : '-' ; ?></span><sup>o</sup></div>
								</div>
							</div>
						</div>

						<!-- rainfall -->
						<div class="panel panel-rainfall">
							<h6>Rainfall for 7 days</h6>
							<canvas id="rainfallCanvas"></canvas>
						</div>

						<!-- waterfall -->
						<div class="panel panel-waterfall">
							<h6>Wind speed for 7 days</h6>
							<canvas id="waterfallCanvas"></canvas>
						</div>

					</div>
					<div class="map-area">
						<div id="map"></div>
					</div>
				</div>
			</div>
		</section>
	
	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'footer.php' ?>

	<!-- Leaflet JS -->
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

	<!-- Include Chart.js from CDN for Prediction Graph -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- script js -->
	<script src="/assets/js/script.js"></script>

	<script>
		const evacuationDepots = [
    {
        name: "Sheung Shui Ambulance Depot",
        address: "1 Choi Shun Street, Sheung Shui, NT",
        district: "North",
        telephone: "2671 1271",
        latitude: 22.50577944,
        longitude: 114.12012561
    },
    {
        name: "Fanling Ambulance Depot",
        address: "2 Sha Tau Kok Road - Lung Yeuk Tau, Fanling, NT",
        district: "North",
        telephone: "2669 2250",
        latitude: 22.49392829,
        longitude: 114.1399262
    },
    {
        name: "Lau Fau Shan Ambulance Depot",
        address: "101 Tin Shui Road, Tin Shui Wai, NT",
        district: "Yuen Long",
        telephone: "2446 2892",
        latitude: 22.47153307,
        longitude: 114.00240451
    },
    {
        name: "Tai Po Ambulance Depot",
        address: "21 Tai Po Tai Wo Road, Tai Po, NT",
        district: "Tai Po",
        telephone: "2658 0359",
        latitude: 22.45168768,
        longitude: 114.16393382
    },
    {
        name: "Tin Shui Wai Ambulance Depot",
        address: "3 Tin Ho Road, Tin Shui Wai, NT",
        district: "Yuen Long",
        telephone: "2445 0033",
        latitude: 22.45020243,
        longitude: 114.00164429
    },
    {
        name: "Yuen Long Ambulance Depot",
        address: "2 Fung Kam Street, Yuen Long, NT",
        district: "Yuen Long",
        telephone: "2474 6845",
        latitude: 22.44105863,
        longitude: 114.0331498
    },
    {
        name: "Ma On Shan Ambulance Depot",
        address: "1 On Shan Lane, Ma On Shan, NT",
        district: "Sha Tin",
        telephone: "2640 3619",
        latitude: 22.41957509,
        longitude: 114.23312188
    },
    {
        name: "Tuen Mun Ambulance Depot",
        address: "1 Tsun Wen Road, Tuen Mun, NT",
        district: "Tuen Mun",
        telephone: "2463 2125",
        latitude: 22.39546872,
        longitude: 113.97086046
    },
    {
        name: "Shatin Ambulance Depot",
        address: "24 Yuen Wo Road, Shatin, NT",
        district: "SHA TIN",
        telephone: "2691 2514",
        latitude: 22.39099262,
        longitude: 114.20036512
    },
    {
        name: "Castle Peak Bay Ambulance Depot",
        address: "6 Tuen Yee Street, Tuen Mun, NT",
        district: "TUEN MUN",
        telephone: "2451 7170",
        latitude: 22.38298686,
        longitude: 113.96949997
    },
    {
        name: "Sham Tseng Ambulance Depot",
        address: "32 Castle Peak Road - Sham Tseng, Sham Tseng, NT",
        district: "TSUEN WAN",
        telephone: "2496 4917",
        latitude: 22.36770982,
        longitude: 114.06312982
    },
    {
        name: "Tsuen Wan Ambulance Depot",
        address: "47-51 Wai Tsuen Road, Tsuen Wan, NT",
        district: "TSUEN WAN",
        telephone: "2416 2751",
        latitude: 22.37400755,
        longitude: 114.12167445
    },
    {
        name: "Lei Muk Shue Ambulance Depot",
        address: "300A Wo Yi Hop Road, Kwai Chung, NT",
        district: "KWAI TSING",
        telephone: "2487 1957",
        latitude: 22.37477966,
        longitude: 114.13707389
    },
    {
        name: "Tin Sum Ambulance Depot",
        address: "2 Fu Kin Street, Shatin, NT",
        district: "SHA TIN",
        telephone: "2681 0713",
        latitude: 22.36634099,
        longitude: 114.17597142
    },
    {
        name: "Kwai Chung Ambulance Depot",
        address: "86 Hing Shing Road, Kwai Chung, NT",
        district: "KWAI TSING",
        telephone: "2417 5750",
        latitude: 22.35986681,
        longitude: 114.12497129
    },
    {
        name: "Tsing Yi Ambulance Depot",
        address: "30 Chung Mei Road, Tsing Yi, NT",
        district: "KWAI TSING",
        telephone: "2495 5080",
        latitude: 22.35065774,
        longitude: 114.10656809
    },
    {
        name: "Penny's Bay Ambulance Depot",
        address: "8 Long Yan Road, North Lantau Island, NT",
        district: "ISLANDS",
        telephone: "2983 6541",
        latitude: 22.31741852,
        longitude: 114.03960488
    },
    {
        name: "Hong Kong-Zhuhai-Macao Bridge Ambulance Depot",
        address: "10 Shun Ngon Road, Hong Kong-Zhuhai-Macao Bridge Hong Kong Port, NT",
        district: "ISLANDS",
        telephone: "2516 0205",
        latitude: 22.31414301,
        longitude: 113.95605185
    },
    {
        name: "Tung Chung Ambulance Depot",
        address: "3 Shun Tung Road, Tung Chung, Lantau Island",
        district: "ISLANDS",
        telephone: "2988 8282",
        latitude: 22.28526574,
        longitude: 113.94173694
    },
    {
        name: "Lai Chi Kok Ambulance Depot",
        address: "33 Mei Lai Road, Lai Chi Kok, Kowloon",
        district: "SHAM SHUI PO",
        telephone: "2959 1857",
        latitude: 22.33763799,
        longitude: 114.14131678
    },
    {
        name: "Cheung Sha Wan Ambulance Depot",
        address: "7 Fat Tseung Street, Cheung Sha Wan, Kowloon",
        district: "SHAM SHUI PO",
        telephone: "2708 1573",
        latitude: 22.33568076,
        longitude: 114.15487809
    },
    {
        name: "Pak Tin Ambulance Depot",
        address: "G/F, Shui Tin House, Pak Tin Estate, 50 Pak Wan Street, Shek Kip Mei, Kowloon",
        district: "SHAM SHUI PO",
        telephone: "2776 7803",
        latitude: 22.33603423,
        longitude: 114.16868156
    },
    {
        name: "Kowloon Tong Ambulance Depot",
        address: "3 Baptist University Road, Kowloon",
        district: "KOWLOON CITY",
        telephone: "3793 6499",
        latitude: 22.33468878,
        longitude: 114.18263063
    },
    {
        name: "Wong Tai Sin Ambulance Depot",
        address: "5 Ying Fung Lane, Wong Tai Sin, Kowloon",
        district: "WONG TAI SIN",
        telephone: "2323 9949",
        latitude: 22.34261646,
        longitude: 114.19701759
    },
    {
        name: "Mongkok Ambulance Depot",
        address: "42 Tai Kok Tsui Road, Kowloon",
        district: "YAU TSIM MONG",
        telephone: "2117 6570",
        latitude: 22.32019413,
        longitude: 114.16223768
    },
    {
        name: "Ma Tau Chung Ambulance Depot",
        address: "53 Shing Tak Street, Ma Tau Wai, Kowloon",
        district: "KOWLOON CITY",
        telephone: "2714 3746",
        latitude: 22.32465552,
        longitude: 114.18793958
    },
    {
        name: "Yau Ma Tei Ambulance Depot",
        address: "44 Waterloo Road, Yau Ma Tei, Kowloon",
        district: "YAU TSIM MONG",
        telephone: "2770 2547",
        latitude: 22.31292507,
        longitude: 114.17146838
    },
    {
        name: "Ho Man Tin Ambulance Depot",
        address: "88 Chung Hau Street, Ho Man Tin, Kowloon",
        district: "KOWLOON CITY",
        telephone: "2624 6110",
        latitude: 22.31452355,
        longitude: 114.17958223
    },
    {
        name: "Tsim Tung Ambulance Depot",
        address: "5-7 Hong Tat Path, Tsim Sha Tsui East, Kowloon",
        district: "YAU TSIM MONG",
        telephone: "2311 5111",
        latitude: 22.30170009,
        longitude: 114.17923261
    },
    {
        name: "Ngau Tau Kok Ambulance Depot",
        address: "9 Siu Yip Street, Ngau Tau Kok, Kowloon",
        district: "KWUN TONG",
        telephone: "2750 1710",
        latitude: 22.32010062,
        longitude: 114.21224309
    },
    {
        name: "Po Lam Ambulance Depot",
        address: "17 Po Lam Road North, NT",
        district: "SAI KUNG",
        telephone: "2701 0955",
        latitude: 22.3271031,
        longitude: 114.2535363
    },
    {
        name: "Lam Tin Ambulance Depot",
        address: "30 Lei Yue Mun Road, Kowloon",
        district: "KWUN TONG",
        telephone: "2952 3861",
        latitude: 22.30353158,
        longitude: 114.23595761
    },
    {
        name: "Tai Chik Sha Ambulance Depot",
        address: "321 Wan Po Road, Tseung Kwan O, NT",
        district: "SAI KUNG",
        telephone: "2623 9232",
        latitude: 22.28979547,
        longitude: 114.27448609
    },
    {
        name: "Mount Davis Ambulance Depot",
        address: "2 Lung Wah Street, Kennedy Town, Hong Kong",
        district: "CENTRAL AND WESTERN",
        telephone: "2819 7967",
        latitude: 22.27950484,
        longitude: 114.12905692
    },
    {
        name: "Pok Fu Lam Ambulance Depot",
        address: "789 Pok Fu Lam Road, Hong Kong",
        district: "SOUTHERN",
        telephone: "2551 6000",
        latitude: 22.25315594,
        longitude: 114.13867994
    },
    {
        name: "Braemar Hill Ambulance Depot",
        address: "170 Tin Hau Temple Road, North Point, Hong Kong",
        district: "EASTERN",
        telephone: "2571 5293",
        latitude: 22.28813421,
        longitude: 114.2017064
    },
    {
        name: "Sai Wan Ho Ambulance Depot",
        address: "22 Wai Hang Street, Sai Wan Ho, Hong Kong",
        district: "EASTERN",
        telephone: "2569 7627",
        latitude: 22.28285655,
        longitude: 114.21975387
    },
    {
        name: "Chai Wan Ambulance Depot",
        address: "401-404 Chin Hing Hse, Hing Wah Estate, Chai Wan, Hong Kong",
        district: "EASTERN",
        telephone: "2556 6490",
        latitude: 22.26247927,
        longitude: 114.2333305
    },
    {
    name: "Pok Fu Lam Ambulance Depot",
    address: "789 Pok Fu Lam Road, Hong Kong",
    district: "SOUTHERN",
    telephone: "2551 6000",
    latitude: 22.25315594,
    longitude: 114.13867994
    }
	
];
var evacuationIcon = L.icon({
    iconUrl: '/assets/icons/evacuate-icon.png',
    iconSize: [38, 38], // size of the icon
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76]
});
		// Initialize the prediction graph after the DOM has fully loaded
		document.addEventListener('DOMContentLoaded', function () {

			var rescueMarkers = [];

			function getNearestRescuePoint(currentLat, currentLng, points) {
				console.log("Function called with:", currentLat, currentLng, points.length);
				let nearestPoint = null;
				let smallestDistance = Infinity;
				points.forEach(point => {
				const distance = Math.sqrt((point.latitude - currentLat) ** 2 + (point.longitude - currentLng) ** 2);
				console.log("Checking point:", point.name, "Distance:", distance); 
				if (distance < smallestDistance) {
					smallestDistance = distance;
					nearestPoint = point;
				}
				});
				console.log("Nearest point:", nearestPoint ? nearestPoint.name : "None found");
				return nearestPoint;
			}

			function updateMap2(value) {

				if (!value) return; // Do nothing if the value is empty

				// Remove previous marker if any
				if (window.marker) {
					window.marker.remove();
				}

				// value to position lat, lng data
				var [lat, lng] = value.split(',').map(Number);

				// Update the map view to the selected suburb
				map.setView([lat, lng], 13, { keepInView: true });

				// Add new marker and open the popup
				window.marker = L.marker([lat, lng]).addTo(map)
					.bindPopup(`Suburb: ${document.getElementById('suburbSelect').selectedOptions[0].text}`)
					.openPopup();
			}

			function updateMap(value) {
				if (!value) return;

				var [lat, lng] = value.split(',').map(Number);
				map.setView([lat, lng], 13);

				if (window.marker) {
					window.marker.remove();
				}

				window.marker = L.marker([lat, lng]).addTo(map)
					.bindPopup(`Suburb: ${document.getElementById('suburbSelect').selectedOptions[0].text}`)
					.openPopup();

				rescueMarkers.forEach(marker => map.removeLayer(marker));
				rescueMarkers = [];

				const nearestDepot = getNearestRescuePoint(lat, lng, evacuationDepots);
				console.log("Nearest depot found:", nearestDepot);

				const suburbName = document.getElementById('suburbSelect').selectedOptions[0].text;
				if (nearestDepot) {
					console.log("Calling updateInfoBox with:", suburbName, nearestDepot.name);
					let marker = L.marker([nearestDepot.latitude, nearestDepot.longitude], {
						icon: L.icon({ iconUrl: '/assets/icons/evacuate-icon.png', iconSize: [25, 25] })
					}).addTo(map)
					.bindPopup(`Nearest Rescue Point: ${nearestDepot.name}<br>Address: ${nearestDepot.address}`);

					rescueMarkers.push(marker);

					updateInfoBox(suburbName, nearestDepot.name);
				} else {
					updateInfoBox(suburbName, "No nearest rescue point available");
				}
			}


			function updateForecast(location) {

				// Function to convert timestamp to 12-hour format
				var timestampTo12HourFormat = function (timestamp) {
					const date = new Date(timestamp*1000);
					let hours = date.getHours();
					const ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12 || 12; // Convert midnight (0) to 12
					return `${hours}${ampm}`;
				};

				// get hongkong time now
				var getHongKongTime = function(addHour){

					// Function to pad zero for single digits
					var padZero = function (num) {
						return (num < 10 ? '0' : '') + num;
					};

					const now = new Date();
					now.setHours( now.getHours() + (addHour||0) );

					// Convert the current time to Hong Kong time
					const hongKongTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Hong_Kong' }));

					// Format the result as "YYYY-MM-DD HH:mm"
					return `${hongKongTime.getFullYear()}-${padZero(hongKongTime.getMonth() + 1)}-${padZero(hongKongTime.getDate())} ${padZero(hongKongTime.getHours())}:00`;

				};

				var forecast_columns = document.querySelector('#section-dashboard .panel.panel-forecast .columns');
				forecast_columns.classList.add('loading');

				// retrieve api data for the location
				fetch('/weatherapi.php?q='+ encodeURI(location), {
					"method": 'GET',
					"cache": "no-cache",
					"headers": {
						"Content-Type": "application/json",
					}
				})
				.then( function(response){ return response.json(); })
				.then(function(d){
					if( d ){
						forecast_columns.classList.remove('loading');
						var time_now = getHongKongTime(0); console.log( time_now );
						if( d[time_now] ){
							forecast_columns.querySelector('.weather-now .weather-time').innerText = 'Now';
							forecast_columns.querySelector('.weather-now .weather-img').src = d[ time_now ]['condition']['icon'];
							forecast_columns.querySelector('.weather-now .weather-temp').innerText = d[ time_now ].temp_c;
						}

						var time_1h = getHongKongTime(1); console.log( time_1h );
						if( d[time_1h] ){
							forecast_columns.querySelector('.weather-1h .weather-time').innerText = timestampTo12HourFormat( d[time_1h]['time_epoch'] );
							forecast_columns.querySelector('.weather-1h .weather-img').src = d[time_1h]['condition']['icon'];
							forecast_columns.querySelector('.weather-1h .weather-temp').innerText = d[time_1h].temp_c;
						}

						var time_2h = getHongKongTime(2);
						if( d[time_2h] ){
							forecast_columns.querySelector('.weather-2h .weather-time').innerText = timestampTo12HourFormat( d[time_2h]['time_epoch'] );
							forecast_columns.querySelector('.weather-2h .weather-img').src = d[time_2h]['condition']['icon'];
							forecast_columns.querySelector('.weather-2h .weather-temp').innerText = d[time_2h].temp_c;
						}

						var time_3h = getHongKongTime(3);
						if( d[time_3h] ){
							forecast_columns.querySelector('.weather-3h .weather-time').innerText = timestampTo12HourFormat( d[time_3h]['time_epoch'] );
							forecast_columns.querySelector('.weather-3h .weather-img').src = d[time_3h]['condition']['icon'];
							forecast_columns.querySelector('.weather-3h .weather-temp').innerText = d[time_3h].temp_c;
						}

						var time_4h = getHongKongTime(4);
						if( d[time_4h] ){
							forecast_columns.querySelector('.weather-4h .weather-time').innerText = timestampTo12HourFormat( d[time_4h]['time_epoch'] );
							forecast_columns.querySelector('.weather-4h .weather-img').src = d[time_4h]['condition']['icon'];
							forecast_columns.querySelector('.weather-4h .weather-temp').innerText = d[time_4h].temp_c;
						}

						var time_5h = getHongKongTime(5);
						if( d[time_5h] ){
							forecast_columns.querySelector('.weather-5h .weather-time').innerText = timestampTo12HourFormat( d[time_5h]['time_epoch'] );
							forecast_columns.querySelector('.weather-5h .weather-img').src = d[time_5h]['condition']['icon'];
							forecast_columns.querySelector('.weather-5h .weather-temp').innerText = d[time_5h].temp_c;
						}
					}
				})
				.catch(function(error){ console.error('Error fetching JSON:', error); });
				
			}

			function updateInfoBox(suburb, nearestRescuePointName) {
				// retrieve data for flood prediction
				fetch("http://127.0.0.1:8000/flood_prediction_current_date/" + encodeURIComponent(suburb.toString().toLowerCase()), {
					"method": 'GET',
					"cache": "no-cache",
					"headers": {
						"Content-Type": "application/text",
					}
				})
				.then( function(response){ return response.json(); })
				.then(function(d){ 
					// Adjust the flooding forecast message as necessary
					document.getElementById('floodingForecast').textContent = d.result; 
				})
				.catch(function(error){ console.error('Error fetching JSON:', error); });

				// Check if the selected suburb's data exists
				if (suburbData && suburbData[suburb]) {
					// Update the information box with the new data
					document.getElementById('locationTitle').textContent = suburb;
					document.getElementById('updateTime').textContent = `Updated: ${ ( new Date(suburbData[suburb].updated) ).toLocaleString() }`;
					document.getElementById('waterLevel').textContent = `${suburbData[suburb].waterLevel} m`;
					document.getElementById('rainfall').textContent = `${suburbData[suburb].rainfall} mm`;
					
					if (nearestRescuePointName) {
						console.log("Setting nearestRescuePointName to:", nearestRescuePointName);
						document.getElementById('nearestRescuePoint').textContent = nearestRescuePointName;
					} else {
						console.error("nearestRescuePointName is undefined!");
						document.getElementById('nearestRescuePoint').textContent = "No nearest rescue point available";
					}

				
				} else {
					// Reset the information box if the suburb's data doesn't exist
					document.getElementById('locationTitle').textContent = 'Select a Suburb';
					document.getElementById('updateTime').textContent = 'Updated: --/--/---- --:--';
					document.getElementById('waterLevel').textContent = '-- m';
					document.getElementById('rainfall').textContent = '-- mm';
					document.getElementById('nearestRescuePoint').textContent = 'No nearest rescue point available';
					document.getElementById('floodingForecast').textContent = '';
				}
			}

			function updateWaterLevel(suburb) {
				// retrieve data for flood prediction
				fetch("http://127.0.0.1:8000/general_weather_forcast/" + encodeURIComponent(suburb.toString().toLowerCase()), {
					"method": 'GET',
					"cache": "no-cache",
					"headers": {
						"Content-Type": "application/json",
					}
				})
				.then( function(response){ return response.json(); })
				.then(function(d){ 
					waterfallChart.data.labels = d.date.slice(1,8)
					waterfallChart.data.datasets[0].data = d.wind_speed_max.slice(1,8);					
					waterfallChart.update();
				})
				.catch(function(error){ console.error('Error fetching JSON:', error); });

				// Check if suburbData exists
				if (suburbData) {
					// Check if suburb exists in suburbData
					if (suburbData[suburb]) {
						waterfallCanvas.style.visibility = 'visible';
					} else {
						waterfallCanvas.style.visibility = 'hidden';
					}
				}else{
					waterfallCanvas.style.visibility = 'hidden';
				}
			}
			
			function updateRainfall(suburb) {
				// retrieve data for flood prediction
				fetch("http://127.0.0.1:8000/general_weather_forcast/" + encodeURIComponent(suburb.toString().toLowerCase()), {
					"method": 'GET',
					"cache": "no-cache",
					"headers": {
						"Content-Type": "application/json",
					}
				})
				.then( function(response){ return response.json(); })
				.then(function(d){ 
					rainfallChart.data.labels = d.date.slice(1,8)
					rainfallChart.data.datasets[0].data = d.rain_sum.slice(1,8);					
					rainfallChart.update();
				})
				.catch(function(error){ console.error('Error fetching JSON:', error); });

				// Check if suburbData exists
				if (suburbData) {
					// Check if suburb exists in suburbData
					if (suburbData[suburb]) {
						rainfallCanvas.style.visibility = 'visible';
					} else {
						rainfallCanvas.style.visibility = 'hidden';
					}
				}else{
					rainfallCanvas.style.visibility = 'hidden';
				}
			}

			var suburbData, // suburb data for the dashboard
				map = L.map('map').setView([22.3193, 114.1694], 13);

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
				maxZoom: 18
			}).addTo(map);

			// Initialize a global marker variable
			window.marker = L.marker([22.3193, 114.1694]).addTo(map)
				.bindPopup('Central and Western District').openPopup();

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
				updateMap(this.value);
				updateForecast(this.value);
				var selectedSuburb = this.selectedOptions[0].text;
				//updateInfoBox(selectedSuburb);
				updateWaterLevel(selectedSuburb);
				updateRainfall(selectedSuburb);
			});

			// waterfallCanvas canvas element
			const waterfallCanvas = document.getElementById('waterfallCanvas');
			
			//  2d context of waterfallCanvas
			var ctx = waterfallCanvas.getContext('2d');

			var waterfallChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
					datasets: [
						{
							label: 'Wind Speed (km/h)',
							backgroundColor: 'rgb(0, 123, 255)',
							borderColor: 'rgb(0, 123, 255)',
							data: [0, 0, 0, 0, 0, 0, 0],
							fill: false,
							pointRadius: 3,
							tension: 0.3
						}
					]
				},
				options: {
					aspectRatio: 1.3,
					layout: {
						padding: {
							top: 0,
							bottom: 0
						}
					},
					scales: {
						y: {
							beginAtZero: false,
							suggestedMax: 60,
							title: {
								display: true,
								text: 'Wind Speed'
							}
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
			var rainfallChart = new Chart(rainfallCanvasCtx, {
				type: 'line',
				data: {
					labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
					datasets: [{
						label: 'Rainfall (mm)',
						fill: false,
						backgroundColor: 'rgb(54, 162, 235)',
						borderColor: 'rgb(54, 162, 235)',
						data: [0, 0, 0, 0, 0, 0, 0], // Replace with actual data
						tension: 0.1 // Make it a bit curved
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
							// Adjust the x-axis settings if needed
						}
					},
					responsive: true,
					maintainAspectRatio: true, //maintain the aspect ratio based on the aspectRatio option
					plugins: {
						legend: {
							display: true, // Set to false to hide, true to show the legend
							position: 'top'
						}
					}
				}
			});

		});

	</script>

</body>
</html>