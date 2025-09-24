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
		if (isset($_GET['id'])) {
			//load project data by id
			$this->data['projectData'] = $this->generic->GetData('projects', array('ProjectID' => $_GET['id'], 'companyID' => $this->session->userdata('companyDetails')['companyID']));
			//load all allocatedd work force
			$this->data['selectedworkforce'] = $this->generic->GetWorkforceofPRoject(array('pwl.ProjectID' => $_GET['id']));
			//load all available equipment
			$this->data['allEquipment'] = $this->generic->GetEquipmentWithCat(false, array('e.companyID' => $this->session->userdata('companyDetails')['companyID']), true);
			$this->data['selectedEquipment'] = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $_GET['id']));
			//assigned equipment to workforce
			$this->data['assignedEquipments'] = $this->generic->GetAssignedEquipmentToWorkforce(array('aew.ProjectID' => $_GET['id']));
		}

		//load workforce data
		$this->data['workforce'] = $this->generic->GetData('workforce', array('companyID' => $this->session->userdata('companyDetails')['companyID'], 'personStatus' => 1), 'workforceID', 'DESC');
		//load all project category
		$this->data['Pcategory'] = $this->generic->GetData('projectcategory', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'pCatID', 'DESC');
		$this->load->view('project/addProject', $this->data);
	}
	public function AddProjectGeneralData()
	{
		// Load the helper for file uploads
		$this->load->helper('file');

		// Initialize the response
		$response = [];
		// Initialize the data array
		$data = [];
		$uploadedImages = [];
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
			// Ensure all pImg fields are set to NULL if no images are uploaded
			for ($i = count($uploadedImages) + 1; $i <= 10; $i++) {
				$data['pImg' . $i] = null;
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
		$data['pStatus'] = 1;
		$data['pDraftStatus'] = 2;
		if (isset($_GET['id'])) {
			// Update the data in the database (example)
			$this->generic->Update('projects', array('ProjectID' => $_GET['id']), $data);
			$projectID = $_GET['id'];
			echo "Projectupdated//" . $projectID;
		} else {
			// Save the data to the database (example)
			$this->db->insert('projects', $data);
			//getmax id
			$projectID = $this->generic->GetMaxID('projects', 'ProjectID');
			$projectID = $projectID[0]['result'];
			// Return success response
			echo "Projectadded//" . $projectID;
		}
	}
	public function AddProjecWorkforce()
	{
		$projectID = $_GET['id'];

		$workforceIDs = $this->input->post('workforceID');
		$data = array(
			'workforceID' => $workforceIDs,
			'ProjectID' => $projectID
		);
		$this->generic->InsertData('projectworkforcelink', $data);
		//update workforce to 2
		$this->generic->Update('workforce', array('workforceID' => $workforceIDs), array('personStatus' => 2));
		//get all workforce have status 1
		$newworkforce = $this->generic->GetData('workforce', array('companyID' => $this->session->userdata('companyDetails')['companyID'], 'personStatus' => 1), 'workforceID', 'DESC');
		//repaire work force select option
		$options = '<option value="">Select Workforce</option>';
		if ($newworkforce) {

			foreach ($newworkforce as $work) {
				$options .= '<option value="' . $work['workforceID'] . '">' . $work['personName'] . '</option>';
			}
		} else {
			$options .= '<option value="">No Workforce Available</option>';
		}
		//make card html of curent selectios
		$selectedworkforce = $this->generic->GetWorkforceofPRoject(array('pwl.ProjectID' => $projectID));
		$cardsHtml = '';
		foreach ($selectedworkforce as $work) {
			$getskill = $this->generic->GetWorkforcewithSkill(array(), array('w.workforceID' => $work['workforceID']));
			if ($getskill) {
				$skills = '';
				foreach ($getskill as $sk) {
					$skills .= $sk['skillNames'];
				}
			}
			$personImg = base_url('assets/uploads/workforce/' . $work['personImg']);
			// die($personImg);
			$cardsHtml .= '<div class="col close" style="position: relative" id="workforceCard_' . $work['workforceID'] . '">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="' . $personImg . '"
                                    class="card-img-top-main rounded-top"
                                    alt="' . $work['personName'] . '" />
									<a href="javascript:removeworkforce(' . $work['workforceID'] . ')" onclick="return confirm(\'Are you sure you want to remove this workforce from project?\')" style="">
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="grey" />
                                  </svg>
								  </a>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      ' . $work['personName'] . '
                                    </h5>
                                    <span class="text-muted">
									' . $skills . '
									</span>
                                  </div>
                                </div>
                              </div>
                            </div>';
		}
		echo "Workforceadded///" . $options . "///" . $cardsHtml;
	}
	public function removeWorkforceFromProject()
	{
		$workforceID = $this->input->post('workforceID');
		$projectID = $_GET['id'];
		if ($workforceID && $projectID) {
			//delete from project workforce link
			$this->generic->Delete('projectworkforcelink', array('workforceID' => $workforceID, 'ProjectID' => $projectID));
			//update workforce status to 1
			$this->generic->Update('workforce', array('workforceID' => $workforceID), array('personStatus' => 1));
			//get all workforce have status 1
			$newworkforce = $this->generic->GetData('workforce', array('companyID' => $this->session->userdata('companyDetails')['companyID'], 'personStatus' => 1), 'workforceID', 'DESC');
			//repaire work force select option
			$options = '<option value="">Select Workforce</option>';
			if ($newworkforce) {

				foreach ($newworkforce as $work) {
					$options .= '<option value="' . $work['workforceID'] . '">' . $work['personName'] . '</option>';
				}
			} else {
				$options .= '<option value="">No Workforce Available</option>';
			}
			//make card html of curent selectios
			$selectedworkforce = $this->generic->GetWorkforceofPRoject(array('pwl.ProjectID' => $projectID));
			$cardsHtml = '';
			foreach ($selectedworkforce as $work) {
				$getskill = $this->generic->GetWorkforcewithSkill(array(), array('w.workforceID' => $work['workforceID']));
				if ($getskill) {
					$skills = '';
					foreach ($getskill as $sk) {
						$skills .= $sk['skillNames'];
					}
				}
				$personImg = base_url('assets/uploads/workforce/' . $work['personImg']);
				// die($personImg);
				$cardsHtml .= '<div class="col close" style="position: relative" id="workforceCard_' . $work['workforceID'] . '">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="' . $personImg . '"
                                    class="card-img-top-main rounded-top"
                                    alt="' . $work['personName'] . '" />
									<a href="javascript:removeworkforce(' . $work['workforceID'] . ')" onclick="return confirm(\'Are you sure you want to remove this workforce from project?\')" style="">
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="grey" />
                                  </svg>
								  </a>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      ' . $work['personName'] . '
                                    </h5>
                                    <span class="text-muted">
									' . $skills . '
									</span>
                                  </div>
                                </div>
                              </div>
                            </div>';
			}
			echo "Workforceremoved///" . $options . "///" . $cardsHtml;
		} else {
			echo "Invalid Request!";
		}
	}

	//ajax add project equipment
	public function addProjectEquipment()
	{
		$projectID = $_GET['id'];
		$equipmentID = $this->input->post('equipmentID');
		$qty = $this->input->post('qty');
		if ($projectID && $equipmentID && $qty) {
			//check if equipment already added to project
			$check = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID));
			$updateCheck = false;

			if ($check) {
				//update quantity
				$newQty = $check[0]['equipmentQTY'] + $qty;
				$this->generic->Update('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID), array('equipmentQTY' => $newQty));
				$updateCheck = true;
			} else {
				//add to project equipment link
				$data = array(
					'ProjectID' => $projectID,
					'equipmentID' => $equipmentID,
					'equipmentQTY' => $qty
				);
				$this->generic->InsertData('projectequipmentlink', $data);
			}
			//update equipment in use quantity
			$equipment = $this->generic->GetData('equipment', array('equipmentID' => $equipmentID));
			if ($equipment) {
				$newInUseQty = $equipment[0]['equipInUseQuantity'] + $qty;
				$this->generic->Update('equipment', array('equipmentID' => $equipmentID), array('equipInUseQuantity' => $newInUseQty));
			}
			//get all available equipment
			$availableEquipment = $this->generic->GetEquipmentWithCat(false, array('e.companyID' => $this->session->userdata('companyDetails')['companyID']), true);
			//repaire equipment select option
			$options = '<option value="">Select Equipment</option>';
			if ($availableEquipment) {
				foreach ($availableEquipment as $equip) {
					$availableQty = $equip['equipTotalQuantity'] - $equip['equipInUseQuantity'];
					if ($availableQty > 0) {
						$options .= '<option value="' . $equip['equipmentID'] . '" data-available-qty="' . $availableQty . '">' . $equip['equipName'] . ' (Available: ' . $availableQty . ')</option>';
					}
				}
			} else {
				$options .= '<option value="">No Equipment Available</option>';
			}
			//make card html of curent selections
			$selectedEquipment = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID));
			$cardsHtml = '';
			foreach ($selectedEquipment as $equipLink) {
				$equipDetails = $this->generic->GetData('equipment', array('equipmentID' => $equipLink['equipmentID']));
				//get category name
				$equipmentCat = $this->generic->GetData('equipcat', array('equipCatID' => $equipDetails[0]['equipCatID']));
				if ($equipDetails) {
					$equip = $equipDetails[0];
					$cardsHtml .= '<div class="col close" style="position: relative">
                              <div class="card border shadow-none h-100">
                                <div class="text-start">
                                  <img
                                    src="' . base_url() . 'assets/uploads/equipment/' . $equip['equipImg'] . '"
                                    class="card-img-top-main rounded-top img-fix-cover"
                                    alt="Helen Heidenreich" />
									<a href="javascript:removeequipment(' . $equip['equipmentID'] . ')" onclick="return confirm(\'Are you sure you want to remove this equipment from project?\')" style="">
                                  <svg
                                    width="29"
                                    height="29"
                                    viewBox="0 0 29 29"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
                                      fill="grey" />
                                  </svg>
								  </a>

                                  <div class="card-body p-3">
                                    <h5 class="card-title mb-1">
                                      ' . $equip['equipName'] . ' (Qty: ' . $equipLink['equipmentQTY'] . ')
                                    </h5>
                                    <span class="text-muted">' . $equipmentCat[0]['catName'] . '</span>
                                  </div>
                                </div>
                              </div>
                            </div>';
				}
			}
			if ($updateCheck) {
				echo "EquipmentUpdated///" . $options . "///" . $cardsHtml;
			} else {
				echo "Equipmentadded///" . $options . "///" . $cardsHtml;
			}
		} else {
			echo "Invalid Request!";
		}
	}
	public function RemoveProjectEquipment()
	{
		$equipmentID = $this->input->post('equipmentID');
		$projectID = $_GET['id'];
		if ($equipmentID && $projectID) {
			//get equipment link to know quantity
			$equipLink = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID));
			if ($equipLink) {
				$qty = $equipLink[0]['equipmentQTY'];
				//delete from project equipment link
				$this->generic->Delete('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID));
				//update equipment in use quantity
				$equipment = $this->generic->GetData('equipment', array('equipmentID' => $equipmentID));
				if ($equipment) {
					$newInUseQty = $equipment[0]['equipInUseQuantity'] - $qty;
					$this->generic->Update('equipment', array('equipmentID' => $equipmentID), array('equipInUseQuantity' => $newInUseQty));
				}
			}
			//get all available equipment
			$availableEquipment = $this->generic->GetEquipmentWithCat(false, array('e.companyID' => $this->session->userdata('companyDetails')['companyID']), true);
			//repaire equipment select option
			$options = '<option value="">Select Equipment</option>';
			if ($availableEquipment) {
				foreach ($availableEquipment as $equip) {
					$availableQty = $equip['equipTotalQuantity'] - $equip['equipInUseQuantity'];
					if ($availableQty > 0) {
						$options .= '<option value="' . $equip['equipmentID'] . '" data-available-qty="' . $availableQty . '">' . $equip['equipName'] . ' (Available: ' . $availableQty . ')</option>';
					}
				}
			} else {
				$options .= '<option value="">No Equipment Available</option>';
			}
			//make card html of curent selections
			$selectedEquipment = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID));
			$cardsHtml = '';
			foreach ($selectedEquipment as $equipLink) {
				$equipDetails = $this->generic->GetData('equipment', array('equipmentID' => $equipLink['equipmentID']));
				//get category name
				$equipmentCat = $this->generic->GetData('equipcat', array('equipCatID' => $equipDetails[0]['equipCatID']));
				if ($equipDetails) {
					$equip = $equipDetails[0];
					$cardsHtml .= '<div class="col close" style="position: relative">
							  <div class="card border shadow-none h-100">
								<div class="text-start">
								  <img
									src="' . base_url() . 'assets/uploads/equipment/' . $equip['equipImg'] . '"
									class="card-img-top-main rounded-top img-fix-cover"
									alt="Helen Heidenreich" />
									 <a href="javascript:removeequipment(' . $equip['equipmentID'] . ')" onclick="return confirm(\'Are you sure you want to remove this equipment from project?\')" style="">
								  <svg
									width="29"
									height="29"
									viewBox="0 0 29 29"
									fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
									  d="M19.323 18.1157L15.6999 14.4925L19.323 10.8694C19.4832 10.7092 19.5732 10.492 19.5732 10.2655C19.5732 10.039 19.4832 9.82181 19.323 9.66166C19.1629 9.50151 18.9457 9.41154 18.7192 9.41154C18.4927 9.41154 18.2755 9.50151 18.1153 9.66166L14.4922 13.2848L10.869 9.66166C10.7089 9.50151 10.4917 9.41154 10.2652 9.41154C10.0387 9.41154 9.82149 9.50151 9.66134 9.66166C9.50118 9.82181 9.41121 10.039 9.41121 10.2655C9.41121 10.492 9.50118 10.7092 9.66134 10.8694L13.2845 14.4925L9.66134 18.1157C9.50118 18.2758 9.41121 18.493 9.41121 18.7195C9.41121 18.946 9.50118 19.1632 9.66134 19.3234C9.82149 19.4835 10.0387 19.5735 10.2652 19.5735C10.4917 19.5735 10.7089 19.4835 10.869 19.3234L14.4922 15.7002L18.1153 19.3234C18.2755 19.4835 18.4927 19.5735 18.7192 19.5735C18.9457 19.5735 19.1629 19.4835 19.323 19.3234C19.4832 19.1632 19.5732 18.946 19.5732 18.7195C19.5732 18.493 19.4832 18.2758 19.323 18.1157Z"
									  fill="grey" />
								  </svg>
								  </a>	
								  <div class="card-body p-3">
									<h5 class="card-title mb-1">
									  ' . $equip['equipName'] . ' (Qty: ' . $equipLink['equipmentQTY'] . ')
									</h5>
									<span class="text-muted">' . $equipmentCat[0]['catName'] . '</span>
								  </div>
								</div>
							  </div>
							</div>';
				}
			}
			echo "Equipmentremoved///" . $options . "///" . $cardsHtml;
		} else {
			echo "Invalid Request!";
		}
	}
	public function MovetoStepThree()
	{
		$projectID = $_GET['id'];
		if ($projectID) {
			//update project draft status to 3
			$this->generic->Update('projects', array('ProjectID' => $projectID), array('pDraftStatus' => 3));
			//get updated selected workforce for options
			$selectedworkforce = $this->generic->GetWorkforceofPRoject(array('pwl.ProjectID' => $projectID));
			$options = '<option value="">Select Workforce</option>';
			if ($selectedworkforce) {
				foreach ($selectedworkforce as $work) {
					$options .= '<option value="' . $work['workforceID'] . '">' . $work['personName'] . '</option>';
				}
			} else {
				$options .= '<option value="">No Workforce Available</option>';
			}
			//get all selected equipment for options
			$selectedEquipment = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID));
			$equipOptions = '<option value="">Select Equipment</option>';
			if ($selectedEquipment) {
				foreach ($selectedEquipment as $equipLink) {
					$equipDetails = $this->generic->GetData('equipment', array('equipmentID' => $equipLink['equipmentID']));
					if ($equipDetails) {
						$equip = $equipDetails[0];
						$availableQty = $equipLink['equipmentQTY'] - $equipLink['TotalAssignQTY'];
						if ($availableQty > 0) {
							$equipOptions .= '<option value="' . $equip['equipmentID'] . '" data-available-assign-qty="' . $availableQty . '">' . $equip['equipName'] . ' (Available: ' . $availableQty . ')</option>';
						}
					}
				}
			} else {
				$equipOptions .= '<option value="">No Equipment Available</option>';
			}

			echo "Success///" . $options . "///" . $equipOptions;
		} else {
			echo "Invalid Request!";
		}
	}
	public function assignEquipmenttoEmployee()
	{
		$projectID = $_GET['id'];
		$workforceID = $this->input->post('workforceID');
		$equipmentID = $this->input->post('equipmentID');
		$assignQty = $this->input->post('assqty');

		if ($projectID && $workforceID && $equipmentID) {

			// check if worker have same equipment assigned, update the quantity then dont remove old assignments
			$checkExisting = $this->generic->GetData('projectequipmentassign', array('ProjectID' => $projectID, 'workforceID' => $workforceID, 'equipmentID' => $equipmentID));
			$updateCheck = false;
			if ($checkExisting) {
				//update quantity
				$newQty = $checkExisting[0]['assignedQty'] + $assignQty;
				$this->generic->Update('projectequipmentassign', array('ProjectID' => $projectID, 'workforceID' => $workforceID, 'equipmentID' => $equipmentID), array('assignedQty' => $newQty));
				$updateCheck = true;
			} else {
				// add new assignment
				$data = array(
					'ProjectID' => $projectID,
					'workforceID' => $workforceID,
					'equipmentID' => $equipmentID,
					'assignedQty' => $assignQty
				);
				$this->generic->InsertData('projectequipmentassign', $data);
			}

			//update assigned quantiy in project equipment link
			$equipLink = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID));
			if ($equipLink) {
				$newAssignedQty = $equipLink[0]['TotalAssignQTY'] + $assignQty;
				$this->generic->Update('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID), array('TotalAssignQTY' => $newAssignedQty));
			}

			//load all assigned equipment to workforce and make table tr
			$assignedEquipments = $this->generic->GetAssignedEquipmentToWorkforce(array('aew.ProjectID' => $projectID));

			$rowsHtml = '';
			$sr = 0;
			foreach ($assignedEquipments as $assign) {
				$sr++;
				$rowsHtml .= '<tr>
                        <td>' . $sr . '.</td>
                        <td>' . $assign['equipName'] . '</td>
                        <td>' . $assign['assignedQty'] . '</td>
                        <td>
                          <div class="employee">
                            <img
                              src="' . base_url() . 'assets/uploads/workforce/' . $assign['personImg'] . '"
                              alt="client" />
                            <span>' . $assign['personName'] . '</span>
                          </div>
                        </td>
                        <td>
                          <div
                            class="table-actions d-flex align-items-center gap-3 fs-6">
                            
                            <a
                              href="javascript:;"
                              class="text-danger"
							  onclick="confirm(\'Are you sure you want to delete this assignment?\') ? deleteAssignedEquipment(' . $assign['assignID'] . ') : false"
                              data-bs-toggle="tooltip"
                              data-bs-placement="bottom"
                              title="Delete"><i class="bi bi-trash-fill"></i></a>
                          </div>
                        </td>
                      </tr>';
			}

			//get selected with updated quantity
			$selectedEquipment = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID));
			$options = '<option value="">Select Equipment</option>';
			if ($selectedEquipment) {
				foreach ($selectedEquipment as $equipLink) {
					$equipDetails = $this->generic->GetData('equipment', array('equipmentID' => $equipLink['equipmentID']));
					if ($equipDetails) {
						$equip = $equipDetails[0];
						$availableQty = $equipLink['equipmentQTY'] - $equipLink['TotalAssignQTY'];
						if ($availableQty > 0) {
							$options .= '<option value="' . $equip['equipmentID'] . '" data-available-assign-qty="' . $availableQty . '">' . $equip['equipName'] . ' (Available: ' . $availableQty . ')</option>';
						}
					}
				}
			} else {
				$options .= '<option value="">No Equipment Available</option>';
			}


			if ($updateCheck) {
				echo "EquipmentAssignmentUpdated///" . $rowsHtml . "///" . $options;
			} else {
				echo "EquipmentAssigned///" . $rowsHtml . "///" . $options;
			}
		} else {
			echo "Invalid Request!";
		}
	}
	public function removeAssignEquipmenttoEmployee()
	{
		$assignID = $this->input->post('assignID');
		$projectID = $_GET['id'];
		if ($assignID && $projectID) {
			//get assignment details
			$assignment = $this->generic->GetData('projectequipmentassign', array('assignID' => $assignID));
			if ($assignment) {
				$workforceID = $assignment[0]['workforceID'];
				$equipmentID = $assignment[0]['equipmentID'];
				$assignedQty = $assignment[0]['assignedQty'];
				//delete assignment
				$this->generic->Delete('projectequipmentassign', array('assignID' => $assignID));
				//update assigned quantity in project equipment link
				$equipLink = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID));
				if ($equipLink) {
					$newAssignedQty = $equipLink[0]['TotalAssignQTY'] - $assignedQty;
					$this->generic->Update('projectequipmentlink', array('ProjectID' => $projectID, 'equipmentID' => $equipmentID), array('TotalAssignQTY' => $newAssignedQty));
				}
			}
			//load all assigned equipment to workforce and make table tr
			$assignedEquipments = $this->generic->GetAssignedEquipmentToWorkforce(array('aew.ProjectID' => $projectID));

			$rowsHtml = '';
			$sr = 0;
			if ($assignedEquipments) {
				foreach ($assignedEquipments as $assign) {
					$sr++;
					$rowsHtml .= '<tr>
						<td>' . $sr . '.</td>
						<td>' . $assign['equipName'] . '</td>
						<td>' . $assign['assignedQty'] . '</td>
						<td>
						  <div class="employee">
							<img
							  src="' . base_url() . 'assets/uploads/workforce/' . $assign['personImg'] . '"
							  alt="client" />
							<span>' . $assign['personName'] . '</span>
						  </div>
						</td>
						<td>
						  <div
							class="table-actions d-flex align-items-center gap-3 fs-6">
							
							<a
							  href="javascript:;"
							  class="text-danger"
							  data-bs-toggle="tooltip"
							  data-bs-placement="bottom"
							  title="Delete"><i class="bi bi-trash-fill"></i></a>
						  </div>	
						</td>
					  </tr>';
				}
			} else {
				$rowsHtml = '<tr><td colspan="5" class="text-center">No Equipment Assigned Yet</td></tr>';
			}
			//get selected with updated quantity
			$selectedEquipment = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID));
			$options = '<option value="">Select Equipment</option>';
			if ($selectedEquipment) {
				foreach ($selectedEquipment as $equipLink) {
					$equipDetails = $this->generic->GetData('equipment', array('equipmentID' => $equipLink['equipmentID']));
					if ($equipDetails) {
						$equip = $equipDetails[0];
						$availableQty = $equipLink['equipmentQTY'] - $equipLink['TotalAssignQTY'];
						if ($availableQty > 0) {
							$options .= '<option value="' . $equip['equipmentID'] . '" data-available-assign-qty="' . $availableQty . '">' . $equip['equipName'] . ' (Available: ' . $availableQty . ')</option>';
						}
					}
				}
			} else {
				$options .= '<option value="">No Equipment Available</option>';
			}
			echo "EquipmentAssignmentRemoved///" . $rowsHtml . "///" . $options;
		} else {
			echo "Invalid Request!";
		}
	}
	public function MarkInProgressProject()
	{
		$projectID = $_GET['id'];
		if ($projectID) {
			//update project draft status to 4
			$this->generic->Update('projects', array('ProjectID' => $projectID), array('pStatus' => 2));
			//set session message
			$this->session->set_flashdata('successaddedd', 'Project marked as In Progress successfully.');
			redirect(base_url('add-project'));
		} else {
			echo "Invalid Request!";
		}
	}
	//all progress module
	public function AllProjects()
	{
		if (isset($_GET['projectName'])) {
			// Get all filters
			$filters = array(
				'p.companyID' => $this->session->userdata('companyDetails')['companyID'],
			);

			if (!empty($_GET['projectName'])) {
				$filters['p.pName LIKE'] = '%' . $_GET['projectName'] . '%';
			}

			if (!empty($_GET['projectCat'])) {
				$filters['p.pCatID'] = $_GET['projectCat'];
			}

			if (!empty($_GET['startDate'])) {
				$filters['p.pStartDate >='] = $_GET['startDate'];
			}

			if (!empty($_GET['enddate'])) {
				$filters['p.pEndDate <='] = $_GET['enddate'];
			}

			if (!empty($_GET['pstatus'])) {
				$filters['p.pStatus'] = $_GET['pstatus'];
			}

			if (!empty($_GET['location'])) {
				$filters['p.pLocation LIKE'] = '%' . $_GET['location'] . '%';
			}

			// Call model function to get filtered projects
			$this->data['projects'] = $this->generic->GetProjectsWithDetails($filters);
		} else {
			// Get all projects of the company
			$this->data['projects'] = $this->generic->GetProjectsWithDetails(array('p.companyID' => $this->session->userdata('companyDetails')['companyID']));
		}
		//load project category for filter
		$this->data['projectCats'] = $this->generic->GetData('projectcategory', array('companyID' => $this->session->userdata('companyDetails')['companyID']), 'pCatID', 'DESC');
		$this->load->view('project/all-projects', $this->data);
	}
	public function DeletProject()
	{
		$projectID = $this->uri->segment(2);
		if ($projectID) {
			//delet all images from folder
			$project = $this->generic->GetData('projects', array('ProjectID' => $projectID));
			if ($project) {
				$project = $project[0];
				for ($i = 1; $i <= 10; $i++) {
					$imageField = 'pImg' . $i; // Dynamically generate the field name (pImg1, pImg2, ..., pImg10)
					if (!empty($project[$imageField]) && file_exists('./assets/uploads/projectImgs/' . $project[$imageField])) {
						unlink('./assets/uploads/projectImgs/' . $project[$imageField]); // Delete the file
					}
				}
			}
			//delete project
			$this->generic->Delete('projects', array('ProjectID' => $projectID));
			//set all assigned workforce status to 1
			$assignedWorkforce = $this->generic->GetWorkforceofPRoject(array('pwl.ProjectID' => $projectID));
			if ($assignedWorkforce) {
				foreach ($assignedWorkforce as $work) {
					$this->generic->Update('workforce', array('workforceID' => $work['workforceID']), array('personStatus' => 1));
				}
			}
			//delete project workforce link
			$this->generic->Delete('projectworkforcelink', array('ProjectID' => $projectID));
			//update equipment in use quantity
			$assignedEquipment = $this->generic->GetData('projectequipmentlink', array('ProjectID' => $projectID));
			if ($assignedEquipment) {
				foreach ($assignedEquipment as $equipLink) {
					$equipment = $this->generic->GetData('equipment', array('equipmentID' => $equipLink['equipmentID']));
					if ($equipment) {
						$newInUseQty = $equipment[0]['equipInUseQuantity'] - $equipLink['equipmentQTY'];
						$this->generic->Update('equipment', array('equipmentID' => $equipLink['equipmentID']), array('equipInUseQuantity' => $newInUseQty));
					}
				}
			}
			//delete project equipment link
			$this->generic->Delete('projectequipmentlink', array('ProjectID' => $projectID));
			//delete project equipment assignment
			$this->generic->Delete('projectequipmentassign', array('ProjectID' => $projectID));
			//set session message
			$this->session->set_flashdata('deletedproject', 'Project deleted successfully.');
			redirect(base_url('all-projects'));
		}
	}
}
