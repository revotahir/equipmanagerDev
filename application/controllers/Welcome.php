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
		$this->load->view('website/home');
	}
	public function login(){
		$this->load->view('login');
	}
	// <!-- ============================================================== -->
	// <!-- Login function -->
	// <!-- ============================================================== -->

	public function loginData()
	{
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		//check if email and password exists
		$user = $this->generic->GetData('users', array('userEmail' => $email, 'userPass' => $password, 'userStatus' => 1));
		$this->session->set_userdata('loginData', $user[0]);
		if ($user) {
			$this->session->set_userdata('loginData', $user[0]);
			//check if user is admin or vendor
			if ($user[0]['userType'] == 1) {
				//if admin then redirect to admin dashboard
				redirect(base_url('admin-dashboard'));
			} elseif ($user[0]['userType'] == 2) {
				//get cpmpany details
				$companyDetails = $this->generic->GetData('companydetail', array('userId' => $user[0]['userID']));
				$this->session->set_userdata('companyDetails', $companyDetails[0]);
				//if vendor then redirect to vendor dashboard	
				redirect(base_url('company-dashboard'));
			} elseif ($user[0]['userType'] == 3) {
				//if user then redirect to company manager dashboard	
				redirect(base_url('manager-dashboard'));
			} elseif ($user[0]['userType'] == 4) {
				//if user then redirect to user dashboard	
				redirect(base_url('user-dashboard'));
			}
			die('User Loged In');
			//set session data
			$this->session->set_userdata('loginData', $user[0]);
			redirect(base_url('dashboard'));
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
			$maxUserId = $this->generic->GetMaxID('users', 'userID');
			$companyData = array(
				'companyName' => $comName,
				'userId' => $maxUserId[0]['result'],
			);
			$this->generic->InsertData('companydetail', $companyData);
			//setup Authentaction
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
			//send email
			$subject = 'Equip Manager - Account Verification';
			$message = 'Your account has been created successfully. Your verification code is: ' . $authCode;
			$this->send_email($email, $subject, $message);
			redirect(base_url('verify-account?auth=' . $authTocken . '&userID=' . $maxUserId[0]['result']));
		}
	}

	public function userRegistersationData()
	{
		// die('userRegistersationData');
		$userName = $this->input->post('usrName');
		$cPhone = $this->input->post('UPhone');
		$email = $this->input->post('uemail');
		$password = md5($this->input->post('upassword') ?? '');
		// check if email already exists
		$checkEmail = $this->generic->GetData('users', array('userEmail' => $email));
		if ($checkEmail) {
			$this->session->set_flashdata('alreadyRegistered', 1);
			redirect(base_url('register'));
		} else {
			$userData = array(
				'userName' => $userName,
				'userPhone' => $cPhone,
				'userEmail' => $email,
				'userPass' => $password,
				'userType' => 4,
				'userStatus' => 2,
			);
			$this->generic->InsertData('users', $userData);
			//get max user id
			$maxUserId = $this->generic->GetMaxID('users', 'userID');
			//setup Authentaction
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
			//send email
			$subject = 'Equip Manager - Account Verification';
			$message = 'Your account has been created successfully. Your verification code is: ' . $authCode;
			$this->send_email($email, $subject, $message);
			redirect(base_url('verify-account?auth=' . $authTocken));
		}
	}



	public function VerifyAccount()
	{
		$authcode = $_GET['auth'];
		//check if auth code exists
		$checkAuth = $this->generic->GetData('userauth', array('authTocken' => $authcode, 'userID' => $_GET['userID'], 'authStatus' => 0));
		if ($checkAuth || isset($_GET['forgot'])) {
			// die('a');
			$this->load->view('verifyAccount');
		} else {
			$this->session->set_flashdata('authExpire', 1);
			redirect(base_url());
		}
	}
	public function VerifyAccountData()
	{

		$authCode = $this->input->post('password');
		$forgotcheck = $this->input->post('forgotcheck');
		$authTocken = $_GET['auth'];
		//get user by auth token
		$userAuth = $this->generic->GetData('userauth', array('authTocken' => $authTocken, 'userID' => $_GET['userID']));
		if ($userAuth) {
			// die($authCode );
			if ($userAuth[0]['authCode'] == $authCode) {
				//update user auth status
				$this->generic->Update('userauth', array('userID' => $userAuth[0]['userID']), array('authStatus' => 1));
				$this->generic->Update('users', array('userID' => $userAuth[0]['userID']), array('userStatus' => 1));
				if ($forgotcheck == '1') {
					// if forgot password then update user password
					redirect(base_url('reset-password?auth=' . $authTocken . '&userID=' . $_GET['userID']));
				} else {
					$this->session->set_flashdata('successRegister', 1);
					redirect(base_url());
				}
			} else {
				$this->session->set_flashdata('error', 1);
				if ($forgotcheck == '1') {
					// die('forgot');
					redirect(base_url('verify-account?auth=' . $authTocken . '&userID=' . $_GET['userID'] . '&forgot=1'));
				} else {
					redirect(base_url('verify-account?auth=' . $authTocken . '&userID=' . $_GET['userID']));
				}
			}
		} else {
			redirect(base_url('register'));
		}
	}
	public function resendVerificationEmail()
	{
		$authTocken = $_GET['auth'];
		//get user by auth token
		$userAuth = $this->generic->GetData('userauth', array('authTocken' => $authTocken, 'userID' => $_GET['userID']));
		//get user data
		$userdata = $this->generic->GetData('users', array('userID' => $userAuth[0]['userID']));
		//generate new authcode
		$userAuth[0]['authCode'] = rand(1000, 9999);
		//update user auth code	
		$this->generic->Update('userauth', array('userID' => $userAuth[0]['userID']), array('authCode' => $userAuth[0]['authCode']));
		if ($userAuth) {
			//send email
			$email = $userdata[0]['userEmail'];
			$subject = 'Equip Manager - Account Verification';
			$message = 'Your account has been created successfully. Your verification code is: ' . $userAuth[0]['authCode'];
			$this->send_email($email, $subject, $message);
			$this->session->set_flashdata('newcodeSend', 1);
			if (isset($_GET['forgot'])) {
				redirect(base_url('verify-account?auth=' . $authTocken . '&userID=' . $_GET['userID'] . '&forgot=1'));
			} else {
				redirect(base_url('verify-account?auth=' . $authTocken . '&userID=' . $_GET['userID']));
			}
		} else {
			redirect(base_url('register'));
		}
	}


	public function forgotpassword()
	{
		$this->load->view('forgotPass');
	}
	public function forgotpasswordData()
	{
		$email = $this->input->post('femail');
		//check if email exists
		$user = $this->generic->GetData('users', array('userEmail' => $email, 'userStatus' => 1));
		$authdata = $this->generic->GetData('userauth', array('userID' => $user[0]['userID']));
		if ($user) {
			//generate new auth code
			$authCode = rand(1000, 9999);
			//update user auth code	
			$this->generic->Update('userauth', array('userID' => $user[0]['userID']), array('authCode' => $authCode));
			//send email
			$subject = 'Equip Manager - Forgot Password';
			$message = 'Your verification code is: ' . $authCode;
			$this->send_email($email, $subject, $message);
			redirect(base_url('verify-account?auth=' . $authdata[0]['authTocken'] . '&userID=' . $user[0]['userID'] . '&forgot=1'));
		} else {
			$this->session->set_flashdata('error', 1);
			redirect(base_url('forgot-password'));
		}
	}


	public function resetPassword()
	{
		$authTocken = $_GET['auth'];
		$userID = $_GET['userID'];
		//get user by auth token
		$userAuth = $this->generic->GetData('userauth', array('authTocken' => $authTocken, 'userID' => $userID));
		if ($userAuth) {
			$this->load->view('resetPass');
		} else {
			redirect(base_url('register'));
		}
	}
	public function resetPasswordData()
	{
		$authTocken = $_GET['auth'];
		$userID = $_GET['userID'];
		//get user by auth token
		$userAuth = $this->generic->GetData('userauth', array('authTocken' => $authTocken, 'userID' => $userID));
		if ($userAuth) {
			$newPassword = md5($this->input->post('password'));
			$confirmPassword = md5($this->input->post('cpassword'));
			if ($newPassword == $confirmPassword) {
				//update user password	
				$this->generic->Update('users', array('userID' => $userID), array('userPass' => $newPassword));
				$this->session->set_flashdata('passwordupdates', 1);
				redirect(base_url());
			} else {
				$this->session->set_flashdata('passwordnotmatch', 1);
				redirect(base_url('reset-password?auth=' . $authTocken . '&userID=' . $userID));
			}
		} else {
			redirect(base_url('register'));
		}
	}




	// <!-- ============================================================== -->
	// <!-- redirect to dashboard -->
	// <!-- ============================================================== -->




	public function companyDashboard()
	{
		//check if user is vendor
		if ($this->session->userdata('loginData')['userType'] == 2) {
			$this->load->view('dashboards/companydashboard');
		} else {
			redirect(base_url());
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
		if ($this->session->userdata('loginData')['userType'] == 2) {
			$this->session->unset_userdata('companyDetails');
		}
		redirect(base_url());
	}
}
