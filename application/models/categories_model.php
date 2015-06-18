<?php
/*
*	CMPT 275 - GROUP 10
*	VigilantEye source Code
*	Coder: Costin Ghiocel
*/

// Most of these functions are pretty self explanatory i believe.

class Categories_model extends CI_Model {

    var $categoryid = '';
    var $locID = '';
    var $topicID = '';       
    
    function __construct()
    {    	
        parent::__construct();
    }
    
    function insert_entry($cat_data)
    {
       $data = array(
			'locID' => $cat_data["locID"],
			'topicID' => $cat_data["topicID"]
		);
        return $this->db->insert('categories', $data);
    }
    
    function category_exists($locID = "", $topicID = "")
    {
    	$this->db->where('locID', $locID);
    	$this->db->where('topicID', $topicID);
    	$query = $this->db->get('categories');
    	if ($query->num_rows() > 0){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
	// get categories with location and topic names
    function get_category_with_locTopic($locID = "", $topicID = "")
    {
    	$this->db->where('locID', $locID);
    	$this->db->where('topicID', $topicID);
    	$query = $this->db->get('categories');
    	if ($query->num_rows() > 0){
    		return $query->row_array();
    	}
    	else{
    		return false;
    	}
    }
	
	// get a certain category
	
	function get_category($categoryID = "") { 
		$this->db->where('categoryID', $categoryID); 
        $query = $this->db->get("categories");
		if ($query->num_rows() > 0) {
            return $query->row_array(); 
		}else {
			return false;
		}
	}
	//
	function get_locations($locID = "") {
		$result = $this->Locations_model->get_all_locations();
		if ($result){
			return $result;
		}else {
			return false;
		}
	}

	function get_topics($topicID = "") {
		$result = $this->Topics_model->get_all_topics();
		if ($result){
			return $result;
		}else {
			return false;
		}
	}
	
	function get_topics_given_location($locID = "") {
		/*$this->db->select('`topics_categories.topicID`, topic_name');
		$this->db->where('`categories.topicID`','`topics_categories.topicID`');
		$this->db->where('languageID', $locationID);
		$this->db->from('categories, topics_categories');
		$query = $this->db->get();*/
		$query = $this->db->query('SELECT topics_categories.topicID, topic_name
						FROM (categories, topics_categories)
						WHERE categories.topicID = topics_categories.topicID
						AND locID = ' .$locID);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return false;
		}
	}
	
	function get_location_given_topic($topicID = "") {
		$query = $this->db->query('SELECT location_categories.locID, loc_name
						FROM (categories, location_categories)
						WHERE categories.locID = location_categories.locID
						AND topicID = ' .$topicID);
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return false;
		}
	}
	
	function get_category_given_topicID($topicID = "") {
		$this->db->where('topicID', $topicID);
		$query = $this->db->get("categories");
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else {
			return false;
		}
	}
	
	
	// this function is used for the right bar menu and will resturn a list of tags based on location and topic.
	function get_tags_with_locTopic($loc = "", $topic = "")
	{
		$this->db->where('locID', $locID, 'topicID', $topicID);
		$query = $this->db->get('categories');
		if ($query->num_rows() > 0){
			return $query->row_array();
		}
		else{
			return false;
		}
	}
	
	//<------- browse functions -->
	//return entries by location
	function get_submissions($where_clause) {
		$this->db->order_by("score", "desc"); 
		$this->db->where($where_clause);
		$post = $this->input->post();
		if(isset($post["tagid"])) {
			$where_filter = "(tags.subtopic1 = ".$post["tagid"]." OR tags.subtopic2 = ".$post["tagid"]." OR tags.subtopic3 = ".$post["tagid"].")";
			$this->db->where($where_filter);
		}
		$this->db->from('submissions',false);
		$this->db->join('categories', 'categories.categoryID = submissions.categoryID','left',false);
		$this->db->join('location_categories', 'location_categories.locID = categories.locID','left',false);
		$this->db->join('topics_categories', 'topics_categories.topicID = categories.topicID','left',false);
		$this->db->join('tags', 'tags.submissionID = submissions.submissionID','left',false);
		$this->db->select('*');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$data["submissions"] = $query->result_array();
		}else {
			return false;
		}
		

		foreach ($data["submissions"] as $key => $value){
			$ids[] = $value["submissionID"];
		}
		$data["tags_list"] = $this->get_unique_subtopics($ids);
		return $data;
	}
	function get_unique_subtopics($subtopics_array) {
		$query = $this->db->query('
			SELECT DISTINCT subtopic1,subtopicName FROM (
			SELECT distinct subtopic1, tags.submissionID, subtopicName
			FROM (submissions) 
			LEFT JOIN tags ON tags.submissionID = submissions.submissionID
			LEFT JOIN subtopics_categories a ON a.subtopicID = tags.subtopic1
			UNION ALL
			SELECT distinct subtopic2, tags.submissionID, subtopicName
			FROM (submissions) 
			LEFT JOIN tags ON tags.submissionID = submissions.submissionID
			LEFT JOIN subtopics_categories a ON a.subtopicID = tags.subtopic2
			UNION ALL
			SELECT distinct subtopic3, tags.submissionID, subtopicName
			FROM (submissions) 
			LEFT JOIN tags ON tags.submissionID = submissions.submissionID
			LEFT JOIN subtopics_categories a ON a.subtopicID = tags.subtopic3) subtopics
			WHERE submissionID IN ('.implode(',',$subtopics_array).') AND subtopic1 IS NOT NULL
		');
		return $query->result_array();
	}
	function get_entries_by_loc($loc="")
	{
		$query = $this->db->query('
				SELECT s.SubmissionID
				FROM (categories AS c, location_categories AS lc, submissions AS s)
				WHERE c.categoryID = s.categoryID AND c.locID = lc.locID
				AND lc.loc_name = '."'".$loc."'"
		);
		return $query->result_array();
	}
	//return submissions based on location name and topic
	function get_entries_by_loc_topic($loc="", $topic="")
	{
		$query = $this->db->query('
				SELECT s.SubmissionID
				FROM (categories AS c, location_categories AS lc, topics_categories AS tc, submissions AS s)
				WHERE c.categoryID = s.categoryID AND c.locID = lc.locID AND c.topicID = tc.topicID
				AND lc.loc_name = '."'" .$loc. "'".' AND tc.topic_name ='."'".$topic."'"
		);
		return $query->result_array();
	}
	//return submission ID and Tags
	function get_submission_and_tags($submissionID = "") {
		$query = $this->db->query('
				SELECT t.submissionID, sc.subtopicName AS tag1, sc2.subtopicName AS tag2, sc3.subtopicName AS tag3
				FROM tags AS t
				LEFT JOIN subtopics_categories AS sc ON t.subtopic1 = sc.subtopicID
				LEFT JOIN subtopics_categories AS sc2 ON t.subtopic2 = sc2.subtopicID
				LEFT JOIN subtopics_categories AS sc3 ON t.subtopic3 = sc3.subtopicID
				WHERE t.submissionID ='.$submissionID
		);
		return $query->result_array();
	}
	
	
	
	//this function creates an array of IDs and tags
	function return_subtag_array($idArray ="") {
		foreach($idArray as $key => $val) {
			$subtags[$val["SubmissionID"]] = $this->get_submission_and_tags($val["SubmissionID"]);
		}
		return $subtags;
	}
	
	//return a list of used UNIQUE tags from a subtag_array
	function return_unique_subtags ($subtags = "") {
		
	}

	
	//this function takes an entry ID array and return an array with the data entries for the IDs
	function return_entry_array($idArray ="") {
		foreach($idArray as $key => $val) {
			$submissions[$val["SubmissionID"]] = $this->Submissions_model->get_submission_given_submissionID($val["SubmissionID"]);
		}
		return $submissions;
	}

}
?>