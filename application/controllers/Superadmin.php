<?php
defined('BASEPATH') or exit('No direct script access allowed');

class superadmin extends MY_Controller
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


    // super admin login
    public function superadmindashboard()
    {
        //check if user is vendor
        if ($this->session->userdata('loginData')['userType'] == 1) {
            $this->load->view('superadmin/superadmindashboard');
        } else {
            redirect(base_url());
        }
    }


    // manage super category
    public function ManageSuperCategory()
    {
        $this->load->view('superadmin/category/managecategory');
    }

    public function addSuperCategory()
    {
        $superCatName = $this->input->post('catName');
        $superCatDesp = $this->input->post('catDesc');

        //check if we have image posted
        if (empty($_FILES['catIcon']['name'])) {
            $personImage = 'category.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/category';
            $config['allowed_types']        = 'svg';
            $config['max_size']             = 1024;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('catIcon')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-super-category'));
            } else {
                $uploadData = $this->upload->data();
                $personImage = $uploadData['file_name'];
            }
        }
        $data = array(
            'web_catName' => $superCatName,
            'web_catDesp' => $superCatDesp,
            'web_catIcon' => $personImage,
            'web_catStatus' => 1,
        );
        $this->generic->InsertData('web_cat', $data);
        $this->session->set_flashdata('success', 'Person deleted successfully!');
        redirect(base_url('show-super-category'));
    }

    public function showSuperCategory()
    {
        // Get data from database
        $this->data['supercategory'] = $this->generic->GetData('web_cat', array(), 'web_catID', 'DESC');
        $this->load->view('superadmin/category/showcategory', $this->data);
    }
}
