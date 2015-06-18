<?php
/*
*	CMPT 275 - GROUP 10
*	VigilantEye source Code
*	Coder: Costin Ghiocel
*/

class Locations_model extends CI_Model {

    var $locID = '';  

    function __construct()
    {
        parent::__construct();
    }
    
    function get_all_locations(){
    	 $query = $this->db->get('location_categories');
    	 if ($query->num_rows() > 0) {
    	 	return $query->result_array();
    	 }else {
    	 	return false;
    	 }
    }
}
?>