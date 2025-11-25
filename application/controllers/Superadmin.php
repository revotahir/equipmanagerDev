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
            $config['max_size']             = 5024;
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

        //get all seo part inputs
        $metaTitle = $this->input->post('metaTittle');
        // normalize title: trim, replace any whitespace sequence with a hyphen, then lowercase
        $Slug = strtolower(preg_replace('/\s+/', '-', trim($superCatName)));
        $metaKeywords = $this->input->post('metaKeyword');
        $metaDesc = $this->input->post('metaDesc');
        $heading1 = $this->input->post('heading1');
        $heading2 = $this->input->post('heading2');
        $headingDesc1 = $this->input->post('headingDesc1');
        $headingDesc2 = $this->input->post('headingDesc2');
        //page entry
        $pagedata = array(
            'slug' => $Slug,
            'pageType' => 2,
            'pageStatus' => 1
        );
        $this->generic->InsertData('web_pages', $pagedata);
        //get page max page id
        $pageID = $this->generic->GetMaxID('web_pages', 'pageID');
        //seo data entry
        if ($metaTitle) {
            $pageTittle = $metaTitle;
        } else {
            $pageTittle = $superCatName . " | equipmanager.dk";
        }
        $seodata = array(
            'pageID' => $pageID[0]['result'],
            'metaTittle' => $pageTittle,
            'metaKeywords' => $metaKeywords,
            'metaDesc' => $metaDesc,
            'h1' => $heading1,
            'h2' => $heading2,
            'p1' => $headingDesc1,
            'p2' => $headingDesc2
        );
        $this->generic->InsertData('web_page_meta', $seodata);
        //add category data
        $data = array(
            'web_catName' => $superCatName,
            'pageID' => $pageID[0]['result'],
            'web_catDesp' => $superCatDesp,
            'web_catIcon' => $personImage,
        );
        $this->generic->InsertData('web_cat', $data);
        $this->session->set_flashdata('success', 'Person deleted successfully!');
        redirect(base_url('manage-super-category'));
    }

    // show super category
    public function showSuperCategory()
    {
        // Get data from database
        $this->data['supercategory'] = $this->generic->GetWebCategoryData();
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
        $this->data['updateCategory'] = $this->generic->GetWebCategoryData(array('wc.web_catID' => $this->uri->segment(2)));
        // Load view
        $this->load->view('superadmin/category/updatecategory', $this->data);
    }

    // change status from active to deactive
    public function changeStatus()
    {
        if ($this->uri->segment(3) == 1) {
            $newStatus = 0;
            $this->session->set_flashdata('statusDeactivated', 'Category deactivated successfully!');
        } else {
            $newStatus = 1;
            $this->session->set_flashdata('statusActivated', 'Category activated successfully!');
        }
        $this->generic->Update('web_pages', array('pageID' => $this->uri->segment(2)), array('pageStatus' => $newStatus));
        redirect(base_url('show-super-category'));
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
        //get cat data
        $cat = $this->generic->GetData('web_cat', array('web_catID' => $catID));
        //update seo meta
        //get all seo part inputs
        $metaTitle = $this->input->post('metaTittle');
        // normalize title: trim, replace any whitespace sequence with a hyphen, then lowercase
        $Slug = strtolower(preg_replace('/\s+/', '-', trim($superCatName)));
        $metaKeywords = $this->input->post('metaKeyword');
        $metaDesc = $this->input->post('metaDesc');
        $heading1 = $this->input->post('heading1');
        $heading2 = $this->input->post('heading2');
        $headingDesc1 = $this->input->post('headingDesc1');
        $headingDesc2 = $this->input->post('headingDesc2');
        if ($metaTitle) {
            $pageTittle = $metaTitle;
        } else {
            $pageTittle = $superCatName . " | equipmanager.dk";
        }
        $seodata = array(
            'metaTittle' => $pageTittle,
            'metaKeywords' => $metaKeywords,
            'metaDesc' => $metaDesc,
            'h1' => $heading1,
            'h2' => $heading2,
            'p1' => $headingDesc1,
            'p2' => $headingDesc2
        );
        $this->generic->Update('web_page_meta', array('pageID' => $cat[0]['pageID']), $seodata);
        //update slug
        $this->generic->Update('web_pages', array('pageID' => $cat[0]['pageID']), array('slug' => $Slug));
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

    // change status 
    public function changeTestimonialStatus()
    {
        if ($this->uri->segment(3) == 1) {
            $newStatus = 0;
            $this->session->set_flashdata('statusDeactivated', 'Category deactivated successfully!');
        } else {
            $newStatus = 1;
            $this->session->set_flashdata('statusActivated', 'Category activated successfully!');
        }
        $this->generic->Update('web_testimonial', array('web_testimonialID' => $this->uri->segment(2)), array('web_testimonialStatus' => $newStatus));
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
        //get testiminial data
        $testiminial = $this->generic->GetData('web_testimonial', array('web_testimonialID' => $testiID));
        //check if we have image posted
        if (empty($_FILES['testiImage']['name'])) {
            $personImage = $testiminial[0]['web_testimonialImg'];
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

    // manage super blog page load

    //--manage blog category
    public function manageBlogCat()
    {
        $this->data['blogCat'] = $this->generic->GetData('web_blog_cat');
        $this->load->view('superadmin/blog/blogCat', $this->data);
    }
    public function blogCatData()
    {
        $catName = $this->input->post('catName');
        //add page
        //get all seo part inputs
        $metaTitle = $this->input->post('metaTittle');
        // normalize title: trim, replace any whitespace sequence with a hyphen, then lowercase
        $Slug = strtolower(preg_replace('/\s+/', '-', trim($catName)));
        $metaKeywords = $this->input->post('metaKeyword');
        $metaDesc = $this->input->post('metaDesc');
        $heading1 = $this->input->post('heading1');
        $heading2 = $this->input->post('heading2');
        $headingDesc1 = $this->input->post('headingDesc1');
        $headingDesc2 = $this->input->post('headingDesc2');
        //page entry
        $pagedata = array(
            'slug' => $Slug,
            'pageType' => 4,
            'pageStatus' => 1
        );
        $this->generic->InsertData('web_pages', $pagedata);
        //get page max page id
        $pageID = $this->generic->GetMaxID('web_pages', 'pageID');
        //seo data entry
        if ($metaTitle) {
            $pageTittle = $metaTitle;
        } else {
            $pageTittle = $catName . " | equipmanager.dk";
        }
        $seodata = array(
            'pageID' => $pageID[0]['result'],
            'metaTittle' => $pageTittle,
            'metaKeywords' => $metaKeywords,
            'metaDesc' => $metaDesc,
            'h1' => $heading1,
            'h2' => $heading2,
            'p1' => $headingDesc1,
            'p2' => $headingDesc2
        );
        $this->generic->InsertData('web_page_meta', $seodata);
        //add blog cat data
        $blogcatData = array(
            'pageID' => $pageID[0]['result'],
            'blogCat' => $this->input->post('catName'),
            'blogCatDesc' => $this->input->post('catDesc'),
        );
        $this->generic->InsertData('web_blog_cat', $blogcatData);
        $this->session->set_flashdata('successadded', 'addedd');
        redirect(base_url('manage-blog-category'));
    }
    public function ManageSuperBlog()
    {
        $this->load->view('superadmin/blog/addblog');
    }

    // show super blog page load
    public function showSuperBlog()
    {
        $this->data['showblogdata'] = $this->generic->GetData('web_blogs', array(), 'web_blogID', 'DESC');
        $this->load->view('superadmin/blog/showblog', $this->data);
    }

    // add blog
    public function addSuperBlog()
    {
        $blogCate = $this->input->post('blogCate');
        $blogDate = $this->input->post('blogDate');
        $blogTitle = $this->input->post('blogTitle');
        $blogDesp = $this->input->post('blogDesp');
        $blogDespSec = $this->input->post('blogDespSec');

        //check if we have image posted
        if (empty($_FILES['blogImage']['name'])) {
            $blogImage = 'testimonial.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/blog';
            $config['allowed_types']        = 'png|jpg|jpeg';
            $config['max_size']             = 1024;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('blogImage')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('add-blog'));
            } else {
                $uploadData = $this->upload->data();
                $blogImage = $uploadData['file_name'];
            }
        }
        $data = array(
            'web_blogCat' => $blogCate,
            'web_blogDate' => $blogDate,
            'web_blogTitle' => $blogTitle,
            'web_blogDesp' => $blogDesp,
            'web_blogDespSec' => $blogDespSec,
            'web_blogImg' => $blogImage,
            'web_blogStatus' => 1,
        );
        $this->generic->InsertData('web_blogs', $data);
        $this->session->set_flashdata('success', 'Person deleted successfully!');
        redirect(base_url('show-super-blog'));
    }

    // delete blog
    public function deletSuperBlog()
    {
        // Delete blog from database
        $this->generic->Delete('web_blogs', array('web_blogID' => $this->uri->segment(2)));
        $this->session->set_flashdata('successDeleted', 'Blog deleted successfully!');
        redirect(base_url('show-super-blog'));
    }

    // update blog
    public function updateSuperBlog()
    {
        // Get blog data
        $this->data['blogData'] = $this->generic->GetData('web_blogs', array('web_blogID' => $this->uri->segment(2)));
        // Load view
        $this->load->view('superadmin/blog/updateblog', $this->data);
    }

    // process blog update
    public function processUpdateBlog()
    {
        $blogID = $this->uri->segment(2);
        $blogCate = $this->input->post('blogCate');
        $blogDate = $this->input->post('blogDate');
        $blogTitle = $this->input->post('blogTitle');
        $blogDesp = $this->input->post('blogDesp');
        $blogDespSec = $this->input->post('blogDespSec');

        //check if we have image posted
        if (empty($_FILES['blogImage']['name'])) {
            $blogImage = 'testimonial.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/blog';
            $config['allowed_types']        = 'png|jpg|jpeg';
            $config['max_size']             = 1024;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('blogImage')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('add-blog'));
            } else {
                $uploadData = $this->upload->data();
                $blogImage = $uploadData['file_name'];
            }
        }
        $data = array(
            'web_blogCat' => $blogCate,
            'web_blogDate' => $blogDate,
            'web_blogTitle' => $blogTitle,
            'web_blogDesp' => $blogDesp,
            'web_blogDespSec' => $blogDespSec,
            'web_blogImg' => $blogImage,
            'web_blogStatus' => 1,
        );
        $this->generic->Update('web_blogs', array('web_blogID' => $blogID), $data);
        $this->session->set_flashdata('success', 'Person deleted successfully!');
        redirect(base_url('show-super-blog'));
    }

    // manage super success metrics page load
    public function manageSuccess()
    {
        // get data from database
        $this->data['successData'] = $this->generic->GetData('web_success', array(), 'web_successID', 'DESC');
        $this->load->view('superadmin/success/managesuccess', $this->data);
    }

    // add success
    public function addSuccess()
    {
        $sucesTitle = $this->input->post('sucesTitle');
        $sucesDesp = $this->input->post('sucesDesp');

        //check if we have image posted
        if (empty($_FILES['sucesIcon']['name'])) {
            $successIcon = 'metrics.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/success-metrics';
            $config['allowed_types']        = 'svg';
            $config['max_size']             = 300;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('sucesIcon')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-success'));
            } else {
                $uploadData = $this->upload->data();
                $successIcon = $uploadData['file_name'];
            }
        }

        $data = array(
            'web_successIcon' => $successIcon,
            'web_successName' => $sucesTitle,
            'web_successDes' => $sucesDesp,
            'web_successStatus' => 1,
        );
        $this->generic->InsertData('web_success', $data);
        $this->session->set_flashdata('success', 'Metrics added successfully!');
        redirect(base_url('manage-success'));
    }

    // delete success
    public function deleteSuccess()
    {
        $this->generic->Delete('web_success', array('web_successID' => $this->uri->segment(2)));
        $this->session->set_flashdata('success-delete', 'Metrics Deleted!');
        redirect(base_url('manage-success'));
    }

    // update success page laod
    public function updateSuccess()
    {
        $this->data['successData'] = $this->generic->GetData('web_success', array('web_successID' => $this->uri->segment(2)));
        $this->load->view('superadmin/success/updatemanagesuccess', $this->data);
    }

    // process update success
    public function processUpdateSuccess()
    {
        $sucesID = $this->uri->segment(2);
        $sucesTitle = $this->input->post('sucesTitle');
        $sucesDesp = $this->input->post('sucesDesp');

        //check if we have image posted
        if (empty($_FILES['sucesIcon']['name'])) {
            $successIcon = 'metrics.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/success-metrics';
            $config['allowed_types']        = 'svg';
            $config['max_size']             = 300;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('sucesIcon')) {
                $error = array('error' => $this->upload->display_errors());
                // die(print_r($error));
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-success'));
            } else {
                $uploadData = $this->upload->data();
                $successIcon = $uploadData['file_name'];
            }
        }

        $data = array(
            'web_successIcon' => $successIcon,
            'web_successName' => $sucesTitle,
            'web_successDes' => $sucesDesp,
            'web_successStatus' => 1,
        );
        $this->generic->Update('web_success', array('web_successID' => $sucesID), $data);
        $this->session->set_flashdata('success-update', 'Metrics added successfully!');
        redirect(base_url('manage-success'));
    }

    // company page load
    public function manageCompany()
    {
        $this->data['companyData'] = $this->generic->GetData('web_company', array(), 'web_companyID', 'DESC');
        $this->load->view('superadmin/partners/managepartners', $this->data);
    }

    // add partner
    public function addPartner()
    {
        //check if we have image posted
        if (empty($_FILES['sucesIcon']['name'])) {
            $partnerIcon = 'partner.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/partner';
            $config['allowed_types']        = 'svg';
            $config['max_size']             = 300;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('sucesIcon')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-company'));
            } else {
                $uploadData = $this->upload->data();
                $partnerIcon = $uploadData['file_name'];
            }
        }

        $data = array(
            'web_companyIcon' => $partnerIcon,
            'web_companyStatus' => 1,
        );
        $this->generic->InsertData('web_company', $data);
        $this->session->set_flashdata('success', 'Partner added successfully!');
        redirect(base_url('manage-company'));
    }

    // delete partner
    public function deletePartner()
    {
        $this->generic->Delete('web_company', array('web_companyID' => $this->uri->segment(2)));
        $this->session->set_flashdata('success-delete', 'Partner Deleted!');
        redirect(base_url('manage-company'));
    }

    // update parnter
    public function updatePartner()
    {
        $this->data['partnerdata'] = $this->generic->GetData('web_company', array('web_companyID' => $this->uri->segment(2)));
        $this->load->view('superadmin/partners/updatemanagepartners', $this->data);
    }

    // process update partner
    public function processUpdatePartner()
    {
        $prntID = $this->uri->segment(2);
        //check if we have image posted
        if (empty($_FILES['sucesIcon']['name'])) {
            $partnerIcon = 'partner.svg';
        } else {
            //upload person image
            $config['upload_path']          = './assets/uploads/superadmin/partner';
            $config['allowed_types']        = 'svg';
            $config['max_size']             = 300;
            $config['encrypt_name']         = TRUE;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('sucesIcon')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $error['error']);
                redirect(base_url('manage-company'));
            } else {
                $uploadData = $this->upload->data();
                $partnerIcon = $uploadData['file_name'];
            }
        }

        $data = array(
            'web_companyIcon' => $partnerIcon,
            'web_companyStatus' => 1,
        );
        $this->generic->Update('web_company', array('web_companyID' => $prntID), $data);
        $this->session->set_flashdata('success-update', 'Partner added successfully!');
        redirect(base_url('manage-company'));
    }
}
