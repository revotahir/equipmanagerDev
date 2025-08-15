<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('Generic_model', 'generic');
		if (isset($this->session->userdata['loginData']['userID'])) {
			$this->data['cartCount'] = $this->generic->GetCount('cart', 'cartID', array('customerID' => $this->session->userdata['loginData']['userID'], 'cartStatus' => 0));
		}
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
	public function index()
	{
		$this->load->view('login');
	}
	// <!-- ============================================================== -->
	// <!-- Login function -->
	// <!-- ============================================================== -->
	public function LoginData()
	{
		$email = $this->input->post('email-address');
		$pass = $this->input->post('email-password');
		// get user 
		$user = $this->generic->GetData('users', array('userEmail' => $email, 'userPass' => $pass, 'userStatus' => 1));
		if ($user) {
			$this->session->set_userdata('loginData', $user[0]);
			if ($user[0]['userType'] == 1) {
				redirect(base_url('dashboard'));
			} else {
				redirect(base_url('customer-dashboard'));
			}
		} else {
			$this->session->set_flashdata('error', 1);
			redirect(base_url());
		}
	}

	// <!-- ============================================================== -->
	// <!-- redirect to dashboard -->
	// <!-- ============================================================== -->

	// redirect to page with check
	public function AdminDashboard()
	{
		if ($this->session->userdata('loginData')) {
			$this->load->view('dashboard-admin');
		} else {
			redirect(base_url());
		}
	}


	// <!-- ============================================================== -->
	// <!-- vendor redirect and insert function -->
	// <!-- ============================================================== -->

	// redirect to page with check
	public function AdminVendors()
	{
		if ($this->session->userData('loginData')) {
			$this->load->view('add-vendors');
		} else {
			redirect(base_url());
		}
	}
	// add vendor
	public function AddAdminVendors()
	{
		$userName = $this->input->post('user-name');
		$userEmail = $this->input->post('user-email');
		$userPhone = $this->input->post('user-phone');
		$userPassword = $this->input->post('user-password');

		$this->db->where('userEmail', $userEmail);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			$this->session->set_flashdata('alreadyRegistered', 1);
			redirect(base_url('vendors'));
		} else {
			$VendorUserData = array(
				'userName' => $userName,
				'userEmail' => $userEmail,
				'userPhone' => $userPhone,
				'userPass' => $userPassword,
				'userType' => 3,
			);
			$this->generic->InsertData('users', $VendorUserData);
			$this->session->set_flashdata('successfullyRegistered', 1);
			redirect(base_url('vendors'));
		}
	}
	// show vendor data
	public function AllAdminVendors()
	{
		if ($this->session->userData('loginData')) {
			$this->data['vendorsList'] = $this->generic->GetData('users', array('userType' => 3));
			$this->load->view('vendors-data', $this->data);
		} else {
			redirect(base_url());
		}
	}
	// deactive vendor 
	public function deactivateVendor()
	{
		$this->generic->Update('users', array('userID' => $this->uri->segment(2)), array('userStatus' => 0));
		$this->session->set_flashdata('vendorDeactivated', 1);
		redirect(base_url('all-vendor'));
	}
	// active vendor
	public function activateVendor()
	{
		$this->generic->Update('users', array('userID' => $this->uri->segment(2)), array('userStatus' => 1));
		$this->session->set_flashdata('vendorActivated', 1);
		redirect(base_url('all-vendor'));
	}
	// delete vendor
	public function deleteVendor()
	{
		$this->generic->Delete('users', array('userID' => $this->uri->segment(2)));
		$this->session->set_flashdata('vendorDeleted', 1);
		redirect(base_url('all-vendor'));
	}
	// update vendor
	public function updateVendor()
	{
		$this->data['vendor'] = $this->generic->GetData('users', array('userID' => $this->uri->segment(2)));
		$this->load->view('update-vendor', $this->data);
	}
	public function updateVendorData()
	{
		$userName = $this->input->post('user-name');
		$userEmail = $this->input->post('user-email');
		$userPhone = $this->input->post('user-phone');
		$userPassword = $this->input->post('user-password');
		$VendorUserData = array(
			'userName' => $userName,
			'userEmail' => $userEmail,
			'userPhone' => $userPhone,
			'userPass' => $userPassword,
		);
		$this->generic->Update('users', array('userID' => $this->uri->segment(2)), $VendorUserData);
		$this->session->set_flashdata('VendorUpdated', 1);
		redirect(base_url('all-vendor'));
	}

	// <!-- ============================================================== -->
	// <!-- customer redirect and insert function -->
	// <!-- ============================================================== -->

	// redirect to page with check
	public function AdminCustomers()
	{
		if ($this->session->userData('loginData')) {
			$this->load->view('add-customers');
		} else {
			redirect(base_url());
		}
	}

	// add customer
	public function AddAdminCustomers()
	{
		$userName = $this->input->post('cstm-user-name');
		$userEmail = $this->input->post('cstm-user-email');
		$userPhone = $this->input->post('cstm-user-phone');
		$userPassword = $this->input->post('cstm-user-password');

		$this->db->where('userEmail', $userEmail);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			$this->session->set_flashdata('alreadyRegistered', 1);
			redirect(base_url('customers'));
		} else {
			$customerUserData = array(
				'userName' => $userName,
				'userEmail' => $userEmail,
				'userPhone' => $userPhone,
				'userPass' => $userPassword,
				'userType' => 2,
			);
			$this->generic->InsertData('users', $customerUserData);
			$this->session->set_flashdata('successfullyRegistered', 1);
			redirect('customers');
		}
	}
	// show customer data
	public function AllAdminCustomers()
	{
		if ($this->session->userData('loginData')) {
			$this->data['customersList'] = $this->generic->GetData('users', array('userType' => 2));
			$this->load->view('customers-data', $this->data);
		} else {
			redirect(base_url());
		}
	}
	// deactive customer
	public function deactivateCustomers()
	{
		$this->generic->Update('users', array('userID' => $this->uri->segment(2)), array('userStatus' => 0));
		$this->session->set_flashdata('customerDeactivated', 1);
		redirect(base_url('all-customer'));
	}
	// active customer
	public function activateCustomers()
	{
		$this->generic->Update('users', array('userID' => $this->uri->segment(2)), array('userStatus' => 1));
		$this->session->set_flashdata('customerActivated', 1);
		redirect(base_url('all-customer'));
	}
	// delete customer
	public function deleteCustomers()
	{
		$this->generic->Delete('users', array('userID' => $this->uri->segment(2)));
		$this->session->set_flashdata('customerDeleted', 1);
		redirect(base_url('all-customer'));
	}
	// update customer
	public function updateCustomers()
	{
		$this->data['customer'] = $this->generic->GetData('users', array('userID' => $this->uri->segment(2)));
		$this->load->view('update-customer', $this->data);
	}
	public function updateCustomerData()
	{
		$userName = $this->input->post('cstm-user-name');
		$userEmail = $this->input->post('cstm-user-email');
		$userPhone = $this->input->post('cstm-user-phone');
		$userPassword = $this->input->post('cstm-user-password');
		$customerUserData = array(
			'userName' => $userName,
			'userEmail' => $userEmail,
			'userPhone' => $userPhone,
			'userPass' => $userPassword,
		);
		$this->generic->Update('users', array('userID' => $this->uri->segment(2)), $customerUserData);
		$this->session->set_flashdata('CustomerUpdated', 1);
		redirect(base_url('all-customer'));
	}



	// <!-- ============================================================== -->
	// <!-- category function -->
	// <!-- ============================================================== -->
	// redirect category page
	public function AdminCategory()
	{
		$this->data['categoryList'] = $this->generic->GetData('productcategory');
		$this->load->view('category', $this->data);
	}
	// add category
	public function AddAdminCategory()
	{
		$catData = array(
			'catName' => $this->input->post('cat-name'),
		);
		$this->generic->InsertData('productcategory', $catData);
		$this->session->set_flashdata('successfullyAdded', 1);
		redirect(base_url('category'));
	}
	//delete category
	public function deleteCategory()
	{
		$this->generic->Delete('productcategory', array('catID' => $this->uri->segment(2)));
		$this->session->set_flashdata('categoryDeleted', 1);
		redirect(base_url('category'));
	}
	// update category
	public function updateCategory()
	{
		$this->data['category'] = $this->generic->GetData('productcategory', array('catID' => $this->uri->segment(2)));
		$this->load->view('update-category', $this->data);
	}
	public function updateCategoryData()
	{
		$catData = array(
			'catName' => $this->input->post('cat-name'),
		);
		$this->generic->Update('productcategory', array('catID' => $this->uri->segment(2)), $catData);
		$this->session->set_flashdata('CategoryUpdated', 1);
		redirect(base_url('category'));
	}


	// <!-- ============================================================== -->
	// <!-- product function -->
	// <!-- ============================================================== -->
	//redirect product page
	public function AddAdminProduct()
	{
		$this->data['vendors'] = $this->generic->GetData('users', array('userType' => 3, 'userStatus' => 1));
		$this->data['categories'] = $this->generic->GetData('productcategory');
		$this->load->view('products/add-products', $this->data);
	}
	public function AddAdminProductData()
	{
		// Handle image upload
		$config['upload_path'] = './assets/productimages/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 2048; // 2MB max
		$config['encrypt_name'] = TRUE; // Encrypt the file name

		$this->load->library('upload', $config);

		// if (!$this->upload->do_upload('productImage')) {
		// 	// If upload fails, show error
		// 	$error = $this->upload->display_errors();
		// 	$this->session->set_flashdata('uploadError', $error);
		// 	redirect(base_url('add-new-product'));
		// } else {
		// If upload is successful, get the file data
		$upload_data = $this->upload->data();

		// Prepare data for database insertion
		$data = array(
			'userID' => $this->input->post('vendorID'),
			'catID' => $this->input->post('catID'),
			'productName' => $this->input->post('product-name'),
			'productPrice' => $this->input->post('price'),
			'productCuisineItem' => $this->input->post('cuisine-item'),
			'productCuisineUpc' => $this->input->post('cuisine-upc'),
			'productLength' => $this->input->post('product-length'),
			'productHeight' => $this->input->post('product-height'),
			'productWidth' => $this->input->post('product-width'),
			'productWeight' => $this->input->post('product-weight'),
			'productDesp' => $this->input->post('Description'),
			'productImage' => $upload_data['file_name']
		);

		// Insert data into the database
		$this->generic->InsertData('products', $data);
		$this->session->set_flashdata('productUploaded', 1);
		// Redirect or show success message
		redirect(base_url('add-new-product')); // Replace with your success route
		// }
	}

	public function manageProducts()
	{
		$this->data['products'] = $this->generic->GetProductList();
		$this->load->view('products/manageProduct', $this->data);
	}
	public function DeactivateProduct()
	{
		$this->generic->Update('products', array('productID' => $this->uri->segment(2)), array('productStatus' => 0));
		$this->session->set_flashdata('ProductDeactivated', 1);
		redirect(base_url('manage-Products'));
	}
	public function activateProduct()
	{
		$this->generic->Update('products', array('productID' => $this->uri->segment(2)), array('productStatus' => 1));
		$this->session->set_flashdata('PRoductActivate', 1);
		redirect(base_url('manage-Products'));
	}
	public function DeleteProduct()
	{
		$this->generic->Delete('products', array('productID' => $this->uri->segment(2)));
		$this->session->set_flashdata('productDeleted', 1);
		redirect(base_url('manage-Products'));
	}
	public function EditProduct()
	{
		$this->data['product'] = $this->generic->GetData('products', array('productID' => $this->uri->segment(2)));
		$this->data['vendors'] = $this->generic->GetData('users', array('userType' => 3, 'userStatus' => 1));
		$this->data['categories'] = $this->generic->GetData('productcategory');
		$this->load->view('products/edit-products', $this->data);
	}
	public function EditProductData()
	{
		$data = array(
			'userID' => $this->input->post('vendorID'),
			'catID' => $this->input->post('catID'),
			'productName' => $this->input->post('product-name'),
			'productPrice' => $this->input->post('price'),
			'productDesp' => $this->input->post('Description'),
		);
		if (isset($_FILES['productImage']) && !empty($_FILES['productImage']['name'])) {
			// Handle image upload
			$config['upload_path'] = './assets/productimages/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2048; // 2MB max
			$config['encrypt_name'] = TRUE; // Encrypt the file name

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('productImage')) {
				// If upload fails, show error
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('uploadError', $error);
				redirect(base_url('edit-product/' . $this->uri->segment(2)));
			} else {
				// If upload is successful, get the file data
				$upload_data = $this->upload->data();
				$data['productImage'] = $upload_data['file_name'];
			}
		}
		$this->generic->Update('products', array('productID' => $this->uri->segment(2)), $data);
		$this->session->set_flashdata('ProductUpdated', 1);
		redirect(base_url('manage-Products'));
	}

	//assign product
	public function assignProductView()
	{
		$this->data['customers'] = $this->generic->GetData('users', array('userType' => 2, 'userStatus' => 1));
		if (isset($_GET['customerID'])) {
			$this->data['products'] = $this->generic->GetUnassignedProducts($_GET['customerID']);
		} else {
			$this->data['products'] = false;
		}
		$this->load->view('products/assignProduct', $this->data);
	}
	// assign product ajax
	public function assignProductDataAjax()
	{
		$data = array(
			'customerID' => $this->input->post('customerID'),
			'productID' => $this->input->post('productID'),
			'newPrice' => $this->input->post('newPRice'),
		);
		$this->generic->InsertData('assignproduct', $data);
		echo 'productAssign';
	}
	public function assignProductEditDataAjax()
	{
		$data = array(

			'newPrice' => $this->input->post('newPRice'),
		);
		$this->generic->Update('assignproduct', array(
			'customerID' => $this->input->post('customerID'),
			'productID' => $this->input->post('productID')
		), $data);
		echo 'productedited';
	}
	//manage assign products
	public function manageAssignProducts()
	{
		$this->data['customers'] = $this->generic->GetData('users', array('userType' => 2, 'userStatus' => 1));
		if (isset($_GET['customerID'])) {
			$this->data['products'] = $this->generic->GetAssignedProducts($_GET['customerID']);
		} else {
			$this->data['products'] = false;
		}
		$this->load->view('products/manageAssignProduct', $this->data);
	}
	public function ManageAdminProducts()
	{
		$this->data['allorders'] = $this->generic->GetOrderListByCusotmer();
		$this->load->view('orderHistoryByAdmin', $this->data);
	}
	public function UpdateOrderStatus()
	{
		$this->generic->Update('checkout', array('checkoutID' => $this->uri->segment(2)), array('orderStatus' => $this->input->post('orderstatus')));
		$this->session->set_flashdata('orderStatusUpdated', 1);
		redirect(base_url('manage-admin-orders'));
	}
	public function TestMail()
	{
		$email = 'revotahir@gmail.com';
		$subject = 'Test Email';
		$message = '<p>This is test Email</p>';

		$result = $this->send_email($email, $subject, $message);

		if ($result === true) {
			die("Email sent successfully.") ;
		} else {
			die("Email failed: " . $result);
		}
	}

	// <!-- ============================================================== -->
	// <!-- logout function -->
	// <!-- ============================================================== -->
	public function LogOut()
	{
		$this->session->unset_userdata('loginData');
		redirect(base_url());
	}
}
