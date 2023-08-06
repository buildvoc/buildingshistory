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

	<link rel="stylesheet" href="styles.css">
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
	<div class="tooltip" id="tooltip"></div>

	<script>
		var geojson3dbuildings = <?php echo json_encode($buildings); ?>;
 		var geojsoncontents = <?php echo json_encode($filescontentarray); ?>;
		var imgcontents = <?php echo json_encode($imgcontentarray); ?>;
	</script>
	<script src="script.js"></script>

</body>

</html>