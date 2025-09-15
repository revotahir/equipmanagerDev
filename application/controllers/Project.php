<?php
defined('BASEPATH') or exit('No direct script access allowed');

class project extends MY_Controller
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
	public function ProjectCategory()
	{
		//loadd all skill according to company id
		$this->data['projectcategory'] = $this->generic->GetData('projectcategory', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'pCatID', 'DESC');
		$this->load->view('project/projectCat', $this->data);
	}
	public function ProjectCategoryData()
	{
		$catName = $this->input->post('pCatName');
		$catDesc = $this->input->post('pCatDesc');

		if ($catName && $catDesc) {
			$data = array(
				'companyID' => $this->session->userdata('companyDetails')['companyID'],
				'pCatName' => $catName,
				'pCatDesc' => $catDesc
			);
			$this->generic->InsertData('projectcategory', $data);
			$this->session->set_flashdata('successcat-added', 'Skill added successfully!');
			// if (isset($_GET['equipmnetlist']) && $_GET['equipmnetlist'] == 1) {
			// 	redirect(base_url('all-equipment'));
			// } else {
			// 	redirect(base_url('manage-category'));
			// }
			redirect(base_url('project-category'));
		} else {
			$this->session->set_flashdata('error', 'Please fill all fields!');
			redirect(base_url('project-category'));
		}
	}
	public function ProjectCategoryDeletData()
	{
		$this->generic->Delete('projectcategory', array('pCatID' => $this->uri->segment(2), 'companyID' => $this->session->userdata('companyDetails')['companyID']));
		$this->session->set_flashdata('successDeleted', 'Skill deleted successfully!');
		redirect(base_url('project-category'));
	}
	public function ProjectCategoryEditData()
	{
		$catName = $this->input->post('pCatName');
		$catDesc = $this->input->post('pCatDesc');

		if ($catName && $catDesc) {
			$data = array(
				'pCatName' => $catName,
				'pCatDesc' => $catDesc
			);
			$this->generic->Update('projectcategory', array('pCatID' => $this->uri->segment(2)), $data);
			$this->session->set_flashdata('success-edited', 'Skill updated successfully!');
			redirect(base_url('project-category'));
		} else {
			$this->session->set_flashdata('error', 'Please fill all fields!');
			redirect(base_url('project-category'));
		}
	}
	// add project module 
	public function AddProject()
	{
		//load all skills
		$this->data['Pcategory'] = $this->generic->GetData('projectcategory', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'pCatID', 'DESC');
		$this->load->view('project/addProject', $this->data);
	}
	public function AddProjectGeneralData()
	{
		// Load the helper for file uploads
		$this->load->helper('file');

		// Initialize the response
		$response = [];

		// Check if files are uploaded
		if (!empty($_FILES['pImg']['name'][0])) {
			$files = $_FILES['pImg'];
			$fileCount = count($files['name']);

			// Check if the file count exceeds the limit
			if ($fileCount > 10) {
				echo "File limit exceeded. Maximum 10 images allowed.";
				return;
			}

			// Path to upload directory
			$uploadPath = './assets/uploads/projectImgs/';
			if (!is_dir($uploadPath)) {
				mkdir($uploadPath, 0777, true);
			}

			// Initialize the data array
			$data = [];
			$uploadedImages = [];

			// Loop through each file and upload
			for ($i = 0; $i < $fileCount; $i++) {
				$_FILES['file']['name'] = $files['name'][$i];
				$_FILES['file']['type'] = $files['type'][$i];
				$_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['file']['error'] = $files['error'][$i];
				$_FILES['file']['size'] = $files['size'][$i];

				// Set upload configuration
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = '*';
				$config['max_size'] = 4048; // 2MB
				$config['file_name'] = uniqid() . '_' . time();

				// Load upload library
				$this->load->library('upload', $config);

				// Attempt to upload the file
				if ($this->upload->do_upload('file')) {
					$uploadData = $this->upload->data();
					$uploadedImages[] = $uploadData['file_name'];
				} else {
					echo "Error uploading file: " . $this->upload->display_errors();
					return;
				}
			}

			// Add uploaded images to the data array
			foreach ($uploadedImages as $key => $image) {
				$data['pImg' . ($key + 1)] = $image;
			}
		}

		// Add other form data to the data array
		$data['companyID'] = $this->session->userdata('companyDetails')['companyID'];
		$data['pName'] = $this->input->post('pName');
		$data['pCatID'] = $this->input->post('pCatID');
		$data['pLocation'] = $this->input->post('pLocation');
		$data['pStartDate'] = $this->input->post('pStartDate');
		$data['pEndDate'] = $this->input->post('pEndDate');
		$data['pDesc'] = $this->input->post('pDesc');
		$data['pStatus'] =1;

		// Save the data to the database (example)
		$this->db->insert('projects', $data);
		//getmax id
		$projectID=$this->generic->GetMaxID('projects','ProjectID');
		// Return success response
		echo "Projectadded//".$projectID[0]['result'];
	}
}
