<script>
    $(function() {
        $( "#accordion" ).accordion({heightStyle:"content"});
    });
</script>
<div id='accordion'>
	<?php 
	if(!empty($submissions)){
		foreach ($submissions as $key=>$entry){
			echo "<h3>"."<strong style='margin-right:5px;border-right:solid 1px;padding-right:5px; color:red;'>".$entry["score"]."</strong>".$entry["submissionName"] ."</h3>";
			echo "<div>";
			echo "<table id='submission_table'>";
			echo "<tr id='top_row'>
					<td>Submission Name:</td>
					<td>Submitted By:</td>
					<td>Location:</td>
					<td>Time:</td>
				</tr>";
			echo "<tr>";
			echo "<td> <a href=".base_url()."users/detailedSubmit/".$entry["submissionID"]."><strong>" .$entry["submissionName"] ."</strong></a></td>";
			echo "<td> <a href=".base_url()."users/index/".$entry["username"].">".$entry["username"]."</a></td>";
			echo "<td>".$entry["address"] ."</td>";
			echo "<td>".$entry["dateSubmitted"] ."</td>";
			echo "</tr>";
			echo "</table>";
			if(!empty($entry["description"])) {
				echo "<div id='quick_description'><strong>Description:</strong><br>".$entry["description"]."</div>";
			}
			echo "</div>";
		}
	}else{
		echo "<h3>No Results Found</h3>";
	}
	?>
</div>