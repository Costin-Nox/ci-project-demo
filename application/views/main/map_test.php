
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVKmPsq1EsmN70NfkPVFHV92gXIb4OpJw&sensor=true">
    </script>
    <script type="text/javascript">
		var map;
      	function initialize() {
        	var mapOptions = {
          		center: new google.maps.LatLng(-34.397, 150.644),
          		zoom: 8,
          		mapTypeId: google.maps.MapTypeId.ROADMAP
        	};
        	map = google.maps.Map(document.getElementById("map_canvas"), mapOptions);
      }
    </script>
    <div id="map_canvas"></div>
    <script type="text/javascript">
		initialize();
	</script>