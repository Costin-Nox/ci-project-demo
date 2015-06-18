    <form class="submit_form" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>submissions/submit_content">
        <table class="submissions_table">
            <tr>
                <td><span class="submission_label">Report Title</span></td>
                </tr><tr>
                <td><input type="text" value="" name="submission_data[title]" size="35"/></td>
            </tr>
            <tr>
                <td><br /><span class="submission_label">Select General Area</span></td>
                </tr><tr>
                <td>
                    <select name="submission_data[locations]">                    	
                        <?php foreach ($locations as $key => $value) { ?>                        
                        <option value="<?php echo $value['locID'] ?>"><?php echo $value['loc_name'] ?></option>      
                        <?php } ?> 
                    </select>
                </td>
            </tr>
            <tr>
                <td><br /><span class="submission_label">Select Report Type</span></td>
                </tr><tr>
                <td>
                    <select name="submission_data[topic]">
                        <option>----Select a topic----</option>                        
                        <?php foreach ($topics as $key => $value) { ?> 
                        <option value="<?php echo $value['topicID'] ?>"><?php echo $value['topic_name'] ?></option>      
                        <?php } ?>           
                    </select>
                </td>
            </tr>
            <tr>
                <td><br /><span class="submission_label">Select up to 3 Tags</span></td>
                </tr><tr>
                <td>
                    <select multiple="multiple" name="submission_data[subtopics][]">
                        <option>----Select a subtopic----</option>
                        <?php foreach ($subtopics as $key => $value) { ?>
                        <option value="<?php echo $value['subtopicID'] ?>"><?php echo $value['subtopicName'] ?></option>      
                        <?php } ?>
                    </select>
                </td>
            </tr>
             <tr>
                <td><br /><span class="submission_label">Location (address):</span></td>
              </tr><tr>
                <td>
					<input type="text" value="" name="submission_data[address]" size="52"/>
                </td>
            </tr>
            </tr>
             <tr>
                <td><br /><span class="submission_label">Enter a description:</span></td>
              </tr><tr>
                <td>
					<textarea cols="40" rows="7" name="submission_data[description]" ></textarea>
                </td>
            </tr>
        </table>
		<br /><br />
        <input type="hidden" name="submission_data[lat]" value="1">
        <input type="hidden" name="submission_data[long]" value="3">
		<input type="submit" value="Submit" />
		
    </form>