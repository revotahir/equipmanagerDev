<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generic_model extends CI_Model
{


    public function GetData($table, $where = false, $sort_colume = false, $sort_type = false, $limit = false, $start = false, $like = false)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        if ($sort_colume && $sort_type) {
            $this->db->order_by($sort_colume, $sort_type);
        }
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        // if($like){
        //     $this->db->like($like);
        // }
        if ($like) {
            $this->db->group_start();
            foreach ($like as $column => $keyword) {
                if (!empty($keyword)) {
                    $this->db->or_like($column, $keyword);
                }
            }
            $this->db->group_end();
        }

        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }


    function InsertData($table, $data)
    {
        $this->db->insert($table, $data);
    }
    function Update($table, $where, $set)
    {
        $this->db->where($where);
        $this->db->update($table, $set);
    }
    public function Delete($table, $where)
    {
        $this->db->delete($table, $where);
    }

    public function GetMaxID($table, $colum)
    {
        $this->db->select('max(' . $colum . ') as result');
        $this->db->from($table);
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    public function GetCount($table, $colum, $where = false)
    {
        $this->db->select('count(' . $colum . ') as result');
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    function GetLoginData($email, $pass)
    {
        $this->db->select('*');
        $this->db->from('users as u');
        $this->db->where('user_email', $email);
        $this->db->where('user_pass', $pass);
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    function GetWorkforcewithSkill($filters, $where = false)
    {
        $this->db->select('w.*, GROUP_CONCAT(s.skillName SEPARATOR ", ") as skillNames');
        $this->db->from('workforce as w');
        $this->db->join('workforceskilllink as wsl', 'w.workforceID = wsl.workforceID', 'left');
        $this->db->join('skills as s', 'wsl.skillID = s.skillID', 'left');
        $this->db->order_by('w.workforceID', 'DESC');
        $this->db->group_by('w.workforceID');


        if ($filters && is_array($filters)) {
            if (isset($filters['companyID'])) {
                $this->db->where('w.companyID', $filters['companyID']);
            }
            if (isset($filters['personPhone']) && $filters['personPhone'] != '') {
                $this->db->where('w.personPhone', $filters['personPhone']);
            }
            if (isset($filters['personEmail']) && $filters['personEmail'] != '') {
                $this->db->where('w.personEmail', $filters['personEmail']);
            }
            if (isset($filters['personStatus']) && $filters['personStatus'] != '') {
                $this->db->where('w.personStatus', $filters['personStatus']);
            }
            if (isset($filters['personName']) && $filters['personName'] != '') {
                // die('asfasf');
                $this->db->like('w.personName', $filters['personName']);
            }
            // Filter by skillID (if needed)
            if (isset($filters['skillID']) && $filters['skillID'] != '') {
                $this->db->where('wsl.skillID', $filters['skillID']);
            }
        }
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    function GetEquipmentWithCat($filters, $where = false, $qtyavalability = false)
    {
        $this->db->select('*');
        $this->db->from('equipment as e');
        $this->db->join('equipcat as ec', 'e.equipCatID = ec.equipCatID', 'left');
        $this->db->order_by('e.equipmentID', 'DESC');
        // $this->db->group_by('w.workforceID');
        if ($filters && is_array($filters)) {
            if (isset($filters['companyID'])) {
                $this->db->where('e.companyID', $filters['companyID']);
            }
            if (isset($filters['equipName']) && $filters['equipName'] != '') {
                $this->db->like('e.equipName', $filters['equipName']);
            }
            if (isset($filters['equipCatID']) && $filters['equipCatID'] != '') {
                $this->db->where('e.equipCatID', $filters['equipCatID']);
            }
        }
        if ($qtyavalability) {
            $this->db->where('(e.equipTotalQuantity - e.equipInUseQuantity) >', 0); // Only include equipment with quantity greater than 0
        }
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }


    function GetWorkforceofPRoject($where = false)
    {
        $this->db->select('*');
        $this->db->from('projectworkforcelink as pwl');
        $this->db->join('workforce as w', 'pwl.workforceID = w.workforceID', 'inner');
        $this->db->join('projects as p', 'p.ProjectID = pwl.ProjectID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    function GetAssignedEquipmentToWorkforce($where = false)
    {
        $this->db->select('*');
        $this->db->from('projectequipmentassign as aew');
        $this->db->join('equipment as e', 'aew.equipmentID = e.equipmentID', 'inner');
        $this->db->join('workforce as w', 'aew.workforceID = w.workforceID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    function GetProjectsWithDetails($where = false)
    {
        $this->db->select('*');
        $this->db->from('projects as p');
        $this->db->join('projectcategory as pc', 'p.pCatID = pc.pCatID', 'left');
        $this->db->order_by('p.projectID', 'DESC');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }

    public function GetEquipmentWithDateRange($filters, $where, $qtyAvailability, $startDate, $endDate)
    {
        $this->db->select('e.*, (e.equipTotalQuantity - e.equipInUseQuantity) AS availableQty');
        $this->db->from('equipment AS e');
        $this->db->join('equipcat AS ec', 'e.equipCatID = ec.equipCatID', 'left');

        // Apply filters
        if ($filters && is_array($filters)) {
            if (isset($filters['companyID'])) {
                $this->db->where('e.companyID', $filters['companyID']);
            }
            if (isset($filters['equipName']) && $filters['equipName'] != '') {
                $this->db->like('e.equipName', $filters['equipName']);
            }
            if (isset($filters['equipCatID']) && $filters['equipCatID'] != '') {
                $this->db->where('e.equipCatID', $filters['equipCatID']);
            }
        }

        // Check availability based on project dates
        $this->db->where("NOT EXISTS (
        SELECT 1 FROM projects AS p
        INNER JOIN projectequipmentlink AS pel ON pel.equipmentID = e.equipmentID
        WHERE pel.ProjectID = p.ProjectID
        AND (
            (p.pStartDate <= '$endDate' AND p.pEndDate >= '$startDate') OR
            (p.pStartDate >= '$startDate' AND p.pStartDate <= '$endDate')
        )
    )");

        // Check quantity availability
        if ($qtyAvailability) {
            $this->db->where('(e.equipTotalQuantity - e.equipInUseQuantity) >', 0); // Ensure available quantity is greater than 0
        }

        // Ensure equipment with total quantity greater than in-use quantity is also loaded
        $this->db->where('e.equipTotalQuantity > e.equipInUseQuantity');

        $this->db->order_by('e.equipmentID', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }
    public function GetDataWithDateRange($table, $where, $orderByColumn, $orderDirection, $startDate, $endDate)
    {
        $this->db->select('*');
        $this->db->from($table);

        // Apply filters
        if ($where) {
            $this->db->where($where);
        }

        // Check availability based on project dates
        $this->db->where("NOT EXISTS (
        SELECT 1 FROM projects AS p
        INNER JOIN projectworkforcelink AS pwl ON pwl.ProjectID = p.ProjectID
        WHERE pwl.workforceID = {$table}.workforceID
        AND (
            (p.pStartDate <= '$endDate' AND p.pEndDate >= '$startDate') OR
            (p.pStartDate >= '$startDate' AND p.pStartDate <= '$endDate')
        )
    )");

        // Order by
        $this->db->order_by($orderByColumn, $orderDirection);

        $query = $this->db->get();
        // die($this->db->last_query());
        return $query->result_array();
    }
    public function GetAllAssignedEquipment($where = false)
    {
        $this->db->select('*');
        $this->db->from('projectequipmentlink as pel');
        $this->db->join('projects as p', 'p.ProjectID = pel.ProjectID', 'inner');
        $this->db->where('p.pStatus!=', 1);
        $this->db->where('p.pStatus!=', 4);
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }




    //super admin panel 
    public function GetWebCategoryData($where = false)
    {
        $this->db->select('*');
        $this->db->from('web_cat as wc');
        $this->db->join('web_pages as p', 'wc.pageID=p.pageID', 'inner');
        $this->db->join('web_page_meta as pm', 'p.pageID=pm.pageID', 'inner');
        $this->db->order_by('wc.web_catID', 'DESC');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    public function GetBlogCatData($where = false)
    {
        $this->db->select('*');
        $this->db->from('web_blog_cat as bc');
        $this->db->join('web_pages as p', 'bc.pageID=p.pageID', 'inner');
        $this->db->join('web_page_meta as pm', 'p.pageID=pm.pageID', 'inner');
        $this->db->order_by('bc.blogCatID', 'DESC');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    public function GetBlogData($where = false)
    {
        $this->db->select('*');
        $this->db->from('web_blogs as wb');
        $this->db->join('web_blog_cat as wbc', 'wbc.blogCatID=wb.blogCatID', 'inner');
        $this->db->join('web_pages as p', 'wb.pageID=p.pageID', 'inner');
        $this->db->join('web_page_meta as pm', 'p.pageID=pm.pageID', 'inner');
        $this->db->order_by('wb.web_blogID', 'DESC');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    //support module 
    public function GetTicketsWithCat($where = false)
    {
        $this->db->select('*');
        $this->db->from('supporttickets as t');
        $this->db->join('supportticketscat as tc', 't.supportTicketsCatID=tc.supportTicketsCatID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    public function GetTicketsWithUsers($where = false)
    {
        $this->db->select('*');
        $this->db->from('supporttickets as t');
        $this->db->join('users as u', 'u.userID=t.userID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }


    //website modales
    public function GetPageData($where = false)
    {
        $this->db->select('*');
        $this->db->from('web_pages as p');
        $this->db->join('web_page_meta as pm', 'p.pageID=pm.pageID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }


    //listing module 
    public function GetMarketPlaceListingData($where = false)
    {
        // 1️⃣ Equipment items (itemType = 1)
        $equipmentItems = $this->db
            ->select('*')
            ->from('shopitem si')
            ->join('shopequipments se', 'si.itemID = se.itemID','inner')
            ->join('equipment e', 'e.equipmentID = se.equipmentID ','inner')
            ->where('si.itemType', 1)
            ->where($where)
            ->get()
            ->result_array();

        // 2️⃣ Workforce items (itemType = 2)
        $workforceItems = $this->db
            ->select('*')
            ->from('shopitem si')
            ->join('shopworkforce sw', 'si.itemID = sw.itemID','inner')
            ->join('workforce w', 'w.workforceID= sw.workforceID ','inner')
            ->where('si.itemType', 2)
            ->where($where)
            ->get()
            ->result_array();

        // 3️⃣ Merge both results
        return array_merge($equipmentItems, $workforceItems);
    }














    function GetProductList($where = false)
    {
        $this->db->select('*');
        $this->db->from('products as p');
        $this->db->join('users  as u', 'p.userID=u.userID', 'inner');
        $this->db->join('productcategory  as pc', 'p.catID=pc.catID', 'inner');
        $this->db->order_by('p.productID', 'DESC');
        if ($where) {
            $this->db->where($where);
        }
        $q = $this->db->get();
        //    die($this->db->last_query());
        if ($q->num_rows() > 0) {
            return $q->result_array();
        } else {
            return false;
        }
    }
    public function GetUnassignedProducts($customerID)
    {
        $this->db->select('p.*, v.*, pc.*');
        $this->db->from('products p');
        $this->db->join('productcategory pc', 'p.catID = pc.catID', 'inner');
        $this->db->join('users v', 'p.userID = v.userID', 'inner');
        $this->db->join('assignProduct ap', 'p.productID = ap.productID AND ap.customerID = ' . $customerID, 'left');
        $this->db->where('p.productStatus', 1); // Only active products
        $this->db->where('ap.productID IS NULL'); // Exclude products assigned to the specified customer
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetAssignedProducts($customerID)
    {
        $this->db->select('p.*, v.*, pc.*,ap.newPrice');
        $this->db->from('products p');
        $this->db->join('productcategory pc', 'p.catID = pc.catID', 'inner');
        $this->db->join('users v', 'p.userID = v.userID', 'inner');
        $this->db->join('assignProduct ap', 'p.productID = ap.productID', 'inner');
        $this->db->where('ap.customerID', $customerID); // Filter by customerID
        $this->db->where('p.productStatus', 1); // Only active products
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetProductsByCart($where = false)
    {
        $this->db->select('*');
        $this->db->from('cart c');
        $this->db->join('products p', 'p.productID = c.productID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetOrderListByCusotmer($where = false)
    {
        $this->db->select('*');
        $this->db->from('checkout c');
        $this->db->join('users u', 'c.customerID = u.userID', 'inner');
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();

        return $query->result_array(); // Return results as an array
    }
    public function GetDistVendorInCart($checkoutID)
    {
        $this->db->distinct();
        $this->db->select('vendorID');
        $this->db->from('cart');
        $this->db->where('checkoutID', $checkoutID);
        $query = $this->db->get();
        // die($this->db->last_query());
        return $query->result_array(); // Get results as an array
    }
}
