
<?php if (isset($bread_crumb)) {?>
<div class="bread_crumb">
	<?php echo $bread_crumb ?>
</div>
<?php } ?>
<br />
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVKmPsq1EsmN70NfkPVFHV92gXIb4OpJw&sensor=true">
</script>
<script type="text/javascript">
      function initialize() {
        var mapOptions = {
          	center: new google.maps.LatLng(49.25, -123.133333),
          	zoom: 12,
          	mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	}
</script>
<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	var i = false;
	
	$("#tabs li").click(function() {
		//	First remove class "active" from currently active tab
		$("#tabs li").removeClass('active');

		//	Now add class "active" to the selected/clicked tab
		$(this).addClass("active");

		//	Hide all tab content
		$(".tab_content").hide();

		//	Here we get the href value of the selected tab
		var selected_tab = $(this).find("a").attr("href");

		//	Show the selected tab content
		$(selected_tab).fadeIn();
		
		if(!i && selected_tab=="#tab2") {
			initialize();
			i = true;
		}

		//	At the end, we add return false so that the click on the link is not executed
		return false;
	});
});
/* ]]> */
</script>

<div id="tabs_wrapper">
	<div id="tabs_container">
		<ul id="tabs">
			<li class="active"><a href="#tab1">Results</a></li>
			<li><a href="#tab2">Map View</a></li>
		</ul>
	</div>
	<div id="tabs_content_container">
		<div id="tab1" class="tab_content" style="display: block;">
        <?php 
			$this->load->view('main/print_submission_array', array( "submissions"=>$submissions));
		?>
       
		</div>
		<div id="tab2" class="tab_content">
		  <div id="map_canvas"></div>
		
		</div>
	</div>
</div>


<br />
<p>
	Page rendered in <strong>{elapsed_time}</strong> seconds
</p>
