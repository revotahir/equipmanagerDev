<?php
defined('BASEPATH') or exit('No direct script access allowed');

class superadmin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('Generic_model', 'generic');
        $this->load->model('Payment_model', 'payment');
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
    public function changeWebsiteMode() {
        $curentStatus=$this->generic->GetData('web_setting');
        if($curentStatus[0]['websiteStatus']==1){
            $this->generic->Update('web_setting',array('settingID'=>1),array('websiteStatus'=>0));
        }else{
            $this->generic->Update('web_setting',array('settingID'=>1),array('websiteStatus'=>1));

        }
        redirect(base_url().$_GET['curentUrl']);
    }

    // manage system settings
    public function manageSystemSettings()
    {
        //check if user is admin
        if ($this->session->userdata('loginData')['userType'] == 1) {
            //get all system settings
            $this->data['settings'] = $this->generic->GetData('system_settings');
            $this->load->view('superadmin/system_settings/manage_settings', $this->data);
        } else {
            redirect(base_url());
        }
    }

    // update system settings
    public function updateSystemSettings()
    {
        //check if user is admin
        if ($this->session->userdata('loginData')['userType'] == 1) {
            $settingKey = $this->input->post('settingKey');
            $settingValue = $this->input->post('settingValue');
            $description = $this->input->post('description');

            //get existing setting
            $existingSetting = $this->generic->GetData('system_settings', array('settingKey' => $settingKey));

            if ($existingSetting) {
                //update existing setting
                $updateData = array(
                    'settingValue' => $settingValue,
                    'description' => $description,
                    'updatedBy' => $this->session->userdata('loginData')['userID']
                );
                $this->generic->Update('system_settings', array('settingKey' => $settingKey), $updateData);
                $this->session->set_flashdata('successUpdated', 'System setting updated successfully!');
            } else {
                //insert new setting if it doesn't exist
                $insertData = array(
                    'settingKey' => $settingKey,
                    'settingValue' => $settingValue,
                    'settingType' => 'number',
                    'description' => $description,
                    'updatedBy' => $this->session->userdata('loginData')['userID']
                );
                $this->generic->InsertData('system_settings', $insertData);
                $this->session->set_flashdata('successAdded', 'System setting added successfully!');
            }

            redirect(base_url('manage-system-settings'));
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
            'web_cat_type'=>$this->input->post('catType')
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
        $catdata = $this->generic->GetData('web_cat', array('web_catID' => $this->uri->segment(2)));
        $this->generic->Delete('web_pages', array('pageID' => $catdata[0]['pageID']));
        $this->generic->Delete('web_page_meta', array('pageID' => $catdata[0]['pageID']));
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
        $this->data['blogCat'] = $this->generic->GetBlogCatData();
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

    public function DltBlogCat()
    {
        // Delete blog from database
        $blogcat = $this->generic->GetData('web_blog_cat', array('blogCatID' => $this->uri->segment(2)));
        $this->generic->Delete('web_pages', array('pageID' => $blogcat[0]['pageID']));
        $this->generic->Delete('web_page_meta', array('pageID' => $blogcat[0]['pageID']));
        $this->generic->Delete('web_blog_cat', array('blogCatID' => $this->uri->segment(2)));
        $this->session->set_flashdata('successDeleted', 'Blog Category deleted successfully!');
        redirect(base_url('manage-blog-category'));
    }

    // change status blog cat
    public function changeBlogCatStatus()
    {
        if ($this->uri->segment(3) == 1) {
            $newStatus = 0;
            $this->session->set_flashdata('statusDeactivated', 'Category deactivated successfully!');
        } else {
            $newStatus = 1;
            $this->session->set_flashdata('statusActivated', 'Category activated successfully!');
        }
        $this->generic->Update('web_pages', array('pageID' => $this->uri->segment(2)), array('pageStatus' => $newStatus));
        redirect(base_url('manage-blog-category'));
    }

    public function updateBlogCat()
    {
        $this->data['blogCatData'] = $this->generic->GetBlogCatData(array('bc.blogCatID' => $this->uri->segment(2)));
        $this->load->view('superadmin/blog/EditBlogCat', $this->data);
    }
    public function updateBlogCatData()
    {
        $catName = $this->input->post('catName');
        //add page
        //get all seo part inputs
        $metaTitle = $this->input->post('metaTittle');
        $metaKeywords = $this->input->post('metaKeyword');
        $metaDesc = $this->input->post('metaDesc');
        $heading1 = $this->input->post('heading1');
        $heading2 = $this->input->post('heading2');
        $headingDesc1 = $this->input->post('headingDesc1');
        $headingDesc2 = $this->input->post('headingDesc2');
        if ($metaTitle) {
            $pageTittle = $metaTitle;
        } else {
            $pageTittle = $catName . " | equipmanager.dk";
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
        $this->generic->Update('web_page_meta', array('pageID' => $this->uri->segment(3)), $seodata);
        //add blog cat data
        $blogcatData = array(
            'blogCat' => $this->input->post('catName'),
            'blogCatDesc' => $this->input->post('catDesc'),
        );
        $this->generic->Update('web_blog_cat', array('pageID' => $this->uri->segment(3)), $blogcatData);
        $this->session->set_flashdata('updatedCat', 'Blog Category deleted successfully!');
        redirect(base_url('manage-blog-category'));
    }
    public function ManageSuperBlog()
    {
        $this->data['blogCatData'] = $this->generic->GetBlogCatData(array('p.pageStatus' => 1));
        $this->load->view('superadmin/blog/addblog', $this->data);
    }

    // show super blog page load
    public function showSuperBlog()
    {
        $this->data['showblogdata'] = $this->generic->GetBlogData();
        $this->load->view('superadmin/blog/showblog', $this->data);
    }
    public function changeBlogStatus()
    {
        if ($this->uri->segment(3) == 1) {
            $newStatus = 0;
            $this->session->set_flashdata('statusDeactivated', 'Category deactivated successfully!');
        } else {
            $newStatus = 1;
            $this->session->set_flashdata('statusActivated', 'Category activated successfully!');
        }
        $this->generic->Update('web_pages', array('pageID' => $this->uri->segment(2)), array('pageStatus' => $newStatus));
        redirect(base_url('show-super-blog'));
    }

    // add blog
    public function addSuperBlog()
    {
        $blogCate = $this->input->post('blogCate');
        $blogDate = $this->input->post('blogDate');
        $blogTitle = $this->input->post('blogTitle');
        $blogDesp = $this->input->post('blogDesp');
        $metaTitle = $this->input->post('metaTittle');
        // normalize title: trim, replace any whitespace sequence with a hyphen, then lowercase
        $Slug = strtolower(preg_replace('/\s+/', '-', trim($blogTitle)));
        $metaKeywords = $this->input->post('metaKeyword');
        $metaDesc = $this->input->post('metaDesc');
        $heading1 = $this->input->post('heading1');
        $heading2 = $this->input->post('heading2');
        $headingDesc1 = $this->input->post('headingDesc1');
        $headingDesc2 = $this->input->post('headingDesc2');
        //page entry
        $pagedata = array(
            'slug' => $Slug,
            'pageType' => 5,
            'pageStatus' => 1
        );
        $this->generic->InsertData('web_pages', $pagedata);
        //get page max page id
        $pageID = $this->generic->GetMaxID('web_pages', 'pageID');
        //seo data entry
        if ($metaTitle) {
            $pageTittle = $metaTitle;
        } else {
            $pageTittle = $blogTitle . " | equipmanager.dk";
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
            'pageID' => $pageID[0]['result'],
            'blogCatID' => $blogCate,
            'web_blogDate' => $blogDate,
            'web_blogTitle' => $blogTitle,
            'web_blogDesp' => $blogDesp,
            'web_blogImg' => $blogImage,
        );
        $this->generic->InsertData('web_blogs', $data);
        $this->session->set_flashdata('successadde', 'Person deleted successfully!');
        redirect(base_url('manage-super-blog'));
    }

    // delete blog
    public function deletSuperBlog()
    {
        // Delete blog from database
        $blogcat = $this->generic->GetData('web_blogs', array('web_blogID' => $this->uri->segment(2)));
        $this->generic->Delete('web_pages', array('pageID' => $blogcat[0]['pageID']));
        $this->generic->Delete('web_page_meta', array('pageID' => $blogcat[0]['pageID']));
        $this->generic->Delete('web_blogs', array('web_blogID' => $this->uri->segment(2)));
        $this->session->set_flashdata('successDeleted', 'Blog deleted successfully!');
        redirect(base_url('show-super-blog'));
    }

    // update blog
    public function updateSuperBlog()
    {
        //load category
        $this->data['blogCatData'] = $this->generic->GetBlogCatData(array('p.pageStatus' => 1));
        // Get blog data
        $this->data['blogData'] = $this->generic->GetBlogData(array('wb.web_blogID' => $this->uri->segment(2)));
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

        //get all seo part inputs
        $metaTitle = $this->input->post('metaTittle');
        $metaKeywords = $this->input->post('metaKeyword');
        $metaDesc = $this->input->post('metaDesc');
        $heading1 = $this->input->post('heading1');
        $heading2 = $this->input->post('heading2');
        $headingDesc1 = $this->input->post('headingDesc1');
        $headingDesc2 = $this->input->post('headingDesc2');
        if ($metaTitle) {
            $pageTittle = $metaTitle;
        } else {
            $pageTittle = $blogTitle . " | equipmanager.dk";
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
        $this->generic->Update('web_page_meta', array('pageID' => $this->uri->segment(3)), $seodata);
        $blogdata = $this->generic->GetData('web_blogs', array('web_blogID' => $this->uri->segment(2)));
        //check if we have image posted
        if (empty($_FILES['blogImage']['name'])) {
            $blogImage = $blogdata[0]['web_blogImg'];
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
            'blogCatID' => $blogCate,
            'web_blogDate' => $blogDate,
            'web_blogTitle' => $blogTitle,
            'web_blogDesp' => $blogDesp,
            'web_blogImg' => $blogImage,
        );
        $this->generic->Update('web_blogs', array('web_blogID' => $blogID), $data);
        $this->session->set_flashdata('successupdated', 'Person deleted successfully!');
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

    // change success status
    public function changeSuccessCatStatus()
    {
        if ($this->uri->segment(3) == 1) {
            $newStatus = 0;
            $this->session->set_flashdata('statusDeactivated', 'Metrics deactivated successfully!');
        } else {
            $newStatus = 1;
            $this->session->set_flashdata('statusActivated', 'Metrics activated successfully!');
        }
        $this->generic->Update('web_success', array('web_successID' => $this->uri->segment(2)), array('web_successStatus' => $newStatus));
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

    // change status
    public function changePartnerStatus()
    {
        if ($this->uri->segment(3) == 1) {
            $newStatus = 0;
            $this->session->set_flashdata('statusDeactivated', 'Metrics deactivated successfully!');
        } else {
            $newStatus = 1;
            $this->session->set_flashdata('statusActivated', 'Metrics activated successfully!');
        }
        $this->generic->Update('web_company', array('web_companyID' => $this->uri->segment(2)), array('web_companyStatus' => $newStatus));
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

    //market place listing management
    public function MarketplaceListing(){
        $where=array();
		if (isset($_GET['ItemType']) && $_GET['ItemType'] != '') {
			$where['si.itemType'] = $_GET['ItemType'];
		}
		if (isset($_GET['listingType']) && $_GET['listingType'] != '') {
			$where['si.saleType'] = $_GET['ItemType'];
		}
		if (isset($_GET['listingStatus']) && $_GET['listingStatus'] != '') {
			$where['si.itemStatus'] = $_GET['listingStatus'];
		}
        $where['si.itemStatus!=']=4;
		$this->data['listing'] = $this->generic->GetMarketPlaceListingData($where);
		$this->load->view('superadmin/marketplaceListing/all-listing', $this->data);
    }
    public function MarketplaceListingMarkedApproved(){
        $this->generic->Update('shopitem',array('itemID'=>$_GET['listingID']),array('itemStatus'=>1,'liveStatus'=>1));
         $this->session->set_flashdata('approved', 'Partner added successfully!');
        redirect(base_url('admin-marketplace-listing'));
    }
    public function MarketplaceListingMarkedRejected(){
        $this->generic->Update('shopitem',array('itemID'=>$_GET['listingID']),array('itemStatus'=>3));
         $this->session->set_flashdata('rejected', 'Partner added successfully!');
        redirect(base_url('admin-marketplace-listing'));
    }
    public function ChangeMarketplacelistingWebsiteStatus(){
        $curentStatus=$this->uri->segment(3);
        if($curentStatus==1){
            $this->generic->Update('shopitem',array('itemID'=>$this->uri->segment(2)),array('liveStatus'=>0));
             $this->session->set_flashdata('notLive', 'Partner added successfully!');
             
        }else{
            $this->generic->Update('shopitem',array('itemID'=>$this->uri->segment(2)),array('liveStatus'=>1));
            $this->session->set_flashdata('live', 'Partner added successfully!');
        }
        if($this->session->userdata('loginData')['userType']==1){
         redirect(base_url('admin-marketplace-listing'));
        }else{
            redirect(base_url('all-listing'));
        }
    }

    /**
     * Payments Dashboard - View all payments and pending payouts
     */
    public function payments()
    {
        // Check if user is SuperAdmin
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
            return;
        }

        // Get pending payouts
        $this->data['pending_payouts'] = $this->payment->getPendingPayouts();

        // Get payment statistics
        $this->data['stats'] = $this->payment->getPaymentStats();

        $this->load->view('superadmin/payments/dashboard', $this->data);
    }

    /**
     * Approve payout
     */
    public function approvePayout()
    {
        // Check if user is SuperAdmin
        if ($this->session->userdata('loginData')['userType'] != 1) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }

        $payout_id = $this->input->post('payout_id');
        $notes = $this->input->post('notes');

        if (!$payout_id) {
            echo json_encode(['success' => false, 'error' => 'Payout ID required']);
            return;
        }

        $admin_id = $this->session->userdata('loginData')['userID'];
        $this->payment->updatePayoutStatus($payout_id, 'approved', $admin_id, $notes);

        $this->session->set_flashdata('success', 'Payout approved successfully!');
        echo json_encode(['success' => true]);
    }

    /**
     * Reject payout
     */
    public function rejectPayout()
    {
        // Check if user is SuperAdmin
        if ($this->session->userdata('loginData')['userType'] != 1) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }

        $payout_id = $this->input->post('payout_id');
        $notes = $this->input->post('notes');

        if (!$payout_id) {
            echo json_encode(['success' => false, 'error' => 'Payout ID required']);
            return;
        }

        $admin_id = $this->session->userdata('loginData')['userID'];
        $this->payment->updatePayoutStatus($payout_id, 'rejected', $admin_id, $notes);

        $this->session->set_flashdata('error', 'Payout rejected');
        echo json_encode(['success' => true]);
    }

    /**
     * Set commission percentage for an item
     */
    public function setItemCommission()
    {
        // Check if user is SuperAdmin
        if ($this->session->userdata('loginData')['userType'] != 1) {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }

        $item_id = $this->input->post('item_id');
        $commission_percent = floatval($this->input->post('commission_percent'));

        if (!$item_id || $commission_percent < 0 || $commission_percent > 100) {
            echo json_encode(['success' => false, 'error' => 'Invalid input']);
            return;
        }

        $admin_id = $this->session->userdata('loginData')['userID'];
        $this->payment->setItemCommission($item_id, $commission_percent, $admin_id);

        $this->session->set_flashdata('success', 'Commission set successfully!');
        echo json_encode(['success' => true]);
    }

    /**
     * Display all orders from all companies (Super Admin view)
     */
    public function all_orders()
    {
        // Check if user is SuperAdmin
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
            return;
        }

        $this->load->database();

        // Get filter parameter from URL
        $filter = $this->input->get('status');

        // Build unified query to get both equipment and workforce orders.
        $this->db->select([
            'o.orderID',
            "CASE WHEN o.equipmentPaymentID IS NOT NULL THEN 'equipment' ELSE 'workforce' END as orderType",
            'o.createdAt',
            'COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount',
            'COALESCE(ep.commissionAmount, wp.commissionAmount) as commission',
            'COALESCE(ep.orderStatus, wp.orderStatus) as orderStatus',
            'COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus',
            'COALESCE(ep.hasActiveIssue, wp.hasActiveIssue) as hasActiveIssue',
            'COALESCE(ep.currentIssueID, wp.currentIssueID) as currentIssueID',
            "COALESCE(ep.saleType, 'rental') as saleType",
            'u.userName as buyerFirstName',
            'u.userEmail as buyerEmail',
            'cd.companyName'
        ], false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('users u', 'u.userID = COALESCE(ep.buyerUserID, wp.buyerUserID)', 'left', false)
        ->join('companydetail cd', 'cd.companyID = COALESCE(ep.sellerCompanyID, wp.sellerCompanyID)', 'left', false);

        // Apply filter if provided
        if ($filter && !empty($filter)) {
            $valid_filters = [
                'requested', 'payment_pending', 'payment_secured', 'shipped', 'pickup_ready', 'delivered', 'completed', 'rejected', 'cancelled',
                'request_pending', 'request_approved', 'request_rejected', 'awaiting_handover', 'rental_active', 'return_requested',
                'rental_overdue', 'returned_by_renter', 'received_by_owner', 'under_review', 'rental_completed', 'rental_cancelled'
            ];
            if (in_array($filter, $valid_filters)) {
                $esc_filter = $this->db->escape($filter);
                if ($filter === 'under_review') {
                    $this->db->where("(COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) = {$esc_filter} OR COALESCE(ep.hasActiveIssue, wp.hasActiveIssue) = 1)", null, false);
                } else {
                    $this->db->where("(COALESCE(ep.orderStatus, wp.orderStatus) = {$esc_filter} OR COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) = {$esc_filter})", null, false);
                }
            }
        }

        // Order by newest first
        $this->db->order_by('o.createdAt', 'DESC');

        $query = $this->db->get();
        $orders = $query->result();

        // Prepare data for view
        $data = [
            'orders' => $orders,
            'filter' => $filter
        ];

        // Load the view with layout
        $this->load->view('superadmin/all_orders', $data);
    }

    /**
     * Display detailed order information (Super Admin view)
     */
    public function view_order($order_id)
    {
        // Check if user is SuperAdmin
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
            return;
        }

        // Validate order ID is numeric
        if (!is_numeric($order_id)) {
            show_404();
            return;
        }

        $this->load->database();

        // Get complete order details using unified orders table
        $has_chat_links = $this->db->table_exists('order_chat_links');

        $order_query = $this->db->select("
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            CASE WHEN o.equipmentPaymentID IS NOT NULL THEN 'equipment' ELSE 'workforce' END as orderType,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus,
            COALESCE(ep.hasActiveIssue, wp.hasActiveIssue) as hasActiveIssue,
            COALESCE(ep.currentIssueID, wp.currentIssueID) as currentIssueID,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.currency, wp.currency) as currency,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.itemID, wp.itemID) as itemID,
            COALESCE(ep.buyerUserID, wp.buyerUserID) as buyerUserID,
            COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) as sellerCompanyID,
            e.equipName as equipmentName,
            e.equipDesc,
            e.equipImg as equipImage,
            e.equipTotalQuantity,
            e.equipmentID,
            wf.personName as workforceName,
            wf.workforceID,
            sw.workforceCity,
            sw.WorkforceAdd,
            sw.workforceAvailableStart,
            sw.workforceAvailableEnd,
            COALESCE(e.equipName, wf.personName) as itemName,
            u.userName as buyerName,
            u.userEmail as buyerEmail,
            u.userPhone as buyerPhone,
            cd.companyName as sellerCompanyName,
            seller.userName as sellerUserName,
            oc.chatID,
            ep.approvedBy,
            approver.userName as approvedByName,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            ep.trackingNumber,
            ep.shippingNotes,
            ep.shippedAt,
            ep.deliveredAt,
            ep.fundsReleasedAt,
            ep.approvedAt,
            ep.rejectionReason
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('shopworkforce sw', 'wp.itemID = sw.itemID', 'left')
        ->join('users u', 'COALESCE(ep.buyerUserID, wp.buyerUserID) = u.userID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
        ->join('users seller', 'cd.userID = seller.userID', 'left');

        if ($has_chat_links) {
            $order_query->join('order_chat_links ocl', 'o.orderID = ocl.orderID', 'left')
                ->join('order_chats oc', 'ocl.chatID = oc.chatID', 'left');
        } else {
            $order_query->join('order_chats oc', 'o.orderID = oc.orderID', 'left');
        }

        $order = $order_query
            ->join('users approver', 'ep.approvedBy = approver.userID', 'left')
            ->where('o.orderID', $order_id)
            ->get()
            ->row();

        if (!$order) {
            show_404();
            return;
        }

        // Build images array â€” try shopequipments first, fallback to equipment main image
        $images = [];
        if (!empty($order->itemID)) {
            $shop_eq = $this->db->select([
                'eqpimg1','eqpimg2','eqpimg3','eqpimg4','eqpimg5',
                'eqpimg6','eqpimg7','eqpimg8','eqpimg9','eqpimg10'
            ])->from('shopequipments')->where('itemID', $order->itemID)->limit(1)->get()->row();
            if ($shop_eq) {
                for ($i = 1; $i <= 10; $i++) {
                    $f = 'eqpimg' . $i;
                    if (!empty($shop_eq->$f)) $images[] = 'assets/website/images/' . $shop_eq->$f;
                }
            }
        }
        if (empty($images) && !empty($order->equipmentID)) {
            $shop_eq = $this->db->select([
                'eqpimg1','eqpimg2','eqpimg3','eqpimg4','eqpimg5',
                'eqpimg6','eqpimg7','eqpimg8','eqpimg9','eqpimg10'
            ])->from('shopequipments')->where('equipmentID', $order->equipmentID)->limit(1)->get()->row();
            if ($shop_eq) {
                for ($i = 1; $i <= 10; $i++) {
                    $f = 'eqpimg' . $i;
                    if (!empty($shop_eq->$f)) $images[] = 'assets/website/images/' . $shop_eq->$f;
                }
            }
        }
        if (empty($images) && !empty($order->equipImage)) {
            $images[] = 'assets/website/images/' . $order->equipImage;
        }

        // Prepare data for view
        $this->load->helper('invoice');
        $this->load->model('Issue_model');
        $data = [
            'order'  => $order,
            'images' => $images,
            'can_download_invoice' => invoice_can_download($order),
            'order_issues' => $this->Issue_model->getIssuesForOrder((int)$order_id),
        ];

        // Load the view with layout
        $this->load->view('superadmin/order_detail', $data);
    }

    /**
     * Download invoice PDF for any order (SuperAdmin only).
     *
     * @param int $order_id
     * @return void
     */
    public function invoice($order_id)
    {
        if (($this->session->userdata('loginData')['userType'] ?? null) != 1) {
            redirect(base_url());
            return;
        }

        if (!is_numeric($order_id)) {
            show_404();
            return;
        }

        $this->load->helper('invoice');
        $order = $this->get_invoice_order_for_superadmin((int)$order_id);
        if (!$order) {
            show_404();
            return;
        }

        if (!invoice_can_download($order)) {
            $this->session->set_flashdata('error', 'Invoice is available only after payment is completed.');
            redirect('super-admin-orders/view/' . (int)$order_id);
            return;
        }

        $invoice_data = invoice_build_payload($order);
        $this->stream_invoice_pdf($invoice_data);
    }

    /**
     * Get invoice-ready order payload for SuperAdmin.
     *
     * @param int $order_id
     * @return object|null
     */
    private function get_invoice_order_for_superadmin($order_id)
    {
        return $this->db->select(" 
            o.orderID,
            o.equipmentPaymentID,
            o.workforcePaymentID,
            COALESCE(ep.grossAmount, wp.grossAmount) as grossAmount,
            COALESCE(ep.commissionPercent, wp.commissionPercent) as commissionPercent,
            COALESCE(ep.commissionAmount, wp.commissionAmount) as commissionAmount,
            COALESCE(ep.netAmount, wp.netAmount) as netAmount,
            COALESCE(ep.currency, wp.currency, 'USD') as currency,
            COALESCE(ep.paymentStatus, wp.paymentStatus) as paymentStatus,
            COALESCE(ep.orderStatus, wp.orderStatus, wp.rentalRequestStatus) as orderStatus,
            COALESCE(ep.rentalRequestStatus, wp.rentalRequestStatus) as rentalRequestStatus,
            COALESCE(ep.stripePaymentIntentID, wp.stripePaymentIntentID) as stripePaymentIntentID,
            COALESCE(ep.saleType, 'rental') as saleType,
            COALESCE(ep.quantity, DATEDIFF(wp.rentalEndDate, wp.rentalStartDate) + 1) as quantity,
            COALESCE(ep.rentalStartDate, wp.rentalStartDate) as rentalStartDate,
            COALESCE(ep.rentalEndDate, wp.rentalEndDate) as rentalEndDate,
            COALESCE(ep.rentalType, wp.rentalType) as rentalType,
            COALESCE(ep.paymentMetadata, wp.paymentMetadata) as paymentMetadata,
            COALESCE(ep.createdAt, wp.createdAt) as createdAt,
            COALESCE(ep.updatedAt, wp.updatedAt) as updatedAt,
            COALESCE(e.equipName, wf.personName) as itemName,
            buyer.userName as buyerName,
            buyer.userEmail as buyerEmail,
            buyer.userPhone as buyerPhone,
            cd.companyName as sellerCompanyName,
            seller.userName as sellerContactName,
            seller.userEmail as sellerEmail,
            seller.userPhone as sellerPhone
        ", false)
        ->from('orders o')
        ->join('equipment_payments ep', 'o.equipmentPaymentID = ep.equipmentPaymentID', 'left')
        ->join('workforce_payments wp', 'o.workforcePaymentID = wp.workforcePaymentID', 'left')
        ->join('equipment e', 'ep.equipmentID = e.equipmentID', 'left')
        ->join('workforce wf', 'wp.workforceID = wf.workforceID', 'left')
        ->join('users buyer', 'COALESCE(ep.buyerUserID, wp.buyerUserID) = buyer.userID', 'left')
        ->join('companydetail cd', 'COALESCE(ep.sellerCompanyID, wp.sellerCompanyID) = cd.companyID', 'left')
        ->join('users seller', 'cd.userID = seller.userID', 'left')
        ->where('o.orderID', $order_id)
        ->get()
        ->row();
    }

    /**
     * Render and stream invoice PDF.
     *
     * @param array $invoice_data
     * @return void
     */
    private function stream_invoice_pdf(array $invoice_data)
    {
        if (!class_exists('Dompdf\\Dompdf')) {
            $autoload_path = FCPATH . 'vendor/autoload.php';
            if (!file_exists($autoload_path)) {
                show_error('PDF library is not installed. Please run composer install.', 500);
                return;
            }
            require_once $autoload_path;
        }

        $html = $this->load->view('invoices/order_invoice_pdf', ['invoice' => $invoice_data], true);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        $filename = 'invoice-' . preg_replace('/[^A-Za-z0-9\-_]/', '', (string)$invoice_data['invoice_number']) . '.pdf';
        $this->output
            ->set_content_type('application/pdf')
            ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
            ->set_output($dompdf->output());
    }

    // =============================================
    // RENTAL ISSUE & DISPUTE MANAGEMENT METHODS
    // =============================================

    /**
     * Issues list for SuperAdmin
     * GET /superadmin/issues
     */
    public function issues()
    {
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
        }

        $this->load->model('Issue_model');
        $this->load->helper('status_display');

        $page         = max(1, intval($this->input->get('page')));
        $per_page     = 20;
        $filter_status = $this->input->get('status', TRUE) ?: '';

        $filters = [];
        if ($filter_status) { $filters['status'] = $filter_status; }

        $issues = $this->Issue_model->getAllIssues($filters, $per_page, ($page - 1) * $per_page);
        $total  = $this->Issue_model->countAllIssues($filters);

        $data = [
            'issues'        => $issues,
            'total'         => $total,
            'per_page'      => $per_page,
            'current_page'  => $page,
            'filter_status' => $filter_status,
        ];

        $this->load->view('superadmin/issues_list', $data);
    }

    /**
     * Issue detail + resolution form
     * GET /superadmin/issue_detail/{id}
     */
    public function issue_detail($issue_id = null)
    {
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
        }

        if (!$issue_id) { show_404(); }

        $this->load->model('Issue_model');
        $this->load->helper('status_display');

        $issue = $this->Issue_model->getIssueById($issue_id);
        if (!$issue) { show_404(); }

        // Get all super admins for assign dropdown
        $admins = $this->db->select('userID, userName')
            ->from('users')
            ->where('userType', 1)
            ->where('userStatus', 1)
            ->get()->result();

        // Get related chat
        if ($this->db->table_exists('order_chat_links')) {
            $chat = $this->db->select('oc.chatID')
                ->from('order_chat_links ocl')
                ->join('order_chats oc', 'oc.chatID = ocl.chatID', 'inner')
                ->where('ocl.orderID', $issue->orderID)
                ->order_by('ocl.linkID', 'DESC')
                ->get()->row();
        } else {
            $chat = $this->db->select('chatID')
                ->from('order_chats')
                ->where('orderID', $issue->orderID)
                ->order_by('chatID', 'DESC')
                ->get()->row();
        }

        $issue->chatID = $chat ? $chat->chatID : null;

        $data = ['issue' => $issue, 'admins' => $admins];
        $this->load->view('superadmin/issue_detail', $data);
    }

    /**
     * API: Assign issue to admin
     * POST /superadmin/api_assign_issue
     */
    public function api_assign_issue()
    {
        header('Content-Type: application/json');
        if ($this->session->userdata('loginData')['userType'] != 1) {
            echo json_encode(['success'=>false,'message'=>'Access denied']); return;
        }
        $issue_id = intval($this->input->post('issue_id', TRUE));
        $admin_id = intval($this->input->post('admin_id', TRUE));
        if (!$issue_id || !$admin_id) {
            echo json_encode(['success'=>false,'message'=>'Invalid parameters']); return;
        }
        $this->load->model('Issue_model');
        $result = $this->Issue_model->assignToAdmin($issue_id, $admin_id);
        echo json_encode(['success' => (bool)$result, 'message' => $result ? 'Assigned' : 'Failed to assign']);
    }

    /**
     * API: Resolve issue with outcome + optional refund
     * POST /superadmin/api_resolve_issue
     */
    public function api_resolve_issue()
    {
        header('Content-Type: application/json');

        $login_data = $this->session->userdata('loginData');
        if (!$login_data || $login_data['userType'] != 1) {
            echo json_encode(['success'=>false,'message'=>'Access denied']); return;
        }

        $admin_id     = $login_data['userID'];
        $issue_id     = intval($this->input->post('issue_id', TRUE));
        $outcome      = $this->input->post('outcome', TRUE);
        $notes        = $this->input->post('notes', TRUE);
        $refund_amount= floatval($this->input->post('refund_amount', TRUE));

        $valid_outcomes = ['no_action','refund_partial','refund_full','compensation','insurance_claim'];
        if (!$issue_id || !in_array($outcome, $valid_outcomes) || !$notes) {
            echo json_encode(['success'=>false,'message'=>'Missing required fields']); return;
        }

        $this->load->model('Issue_model');
        $this->load->helper('notification');

        $issue = $this->Issue_model->getIssueById($issue_id);
        if (!$issue) {
            echo json_encode(['success'=>false,'message'=>'Issue not found']); return;
        }

        $resolution_data = [
            'outcome'            => $outcome,
            'notes'              => $notes,
            'refund_amount'      => $refund_amount > 0 ? $refund_amount : null,
            'resolved_by'        => $admin_id,
        ];

        $result = $this->Issue_model->resolveIssue($issue_id, $resolution_data);

        if ($result) {
            $payment_table = $issue->equipmentPaymentID ? 'equipment_payments' : 'workforce_payments';
            $pk = $issue->equipmentPaymentID ? 'equipmentPaymentID' : 'workforcePaymentID';
            $pay_id = $issue->equipmentPaymentID ?? $issue->workforcePaymentID;

            // Normalize legacy under_review lifecycle/status flags after issue resolution.
            $this->normalize_payment_after_issue_resolution($issue, $payment_table, $pk, $pay_id);

            // Resolve chat behavior based on whether order is still ongoing
            if ($this->db->table_exists('order_chat_links')) {
                $chat = $this->db->select('oc.chatID')
                    ->from('order_chat_links ocl')
                    ->join('order_chats oc', 'oc.chatID = ocl.chatID', 'inner')
                    ->where('ocl.orderID', $issue->orderID)
                    ->where('oc.chatType', 'dispute')
                    ->order_by('ocl.linkID', 'DESC')
                    ->get()->row();
            } else {
                $chat = $this->db->select('chatID')
                    ->from('order_chats')
                    ->where('orderID', $issue->orderID)
                    ->where('chatType', 'dispute')
                    ->get()->row();
            }

            $payment = $this->db->get_where($payment_table, [$pk => $pay_id])->row();

            $is_order_ongoing = true;
            if ($payment) {
                $order_status = strtolower(trim((string)($payment->orderStatus ?? '')));
                $rental_status = strtolower(trim((string)($payment->rentalRequestStatus ?? '')));
                $terminal_order_statuses = ['completed', 'cancelled', 'refunded'];
                $terminal_rental_statuses = ['rental_completed', 'rental_cancelled'];
                if (in_array($order_status, $terminal_order_statuses, true) || in_array($rental_status, $terminal_rental_statuses, true)) {
                    $is_order_ongoing = false;
                }
            }

            if ($chat) {
                $this->load->model('Chat_model');
                // Remove superadmin participation after resolution.
                // Keep chat open for buyer/seller while order is ongoing.
                $this->Chat_model->deescalate_dispute_chat($chat->chatID, $is_order_ongoing);
                if (!$is_order_ongoing) {
                    $this->Chat_model->lock_chat($chat->chatID, true);
                }

                $resolution_message = $is_order_ongoing
                    ? "✅ Issue #$issue_id resolved by SuperAdmin. Outcome: " . ucwords(str_replace('_', ' ', $outcome)) . ". " . $notes . "\n\nThis dispute chat remains available for buyer, company admin, and superadmin until order completion."
                    : "✅ Issue #$issue_id resolved by SuperAdmin. Outcome: " . ucwords(str_replace('_', ' ', $outcome)) . ". " . $notes . "\n\nOrder is already completed/cancelled, so this chat is now closed but remains available for history.";

                $this->db->insert('order_chat_messages', [
                    'chatID'       => $chat->chatID,
                    'senderUserID' => $admin_id,
                    'messageText'  => $resolution_message,
                    'createdAt'    => date('Y-m-d H:i:s'),
                ]);
            }

            // Notify both parties
            if ($payment) {
                send_notification($payment->buyerUserID, 'issue_resolved', $issue->orderID);
                $owner = $this->db->select('userID')->from('companydetail')->where('companyID', $payment->sellerCompanyID)->get()->row();
                if ($owner) { send_notification($owner->userID, 'issue_resolved', $issue->orderID); }
            }

            echo json_encode(['success'=>true,'message'=>'Issue resolved successfully']);
            log_message('info', "SuperAdmin $admin_id resolved issue $issue_id with outcome: $outcome");
        } else {
            echo json_encode(['success'=>false,'message'=>'Failed to resolve issue']);
        }
    }

    /**
     * SuperAdmin: List all dispute/issue chats
     * GET /superadmin/issue-chats
     */
    public function issue_chats()
    {
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
        }

        $this->load->model('Chat_model');
        $filter_status = $this->input->get('status', TRUE) ?: '';

        $filters = [];
        if ($filter_status && in_array($filter_status, ['open', 'locked'], true)) {
            $filters['status'] = $filter_status;
        }

        $data = [
            'chats' => $this->Chat_model->get_dispute_chats($filters),
            'filter_status' => $filter_status,
        ];

        $this->load->view('superadmin/issue_chats_list', $data);
    }

    /**
     * SuperAdmin: Open a specific dispute chat
     * GET /superadmin/issue-chats/view/{chatID}
     */
    public function issue_chat_view($chat_id = null)
    {
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
        }

        $chat_id = intval($chat_id);
        if (!$chat_id) {
            show_404();
            return;
        }

        $this->load->model('Chat_model');
        $this->load->model('Issue_model');
        $this->load->library('Jwt_service');

        $chat_row = $this->Chat_model->get_chat_by_id($chat_id);
        if (!$chat_row) {
            show_error('Issue chat not found', 404);
            return;
        }

        $issue_id = intval($chat_row->disputeIssueID ?? 0);
        if ($issue_id <= 0) {
            $issue_id = intval($this->input->get('issue_id', TRUE));
        }
        if ($issue_id <= 0) {
            $fallback_issue = $this->db->select('issueID')
                ->from('rental_issues')
                ->where('orderID', $chat_row->orderID)
                ->order_by('reportedAt', 'DESC')
                ->limit(1)
                ->get()->row();
            $issue_id = $fallback_issue ? intval($fallback_issue->issueID) : 0;
        }

        $issue = $issue_id > 0 ? $this->Issue_model->getIssueById($issue_id) : null;
        if (!$issue) {
            show_error('Related issue not found', 404);
            return;
        }

        $login_data = $this->session->userdata('loginData');
        $user_id = intval($login_data['userID']);

        $data = [
            'chat' => $this->Chat_model->get_chat_details($chat_id),
            'messages' => $this->Chat_model->get_messages($chat_id),
            'issue' => $issue,
            'current_user_id' => $user_id,
            'user_role' => 'superadmin',
            'jwt_token' => $this->jwt_service->generate_token($user_id, $chat_id, 'superadmin'),
        ];

        $this->load->view('superadmin/issue_chat_view', $data);
    }

    /**
     * SuperAdmin: One-click resolve from issue chat page
     * POST /superadmin/resolve-issue-chat
     */
    public function resolve_issue_chat()
    {
        if ($this->session->userdata('loginData')['userType'] != 1) {
            redirect(base_url());
        }

        if (strtoupper($this->input->server('REQUEST_METHOD')) !== 'POST') {
            show_error('Invalid request method', 405);
            return;
        }

        $chat_id = intval($this->input->post('chat_id', TRUE));
        if (!$chat_id) {
            $this->session->set_flashdata('error', 'Invalid chat reference.');
            redirect(base_url('superadmin/issue-chats'));
            return;
        }

        $this->load->model('Chat_model');
        $this->load->model('Issue_model');
        $this->load->helper('notification');

        $login_data = $this->session->userdata('loginData');
        $admin_id = intval($login_data['userID']);

        $chat_row = $this->Chat_model->get_chat_by_id($chat_id);
        if (!$chat_row || $chat_row->chatType !== 'dispute' || empty($chat_row->disputeIssueID)) {
            $this->session->set_flashdata('error', 'Issue chat not found.');
            redirect(base_url('superadmin/issue-chats'));
            return;
        }

        $issue_id = intval($chat_row->disputeIssueID);
        $issue = $this->Issue_model->getIssueById($issue_id);
        if (!$issue) {
            $this->session->set_flashdata('error', 'Related issue not found.');
            redirect(base_url('superadmin/issue-chats'));
            return;
        }

        if (!in_array($issue->issueStatus, ['resolved', 'closed'], true)) {
            $resolution_data = [
                'outcome' => 'no_action',
                'notes' => 'Issue resolved by SuperAdmin from issue chat.',
                'resolved_by' => $admin_id,
            ];
            $this->Issue_model->resolveIssue($issue_id, $resolution_data);
        }

        $payment_table = $issue->equipmentPaymentID ? 'equipment_payments' : 'workforce_payments';
        $pk = $issue->equipmentPaymentID ? 'equipmentPaymentID' : 'workforcePaymentID';
        $pay_id = $issue->equipmentPaymentID ?? $issue->workforcePaymentID;

        // Normalize legacy under_review lifecycle/status flags after issue resolution.
        $this->normalize_payment_after_issue_resolution($issue, $payment_table, $pk, $pay_id);

        $payment = $this->db->get_where($payment_table, [$pk => $pay_id])->row();

        $is_order_ongoing = true;
        if ($payment) {
            $order_status = strtolower(trim((string)($payment->orderStatus ?? '')));
            $rental_status = strtolower(trim((string)($payment->rentalRequestStatus ?? '')));
            $terminal_order_statuses = ['completed', 'cancelled', 'refunded'];
            $terminal_rental_statuses = ['rental_completed', 'rental_cancelled'];
            if (in_array($order_status, $terminal_order_statuses, true) || in_array($rental_status, $terminal_rental_statuses, true)) {
                $is_order_ongoing = false;
            }
        }

        // Remove superadmin from dispute chat after resolution.
        // Keep buyer/seller chat open when order is still ongoing.
        $this->Chat_model->deescalate_dispute_chat($chat_id, $is_order_ongoing);
        if (!$is_order_ongoing) {
            $this->Chat_model->lock_chat($chat_id, true);
        }

        $resolution_message = $is_order_ongoing
            ? "✅ Issue #{$issue_id} marked as resolved by SuperAdmin. This dispute chat remains available for buyer, company admin, and superadmin until order completion."
            : "✅ Issue #{$issue_id} marked as resolved by SuperAdmin. Order is already completed/cancelled, so this chat is now closed but remains available for history.";

        $this->db->insert('order_chat_messages', [
            'chatID' => $chat_id,
            'senderUserID' => $admin_id,
            'messageText' => $resolution_message,
            'createdAt' => date('Y-m-d H:i:s'),
        ]);

        // Notify both parties
        if ($payment) {
            send_notification($payment->buyerUserID, 'issue_resolved', $issue->orderID);
            $owner = $this->db->select('userID')->from('companydetail')->where('companyID', $payment->sellerCompanyID)->get()->row();
            if ($owner) {
                send_notification($owner->userID, 'issue_resolved', $issue->orderID);
            }
        }

        $this->session->set_flashdata('success', $is_order_ongoing
            ? "Issue #{$issue_id} resolved. Dispute chat remains open for all parties."
            : "Issue #{$issue_id} resolved and chat closed (history preserved).");
        redirect(base_url('superadmin/issue-chats'));
    }

    /**
     * Normalize payment flags and lifecycle status after an issue is resolved.
     *
     * Legacy flows set rentalRequestStatus=under_review directly on payment rows.
     * This restores the expected lifecycle so renter/owner actions remain available.
     *
     * @param object $issue
     * @param string $payment_table
     * @param string $pk
     * @param int $pay_id
     * @return void
     */
    private function normalize_payment_after_issue_resolution($issue, $payment_table, $pk, $pay_id)
    {
        if (empty($pay_id)) {
            return;
        }

        $payment = $this->db->get_where($payment_table, [$pk => $pay_id])->row();
        if (!$payment) {
            return;
        }

        $open_issue_count = $this->db->from('rental_issues')
            ->group_start()
                ->where('equipmentPaymentID', $issue->equipmentPaymentID)
                ->or_where('workforcePaymentID', $issue->workforcePaymentID)
            ->group_end()
            ->where_in('issueStatus', ['reported', 'under_review'])
            ->count_all_results();

        $update = ['updatedAt' => date('Y-m-d H:i:s')];

        if ($open_issue_count === 0) {
            $update['hasActiveIssue'] = 0;
            $update['currentIssueID'] = null;
        }

        $rental_status = strtolower(trim((string)($payment->rentalRequestStatus ?? '')));
        if ($rental_status === 'under_review') {
            $order_status = strtolower(trim((string)($payment->orderStatus ?? '')));
            $start_ts = !empty($payment->rentalStartDate) ? strtotime($payment->rentalStartDate . ' 00:00:00') : null;
            $end_ts = !empty($payment->rentalEndDate) ? strtotime($payment->rentalEndDate . ' 23:59:59') : null;
            $renter_confirmed = !empty($payment->renterConfirmedReturn);
            $owner_confirmed = !empty($payment->ownerConfirmedReturn);

            $restored_status = 'rental_active';

            if ($renter_confirmed && $owner_confirmed) {
                $restored_status = 'rental_completed';
            } elseif ($renter_confirmed) {
                $restored_status = 'returned_by_renter';
            } elseif ($owner_confirmed) {
                $restored_status = 'received_by_owner';
            } elseif ($start_ts && time() < $start_ts) {
                $restored_status = in_array($order_status, ['request_pending', 'request_approved', 'awaiting_handover'], true)
                    ? $order_status
                    : 'awaiting_handover';
            } elseif ($end_ts && time() > ($end_ts + (72 * 3600))) {
                $restored_status = 'rental_overdue';
            } elseif ($end_ts && time() > $end_ts) {
                $restored_status = 'return_requested';
            }

            $update['rentalRequestStatus'] = $restored_status;
        }

        $this->db->update($payment_table, $update, [$pk => $pay_id]);
    }
}


