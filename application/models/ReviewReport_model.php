<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReviewReport_model extends CI_Model
{
    public function create(array $data)
    {
        return $this->db->insert('review_reports', $data);
    }
}
