<?php
defined('BASEPATH') or exit('No direct script access allowed');

class workforce extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('Generic_model', 'generic');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function ManageWorkforceSkill()
	{
		//loadd all skill according to company id
		$this->data['skills'] = $this->generic->GetData('skills', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'skillID', 'DESC');
		$this->load->view('workforce/manageSkill', $this->data);
	}
	public function addSkillData()
	{
		$skillName = $this->input->post('skillName');
		$skillDescription = $this->input->post('skillDescription');

		if ($skillName && $skillDescription) {
			$data = array(
				'companyID' => $this->session->userdata('companyDetails')['companyID'],
				'skillName' => $skillName,
				'skillDesc' => $skillDescription
			);
			$this->generic->InsertData('skills', $data);
			$this->session->set_flashdata('success', 'Skill added successfully!');
			if (isset($_GET['allWorkforce']) && $_GET['allWorkforce'] == 1) {
				redirect(base_url('all-workforce'));
			} else {

				redirect(base_url('manage-workforce-skill'));
			}
		} else {
			$this->session->set_flashdata('error', 'Please fill all fields!');
			redirect(base_url('manage-workforce-skill'));
		}
	}
	public function DeleteSkill()
	{
		$this->generic->Delete('skills', array('skillID' => $this->uri->segment(2), 'companyID' => $this->session->userdata('companyDetails')['companyID']));
		$this->session->set_flashdata('successDeleted', 'Skill deleted successfully!');
		redirect(base_url('manage-workforce-skill'));
	}
	public function UpdateSkillData()
	{
		$skillName = $this->input->post('skillName');
		$skillDescription = $this->input->post('skillDescription');

		if ($skillName && $skillDescription) {
			$data = array(
				'skillName' => $skillName,
				'skillDesc' => $skillDescription
			);
			$this->generic->Update('skills', array('skillID' => $this->uri->segment(2)), $data);
			$this->session->set_flashdata('success-edited', 'Skill updated successfully!');
			redirect(base_url('manage-workforce-skill'));
		} else {
			$this->session->set_flashdata('error', 'Please fill all fields!');
			redirect(base_url('manage-workforce-skill'));
		}
	}
	// add work force module 
	public function addWorkforce()
	{
		//load all skills
		$this->data['skills'] = $this->generic->GetData('skills', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'skillID', 'DESC');
		$this->load->view('workforce/addWorkforce', $this->data);
	}
	public function addSkillDataAjax()
	{
		$skillName = $this->input->post('skillName');
		$skillDescription = $this->input->post('skillDescription');

		if ($skillName && $skillDescription) {
			$data = array(
				'companyID' => $this->session->userdata('companyDetails')['companyID'],
				'skillName' => $skillName,
				'skillDesc' => $skillDescription
			);
			$this->generic->InsertData('skills', $data);
			$getSkill = $this->generic->GetData('skills', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'skillID', 'DESC');
			$option = '';
			foreach ($getSkill as $skill) {
				$option .= '<option value="' . $skill['skillID'] . '">' . $skill['skillName'] . '</option>';
			}
			echo $option;
		} else {
			echo "error";
		}
	}
	public function addWorkForceData()
	{
		$personName = $this->input->post('personName');
		$personEmail = $this->input->post('personEmail');
		$personPhone = $this->input->post('personPhone');
		$personAddress = $this->input->post('personAddress');
		$personSkill = $this->input->post('personSkill');
		$checkEmail = $this->generic->GetData('users', array('userEmail' => $personEmail, 'userID !=' => $this->uri->segment(3)));
		if ($checkEmail) {
			$this->session->set_flashdata('emailExist', 'Email already exists!');
			if (isset($_GET['worforcelist']) && $_GET['worforcelist'] == 1) {
			redirect(base_url('all-workforce'));
		} else {

			redirect(base_url('add-workforce'));
		}
		}
		//check if we have image posted
		if (empty($_FILES['personImage']['name'])) {
			$personImage = 'images.png';
		} else {
			//upload person image
			$config['upload_path']          = './assets/uploads/workforce/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2048;
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);
			if (! $this->upload->do_upload('personImage')) {
				$error = array('error' => $this->upload->display_errors());
				// die(print_r($error));
				$this->session->set_flashdata('error', $error['error']);
				redirect(base_url('add-workforce'));
			} else {
				$uploadData = $this->upload->data();
				$personImage = $uploadData['file_name'];
			}
		}
		$data = array(
			'companyID' => $this->session->userdata('companyDetails')['companyID'],
			'personName' => $personName,
			'personEmail' => $personEmail,
			'personPhone' => $personPhone,
			'personAddInfo' => $personAddress,
			'personImg' => $personImage
		);
		$this->generic->InsertData('workforce', $data);
		//get recently added workforce id
		$workforceID = $this->db->insert_id();
		//insert skill data in workforce skill table


		if ($personSkill) {
			foreach ($personSkill as $skill) {
				$dataSkill = array(
					'workforceID' => $workforceID,
					'skillID' => $skill
				);
				$this->generic->InsertData('workforceskilllink', $dataSkill);
			}
		}
		//add user
		$userdata = array(
			'userName' => $personName,
			'userEmail' => $personEmail,
			'userPhone' => $personPhone,
			'userType' => 4,
			'userStatus' => 2
		);
		$this->generic->InsertData('users', $userdata);
		//add auth data

		//setup Authentaction
		$maxUserId = $this->generic->GetMaxID('users', 'userID');
		$authCode = rand(1000, 9999);
		$authTocken = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
		// check if token is generated already exists
		$checkAuthTocken = $this->generic->GetData('userauth', array('authTocken' => $authTocken, 'authStatus' => 0));
		if ($checkAuthTocken) {
			// if exists then generate new token
			$authTocken = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
		}
		$authData = array(
			'userId' => $maxUserId[0]['result'],
			'authCode' => $authCode,
			'authTocken' => $authTocken,
			'authStatus' => 0,
		);
		$this->generic->InsertData('userauth', $authData);

		//add company user link
		$companyUserData = array(
			'companyID' => $this->session->userdata('companyDetails')['companyID'],
			'userID' => $maxUserId[0]['result'],
			'workforceID' => $workforceID,
		);
		$this->generic->InsertData('usercompanyworkforcelink', $companyUserData);

		//send email to user with auth code and token url
		//send email
		$subject = 'Equip Manager - Account Verification';
		$message = 'Your account has been created successfully. Your verification code is: ' . $authCode . ' . Please click on the link to verify your account: ' . base_url('verify-account/' . $authTocken);
		$this->send_email($personEmail, $subject, $message);

		$this->session->set_flashdata('success-added', 'Workforce added successfully!');
		if (isset($_GET['worforcelist']) && $_GET['worforcelist'] == 1) {
			redirect(base_url('all-workforce'));
		} else {

			redirect(base_url('add-workforce'));
		}
	}
	public function allWorkforce()
	{
		// Get company ID from session
		$companyID = $this->session->userdata('companyDetails')['companyID'];

		// Load skills for the filter dropdown
		$this->data['skills'] = $this->generic->GetData('skills', array('companyID' => $companyID), 'skillID', 'DESC');

		// Build filter array from GET parameters
		$filters = array('companyID' => $companyID);

		if ($this->input->get('personSkill')) {
			$filters['skillID'] = $this->input->get('personSkill');
		}
		if ($this->input->get('personName')) {
			$filters['personName'] =  $this->input->get('personName') ;
		}
		if ($this->input->get('personPhone')) {
			$filters['personPhone'] = $this->input->get('personPhone');
		}
		if ($this->input->get('personEmail')) {
			$filters['personEmail'] = $this->input->get('personEmail');
		}
		if ($this->input->get('status')) {
			$filters['personStatus'] = $this->input->get('status');
		}

		// Get filtered workforce list
		$this->data['workforces'] = $this->generic->GetWorkforcewithSkill($filters);

		// Load view
		$this->load->view('workforce/allWorkforce', $this->data);
	}
	public function DeletePerson()
	{
		$this->generic->Delete('workforce', array('workforceID' => $this->uri->segment(2), 'companyID' => $this->session->userdata('companyDetails')['companyID']));
		$this->session->set_flashdata('successDeleted', 'Person deleted successfully!');
		redirect(base_url('all-workforce'));
	}
	public function editWorkForce()
	{
		$personName = $this->input->post('personName');
		$personEmail = $this->input->post('personEmail');
		$personPhone = $this->input->post('personPhone');
		$personAddress = $this->input->post('personAddress');
		$personSkill = $this->input->post('personSkill');
		//check email exsist in user
		//get user data from worforce id
		$curentuser = $this->generic->GetData('workforce', array('workforceID' => $this->uri->segment(2)));

		$checkEmail = $this->generic->GetData('users', array('userEmail' => $personEmail));
		if ($curentuser[0]['personEmail'] != $personEmail) {
			
			if ($checkEmail) {
			$this->session->set_flashdata('emailExist', 'Email already exists!');
			redirect(base_url('all-workforce'));
			}
		}
		//upload person image
		$config['upload_path']          = './assets/uploads/workforce/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		$config['encrypt_name']         = TRUE;
		$this->load->library('upload', $config);
		if (! $this->upload->do_upload('personImage')) {
			$error = array('error' => $this->upload->display_errors());
			// die(print_r($error));
			if ($error['error'] == '<p>You did not select a file to upload.</p>') {
				$data = array(
					'personName' => $personName,
					'personEmail' => $personEmail,
					'personPhone' => $personPhone,
					'personAddInfo' => $personAddress,
				);
				$this->generic->Update('workforce', array('workforceID' => $this->uri->segment(2)), $data);
				//delet all skill 
				$this->generic->Delete('workforceskilllink', array('workforceID' => $this->uri->segment(2)));
				if ($personSkill) {
					foreach ($personSkill as $skill) {
						$dataSkill = array(
							'workforceID' => $this->uri->segment(2),
							'skillID' => $skill
						);
						$this->generic->InsertData('workforceskilllink', $dataSkill);
					}
				}
				$this->session->set_flashdata('success-edited', 'Workforce updated successfully!');
				redirect(base_url('all-workforce'));
			} else {
				$this->session->set_flashdata('error', $error['error']);
				redirect(base_url('all-workforce'));
			}
		} else {
			$uploadData = $this->upload->data();
			$personImage = $uploadData['file_name'];
			$data = array(
				'personName' => $personName,
				'personEmail' => $personEmail,
				'personPhone' => $personPhone,
				'personAddInfo' => $personAddress,
				'personImg' => $personImage
			);
			$this->generic->Update('workforce', array('workforceID' => $this->uri->segment(2)), $data);
			//delet all skill 
				$this->generic->Delete('workforceskilllink', array('workforceID' => $this->uri->segment(2)));
				if ($personSkill) {
					foreach ($personSkill as $skill) {
						$dataSkill = array(
							'workforceID' => $this->uri->segment(2),
							'skillID' => $skill
						);
						$this->generic->InsertData('workforceskilllink', $dataSkill);
					}
				}
			$this->session->set_flashdata('success-edited', 'Workforce updated successfully!');
			redirect(base_url('all-workforce'));
		}
	}
}
