<?php 
		$link = mysqli_connect('comse6998.cbuoihga32cd.us-east-1.rds.amazonaws.com', 'client', 'client', 'tweet', 3306);
		
		// Check connection
		if ($link->connect_error) {
			die("Connection failed: " . $link->connect_error);
		}
		else {
			//echo "connected<br>";
		}
		
		$sql = "SELECT * FROM tweet WHERE text LIKE '%computing%'";
		$result = $link->query($sql);
?>

<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <title>Tweet Density Map Refined By Keyword - COMSE6998 Assignment 1</title>
	    <style>
	      	html, body, #map-canvas {
	        	height: 100%;
	        	margin: 0px;
	        	padding: 0px
	      	}
	    </style>
	    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization"></script>
	    
	</head>

	<body>
	    <div id="menu" align="center">
	    	<h3 align="center">Please choose keyword</h3>
	    	<select name="list" onchange="location = this.options[this.selectedIndex].value;">
				<option value="keyword_computing.php">computing</option>
				<option value="index.php">food</option>
				<option value="keyword_cloud.php">cloud</option>
				<option value="keyword_homework.php">homework</option>
				<option value="keyword_time.php">time</option>
				<option value="keyword_consuming.php">consuming</option>
			</select>
			<h3 align="center"></h3>
	    </div>
	    <div id="map-canvas"></div>
	    
	    <script>
			// Adding 500 Data Points
			var map, pointarray, heatmap;
			
			var tweetData = [
				<?php 
					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
							echo "new google.maps.LatLng(" . $row["xlabel"]. ", " . $row["ylabel"]. "),";
						}
					}
				?>
			];
			
			function initialize() {
			  var mapOptions = {
			    zoom: 3,
			    center: new google.maps.LatLng(37.774546, -122.433523),
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			  };
			
			  map = new google.maps.Map(document.getElementById('map-canvas'),
			      mapOptions);
			
			  var pointArray = new google.maps.MVCArray(tweetData);
			
			  heatmap = new google.maps.visualization.HeatmapLayer({
			    data: pointArray
			  });
			
			  heatmap.setMap(map);
			}
			
			function toggleHeatmap() {
			  heatmap.setMap(heatmap.getMap() ? null : map);
			}
			
			function changeGradient() {
			  var gradient = [
			    'rgba(0, 255, 255, 0)',
			    'rgba(0, 255, 255, 1)',
			    'rgba(0, 191, 255, 1)',
			    'rgba(0, 127, 255, 1)',
			    'rgba(0, 63, 255, 1)',
			    'rgba(0, 0, 255, 1)',
			    'rgba(0, 0, 223, 1)',
			    'rgba(0, 0, 191, 1)',
			    'rgba(0, 0, 159, 1)',
			    'rgba(0, 0, 127, 1)',
			    'rgba(63, 0, 91, 1)',
			    'rgba(127, 0, 63, 1)',
			    'rgba(191, 0, 31, 1)',
			    'rgba(255, 0, 0, 1)'
			  ]
			  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
			}
			
			function changeRadius() {
			  heatmap.set('radius', heatmap.get('radius') ? null : 20);
			}
			
			function changeOpacity() {
			  heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
			}
			
			google.maps.event.addDomListener(window, 'load', initialize);
	
	    </script>
	</body>
</html>