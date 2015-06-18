<div class="profile-content">
    <h2><?php echo $user_info["username"]."'s profile page" ?></h2>
    <div class="profile-box profile-info">
        <div class="blk_heading"> <h3>My Profile Info</h3> </div>
        <table id="profile_table">
        	<tr>
        		<th class="heading"> Level: </th> <td><input type="text" value="<?php
					if( $user_info["level"] == 0 ) {
						echo "Regular User";
					} else if( $user_info["level"] == 1 ) {
						echo "Volunteer";
					} else if( $user_info["level"] == 2 ) {
						echo "Admin";
					} else {
						echo "Undefined";
					}?>" /></td>
        	</tr>
			<tr>
        		<th class="heading"> Name: </th> <td><input type="text" value="<?php echo $user_info["name"]; ?>" /></td>
        	</tr>
			 <tr>
                <th class="heading"> Email: </th> <td><input type="text" value="<?php echo $user_info["email"]; ?>" /></td>
            </tr>
            <tr>
                <th class="heading"> Website: </th> <td><input type="text" value="<?php echo $user_info["webAddress"]; ?>" /></a></td>
            </tr>
            <tr>
                <th class="heading"> Score: </th> <td><input type="text" value="<?php echo $user_info["score"]; ?>" /></a></td>
            </tr>
        </table>
        
    </div>
    <div class="profile-box user-submissions">
        <h2>My Submissions</h2>
        <div class="profile-box-user-submissions-submits"><p> 
        	<?php if (!($submissions)) {?>
        	There are no submissions for your account. You can upload reports by clicking the button below.
        	<?php } else { ?>
	        	 <?php foreach ($submissions as $key => $value) { ?>  
	              <br><p><strong>Name:</strong> &nbsp; <a href="<?php echo base_url(); ?>users/detailedSubmit/<?php echo $value['submissionID'] ?>"><?php echo $value['submissionName'] ?></a>&nbsp;&nbsp;
	              <strong>Ranking:</strong> &nbsp;<?php echo $value['score'] ?>&nbsp;&nbsp;
	              <strong>Submitted:</strong> &nbsp;<?php echo $value['dateSubmitted'] ?></p> </br>
	             <?php } ?>  
             <?php }?>       	
        </p>
        </div>
        <script>
			$(document).ready(function() {
				$("#submit_project").colorbox({
					speed: 500,
					href: "<?php echo base_url(); ?>submissions/index"
				});
				$("#promote").colorbox({
					speed: 500,
					href: "<?php echo base_url(); ?>users/promote/<?php echo $user_info["username"]; ?>"
				});
				$("#demote").colorbox({
					speed: 500,
					href: "<?php echo base_url(); ?>users/demote/<?php echo $user_info["username"]; ?>"
				});
			});
		</script>
        <?php if($user_info["username"] == $this->session->userdata('username')) {?>
        	<input id="submit_project" type="button" value="Submit your report" />
        <?php } else if($this->session->userdata('level') == 2) {
					if($user_info["level"] == 0){?>
        				<input id="promote" type="button" value="Promote To Volunteer" />
                   	<?php } else if($user_info["level"] == 1){?>
                    	<input id="demote" type="button" value="Demote to User" />
                     <?php } ?>
        <?php } ?>
        
        <script>
			$(document).ready(function() {
				$("#more_projects").colorbox({
					speed: 500,
					href: "<?php echo base_url(); ?>submissions/view_submissions/<?php echo $user_info["username"] ?>"
				});
			});
		</script>
        <input id="more_projects" type="button" value="View All Reports" />
    </div>
</div>