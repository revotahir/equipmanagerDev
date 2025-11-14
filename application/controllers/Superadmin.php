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


    // manage super category page load
    public function ManageSuperCategory()
    {
        $this->load->view('superadmin/category/managecategory');
    }

    // add category
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

    // show super category
    public function showSuperCategory()
    {
        // Get data from database
        $this->data['supercategory'] = $this->generic->GetData('web_cat', array(), 'web_catID', 'DESC');
        $this->load->view('superadmin/category/showcategory', $this->data);
    }

    // delete category
    public function deletCategory()
    {
        // Delete category from database
        $this->generic->Delete('web_cat', array('web_catID' => $this->uri->segment(2)));
        $this->session->set_flashdata('successDeleted', 'Category deleted successfully!');
        redirect(base_url('show-super-category'));
    }

    // update category
    public function updateSuperCategory()
    {
        // Get category data
        $this->data['updateCategory'] = $this->generic->GetData('web_cat', array('web_catID' => $this->uri->segment(2)));
        // Load view
        $this->load->view('superadmin/category/updatecategory', $this->data);
    }

    // process update category
    public function processUpdateCategory()
    {
        $catID = $this->input->post('catID');
        $superCatName = $this->input->post('catName');
        $superCatDesp = $this->input->post('catDesc');

        //check if we have image posted
        if (empty($_FILES['catIcon']['name'])) {
            $personImage = 'category.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/category';
            $config['allowed_types']        = 'svg';
            $config['max_size']             = 300;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('catIcon')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('show-super-category'));
            } else {
                $uploadData = $this->upload->data();
                $personImage = $uploadData['file_name'];
            }
        }
        $data = array(
            'web_catName' => $superCatName,
            'web_catDesp' => $superCatDesp,
            'web_catIcon' => $personImage,
        );
        $this->generic->Update('web_cat', array('web_catID' => $catID), $data);
        $this->session->set_flashdata('success-edited', 'Person deleted successfully!');
        redirect(base_url('show-super-category'));
    }


    // manage super testimonial page load
    public function ManageSuperTestimonial()
    {
        $this->data['showtestimonialdata'] = $this->generic->GetData('web_testimonial', array(), 'web_testimonialID', 'DESC');
        $this->load->view('superadmin/testimonial/supertestimonial', $this->data);
    }

    // add testimonial
    public function AddTestimonial()
    {
        $testiRating = $this->input->post('testiRating');
        $testiReview = $this->input->post('testiReview');
        $testiName = $this->input->post('testiName');
        $testiLocation = $this->input->post('testiLocation');

        //check if we have image posted
        if (empty($_FILES['testiImage']['name'])) {
            $personImage = 'testimonial.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/testimonial';
            $config['allowed_types']        = 'svg|png|jpg|jpeg';
            $config['max_size']             = 500;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('testiImage')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-super-testimonial'));
            } else {
                $uploadData = $this->upload->data();
                $personImage = $uploadData['file_name'];
            }
        }
        $data = array(
            'web_testimonialRating' => $testiRating,
            'web_testimonialDesp' => $testiReview,
            'web_testimonialName' => $testiName,
            'web_testimonialLocation' => $testiLocation,
            'web_testimonialImg' => $personImage,
            'web_testimonialStatus' => 1,
        );
        $this->generic->InsertData('web_testimonial', $data);
        $this->session->set_flashdata('success', 'Person deleted successfully!');
        redirect(base_url('manage-super-testimonial'));
    }

    // delete testimonial
    public function deleteTestimonial()
    {
        // Delete testimonial from database
        $this->generic->Delete('web_testimonial', array('web_testimonialID' => $this->uri->segment(2)));
        $this->session->set_flashdata('successDeleted', 'Testimonial deleted successfully!');
        redirect(base_url('manage-super-testimonial'));
    }

    // update testimonial
    public function updateTestimonial()
    {
        // Get testimonial data
        $this->data['testimonialData'] = $this->generic->GetData('web_testimonial', array('web_testimonialID' => $this->uri->segment(2)));
        // Load view
        $this->load->view('superadmin/testimonial/updatetestimonial', $this->data);
    }

    // process update testimonial
    public function processUpdateTestimonial()
    {
        $testiID = $this->uri->segment(2);
        $testiRating = $this->input->post('testiRating');
        $testiReview = $this->input->post('testiReview');
        $testiName = $this->input->post('testiName');
        $testiLocation = $this->input->post('testiLocation');

        //check if we have image posted
        if (empty($_FILES['testiImage']['name'])) {
            $personImage = 'testimonial.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/testimonial';
            $config['allowed_types']        = 'svg|png|jpg|jpeg';
            $config['max_size']             = 500;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('testiImage')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-super-testimonial'));
            } else {
                $uploadData = $this->upload->data();
                $personImage = $uploadData['file_name'];
            }
        }
        $data = array(
            'web_testimonialRating' => $testiRating,
            'web_testimonialDesp' => $testiReview,
            'web_testimonialName' => $testiName,
            'web_testimonialLocation' => $testiLocation,
            'web_testimonialImg' => $personImage,
        );
        $this->generic->Update('web_testimonial', array('web_testimonialID' => $testiID), $data);
        $this->session->set_flashdata('success-edited', 'Person deleted successfully!');
        redirect(base_url('manage-super-testimonial'));
    }
}
