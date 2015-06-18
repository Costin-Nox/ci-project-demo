<?php 
/*
*	CMPT 275 - GROUP 10
*	VigilantEye source Code
*	Coder: Costin Ghiocel
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends MY_Controller{
	
	public function __construct() {
		parent::__construct();
	}
	
	function index($username = "") {
		if($username == "") {
			redirect('/home/', 'refresh');
		}
		//GET USER DATA
		$content["submissions"] = $this->Submissions_model->get_submission_given_username($username);
		$this->load->model('users_model');
		$content["user_info"] = $this->users_model->get_user($username);
		$content["user_info"]["score"] = $this->users_model->retScore($content["user_info"]["username"]);
		$data["content"] = $this->load->view('main/profile', $content,TRUE);
		
		
		
		$this->func_display($data);
	}
	
	function promote($username, $confirm="") {
		$this->load->model('users_model');
		if($this->session->userdata('level') == 2) {
			if($confirm == "") {
				echo "<br />Promote user ".$username." to Volunteer? <br /><br />";
				echo '<form class="delete_submission_form" method="post" action="'.base_url().'users/promote/'.$username.'/false">
					<input id="button_no" type="submit" value="No" style="float: right;" />
					</form>
						
					<form class="delete_submission_form" method="post" action="'.base_url().'users/promote/'.$username.'/true">
					<input id="button_yes" type="submit" value="Yes" style="float: right;" />
					</form>';
			} else if($confirm == true) {
				$this->users_model->promote_to_volunteer($username);
				redirect("/users/index/".$username, "REFRESH");
			} else {
				redirect("/users/index/".$username, "REFRESH");  
			}
		} else {
			echo "Nice try :)";
		}
	}
	
		function demote($username, $confirm="") {
		$this->load->model('users_model');
		if($this->session->userdata('level') == 2) {
			if($confirm == "") {
				echo "<br />Demote user ".$username." to regular user? <br /><br />";
				echo '<form class="delete_submission_form" method="post" action="'.base_url().'users/demote/'.$username.'/false">
					<input id="button_no" type="submit" value="No" style="float: right;" />
					</form>
						
					<form class="delete_submission_form" method="post" action="'.base_url().'users/demote/'.$username.'/true">
					<input id="button_yes" type="submit" value="Yes" style="float: right;" />
					</form>';
			} else if($confirm == true) {
				$this->users_model->demote_from_volunteer($username);
				redirect("/users/index/".$username, "REFRESH");
			} else {
				redirect("/users/index/".$username, "REFRESH"); 
			}
		} else {
			echo "Nice try :)";
		}
	}
	
	function login() {
		$this->load->library('login'); 
		$header = array();
		$posted_data = $this->input->post('posted_data');
		if(empty($posted_data)) {
			$posted_data["username"] = $this->session->flashdata("username");
			$posted_data["password"] = $this->session->flashdata("password");
		}
		if(!empty($posted_data)){
			$success = $this->login->login($posted_data["username"], $posted_data["password"]);
			if(!$success){
				$header["site_msg"] = "Invalid username and/or password";
			}
		}
		if($this->session->userdata('logged_in')) {
			redirect('/users/index/'.$this->session->userdata('username'), 'refresh');
		} else{
			$this->load->view('main/login', $header);
		}
	}
	
		function mobile_login() {
		$this->load->library('login'); 
		$header = array();
		$posted_data = $this->input->post('posted_data');
		if(empty($posted_data)) {
			$posted_data["username"] = $this->session->flashdata("username");
			$posted_data["password"] = $this->session->flashdata("password");
		}
		if(!empty($posted_data)){
			$success = $this->login->login($posted_data["username"], $posted_data["password"]);
			
			if(!$success){
				if($this->session->userdata('logged_in')) {

				} else {
					echo "FALSE";
				}
			}
		}
		if($this->session->userdata('logged_in')) {
			$this->load->model('users_model');
			$user_data = $this->users_model->get_user($this->session->userdata("username"));
			echo json_encode($user_data);
		} else{
			$this->load->view('main/mobile_login', $header);
		}
	}

	function logout() {
		$this->load->library('login');
		$this->login->logout();
		redirect('/home/', 'refresh');
	}
	
	function signup () {
		$this->load->view('main/signup');
	}
	
	function register() {
		$user_data = $this->input->post('posted_data');
		if($this->form_validation->run() != FALSE){
			$this->load->model('Users_model');
			$created_user_dir = mkdir('./uploads/' . base64_encode($this->encrypt->encode($user_data["username"])), 0777);
			if(!$created_user_dir){
				echo "FATAL ERROR: USER FILE FOLDER CANNOT BE CREATED: " . './uploads/' . base64_encode($this->encrypt->encode($user_data["username"]));				
				die;
			}
			if($this->Users_model->insert_user($user_data)) {
				$this->session->set_flashdata('username', $user_data["username"]);
				$this->session->set_flashdata('password', $user_data["password"]);
				$this->load->view('main/signup_form',array("success" => true));
			}
			else {
				echo "FATAL ERROR: USER CANNOT BE INSERTED";
			}
			
		} else {
			$this->load->view('main/signup_form');
		}
	}

	
	function register_mobile() {
		$user_data = $this->input->post('posted_data');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run() != FALSE){
			$this->load->model('Users_model');
			$created_user_dir = mkdir('./uploads/' . base64_encode($this->encrypt->encode($user_data["username"])), 0777);
			if(!$created_user_dir){
				echo "FATAL ERROR: USER FILE FOLDER CANNOT BE CREATED: " . './uploads/' . base64_encode($this->encrypt->encode($user_data["username"]));				
				die;
			}
			if($this->Users_model->insert_user($user_data)) {
				$this->session->set_flashdata('username', $user_data["username"]);
				$this->session->set_flashdata('password', $user_data["password"]);
				echo "true";
			}
			else {
				echo "FATAL ERROR: USER CANNOT BE INSERTED";
			}
			
		} else {
			$errors = array( 
								'username' 	=> form_error('posted_data[username]'),
								'password' 	=> form_error('posted_data[password]'),
								'passconf' 	=> form_error('posted_data[passconf]'),
								'email' 	=> form_error('posted_data[email]'),
								'name'		=> form_error('posted_data[name]'),
								'webSite'	=> form_error('posted_data[webAddress]')
								);
			echo json_encode($errors);
		}
	}
	
		
	function user_level() {
		$this->load->model('Users_model');
		$ret = $this->Users_model->get_account_level($this->session->userdata("username"));
		echo $ret;
	}
	
	function get_score() {
		$this->load->model('Users_model');
		$sc = $this->Users_model->retScore($this->session->userdata("username"));
		if(isset($sc)) {
			echo $sc;
		} else {
			echo "Not logged in";
		}
	}
	
	function view_inbox() {
		$this->load->model('Messages_model');
		$inbox = $this->Messages_model->get_inbox($this->session->userdata("username"));
		$this->load->view('main/inbox',array("inbox" => $inbox));
	}
	
	function view_compose_box() {
		$this->load->view('main/inbox_compose');
	}
	
	function send_message() {
		$message_data = $this->input->post('message_data');
		if($this->form_validation->run() != FALSE){
			$this->load->model('Messages_model');
			$this->Messages_model->send_message($message_data);
			$this->load->view('main/inbox_compose', array("success" => true));
		}else {
			$this->load->view('main/inbox_compose');
		}
	}
	
	function delete_message($id = "") {
		if ($id == "")
			return false;
		$this->load->model('Messages_model');
		return $this->Messages_model->delete_message($id);
	}
	
	function detailedSubmit($submissionID =""){
		$content_data['title'] = "Welcome";
		$rightbar_data['color'] = "blk_heading";
		$rightbar_data['title'] = "Info";
		
		$right_bar_comments['color'] = "red_heading";
		$right_bar_comments['title'] = "Comments";
		
		$this->load->model('Users_model');
		$content_data['level'] = $this->Users_model->get_account_level($this->session->userdata("username"));
		$right_bar_comments['level'] = $content_data['level'];
		$content_data['submissions'] = $this->Submissions_model->get_submission_given_submissionID($submissionID);	
		$content_data['screenshots'] = $this->Submissions_model->get_screenshots($content_data['submissions']['submissionName'], $content_data['submissions']['username']);
		
		$right_bar_comments['comments'] = $this->Comments_model->retrieve_comments($submissionID);
		$rightbar_data['submissions'] = $content_data['submissions'];
		$data['right_bar'] = $this->load->view('template/rightbar_detailed', $rightbar_data,TRUE);
		$data['right_bar'] .= $this->load->view('main/rightbar_comments', $right_bar_comments,TRUE);
		$data["content"] = $this->load->view('main/submissionsDetails', $content_data, TRUE);	
		if($this->Submissions_model->check_if_exists_id($submissionID)) {
			$this->func_display($data);
		} else {
			echo "Submission does not exist. It either got deleted, or something went wrong. Please use your browser back button.";
		}
	}
}
?>