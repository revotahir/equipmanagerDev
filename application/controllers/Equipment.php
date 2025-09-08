<?php
defined('BASEPATH') or exit('No direct script access allowed');

class equipment extends MY_Controller
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
	public function ManageCategory()
	{
		//loadd all skill according to company id
		$this->data['categories'] = $this->generic->GetData('equipcat', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'equipCatID', 'DESC');
		$this->load->view('equipment/manageCategory', $this->data);
	}
	public function CategoryData()
	{
		$catName = $this->input->post('catName');
		$catDesc = $this->input->post('catDesc');

		if ($catName && $catDesc) {
			$data = array(
				'companyID' => $this->session->userdata('companyDetails')['companyID'],
				'catName' => $catName,
				'catDesc' => $catDesc
			);
			$this->generic->InsertData('equipcat', $data);
			$this->session->set_flashdata('success', 'Skill added successfully!');
			if (isset($_GET['equipmnetlist']) && $_GET['equipmnetlist'] == 1) {
				redirect(base_url('all-equipment'));
			} else {
				redirect(base_url('manage-category'));
			}
		} else {
			$this->session->set_flashdata('error', 'Please fill all fields!');
			redirect(base_url('manage-category'));
		}
	}
	public function deletCategory()
	{
		$this->generic->Delete('equipcat', array('equipCatID' => $this->uri->segment(2), 'companyID' => $this->session->userdata('companyDetails')['companyID']));
		$this->session->set_flashdata('successDeleted', 'Skill deleted successfully!');
		redirect(base_url('manage-category'));
	}
	public function CategoryUpdateData()
	{
		$catName = $this->input->post('catName');
		$catDesc = $this->input->post('catDesc');

		if ($catName && $catDesc) {
			$data = array(
				'catName' => $catName,
				'catDesc' => $catDesc
			);
			$this->generic->Update('equipcat', array('equipCatID' => $this->uri->segment(2)), $data);
			$this->session->set_flashdata('success-edited', 'Skill updated successfully!');
			redirect(base_url('manage-category'));
		} else {
			$this->session->set_flashdata('error', 'Please fill all fields!');
			redirect(base_url('manage-category'));
		}
	}
	// add work force module 
	public function AddEquipment()
	{
		//load all skills
		$this->data['category'] = $this->generic->GetData('equipcat', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'equipCatID', 'DESC');
		$this->load->view('equipment/addEquipment', $this->data);
	}
	public function AddEquipmentAjaxData()
	{
		$catName = $this->input->post('catName');
		$catDesc = $this->input->post('catDesc');

		if ($catName && $catDesc) {
			$data = array(
				'companyID' => $this->session->userdata('companyDetails')['companyID'],
				'catName' => $catName,
				'catDesc' => $catDesc
			);
			$this->generic->InsertData('equipcat', $data);
			$getCat = $this->generic->GetData('equipcat', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'equipCatID', 'DESC');
			$option = '';
			foreach ($getCat as $cat) {
				$option .= '<option value="' . $cat['equipCatID'] . '">' . $cat['catName'] . '</option>';
			}
			echo $option;
		} else {
			echo "error";
		}
	}
	public function AddEquipmentData()
	{
		$equipName = $this->input->post('equipName');
		$equipCatID = $this->input->post('equipCat');
		$equipTotalQuantity = $this->input->post('quantity');
		$equipDesc = $this->input->post('equipDesc');

		//check if we have image posted
		if (empty($_FILES['equipImg']['name'])) {
			$personImage = 'equipment.png';
			die('Please select image');
		} else {
			//upload person image
			$config['upload_path']          = './assets/uploads/equipment/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 2048;
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);
			if (! $this->upload->do_upload('equipImg')) {
				$error = array('error' => $this->upload->display_errors());
				// die(print_r($error));
				$this->session->set_flashdata('error', $error['error']);
				redirect(base_url('add-equipment'));
			} else {
				$uploadData = $this->upload->data();
				$personImage = $uploadData['file_name'];
			}
		}
		$data = array(
			'companyID' => $this->session->userdata('companyDetails')['companyID'],
			'equipName' => $equipName,
			'equipCatID' => $equipCatID,
			'equipTotalQuantity' => $equipTotalQuantity,
			'equipDesc' => $equipDesc,
			'equipImg' => $personImage,
		);
		$this->generic->InsertData('equipment', $data);



		$this->session->set_flashdata('success-added', 'Workforce added successfully!');
		if (isset($_GET['equipmentList']) && $_GET['equipmentList'] == 1) {
			redirect(base_url('all-equipment'));
		} else {

			redirect(base_url('add-equipment'));							
		}
		
	}
	public function AllEquipment()
	{
		// Get company ID from session
		$companyID = $this->session->userdata('companyDetails')['companyID'];

		// Load category for the filter dropdown
		$this->data['equipCat'] = $this->generic->GetData('equipcat', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'equipCatID', 'DESC');

		// Build filter array from GET parameters
		$filters = array('companyID' => $companyID);
		if ($this->input->get('equipName')) {
			$filters['equipName'] = $this->input->get('equipName');
		}
		if ($this->input->get('equipCatID')) {
			$filters['equipCatID'] = $this->input->get('equipCatID');
		}



		// Get filtered workforce list
		$this->data['equipment'] = $this->generic->GetEquipmentWithCat($filters);

		// Load view
		$this->load->view('equipment/equipmentList', $this->data);
	}
	public function DeleteEquipment()
	{
		$this->generic->Delete('equipment', array('equipmentID' => $this->uri->segment(2), 'companyID' => $this->session->userdata('companyDetails')['companyID']));
		$this->session->set_flashdata('successDeleted', 'Person deleted successfully!');
		redirect(base_url('all-equipment'));
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
