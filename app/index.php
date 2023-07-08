<?php
$filescontentarray = [];
$imgcontentarray = [];
foreach (glob("*.geojson") as $filename) {
	$file = file_get_contents("./" . $filename);
	array_push($filescontentarray, $file);
}

foreach (glob("*.{jpg,JPG,png,jpeg,JPEG,PNG,GIF,gif}", GLOB_BRACE) as $filename) {
	$exif = @exif_read_data('./' . $filename, 0, true);
	array_push($imgcontentarray, $exif);
}

$buildings = file_get_contents("./3DBuildings_edited/edited3Dbuildings.geojson");

?>


<!DOCTYPE html>
<html>

<head>
	<meta charset=utf-8 />
	<title>Buildings History</title>
	<link rel="shortcut icon" href="images/png/page-title.png">
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />


	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.js'></script>
	<link href='https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.css' rel='stylesheet' />

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

	<link rel="stylesheet" href="https://unpkg.com/leaflet-geotag-photo/dist/Leaflet.GeotagPhoto.css" />
	<script src="https://unpkg.com/leaflet-geotag-photo/dist/Leaflet.GeotagPhoto.min.js"></script>

	<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>

	<script src="https://cdn.jsdelivr.net/gh/jscastro76/threebox@v.2.2.1/dist/threebox.min.js" type="text/javascript"></script>
	<link href="https://cdn.jsdelivr.net/gh/jscastro76/threebox@v.2.2.1/dist/threebox.css" rel="stylesheet" />

	<script src="hhttps://labs.os.uk/public/os-api-branding/v0.2.0/os-api-branding.js"></script>
	<link rel="stylesheet" href="https://labs.os.uk/public/os-api-branding/v0.2.0/os-api-branding.css" />

	<link href="https://cdn.osmbuildings.org/4.1.1/OSMBuildings.css" rel="stylesheet">

	<script src="https://cdn.osmbuildings.org/4.1.1/OSMBuildings.js"></script>

	<script src="https://unpkg.com/deck.gl@latest/dist.min.js"></script>
	<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.js'></script>
	<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.3.0/mapbox-gl-draw.css' type='text/css' />


	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	<style>
		body {
			margin: 0;
			padding: 0;
		}

		#map {
			position: absolute;
			top: 0;
			bottom: 0;
			width: 100%;
		}

		.dropbtn {
			background-color: #04AA6D;
			color: white;
			padding: 16px;
			font-size: 16px;
			border: none;
		}

		.dropdown {
			position: relative;
			display: inline-block;
		}

		.dropdown-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
			z-index: 1;
		}

		.dropdown-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}

		.dropdown-content a:hover {
			background-color: #ddd;
		}

		.dropdown:hover .dropdown-content {
			display: block;
		}

		.dropdown:hover .dropbtn {
			background-color: #3e8e41;
		}


		@keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@-moz-keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@-webkit-keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@-o-keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@-moz-keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@-webkit-keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@-o-keyframes rotate-loading {
			0% {
				transform: rotate(0deg);
				-ms-transform: rotate(0deg);
				-webkit-transform: rotate(0deg);
				-o-transform: rotate(0deg);
				-moz-transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
				-ms-transform: rotate(360deg);
				-webkit-transform: rotate(360deg);
				-o-transform: rotate(360deg);
				-moz-transform: rotate(360deg);
			}
		}

		@keyframes loading-text-opacity {
			0% {
				opacity: 0
			}

			20% {
				opacity: 0
			}

			50% {
				opacity: 1
			}

			100% {
				opacity: 0
			}
		}

		@-moz-keyframes loading-text-opacity {
			0% {
				opacity: 0
			}

			20% {
				opacity: 0
			}

			50% {
				opacity: 1
			}

			100% {
				opacity: 0
			}
		}

		@-webkit-keyframes loading-text-opacity {
			0% {
				opacity: 0
			}

			20% {
				opacity: 0
			}

			50% {
				opacity: 1
			}

			100% {
				opacity: 0
			}
		}

		@-o-keyframes loading-text-opacity {
			0% {
				opacity: 0
			}

			20% {
				opacity: 0
			}

			50% {
				opacity: 1
			}

			100% {
				opacity: 0
			}
		}

		.loading-container,
		.loading {
			height: 100px;
			position: relative;
			width: 100px;
			border-radius: 100%;
		}


		.loading-container {
			margin: 40px auto
		}

		.loading {
			border: 2px solid transparent;
			border-color: transparent #fff transparent #FFF;
			-moz-animation: rotate-loading 1.5s linear 0s infinite normal;
			-moz-transform-origin: 50% 50%;
			-o-animation: rotate-loading 1.5s linear 0s infinite normal;
			-o-transform-origin: 50% 50%;
			-webkit-animation: rotate-loading 1.5s linear 0s infinite normal;
			-webkit-transform-origin: 50% 50%;
			animation: rotate-loading 1.5s linear 0s infinite normal;
			transform-origin: 50% 50%;
		}

		.loading-container:hover .loading {
			border-color: transparent #E45635 transparent #E45635;
		}

		.loading-container:hover .loading,
		.loading-container .loading {
			-webkit-transition: all 0.5s ease-in-out;
			-moz-transition: all 0.5s ease-in-out;
			-ms-transition: all 0.5s ease-in-out;
			-o-transition: all 0.5s ease-in-out;
			transition: all 0.5s ease-in-out;
		}

		#loading-text {
			-moz-animation: loading-text-opacity 2s linear 0s infinite normal;
			-o-animation: loading-text-opacity 2s linear 0s infinite normal;
			-webkit-animation: loading-text-opacity 2s linear 0s infinite normal;
			animation: loading-text-opacity 2s linear 0s infinite normal;
			color: #ffffff;
			font-family: "Helvetica Neue, " Helvetica", " "arial";
			font-size: 10px;
			font-weight: bold;
			margin-top: 45px;
			opacity: 0;
			position: absolute;
			text-align: center;
			text-transform: uppercase;
			top: 0;
			width: 100px;
		}

		.info {
			position: absolute;
			font-family: sans-serif;
			padding: 5px;
			width: 40%;
			font-size: 14px;
			border-radius: 3px;
			z-index: 3;
		}
	</style>
</head>

<body>

	<div id="loading-map" style="position: absolute; width:100%; height:100%; background-color:#43242485; z-index:9999; display: flex;align-items: center;align-content: center;justify-content: center;">
		<div class="loading-container" style="z-index:9999999;">
			<div class="loading"></div>
			<div id="loading-text">Loading...</div>
		</div>
	</div>

	<div class="info">
		<div id='insideinfo' class="w3-panel w3-display-container" style="background-color: rgba(78, 147, 144, 0.56); color:white; display:none">
			<p>- Click on building blue polygon to edit it.<br>- Click again to edit/add vertices.</p>
			<div style="display:flex; flex-direction: row; justify-content: space-between;">
			<button id="savebutton" class="w3-btn w3-round-large w3-teal">Save</button> 
			<button id="uploadbutton" class="w3-btn w3-round-large w3-teal">Upload</button> 
			<button id="discardbutton" class="w3-btn w3-round-large w3-teal">Discard</button> </div>
		</div>
	</div>

	<div id='map'></div>

	<script>
		var geojson3dbuildings = <?php echo json_encode($buildings); ?>;
		var parsed3dbuildings = JSON.parse(geojson3dbuildings);

		$('.info').css('top', '0');
		$('.info').css('left', '30%');

		var draw = new MapboxDraw({
			displayControlsDefault: false
		});

		const apiKey = 'wCujufkC5D7bjVRTf5goHOSQSu8lLAbT';
		mapboxgl.accessToken = 'pk.eyJ1Ijoibm91ZmVsZ2hheWF0aSIsImEiOiJja3lmNWwwemEwOXNuMnhxcm9qNDF2ZXRhIn0.n0EDO6c611aAGh4r9-FwSg';
		var map = new mapboxgl.Map({
			container: 'map',
			style: 'https://api.os.uk/maps/vector/v1/vts/resources/styles?key=' + apiKey,
			center: [-0.098136, 51.513813],
			zoom: 16.5,
			maxPitch: 85,
			pitch: 37,
			bearing: -63.4,
			hash: true,
			antialias: true,
			maxZoom: 21,
			transformRequest: (url, resourceType) => {
				if (resourceType !== 'Image' && !url.includes('google') && !url.includes('openstreet') && !url.includes('opentopo') && !url.includes('osmbuildings') && !url.includes('edited3Dbuildings')) {
					return {
						url: url + '&srs=3857'
					}
				}
			}
		});
		localStorage.setItem('name', 'ejioforched');
		localStorage.getItem('name');

		sessionStorage.setItem('map', 'maptiler');

		const popup = new mapboxgl.Popup({
			closeButton: false,
			closeOnClick: false,
			maxWidth: '500px'
		});

		const popup1 = new mapboxgl.Popup({
			closeButton: false,
			closeOnClick: true,
			maxWidth: '500px'
		});


		map.on('load', async () => {

			$('.mapboxgl-ctrl-top-left').append(`
<div class="mapboxgl-ctrl mapboxgl-ctrl-group">

<div class="dropdown">
  <button class="dropbtn" style="width: 60px; font-size: 12px;background-color: #337795;">Base Map</button>
  <div class="dropdown-content">
  <div id="menu" style="display: flex;flex-direction: column;justify-content: center;align-items: flex-start;">

<div style="display: flex;flex-direction: row;justify-content: center;align-items: flex-start;">
<input id="os" type="radio" name="rtoggle" value="os" checked="checked" onClick="javascript:map.setLayoutProperty('googlehybrid', 'visibility', 'none'); map.setLayoutProperty('googlesatellite', 'visibility', 'none'); map.setLayoutProperty('osmstreet', 'visibility', 'none');">
<label for="os">Ordnance Survey</label>
</div>

<div style="display: flex;flex-direction: row;justify-content: center;align-items: flex-start;">
<input id="osmstreet" type="radio" name="rtoggle" value="osmstreet" onClick="javascript:map.setLayoutProperty('googlehybrid', 'visibility', 'none'); map.setLayoutProperty('googlesatellite', 'visibility', 'none'); map.setLayoutProperty('osmstreet', 'visibility', 'visible');">
<label for="osmstreet">OpenStreetMap Street</label>
</div>

<div style="display: flex;flex-direction: row;justify-content: center;align-items: flex-start;">
<input id="satellite" type="radio" name="rtoggle" value="satellite" onClick="javascript:map.setLayoutProperty('googlehybrid', 'visibility', 'none'); map.setLayoutProperty('googlesatellite', 'visibility', 'visible'); map.setLayoutProperty('osmstreet', 'visibility', 'none');">
<label for="satellite">Google Satellite</label>
</div>

<div style="display: flex;flex-direction: row;justify-content: center;align-items: flex-start;">
<input id="hybrid" type="radio" name="rtoggle" value="hybrid" onClick="javascript:map.setLayoutProperty('googlehybrid', 'visibility', 'visible'); map.setLayoutProperty('googlesatellite', 'visibility', 'none'); map.setLayoutProperty('osmstreet', 'visibility', 'none');">
<label for="hybrid">Google Hybrid</label>
</div>

</div>
  </div>
</div>


</div>
`);

			map.setFog({
				'color': 'rgb(255, 255, 255)',
				'high-color': 'rgb(55, 187, 232)',
				'horizon-blend': 0.2
			});

			map.addLayer({
				'id': 'googlehybrid',
				'type': 'raster',
				'source': {
					'type': 'raster',
					'tiles': [
						'https://mt1.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}'
					],
					'tileSize': 128,
					'layout': {
						'visibility': 'none'
					}
				}
			});
			map.addLayer({
				'id': 'googlesatellite',
				'type': 'raster',
				'source': {
					'type': 'raster',
					'tiles': [
						'https://mt1.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}'
					],
					'tileSize': 128,
					'layout': {
						'visibility': 'none'
					}
				}
			});
			map.addLayer({
				'id': 'osmstreet',
				'type': 'raster',
				'source': {
					'type': 'raster',
					'tiles': [
						'https://a.tile.openstreetmap.org/{z}/{x}/{y}.png'
					],
					'tileSize': 128,
					'layout': {
						'visibility': 'none'
					}
				}
			});

			map.setLayoutProperty('googlehybrid', 'visibility', 'none');
			map.setLayoutProperty('googlesatellite', 'visibility', 'none');
			map.setLayoutProperty('osmstreet', 'visibility', 'none');

			map.addLayer({
				"id": "OS/TopographicArea_2/Building/1_3D",
				"type": "fill-extrusion",
				"source": "esri",
				"source-layer": "TopographicArea_2",
				"filter": ["==", "_symbol", 4],
				"minzoom": 15,
				"layout": {
					"visibility": "visible"
				},
				"paint": {
					"fill-extrusion-color": "#DCD7C6",
					"fill-extrusion-height": [
						"interpolate",
						["linear"],
						["zoom"],
						15,
						0,
						15.05,
						["get", "RelHMax"]
					],
					"fill-extrusion-opacity": [
						"interpolate",
						["linear"],
						["zoom"],
						15,
						0,
						16,
						0.9
					]
				},
				'filter': ["all", ["!=", "TOID", "test"]]
			});

			map.addLayer({
				"id": "OS/TopographicArea_2/Building/1_3D_high",
				"type": "fill-extrusion",
				"source": "esri",
				"source-layer": "TopographicArea_2",
				"filter": ["==", "_symbol", 4],
				"minzoom": 15,
				"layout": {
					"visibility": "visible"
				},
				"paint": {
					"fill-extrusion-color": "#993a3a",
					"fill-extrusion-height": [
						"interpolate",
						["linear"],
						["zoom"],
						15,
						0,
						15.05,
						["get", "RelHMax"]
					],
					"fill-extrusion-opacity": [
						"interpolate",
						["linear"],
						["zoom"],
						15,
						0,
						16,
						0.9
					]
				},
				'filter': ['in', 'TOID', '']
			});


			var filterbuildings = ["all", ["!=", "TOID", "test"]];

			for (let i = 0; i < (parsed3dbuildings.features).length; i++) {
				filterbuildings.push(["!=", "TOID", parsed3dbuildings.features[i].properties.TOID]);
				parsed3dbuildings.features[i].properties.RelHMax = parseFloat(parsed3dbuildings.features[i].properties.RelHMax);
			}

			map.setFilter('OS/TopographicArea_2/Building/1_3D', filterbuildings);

			map.addSource('new3Dbuildings', {
				type: 'geojson',
				data: parsed3dbuildings
			});

			map.addLayer({
				"id": "new3Dbuildings",
				"type": "fill-extrusion",
				"source": "new3Dbuildings",
				"minzoom": 15,
				"layout": {
					"visibility": "visible"
				},
				"paint": {
					"fill-extrusion-color": "#3ec4b9",
					"fill-extrusion-height": [
						"interpolate",
						["linear"],
						["zoom"],
						15,
						0,
						15.05,
						["get", "RelHMax"]
					],
					"fill-extrusion-opacity": [
						"interpolate",
						["linear"],
						["zoom"],
						15,
						0,
						16,
						0.9
					]
				}
			});

			map.on('click', 'OS/TopographicArea_2/Building/1_3D', (e) => {

				map.setFilter('OS/TopographicArea_2/Building/1_3D_high', ['in', 'TOID', e.features[0].properties.TOID]);
				draw.deleteAll();
				map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D', 'visibility', 'none');
				map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D_high', 'visibility', 'none');
				draw.add(e.features[0]);

				// console.log(e.features[0])


				$('#insideinfo').css('display', 'block');

				$('#discardbutton').click(function() {
					$('#insideinfo').css('display', 'none');
					draw.deleteAll();
					map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D', 'visibility', 'visible');
					map.setFilter('OS/TopographicArea_2/Building/1_3D_high', ['in', 'TOID', '']);
					map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D_high', 'visibility', 'visible');
				});

				$('#savebutton').click(async function() {
					$('#insideinfo').css('display', 'none');
					(parsed3dbuildings.features).push(draw.getAll().features[0]);

					const feature = draw.getAll();

					// $.post('./3DBuildings_edited/edit.php', {
					// 	data: parsed3dbuildings
					// });

					map.getSource('new3Dbuildings').setData(parsed3dbuildings);
					filterbuildings.push(["!=", "TOID", draw.getAll().features[0].properties.TOID]);
					map.setFilter('OS/TopographicArea_2/Building/1_3D', filterbuildings);
					map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D', 'visibility', 'visible');
					map.setFilter('OS/TopographicArea_2/Building/1_3D_high', ['in', 'TOID', '']);
					map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D_high', 'visibility', 'visible');
					draw.deleteAll();

					console.log("-------");
					console.log(feature)
					try {
						const myHeaders = new Headers();
						myHeaders.append("Content-Type", "application/json");
						const raw = JSON.stringify({
							"osid": feature.features[0].id,
							"toid": feature.features[0].properties.TOID,
							"symbol": feature.features[0].properties._symbol,
							"height_max": feature.features[0].properties.RelHMax,
							"geom": feature.features[0].geometry
						});
						const requestOptions = {
							method: 'POST',
							headers: myHeaders,
							body: raw,
						};
						const response = await fetch('http://127.0.0.1:8000/api/v1/geo', requestOptions)
						const data = await response.json();
						console.log(data);
					} catch (error) {
						console.log(error);
					}
				});

				$('#uploadbutton').click(async function() {
					$('#insideinfo').css('display', 'none');
					(parsed3dbuildings.features).push(draw.getAll().features[0]);

					const feature = draw.getAll();

					// $.post('./3DBuildings_edited/edit.php', {
					// 	data: parsed3dbuildings
					// });

					map.getSource('new3Dbuildings').setData(parsed3dbuildings);
					filterbuildings.push(["!=", "TOID", draw.getAll().features[0].properties.TOID]);
					map.setFilter('OS/TopographicArea_2/Building/1_3D', filterbuildings);
					map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D', 'visibility', 'visible');
					map.setFilter('OS/TopographicArea_2/Building/1_3D_high', ['in', 'TOID', '']);
					map.setLayoutProperty('OS/TopographicArea_2/Building/1_3D_high', 'visibility', 'visible');
					draw.deleteAll();

					console.log("-------");
					console.log(feature)
					try {
						const myHeaders = new Headers();
						myHeaders.append("Content-Type", "application/json");
						const raw = JSON.stringify({
							"osid": feature.features[0].id,
							"toid": feature.features[0].properties.TOID,
							"symbol": feature.features[0].properties._symbol,
							"height_max": feature.features[0].properties.RelHMax,
							"geom": feature.features[0].geometry
						});
						const requestOptions = {
							method: 'POST',
							headers: myHeaders,
							body: raw,
						};
						const response = await fetch('http://127.0.0.1:8000/api/v1/geo/upload', requestOptions)
						const data = await response.json();
						console.log(data);
					} catch (error) {
						console.log(error);
					}
				});

			});

			map.addControl(new mapboxgl.GeolocateControl({
				positionOptions: {
					enableHighAccuracy: true
				},
				trackUserLocation: true,
				showUserHeading: true
			}), 'top-right');
			map.addControl(new mapboxgl.NavigationControl(), 'top-right');


			map.addControl(draw);

			var geojsoncontents = <?php echo json_encode($filescontentarray); ?>;
			var imgcontents = <?php echo json_encode($imgcontentarray); ?>;
			console.log(geojsoncontents, imgcontents)


			var pointsdata = {
				'type': 'FeatureCollection',
				'features': []
			}

			var fieldview = {
				'type': 'FeatureCollection',
				'features': []
			}

			var polygondata = {
				'type': 'FeatureCollection',
				'features': []
			}

			var linesdata = {
				'type': 'FeatureCollection',
				'features': []
			}

			for (let i = 0; i < geojsoncontents.length; i++) {
				content = JSON.parse(geojsoncontents[i]);
				for (let o = 0; o < content.features.length; o++) {
					if (content.features[o].geometry.type === "Point") {
						pointsdata['features'].push(content.features[o]);
					} else if (content.features[o].geometry.type === "Polygon") {
						polygondata['features'].push(content.features[o]);
					} else if (content.features[o].geometry.type === "LineString") {
						linesdata['features'].push(content.features[o]);
					}
				}
			}


			var exifcamera = {
				'type': 'FeatureCollection',
				'features': []
			}

			var fieldofview3D = {
				'type': 'FeatureCollection',
				'features': []
			}

			var fieldofview3Dcontent = {
				'type': 'FeatureCollection',
				'features': []
			}


			const imgLocations = [];
			for (let i = 0; i < imgcontents.length; i++) {
				if (imgcontents[i] !== false) {
					latitude = eval(imgcontents[i].GPS.GPSLatitude[0]) + (eval(imgcontents[i].GPS.GPSLatitude[1]) / 60) + (eval(imgcontents[i].GPS.GPSLatitude[2]) / 3600);
					longitude = eval(imgcontents[i].GPS.GPSLongitude[0]) + (eval(imgcontents[i].GPS.GPSLongitude[1]) / 60) + (eval(imgcontents[i].GPS.GPSLongitude[2]) / 3600);
					if (imgcontents[i].GPS.GPSLatitudeRef === 'N') {
						latitude = latitude;
					} else {
						latitude = -latitude;
					}
					if (imgcontents[i].GPS.GPSLongitudeRef === 'E') {
						longitude = longitude;
					} else {
						longitude = -longitude;
					}
					imgLocations.push({
						coordinates: [longitude, latitude]
					})

					Bearingofcamera = eval(imgcontents[i].GPS.GPSImgDirection);
					Atitudeofcamera = eval(imgcontents[i].GPS.GPSAltitude);
					URLofcamera = imgcontents[i].FILE.FileName;

					f = eval(imgcontents[i].EXIF.FocalLength);
					fquiv = (eval(imgcontents[i].EXIF.FocalLength) * 35) / imgcontents[i].EXIF.FocalLengthIn35mmFilm;

					FOV = (2 * Math.atan(fquiv / (2 * f))) * (180 / Math.PI);

					exifcamera['features'].push({
						type: 'Feature',
						geometry: {
							coordinates: [longitude, latitude],
							type: 'Point'
						},
						properties: {
							Bearing: eval(imgcontents[i].GPS.GPSImgDirection),
							URL: './' + imgcontents[i].FILE.FileName,
							AOV: FOV,
							Altitude: eval(imgcontents[i].GPS.GPSAltitude)
						}
					})

					originalpoint = turf.point([longitude, latitude]);
					destination = turf.destination(originalpoint, '0.003', eval(imgcontents[i].GPS.GPSImgDirection), {
						units: 'kilometers'
					});

					cameraPoint = [longitude, latitude]
					targetPoint = destination.geometry.coordinates;

					points = {
						type: 'Feature',
						properties: {
							angle: FOV
						},
						geometry: {
							type: 'GeometryCollection',
							geometries: [{
									type: 'Point',
									coordinates: cameraPoint
								},
								{
									type: 'Point',
									coordinates: targetPoint
								}
							]
						}
					}

					options = {
						draggable: true
					}

					FOVresult = L.geotagPhoto.camera(points, options).getFieldOfView();

					fieldview['features'].push({
						type: 'Feature',
						geometry: {
							coordinates: [FOVresult.geometry.geometries[1].coordinates[0], cameraPoint, FOVresult.geometry.geometries[1].coordinates[1]],
							type: 'LineString'
						}
					})

					firstline = turf.lineString([cameraPoint, FOVresult.geometry.geometries[1].coordinates[0]]);
					secondline = turf.lineString([cameraPoint, FOVresult.geometry.geometries[1].coordinates[1]]);

					firstlinechunk = turf.lineChunk(firstline, 0.00001, {
						units: 'kilometers'
					});
					secondlinechunk = turf.lineChunk(secondline, 0.00001, {
						units: 'kilometers'
					});
					/*
					for (let i = 0; i < firstlinechunk.features.length; i++) {
					fieldofview3D['features'].push({type: 'Feature', geometry: {coordinates: [[ firstlinechunk.features[i].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[1], firstlinechunk.features[i].geometry.coordinates[1]]], type:'Polygon'}, properties: {height: i/130, base:firstlinechunk.features.length/130}})
					}
					*/
					for (let i = 0; i < firstlinechunk.features.length; i++) {
						parralellineforfirst = turf.lineChunk(turf.lineString([firstlinechunk.features[i].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[0]]), 0.00002, {
							units: 'kilometers'
						});
						parralellineforsecond = turf.lineChunk(turf.lineString([firstlinechunk.features[i].geometry.coordinates[1], secondlinechunk.features[i].geometry.coordinates[1]]), 0.00002, {
							units: 'kilometers'
						});
						fieldofview3D['features'].push({
							type: 'Feature',
							geometry: {
								coordinates: [
									[firstlinechunk.features[i].geometry.coordinates[0], parralellineforfirst.features[0].geometry.coordinates[1], parralellineforsecond.features[0].geometry.coordinates[1], firstlinechunk.features[i].geometry.coordinates[1]]
								],
								type: 'Polygon'
							},
							properties: {
								height: (i + 130) / 130,
								base: (i + 131) / 130
							}
						})
						fieldofview3D['features'].push({
							type: 'Feature',
							geometry: {
								coordinates: [
									[secondlinechunk.features[i].geometry.coordinates[0], parralellineforfirst.features[parralellineforfirst.features.length - 1].geometry.coordinates[0], parralellineforsecond.features[parralellineforsecond.features.length - 1].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[1]]
								],
								type: 'Polygon'
							},
							properties: {
								height: (i + 130) / 130,
								base: (i + 131) / 130
							}
						})
						fieldofview3D['features'].push({
							type: 'Feature',
							geometry: {
								coordinates: [
									[firstlinechunk.features[i].geometry.coordinates[0], parralellineforfirst.features[0].geometry.coordinates[1], parralellineforsecond.features[0].geometry.coordinates[1], firstlinechunk.features[i].geometry.coordinates[1]]
								],
								type: 'Polygon'
							},
							properties: {
								height: (-i + 370) / 370,
								base: (-i + 370) / 370
							}
						})
						fieldofview3D['features'].push({
							type: 'Feature',
							geometry: {
								coordinates: [
									[secondlinechunk.features[i].geometry.coordinates[0], parralellineforfirst.features[parralellineforfirst.features.length - 1].geometry.coordinates[0], parralellineforsecond.features[parralellineforsecond.features.length - 1].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[1]]
								],
								type: 'Polygon'
							},
							properties: {
								height: (-i + 370) / 370,
								base: (-i + 370) / 370
							}
						})
						fieldofview3Dcontent['features'].push({
							type: 'Feature',
							geometry: {
								coordinates: [
									[firstlinechunk.features[i].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[0], secondlinechunk.features[i].geometry.coordinates[1], firstlinechunk.features[i].geometry.coordinates[1]]
								],
								type: 'Polygon'
							},
							properties: {
								height: (-i + 370) / 370,
								base: (i + 130) / 130,
								Bearing: Bearingofcamera,
								URL: './' + URLofcamera,
								Altitude: Atitudeofcamera
							}
						})
					}


				}
			}

			console.log(imgLocations)
			const ICON_MAPPING = {
				marker: {x: 0, y: 0, width: 128, height: 128, mask: true}
			};
			const deckOverlay = new deck.MapboxOverlay({
				layers: [
					new deck.IconLayer({
					id: 'IconLayer',
					data: imgLocations,
					
					/* props from IconLayer class */
					
					// alphaCutoff: 0.05,
					// billboard: true,
					// getAngle: 0,
					getColor: d => [Math.sqrt(d.exits), 140, 0],
					getIcon: d => 'marker',
					// getPixelOffset: [0, 0],
					getPosition: d => d.coordinates,
					getSize: d => 5,
					iconAtlas: 'https://raw.githubusercontent.com/visgl/deck.gl-data/master/website/icon-atlas.png',
					iconMapping: {
						marker: {
						x: 0,
						y: 0,
						width: 128,
						height: 128,
						anchorY: 128,
						mask: true
						}
					},
					// onIconError: null,
					// sizeMaxPixels: Number.MAX_SAFE_INTEGER,
					// sizeMinPixels: 0,
					sizeScale: 8,
					// sizeUnits: 'pixels',
					// textureParameters: null,
					
					/* props inherited from Layer class */
					
					// autoHighlight: false,
					// coordinateOrigin: [0, 0, 0],
					// coordinateSystem: COORDINATE_SYSTEM.LNGLAT,
					// highlightColor: [0, 0, 128, 128],
					// modelMatrix: null,
					// opacity: 1,
					pickable: true,
					// visible: true,
					// wrapLongitude: false,
					})
			]
			});
			map.addControl(deckOverlay);

			map.loadImage('./camera.png', (error, image) => {
				if (error) throw error;
				map.addImage('camera-icon', image, {
					'sdf': true
				});
				map.addSource('exifcamera', {
					'type': 'geojson',
					'data': exifcamera,
					'generateId': true
				});
				map.addLayer({
					'id': 'exifcamera',
					'source': 'exifcamera',
					'type': 'symbol',
					'layout': {
						'icon-image': 'camera-icon',
						'icon-size': 0.1,
						'icon-rotate': ['get', 'Bearing'],
						'icon-pitch-alignment': 'map',
						'icon-rotation-alignment': 'map',
						'icon-allow-overlap': true
					},
					'paint': {
						'icon-color': '#cb18e2'
					},
					'maxzoom': 19
				});

				map.on('mouseenter', 'exifcamera', (e) => {
					map.getCanvas().style.cursor = 'pointer';
					coordinates = e.features[0].geometry.coordinates.slice();
					while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
						coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
					}
					whattoshow = `
<img src="${e.features[0].properties.URL}" alt="Click to view full image" width="240" height="240"><br>
<b>Altitude:</b> ${(e.features[0].properties.Altitude).toFixed(2)}m<br>
<b>Heading:</b> ${(e.features[0].properties.Bearing).toFixed(2)}°<br>
`;
					popup.setLngLat(coordinates).setHTML(whattoshow).addTo(map);
				});

				map.on('mouseleave', 'exifcamera', () => {
					map.getCanvas().style.cursor = '';
					popup.remove();
				});


			});

			map.addSource('fieldview', {
				'type': 'geojson',
				'data': fieldview,
				'generateId': true
			});

			map.addSource('fieldofview3D', {
				'type': 'geojson',
				'data': fieldofview3D,
				'generateId': true
			});

			map.addSource('fieldofview3Dcontent', {
				'type': 'geojson',
				'data': fieldofview3Dcontent,
				'generateId': true
			});

			map.addSource('polygondata', {
				'type': 'geojson',
				'data': polygondata,
				'generateId': true
			});

			map.addSource('linesdata', {
				'type': 'geojson',
				'data': linesdata,
				'generateId': true
			});
			/*
			map.addLayer({
			'id': 'fieldofview',
			'type': 'line',
			'source': 'fieldview',
			'layout': {
			'line-join': 'round',
			'line-cap': 'round'
			},
			'paint': {
			'line-color': '#ce2d2d',
			'line-width': 1,
			'line-opacity': 0.6
			}
			});
			*/
			map.addLayer({
				'id': 'fieldofview3D',
				'type': 'fill-extrusion',
				'source': 'fieldofview3D',
				'paint': {
					'fill-extrusion-color': "#48C6EF",
					'fill-extrusion-height': ['get', 'base'],
					'fill-extrusion-base': ['get', 'height'],
					'fill-extrusion-opacity': 0.6
				}
			});

			map.addLayer({
				'id': 'fieldofview3Dcontent',
				'type': 'fill-extrusion',
				'source': 'fieldofview3Dcontent',
				'paint': {
					'fill-extrusion-color': "#48C6EF",
					'fill-extrusion-height': ['get', 'base'],
					'fill-extrusion-base': ['get', 'height'],
					'fill-extrusion-opacity': 0.05
				}
			});

			map.on('mouseenter', 'fieldofview3Dcontent', (e) => {
				map.getCanvas().style.cursor = 'pointer';
				whattoshow = `
<img src="${e.features[0].properties.URL}" alt="Click to view full image" width="240" height="240"><br>
<b>Altitude:</b> ${(e.features[0].properties.Altitude).toFixed(2)}m<br>
<b>Heading:</b> ${(e.features[0].properties.Bearing).toFixed(2)}°<br>
`;
				popup.setLngLat(e.lngLat).setHTML(whattoshow).addTo(map);
			});
			map.on('mouseleave', 'fieldofview3Dcontent', () => {
				map.getCanvas().style.cursor = '';
				popup.remove();
			});



			map.addLayer({
				'id': 'polygondata_fill',
				'type': 'fill',
				'source': 'polygondata',
				'paint': {
					'fill-color': '#ffffff',
					'fill-opacity': 0.1
				},
				'layout': {
					'visibility': 'visible'
				},
			});

			map.addLayer({
				'id': 'polygondata_outline',
				'type': 'line',
				'source': 'polygondata',
				'layout': {},
				'paint': {
					'line-color': '#fff',
					'line-width': 1
				}
			});

			map.addLayer({
				'id': 'linesdata',
				'type': 'line',
				'source': 'linesdata',
				'layout': {
					'line-join': 'round',
					'line-cap': 'round'
				},
				'paint': {
					'line-color': '#000',
					'line-width': 2
				}
			});


			map.loadImage('./triangle.png', (error, image) => {
				if (error) throw error;
				map.addImage('triangle-icon', image, {
					'sdf': true
				});
				map.addSource('pointsdata', {
					'type': 'geojson',
					'data': pointsdata,
					'generateId': true
				});
				map.addLayer({
					'id': 'pointsdata',
					'source': 'pointsdata',
					'type': 'symbol',
					'layout': {
						'icon-image': 'triangle-icon',
						'icon-size': 0.1,
						'icon-allow-overlap': true
					},
					'paint': {
						'icon-color': '#156ad3'
					}
				});

				map.on('mouseenter', 'pointsdata', (e) => {
					map.getCanvas().style.cursor = 'pointer';
					coordinates = e.features[0].geometry.coordinates.slice();
					while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
						coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
					}

					whattoshow = ``;

					propertieskeys = Object.keys(e.features[0].properties);
					for (let i = 0; i < propertieskeys.length; i++) {
						if ((e.features[0].properties[propertieskeys[i]]).includes('http')) {
							whattoshow = whattoshow + `<b>${propertieskeys[i].toUpperCase()}:</b> <a href="${e.features[0].properties[propertieskeys[i]]}" target="_blank">Click to see link</a><br>`
						} else {
							whattoshow = whattoshow + `<b>${propertieskeys[i].toUpperCase()}:</b> ${e.features[0].properties[propertieskeys[i]]}<br>`
						}
					}


					popup.setLngLat(coordinates).setHTML(whattoshow).addTo(map);

				});

				map.on('mouseleave', 'pointsdata', () => {
					map.getCanvas().style.cursor = '';
					popup.remove();
				});


				map.on('click', 'pointsdata', (e) => {
					coordinates = e.features[0].geometry.coordinates.slice();
					while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
						coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
					}

					whattoshow = `<div style="background-color: #8b8282; color:white; padding-left: 5px; margin-bottom: 5px; display: flex;flex-direction: row;align-items: center;justify-content: space-between"><div>List Entry</div><button style="position:relative; color:white" class="mapboxgl-popup-close-button" type="button" aria-label="Close popup" onClick="popup1.remove();">×</button></div>`;

					propertieskeys = Object.keys(e.features[0].properties);
					for (let i = 0; i < propertieskeys.length; i++) {
						if ((e.features[0].properties[propertieskeys[i]]).includes('http')) {
							whattoshow = whattoshow + `<b>${propertieskeys[i].toUpperCase()}:</b> <a href="${e.features[0].properties[propertieskeys[i]]}" target="_blank">Click to see link</a><br>`
						} else {
							whattoshow = whattoshow + `<b>${propertieskeys[i].toUpperCase()}:</b> ${e.features[0].properties[propertieskeys[i]]}<br>`
						}
					}


					popup1.setLngLat(coordinates).setHTML(whattoshow).addTo(map);

				});





			});

			$('#loading-map').css('display', 'none');

		});
	</script>

</body>

</html>