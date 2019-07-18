<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package         Users_model
 * @subpackage      Model
 * @author          Nur Rachmat <rachmat.nur91@gmail.com>
 * @version         0.1
 * @copyright       Copyright © 2017 Nur Rachmat <rachmat.nur91@gmail.com>
 */

class Query_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_data_query($query, $qbind){
        return $this->db->query($query, $qbind)->result_array();
    }

    function get_data_query($query, $qbind){
        $data =  $this->db->query($query, $qbind)->row_array();
        return $data;
    }

    function get_data_where($table = null, $where = array(), $fields = '*')
    {
        $this->db->select($fields);
        return $this->db->get_where($table, $where)->row_array();
    }

    function get_all_data_where($table = null, $where = array(), $fields = '*', $params= array())
    {
        if(isset($params) && !empty($params))
        {
            $this->db->limit($params['limit'], $params['offset']);
        }
        return $this->db->get_where($table, $where)->result_array();
    }

    function add_data($table=null, $params= array()){
        $this->db->insert($table, $params);
        return $this->db->insert_id();
    }

    function update_data($table=null, $params= array(), $where= array()){
        return $this->db->update($table, $params, $where);
        // return $this->db->insert_id();
    }

}
