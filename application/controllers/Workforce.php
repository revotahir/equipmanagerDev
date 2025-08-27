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
			if(isset($_GET['allWorkforce']) && $_GET['allWorkforce']==1){
				redirect(base_url('all-workforce'));
			}else{

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
		//upload person image
		$config['upload_path']          = './assets/uploads/workforce/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		$config['encrypt_name']         = TRUE;
		$this->load->library('upload', $config);
		if (! $this->upload->do_upload('personImage')) {
			$error = array('error' => $this->upload->display_errors());
			die(print_r($error));
			$this->session->set_flashdata('error', $error['error']);
			redirect(base_url('add-workforce'));
		} else {
			$uploadData = $this->upload->data();
			$personImage = $uploadData['file_name'];
		}
		$data = array(
			'companyID' => $this->session->userdata('companyDetails')['companyID'],
			'personName' => $personName,
			'personEmail' => $personEmail,
			'personPhone' => $personPhone,
			'personAddInfo' => $personAddress,
			'skillID' => $personSkill,
			'personImg' => $personImage
		);
		$this->generic->InsertData('workforce', $data);
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
        $filters['personName LIKE'] = '%' . $this->input->get('personName') . '%';
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
					'skillID' => $personSkill
				);
				$this->generic->Update('workforce', array('workforceID' => $this->uri->segment(2)), $data);
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
				'skillID' => $personSkill,
				'personImg' => $personImage
			);
			$this->generic->Update('workforce', array('workforceID' => $this->uri->segment(2)), $data);
			$this->session->set_flashdata('success-edited', 'Workforce updated successfully!');	
			redirect(base_url('all-workforce'));
		}
	}
}
