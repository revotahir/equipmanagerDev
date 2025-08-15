<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
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
	public function RegisterView()
	{
		$this->load->view('signup');
	}

	public function comapnyRegisterationData()
	{
		// die('comapnyRegisterationData');
		$comName = $this->input->post('comName');
		$userName = $this->input->post('userName');
		$cPhone = $this->input->post('cPhone');
		$email = $this->input->post('Cemail');
		$password = md5($this->input->post('Cpassword') ?? '');
		// check if email already exists
		$checkEmail = $this->generic->GetData('users', array('userEmail' => $email));
		if ($checkEmail) {
			$this->session->set_flashdata('alreadyRegistered', 1);
			redirect(base_url('register'));
		} else {

			$companyData = array(
				'userName' => $userName,
				'userPhone' => $cPhone,
				'userEmail' => $email,
				'userPass' => $password,
				'userType' => 2,
				'userStatus' => 2,
			);
			$this->generic->InsertData('users', $companyData);
			//get max user id
			$maxUserId = $this->generic->GetMaxID('users', 'userId');
			$companyData = array(
				'companyName' => $comName,
				'userId' => $maxUserId[0]['result'],
			);
			$this->generic->InsertData('companydetail', $companyData);
			//setup Authentaction
			$authCode = rand(1000, 9999);
			$authTocken = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
			$authData = array(
				'userId' => $maxUserId[0]['result'],
				'authCode' => $authCode,
				'authTocken' => $authTocken,
				'authStatus' => 0,
			);
			$this->generic->InsertData('userauth', $authData);
			//send email
			$subject = 'Equip Manager - Account Verification';
			$message = 'Your account has been created successfully. Your verification code is: ' . $authCode;
			$this->send_email($email, $subject, $message);
			redirect(base_url('verify-account?auth=' . $authTocken));
		}
	}
	public function VerifyAccount()
	{
		$authcode= $_GET['auth'];
		//check if auth code exists
		$checkAuth = $this->generic->GetData('userauth', array('authTocken' => $authcode, 'authStatus' => 0));
		if($checkAuth){
			$this->load->view('verifyAccount');
		}else{
			$this->session->set_flashdata('authExpire', 1);
			redirect(base_url());
		}
		
	}
	public function VerifyAccountData()
	{
		$authCode = $this->input->post('password');
		$authTocken = $_GET['auth'];
		//get user by auth token
		$userAuth = $this->generic->GetData('userauth', array('authTocken' => $authTocken, 'authStatus' => 0));
		if ($userAuth) {
			if ($userAuth[0]['authCode'] == $authCode) {
				//update user auth status
				$this->generic->Update('userauth', array('userID' => $userAuth[0]['userID']), array('authStatus' => 1));
				$this->generic->Update('users', array('userID' => $userAuth[0]['userID']), array('userStatus' => 1));
				$this->session->set_flashdata('success', 1);
				redirect(base_url());
			} else {
				$this->session->set_flashdata('error', 1);
				redirect(base_url('verify-account?auth=' . $authTocken));
			}
		} else {
			redirect(base_url('register'));
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
public function TestMail()
	{
		//send email
		$email = 'revotahir@gmail.com';
			$subject = 'Equip Manager - Account Verification';
			$message = 'Your account has been created successfully. Your verification code is: ';
			$this->send_email($email, $subject, $message);
			die('Email sent successfully');
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
