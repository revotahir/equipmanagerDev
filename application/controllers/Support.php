<?php

use Phpass\Loader;

defined('BASEPATH') or exit('No direct script access allowed');

class support extends MY_Controller
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
	public function addNewTicket()
	{
		$this->data['supportCat'] = $this->generic->GetData('supportticketscat', array('supportCatStatus' => 1));
		$this->load->view('support/addTicket', $this->data);
	}
	public function addNewTicketData()
	{
		$ticketData = array(
			'supportTicketsCatID' => $this->input->post('suppCat'),
			'userID' => $this->session->userdata('loginData')['userID'],
			'supportSubject' => $this->input->post('suppSub'),
			'supportMessage' => $this->input->post('suppmsg'),
		);
		$this->generic->InsertData('supporttickets', $ticketData);
		//get max ticket id
		$ticketid = $this->generic->GetMaxID('supporttickets', 'supportTicketID');
		$chatdata = array(
			'supportTicketID' => $ticketid[0]['result'],
			'userID' => $this->session->userdata('loginData')['userID'],
			'chatText' => $this->input->post('suppmsg'),
		);
		$this->generic->InsertData('supportticketchat', $chatdata);
		//get ticket data
		$ticket = $this->generic->GetMaxID('supporttickets', 'supportTicketID');
		//get admin id
		$adminDetail = $this->generic->GetData('users', array('userType' => 1));
		foreach ($adminDetail as $row) {
			//send email to admin 
			$subject = 'Equip Manager - New Ticket Created';
			$message = 'New Ticket #' . $ticket[0]['result'] . ' is Created! Here is Link:' . base_url('ticket-chat?ticketID=' . $ticket[0]['result']);
			$this->send_email($row['userEmail'], $subject, $message);
		}

		$this->session->set_flashdata('newTicket', 'Person deleted successfully!');
		redirect(base_url('ticket-chat?ticketID=' . $ticketid[0]['result']));
	}
	public function ticketChat()
	{
		if (isset($_GET['ticketID'])) {
			//get curent selected ticket data
			$this->data['cTicketChat'] = $this->generic->GetData('supportticketchat', array('supportTicketID' => $_GET['ticketID']));
			if ($this->session->userdata('loginData')['userType'] == 1) {
				$this->data['cTicketData'] = $this->generic->GetData('supporttickets', array('supportTicketID' => $_GET['ticketID']));
				//get user data for admin
				$this->data['userData'] = $this->generic->GetData('users', array('userID' => $this->data['cTicketData'][0]['userID']));
			} else {
				$this->data['cTicketData'] = $this->generic->GetData('supporttickets', array('supportTicketID' => $_GET['ticketID'], 'userID' => $this->session->userdata('loginData')['userID']));
			}
		}
		//load all ticket for curent user
		if ($this->session->userdata('loginData')['userType'] == 1) {
			$this->data['allTickets'] = $this->generic->GetTicketsWithCat(array('t.supportTicketStatus!=' => 3));
		} else {
			$this->data['allTickets'] = $this->generic->GetTicketsWithCat(array('t.userID' => $this->session->userdata('loginData')['userID'], 't.supportTicketStatus!=' => 3));
		}
		$this->load->view('support/chat', $this->data);
	}
	public function newChatAjax()
	{
		$chatdata = array(
			'supportTicketID' => $this->input->post('ticketID'),
			'userID' => $this->input->post('userID'),
			'chatText' => $this->input->post('chat')
		);
		$this->generic->InsertData('supportticketchat', $chatdata);

		// update status
		if ($this->session->userdata('loginData')['userType'] == 1) {
			//admin responded
			$this->generic->Update('supporttickets', array('supportTicketID' => $this->input->post('ticketID')), array('supportTicketStatus' => 2));
			$status = '///Answered by Support';
			$email = 1;
		} else {
			$this->generic->Update('supporttickets', array('supportTicketID' => $this->input->post('ticketID')), array('supportTicketStatus' => 1));
			$status = '///Waiting for Support';
			$email = 2;
		}
		//send email notisfication
		//==admin side
		if ($email == 2) {
			$adminDetail = $this->generic->GetData('users', array('userType' => 1));
			foreach ($adminDetail as $row) {
				//send email to admin 
				$subject = 'Equip Manager - Ticket Updated';
				$message = 'Ticket #' . $this->input->post('ticketID') . ' is Updated by User! Here is Link:' . base_url('ticket-chat?ticketID=' . $this->input->post('ticketID'));
				$this->send_email($row['userEmail'], $subject, $message);
			}
		} else {
			//==client side
			$userdata = $this->generic->GetTicketsWithUsers(array('t.supportTicketID' => $this->input->post('ticketID')));
			//send email to company admin 
			$subject = 'Equip Manager - Ticket Updated';
			$message = 'Ticket #' . $this->input->post('ticketID') . ' is Updated by Admin! Here is Link:' . base_url('ticket-chat?ticketID=' . $this->input->post('ticketID'));
			$this->send_email($userdata[0]['userEmail'] , $subject, $message);
		}


		//get latest chat
		$chatID = $this->generic->GetMaxID('supportticketchat', 'chatID ');
		$newchat = $this->generic->GetData('supportticketchat', array('chatID' => $chatID[0]['result']));
		$ts = $newchat[0]['chatTimeStamp'] ?? '';
		$t = strtotime($ts);
		$timeDate = $t ? date('M j, Y g:i A', $t) : $ts;
		echo $timeDate . $status;
	}
	public function ticketMarketCompleted()
	{
		$this->generic->Update('supporttickets', array('supportTicketID' => $this->uri->segment(2)), array('supportTicketStatus' => 3));
			$userdata = $this->generic->GetTicketsWithUsers(array('t.supportTicketID' => $this->uri->segment(2)));
			//send email to company admin 
			$subject = 'Equip Manager - Ticket Updated';
			$message = 'Ticket #' . $this->uri->segment(2) . ' is marked Completed by Admin!';
			$this->send_email($userdata[0]['userEmail'] , $subject, $message);
		redirect(base_url('ticket-chat?ticketID=' . $this->uri->segment(2)));
	}
	public function allTickets()
	{
		if ($this->session->userdata('loginData')['userType'] == 1) {
			$this->data['alltickets'] = $this->generic->GetTicketsWithCat();
		} else {
			$this->data['alltickets'] = $this->generic->GetTicketsWithCat(array('userID' => $this->session->userdata('loginData')['userID']));
		}
		$this->load->view('support/ticketList', $this->data);
	}
	public function ticketCategory()
	{
		$this->data['ticketCat'] = $this->generic->GetData('supportticketscat');
		$this->load->view('support/ticketCategory', $this->data);
	}
	public function ticketCategoryData()
	{
		$this->generic->InsertData('supportticketscat', array('supportCat' => $this->input->post('ticketCat')));
		$this->session->set_flashdata('newTicketCat', 'Person deleted successfully!');
		redirect(base_url('ticket-category'));
	}
	public function ticketCategoryStatus()
	{
		$tcat = $this->generic->GetData('supportticketscat', array('supportTicketsCatID' => $this->uri->segment(2)));
		if ($tcat[0]['supportCatStatus'] == 1) {
			//set it off
			$this->generic->Update('supportticketscat', array('supportTicketsCatID' => $this->uri->segment(2)), array('supportCatStatus' => 0));
			$this->session->set_flashdata('newTicketCatOff', 'Person deleted successfully!');
			redirect(base_url('ticket-category'));
		} else {
			$this->generic->Update('supportticketscat', array('supportTicketsCatID' => $this->uri->segment(2)), array('supportCatStatus' => 1));
			$this->session->set_flashdata('newTicketCatOnn', 'Person deleted successfully!');
			redirect(base_url('ticket-category'));
		}
	}
	public function ticketCategoryDlt()
	{
		$this->generic->Delete('supportticketscat', array('supportTicketsCatID' => $this->uri->segment(2)));
		$this->session->set_flashdata('newTicketCatDlt', 'Person deleted successfully!');
		redirect(base_url('ticket-category'));
	}
	public function ticketCategoryUpdate()
	{
		$this->generic->Update('supportticketscat', array('supportTicketsCatID' => $this->uri->segment(2)), array('supportCat' => $this->input->post('ticketCat')));
		$this->session->set_flashdata('newTicketCatupdated', 'Person deleted successfully!');
		redirect(base_url('ticket-category'));
	}
}
