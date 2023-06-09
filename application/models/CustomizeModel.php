<?php
class CustomizeModel extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session', 'Dbvars'));
        $this->load->database();
    }

    public function CustomizeColorList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_color p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_color p');
            return (int)$count;
        }
    }

    public function typeofjarList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_typeofjar p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_typeofjar p');
            return (int)$count;
        }
    }

    public function typeofhandleList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_typeofhandle p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_typeofhandle p');
            return (int)$count;
        }
    }


    public function capacityList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.sortby', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_capacity p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_capacity p');
            return (int)$count;
        }
    }

    public function typeoflidList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_typeoflid p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_typeoflid p');
            return (int)$count;
        }
    }


    public function customizemotorList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_motors p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_motors p');
            return (int)$count;
        }
    }


    public function customizebaseList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_basemodel p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_basemodel p');
            return (int)$count;
        }
    }


    public function customizejarList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {
        //echo "hhh"; die();

        $this->db->select('p.*,c.name as category_name,l.typeoflidname,t.typeofjarname,h.typeofhandlename');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');
        $this->db->join('vidiem_typeofhandle  h', 'h.typeofhandle_id=p.typeofhandle_id');
        $this->db->join('vidiem_typeofjar  t', 't.typeofjar_id=p.typeofjar_id');
        $this->db->join('vidiem_typeoflid  l', 'l.typeoflid_id=p.typeoflid_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_jar p ', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_jar p ');
            return (int)$count;
        }
    }


    public function customizepackageList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*,c.name as category_name');
        $this->db->join('vidiem_category  c', 'c.id=p.category_id');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_packages p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_packages p');
            return (int)$count;
        }
    }

    public function combinebasecolorList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('p.*');
        $this->db->join('vidiem_basemodel  b', 'b.base_id=p.base_id and  b.isactive=1 ');
        $this->db->join('vidiem_color  c', 'c.color_id=p.color_id and  c.isactive=1 ');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_basemodel_color p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_basemodel_color p');
            return (int)$count;
        }
    }


    public function combinebasemotorList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {
        $this->db->select('p.*,c.motorname,c.code as motorcode,c.description,c.price as motorprice, b.base_id as motor_base_id');
        $this->db->join('vidiem_basemodel  b', 'b.base_id=p.base_id and  b.isactive=1 ');
        $this->db->join('vidiem_motors  c', 'c.motor_id=p.motor_id and  c.isactive=1 ');
        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_basemodel_motor p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            //  print_r($this->db->last_query());
            //	die();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_basemodel_motor p');
            return (int)$count;
        }
    }


    public function combinebasejarList($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('c.*');
        $this->db->join('vidiem_basemodel_color  b', 'b.bm_color_id=p.base_id and  b.isactive=1 ');
        $this->db->join('vidiem_jar  c', ' find_in_set(c.jar_id,p.default_jar_ids) and  c.isactive=1 ');

        $this->db->join('vidiem_typeofjar  tj', ' tj.typeofjar_id=c.typeofjar_id  and  tj.isactive=1 ');
        $this->db->join('vidiem_typeofhandle  th', ' th.typeofhandle_id=c.typeofhandle_id and  th.isactive=1 ');
        $this->db->join('vidiem_typeoflid  tl', ' tl.typeoflid_id=c.typeoflid_id and  tl.isactive=1 ');
        $this->db->join('vidiem_capacity  cc', ' cc.capacity_id=c.capacity_id and  cc.isactive=1 ');

        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_basemodel_jar p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_basemodel_jar p');
            return (int)$count;
        }
    }


    public function combinebasejarexclude($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('c.*');
        $this->db->join('vidiem_basemodel_color  b', 'b.bm_color_id=p.base_id and  b.isactive=1 ');
        $this->db->join('vidiem_jar  c', '   c.isactive=1    ');

        $this->db->join('vidiem_typeofjar  tj', ' tj.typeofjar_id=c.typeofjar_id  and  tj.isactive=1 ');
        $this->db->join('vidiem_typeofhandle  th', ' th.typeofhandle_id=c.typeofhandle_id and  th.isactive=1 ');
        $this->db->join('vidiem_typeoflid  tl', ' tl.typeoflid_id=c.typeoflid_id and  tl.isactive=1 ');
        $this->db->join('vidiem_capacity  cc', ' cc.capacity_id=c.capacity_id and  cc.isactive=1 ');

        $this->db->where(" not find_in_set(c.jar_id,p.exclude_jar_id) ");
        //	$this->db->where(" not find_in_set(c.jar_id,p.default_jar_ids) ");
        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_basemodel_jar p', array(), $this->input->post('length'), (int)$this->input->post('start'))->result_array();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_basemodel_jar p');
            return (int)$count;
        }
    }


    public function combinebasejarexcludeids($list = 'list', $where = array(), $custom = null, $search = [], $order = false)
    {

        $this->db->select('group_concat(c.jar_id) as jar_id');
        $this->db->join('vidiem_basemodel_color  b', 'b.bm_color_id=p.base_id and  b.isactive=1 ');
        $this->db->join('vidiem_jar  c', '   c.isactive=1    ');

        $this->db->join('vidiem_typeofjar  tj', ' tj.typeofjar_id=c.typeofjar_id  and  tj.isactive=1 ');
        $this->db->join('vidiem_typeofhandle  th', ' th.typeofhandle_id=c.typeofhandle_id and  th.isactive=1 ');
        $this->db->join('vidiem_typeoflid  tl', ' tl.typeoflid_id=c.typeoflid_id and  tl.isactive=1 ');
        $this->db->join('vidiem_capacity  cc', ' cc.capacity_id=c.capacity_id and  cc.isactive=1 ');
        $this->db->where(" not find_in_set(c.jar_id,p.exclude_jar_id) ");
        $this->db->where(" not find_in_set(c.jar_id,p.default_jar_ids) ");
        $this->db->where($where);
        if (!empty($search)) {

            $searchqry = " (  ";
            foreach ($search as $filed => $value) {
                $searchqry .= $filed . " like '%" . $value . "%' or ";
            }

            $searchqry = rtrim($searchqry, "or ");
            $searchqry .= " ) ";

            $this->db->where($searchqry);
        }
        if ($order) {
            $this->db->order_by($order['field'], $order['type']);
        } else {
            $this->db->order_by('p.createddate', 'desc');
        }

        if ($list == 'list') {
            $dataarr = $this->db->get_where(' vidiem_basemodel_jar p', array())->row();
            return  $dataarr;
        } else {
            $count = $this->db->count_all_results(' vidiem_basemodel_jar p');
            return (int)$count;
        }
    }

    public function GetJarById($id)
    {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->join('vidiem_basemodel_color  b', 'b.bm_color_id=p.base_id and  b.isactive=1 ');
        $this->db->join('vidiem_jar  c', '   c.isactive=1    ');

        $this->db->join('vidiem_typeofjar  tj', ' tj.typeofjar_id=c.typeofjar_id  and  tj.isactive=1 ');
        $this->db->join('vidiem_typeofhandle  th', ' th.typeofhandle_id=c.typeofhandle_id and  th.isactive=1 ');
        $this->db->join('vidiem_typeoflid  tl', ' tl.typeoflid_id=c.typeoflid_id and  tl.isactive=1 ');
        $this->db->join('vidiem_capacity  cc', ' cc.capacity_id=c.capacity_id and  cc.isactive=1 ');
        $this->db->where('c.jar_id', $id);
        return $this->db->get('vidiem_basemodel_jar p')->row();
        // return  $this->db->select('p.*,group_concat(mj.motor_id) as mot_jar_id')
        //             ->join('vidiem_motors_jars mj','mj.jar_id=p.jar_id and mj.isactive=1 ','left')
        //             ->where('p.jar_id',$id)
        //             ->get('vidiem_jar p')
        //             ->row();

    }


    public function getColorById($id)
    {
        return $this->db->select('*')
            ->where('color_id', $id)
            ->get('vidiem_color')
            ->row();
    }

    public function getDataArrById($id, $table_name, $field_name)
    {
        return  $this->db->select('*')
            ->where($field_name, $id)
            ->get($table_name)
            ->row();
        // print_r($this->db->last_query());
        //die();

    }
    public function checkProductMapping($id, $table_name, $field_name)
    {
        
      return $this->db->select('*')
            ->where($field_name, $id)
            ->where('isactive', 1)
            ->get($table_name)
            ->row();
            
            
    }

    public function getDataActiveById($id, $table_name, $field_name, $is_null_dealer_id = '')
    {

        $this->db->select('*')
            ->where($field_name, $id)
            ->where("IsActive", "1");
        if (!empty($is_null_dealer_id)) {
            $this->db->where('dealer_id IS NULL', null, true);
        }

        $details = $this->db->get($table_name)
            ->row();

        return $details;
    }

    public function getDataArrMultCond($table_name, $wherecond)
    {
        return  $this->db->select('*')
            ->where($wherecond)
            ->get($table_name)
            ->row();
        // print_r($this->db->last_query());
        //die();

    }

    public function getJarCountByCardId($cardId)
    {
        return $this->db
            ->where(["cart_id" => $cardId, "IsActive" => 1])
            ->get('vidiem_cart_jar')
            ->result();
    }

    public function getCartJarCount($cart_id)
    {

        $this->db->select(" count(*) as cnt, sum(qty) as qty ");
        $this->db->join('vidiem_cart_jar  cj', ' cj.cart_id=c.cart_id and cj.Isactive=1 ');
        $this->db->join('vidiem_jar j', ' j.jar_id=cj.jar_id and j.isactive=1 ');

        $this->db->where(" c.IsActive=1 ");
        $this->db->where(" c.cart_id= " . $cart_id);
        $jarcount = $this->db->get_where(' vidiem_carts c ')->result_array();

        return $jarcount[0]['qty'];
    }

    public function checkCartHas75L($cart_id)
    {

        $this->db->join('vidiem_cart_jar  cj', ' cj.cart_id=c.cart_id and cj.Isactive=1 ');
        $this->db->join('vidiem_jar j', ' j.jar_id=cj.jar_id and j.isactive=1 ');
        $this->db->join('vidiem_capacity cpt', 'cpt.capacity_id = j.capacity_id');
        $this->db->where(" c.IsActive=1 ");
        $this->db->where(" c.cart_id= " . $cart_id);
        $this->db->where('capacityname',  '1.75L');
        return $this->db->from('vidiem_carts c')->count_all_results();
    }

    public function checkCartHas75Lfixed($cart_id)
    {

        $this->db->join('vidiem_cart_jar  cj', ' cj.cart_id=c.cart_id and cj.Isactive=1 ');
        $this->db->join('vidiem_jar j', ' j.jar_id=cj.jar_id and j.isactive=1 ');
        $this->db->join('vidiem_capacity cpt', 'cpt.capacity_id = j.capacity_id');
        $this->db->where(" c.IsActive=1 ");
        $this->db->where(" c.cart_id= " . $cart_id);
        $this->db->where('capacityname >=',  '1.75L');
        return $this->db->from('vidiem_carts c')->count_all_results();
    }
    
    public function CustomOrderCode()
    {
        $code = $this->FunctionModel->Select_Field('code', 'vidiem_customorder', array(), 'id', 'DESC', 1);
        if (empty($code)) {
            return '550001';
        } else {
            ++$code;
            return str_pad($code, '4', '0', STR_PAD_LEFT);
        }
    }

    public function CustomInvoiceCode()
    {

        $code   = $this->FunctionModel->Select_Field('inv_code', 'vidiem_customorder', array(), 'inv_code', 'DESC', 1);

        if (empty($code)) {
            return '550001';
        } else {
            ++$code;
            return str_pad($code, '4', '0', STR_PAD_LEFT);
        }
    }
     public function UploadAdminInvoiceNotification($order_id)
    {
           
           $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

        $mail_content = '';


        $order_info             = $this->FunctionModel->Select_Fields_Row('dealer_user_id,client_id,inv_code,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, dealer_id, pg_type,vidiem_invoice', 'vidiem_customorder', array('id' => $order_id));
          //echo '<pre>';print_r($order_info); die;
  
            if (isset($order_info['dealer_user_id']) && !empty($order_info['dealer_user_id'])) {
            $dealer_info        = $this->FunctionModel->getDealerLocationInfo($order_info['dealer_user_id']);
            
            }
           
             $client_mail_subject                = 'Vidiem By You - Order Reference No :'.$order_info['code'] .'   Vidiem Invoice Generated | '. $dealer_info['display_name'] . '-' . $dealer_info['location_name'] ;
            $mail_content                       .= $mail_header;
            $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                        <h2> Hello '. $dealer_info['display_name'].'<br> We appreciate you joining our team! </h2>,
                                                       
                                                    </div>
                                                    <br><br>
                                                    <div>
                                                    Please see the Vidiem invoice attached. By You place the Order No : '.$order_info['code'] .'  for the item with the Reference No   '.$order_info['order_no'] .' at ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . '.
                                                   
                                                    </div>
                                                    
                                                    ';
            $mail_content                        .= '<p>Regards</p>
                                                    <p>Vidiem Team</p>';

            $mail_content                        .= '</div>';
            
            $attachdata = 'uploads/dealer/orders/'.$order_info['vidiem_invoice'];
            $to_mail=$dealer_info['admin_email'].','.$dealer_info['email'];
          // $to_mail ='orders@vidiem.in, itsupport@mayaappliances.com,saravanan.p@mayaappliances.com';
            $cc_mail='orders@vidiem.in,itsupport@mayaappliances.com,saravanan.p@mayaappliances.com,saranmini.85@gmail.com,prodmgsrk@mayaappliances.com,john@pixel-studios.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,itsupport@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
           
        
         
                  $this->FunctionModel->send_dealer_attach_mail($to_mail,$cc_mail, $mail_content, $client_mail_subject,  'orders@vidiem.in',$attachdata);
            
              

    } 
    public function UploadDealerRecipetNotification($order_id)
    {
           
           $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

        $mail_content = '';


        $order_info             = $this->FunctionModel->Select_Fields_Row('dealer_user_id,client_id,inv_code,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, dealer_id, pg_type,dealer_invoice,receipt_file', 'vidiem_customorder', array('id' => $order_id));
          //echo '<pre>';print_r($order_info); die;
  
            if (isset($order_info['dealer_user_id']) && !empty($order_info['dealer_user_id'])) {
            $dealer_info        = $this->FunctionModel->getDealerLocationInfo($order_info['dealer_user_id']);
            
            }
     
           
             $client_mail_subject                = 'Vidiem By You - Order Reference No:'.$order_info['order_no'] .'   Confirmed | '. $dealer_info['display_name'] . '-' . $dealer_info['location_name'] ;
            $mail_content                       .= $mail_header;
            
            $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                    <h2> Hi ' . $order_info['billing_name'] . '</h2>,
                                                    <h2> Thanks for choosing to shop with us! </h2>
                                                </div>
                                                <br><br>
                                                <div>
                                                We’re happy to confirm your order on ' . date('d/m/Y') . ' Your order number is ' . $order_info['order_no'] . ' at ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . ' . As you can see, we’re getting it ready under strict supervision. We’ll send you a shipping confirmation soon! Stay tuned!
                                                </div>
                                                <div style="text-align:center">Happy Cooking, Love Team Vidiem </div>
                                                <br><br>
                                                <p>Regards</p>
                                                <p>Vidiem Team</p>
                                                </div>
                                                    
                                                    ';
            $mail_content                        .= '<p>Regards</p>
                                                    <p>Sincerely,</p>
                                                    <p>Team ' . $dealer_info['display_name'] . '</p>';

            $mail_content                        .= '</div>';
            
            $attachdata = 'uploads/dealer/orders/'.$order_info['receipt_file'];
          
            $cc_mail=$dealer_info['admin_email'].','.$dealer_info['email'];
            //$to_mail ='orders@vidiem.in, itsupport@mayaappliances.com,saravanan.p@mayaappliances.com';
            //$to_mail='orders@vidiem.in, itsupport@mayaappliances.com,saravanan.p@mayaappliances.com,saranmini.85@gmail.com,prodmgsrk@mayaappliances.com,john@pixel-studios.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,ramakrishnan.n@mayaappliances.com,itsupport@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,rnd@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
           $to_mail ='saravanan.p@mayaappliances.com,'.$order_info['billing_emailid'];
        
         
                  $this->FunctionModel->send_dealer_attach_mail($to_mail,$cc_mail, $mail_content, $client_mail_subject,  'orders@vidiem.in',$attachdata);
            
              

    }
    public function ARDSuDealerInvoice($order_id,$commission_id)
    {
        //ARD Service Bill Mail Start
        //$to_mail='naveenkumar.pixel@gmail.com';

        $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';
        $mail_content = '';
        $order_info                 = $this->FunctionModel->Select_Fields_Row('dealer_user_id,client_id,inv_code,created,dealer_location_id,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, billing_city,billing_zip,billing_state,dealer_id, pg_type,code', 'vidiem_customorder', array('id' => $order_id));
        $dealer_info                = $this->FunctionModel->getARDLocationInfo($order_info['dealer_user_id']);
        $ard_info                   = $this->FunctionModel->getARDInfo($order_info['dealer_user_id']);
        $sub_dealer_info            = $this->FunctionModel->Select_Row('vidiem_dealer_locations', array('id' => $order_info['dealer_location_id']));
        $ard_commission_details     = $this->FunctionModel->getARDCommissionDetails($commission_id);
        $ard_gst=$ard_commission_details['sub_dealer_gst']/2;
        $amount_words     = $this->FunctionModel->AmountInWords($ard_commission_details['sub_dealer_service_bill']);
        $amount_words = str_replace(array("\r", "\n"), '', $amount_words);
        $amount_words = preg_replace('/\s+/', ' ', $amount_words);      
        
        $mail_content               .= $mail_header;
        $mail_content               .= $mail_header;
        $mail_content               .= '    <div style="width:100%;text-align:center;">
                                                <h2>     Greetings, Vidiem. We appreciate your partnership.</h2>,
                                                <h2> You may access the ARD Service Bill here. Vidiem By You order for the order no ' . $order_info['code'].'  against the receipt. </h2>
                                            </div>';
        $mail_content               .= '<p>Regards</p>
                                                    <p>Vidiem Team</p>
                                                    <p>' . $dealer_info['display_name'] . ' - ' . $dealer_info['location_name'] . '</p>';
        $mail_content               .= '</div>';
        $current_date=date('Y-m-d H:i:s');
          $mail_content               .= '
       
        <div style="border:1px solid black;">
        <div class="container inCon">
             <div style="float:left;"><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></div>
             <div style="float:left;"><ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                     <li style="font-size:12px; text-transform:uppercase;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road, Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA. 
                    |   <span style="list-style:none;line-height:28px; display:inline-block;">Phone</span> : &nbsp; 044-6635 6635 / 77110 06635  | Website</span> : &nbsp; http://vidiem.in/
                      | GST NO</span> : &nbsp; 33AAACM6280D1ZT </li>
                 </ul></div><br>
            
            
        
              <div style="width:100%;"><h2 style="color:#000000;" style="text-align:center;">Sub Dealer to ARD(Proforma Invoice)</h2>  </div> ';
     
             $mail_content               .= '
                   
             <div class="form" style="width:100%;"> ';
     
              $mail_content               .= '<table class="" style="width: 4.8e+2pt;margin-left:5.4pt;border-collapse:collapse;">
             <tbody>
                 <tr>
                     <td rowspan="2" style="width: 7cm;border: 1pt solid black;padding: 0cm 5.4pt;height: 46.5pt;vertical-align: top;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">From.</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">' . $sub_dealer_info['location_name'] . '</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">' . $sub_dealer_info['location_address'] . '</p>
                 
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">GSTIN : ' . $sub_dealer_info['sub_dealer_cin_no'] . '</p>
                     </td>
                     
                     <td rowspan="2" style="width: 7cm;border: 1pt solid black;padding: 0cm 5.4pt;height: 46.5pt;vertical-align: top;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">To.</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">' . $ard_info['display_name'] . '</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">' . $ard_info['address'] . '</p>
                 
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">GSTIN : ' .$ard_info['gstin_no'] . '</p>
                     </td>
                     
                     <td colspan="2" style="width: 278.05pt;border: 1pt solid black;padding: 0cm 5.4pt;height: 46.5pt;vertical-align: top;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Order No. : <strong>' . $order_info['code'].'</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Order Date &nbsp; &nbsp; &nbsp; &nbsp; : '. $order_info['created'].' </p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Under Reverse Charge:&nbsp;<s>Yes</s> / No</p>
                     </td>
                 </tr>
                 <tr>
                     <td colspan="2" style="width: 278.05pt;border: 1pt solid black;padding: 0cm 5.4pt;vertical-align: top;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Income Tax PAN No.: ' . $sub_dealer_info['sub_dealer_pan_no'] . '</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">GSTIN &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; :  ' . $sub_dealer_info['sub_dealer_gst_no'] . '</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">CIN. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : ' . $sub_dealer_info['sub_dealer_cin_no'] . '  </p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">HSN/SAC Code &nbsp; &nbsp; &nbsp; &nbsp; : 996211</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Type of Service &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: Referral Commission on Sales</p>
                     </td>
                 </tr>
                 <tr>
                     <td colspan="2" style="width:342.75pt;border:1pt solid black;padding:0cm 5.4pt 0cm 5.4pt;height:20.25pt;">
                         <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:center;text-indent:-36.0pt;font-size:17px;margin-left:36.0pt;"><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style="font-size:16px;">Particulars</span></h3>
                     </td>
                     <td style="width:133.75pt;border:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:20.25pt;" >
                         <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:center;text-indent:0cm;font-size:17px;"><span style="font-size:16px;">Amount</span></h3>
                     </td>
                 </tr>
                 <tr>
                     <td colspan="2" rowspan="2" style="width: 342.75pt;border: 1pt solid black;padding: 0cm 5.4pt;height: 110.8pt;vertical-align: top;">
                        
                         
                        <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:54.0pt;">&nbsp;</p>
                                 <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:54.0pt;">&nbsp;</p>
                   
                         
                         
                         
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:54.0pt;">Referral Commission&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;margin-left:36.0pt;">&nbsp; &nbsp; &nbsp;&nbsp;</p>
                      
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;' . $order_info['billing_name'].',&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . $order_info['billing_city'].',</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . $order_info['billing_state'].',</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ' . $order_info['billing_zip'].'.</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>
                           <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Order No: <strong>' . $order_info['code'].'</strong> |  Order Amount: <strong>' . $order_info['amount'].'</strong> </p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; TOTAL</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp;</span></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CGST @ 9%</span></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;SGST @ 9%</span></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;color:black;"><span style="font-size:17px;">&nbsp;</span></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">&nbsp;</p>
                         <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:center;text-indent:-36.0pt;font-size:17px;margin-left:36.0pt;"><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style="font-size:16px;">GRAND TOTAL</span></h3>
                         <h3 style="margin:0cm;margin-bottom:.0001pt;text-align:left;text-indent:-36.0pt;font-size:17px;margin-left:36.0pt;"><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span><span style="font-size:16px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span></h3>
                     </td>
                     <td style="width: 133.75pt;border: 1pt solid black;padding: 0cm 5.4pt;height: 110.8pt;vertical-align: top;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>-
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">'.number_format($ard_commission_details['sub_dealer_commission'],2).'</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;">&nbsp;</p>
                     </td>
                 </tr>
                 <tr style="border-right:solid black 1.0pt !important;">
                     <td style="width:133.75pt;border:solid black 1.0pt;border-right:solid black 1.0pt !important;border-bottom:solid black 1.0pt !important;padding:0cm 5.4pt 0cm 5.4pt;height:125.45pt;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;"><strong>&nbsp;</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.number_format($ard_commission_details['sub_dealer_commission'],2).'</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.number_format($ard_gst,2).'</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.number_format($ard_gst,2).'</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>&nbsp;</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>---------------------------</strong></p>
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;text-align:right;"><strong>'.round($ard_commission_details['sub_dealer_service_bill']).'</strong></p>
                     </td>
                 </tr>
                 <tr>
                     <td colspan="3" style="width:476.5pt;border:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:40.0pt;">
                         <p style="margin:0cm;margin-bottom:.0001pt;font-size:16px;">Rupees : '.$amount_words.' Only</p>
                     </td>
                 </tr>
               
             </tbody>
         </table>
         <div style="float:left;">
         <p>E. & O.E</p>
         </div>
         <div style="float:right;">
         <p>For</p><br><br><br>
            <p style="margin-left:50%;"><strong>Authorised Signatory<strong></p>
         </div>
         </div></div></div>';    
        // print_r($invoice); die;
             $this->load->library('m_pdf');
             $pdfObject = '';
             $pdfObject = $this->m_pdf;
             $pdfObject->pdf->AddPage(
                 'P', // L - landscape, P - portrait
                 '',
                 '',
                 '',
                 '',
                 7, // margin_left
                 3, // margin right
                 5, // margin top
                 5, // margin bottom
                 5, // margin header
                 5
             ); // margin footer
             //generate the PDF from the given html
           
             $file_name = 'uploads/dealer/orders/invoice_ard/vidiem_ard_Invoice.pdf';
             $pdfObject->pdf->WriteHTML($invoice);
             $attachdata = $pdfObject->pdf->Output($file_name, 'S');
               $attachdata1='';
            
             $cc_mail='naveenkumar.pixel@gmail.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,itsupport@mayaappliances.com,saravanan.p@mayaappliances.com,satheyaraaj.t@mayaappliances.com,umashankar.k@mayaappliances.com,taxation@mayaappliances.com,receivables@mayaappliances.com';
            $to_mail=$dealer_info['email']; 
            //$cc_mail='';
             $client_mail_subject='VBY - Dealer To ARD Service Bill | Order No :'.$order_info['code'];
             $this->FunctionModel->send_office_dealer_ard($to_mail,$cc_mail, $mail_content, $client_mail_subject,  'orders@vidiem.in',$attachdata1);
            //  $pdfObject_admin->pdf->WriteHTML(false);
        //ARD Service Bill Mail End
        //VBY - Dealer To ARD Service Bill | Order No : <order no>
        
        
        
        
        
        
        
        
        //////////////////

       
    }


    public function ARDAdminInvoice($order_id,$commission_id)
    {

       
    }

     public function CustomerInvoiceDealer($order_id,$order_pass_type)
    {
        $order_info             = $this->FunctionModel->Select_Fields_Row('dealer_user_id,billing_address2,delivery_address2,client_id,inv_code,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, dealer_id, pg_type,receipt_file,vidiem_invoice,dealer_invoice', 'vidiem_customorder', array('id' => $order_id));
        $admin_to_mail_list='john@pixel-studios.com,prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
        $admin_mail_ids='orders@vidiem.in,itsupport@mayaappliances.com,saravanan.p@mayaappliances.com';
       //$admin_mail_ids='';
        $dealer_info        = $this->FunctionModel->getDealerLocationInfo($order_info['dealer_user_id']);
        $clt_info               = $this->FunctionModel->Select_Fields_Row('mobile_no,email', 'vidiem_clients', array('id' => $order_info['client_id']));
        $clt_info['mobile_no'] = $order_info['billing_mobile_no'];
        $clt_info['email']  = $order_info['billing_emailid'];
        
       /****** Showing interest Mail and SMS Content Start *******/
        if($order_pass_type=='Showing interest')
        {
            $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

            $mail_content = '';
            
            
            /******* Showing Interest Mail Content Start ********/
            $client_mail_subject                = 'Vidiem By You - Showing Interest Reference No : | ' .$order_info['order_no'].' | '. $dealer_info['display_name'] . ' - ' . $dealer_info['location_name'] ;
            $mail_content                       .= $mail_header;
            $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                        <h2> Hi ' . $order_info['billing_name'] . '</h2>,
                                                        <h2> Thanks for choosing to shop with us! </h2>
                                                    </div>
                                                    <br><br>
                                                    <div>
                                                    Thanks for showing interest in Vidiem By You ' . $dealer_info['display_name'] . ' - ' . $dealer_info['location_name'] . '.
                                                    </div>
                                                    
                                                    ';
            $mail_content                        .= '<p>Regards</p>
                                                    <p>Vidiem Team</p>';

            $mail_content                        .= '</div>';
            $this->FunctionModel->send_office_mail($dealer_info['email'], $mail_content, $client_mail_subject, InfoMail);
            $this->FunctionModel->send_office_mail($clt_info['email'], $mail_content, $client_mail_subject, InfoMail);
            $this->FunctionModel->send_office_mail($admin_mail_ids, $mail_content, $client_mail_subject, InfoMail);
            
             /******* Showing Interest Mail Content End ********/
            
            /***** SMS Content Customer and Dealer Start ****/
            $sms_content    = 'Thanks for showing interest with our Dealer ' . $dealer_info['display_name'] .' - '.$dealer_info['location_name']. ' on Vidiem By You. To confirm order, please pay online or in bill counter. -VIDIEM';
            $this->ProjectModel->SMSContent($clt_info['mobile_no'], $sms_content);
            $sms_content    = 'Dear Dealer ' . $dealer_info['display_name'] . ' - '.$dealer_info['location_name']. ', Our Customer showing interest on Vidiem By You. To confirm order ' . $order_info['order_no'] . ', please collect the amount in bill counter. -VIDIEM';
            $this->ProjectModel->SMSContent($dealer_info['mobile_no'], $sms_content);
            
            
              /***** SMS Content Customer and Dealer End ****/
        }
        /****** Showing interest Mail and SMS Content End *******/
        
        /****** Amount Paid Dealer Counter *******/
        
        if($order_pass_type=='Counter Pay')
        {
                $order_data         = $this->FunctionModel->Select_Row('vidiem_customorder', array('id' => $order_id));
                $basiciteminfo      = $this->getOrderBasicDetails($order_id);
                $jarinfo            = $this->getOrderJarsDetails($order_id);
                $jar_count          = 0;
        
                $order_no           = $order_data['order_no'] ?? '';
                $client_mail_subject = 'New order – Vidiem by You | ' .$dealer_info['display_name'] .' - '.$dealer_info['location_name'];
                $template2 = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;" >
                <span ><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></span>
                <div style="width:100%;text-align:center" ><h2> Hi ' . ($client['name'] ?? @$order_data['billing_name']) . ', <br>Thanks for choosing to shop with us!</h2></div>
                <hr><div style="text-align:center">We’re happy to confirm your order on ' . date('d/m/Y') . '! Your order number is ' . @$order_data['code'] . ' at ' . $dealer_info['display_name'] . '-' . $dealer_info['location_code'] . ' As you can see, we’re getting it ready under strict supervision. We’ll send you a shipping confirmation soon! Stay tuned!<br></div>
                
                <div style="width:100%;text-align:center">Happy Cooking, Love Team Vidiem </div><hr><br><br> Regards<br>Vidiem Team </div>';

$template = '
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">';

        $template .= "<title>Invocie</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900italic,900,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
<style>
     .inTi li{font-family: arial;list-style: none;padding-top:10px;}
     .fullIn{width:80%;margin: 0 auto;padding:20px 5%;background-color:#f8f8f8; over-flow:hidden; overflow-x:scroll}
     .inCon{ width: 800px;font-family: Roboto, sans-serif; border: solid 2px #00bfff; margin: 0 auto;font-family:arial; box-sizing:border-box; padding: 1% 30px; margin-top:40px; }
</style>
</head>";
        $template .= '<body style="margin:0; padding:0;">
    <div class="fullIn">
    <ul class="inTi">
        <li></li>
    </ul>';

        $template .= '<div >
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></div>
        
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">PROFORMA INVOICE</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px; text-transform:uppercase;">No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp; 33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['billing_name'] . '
                </li>';
        if (!empty($order_data['billing_company_name'])) {
            $template .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['billing_company_name'] . '</li>';
        }
        $template .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['billing_address'] . ' - ' . $order_info['billing_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; ' . @$order_data['billing_city'] . '-' . $order_data['billing_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['billing_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['billing_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['billing_mobile_no'] . '
                </li>
            </ul>
        </div>
        <div class="logo" style="float:left; width:35%; "></div>
         <div class="contact" style="float:right; width:30%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">DATE</span> :&nbsp;
                &nbsp;' . date("d-M-Y", strtotime(@$order_data['created'])) . '</li>
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">PROFORMA INVOICE</span> :&nbsp;
                &nbsp;' . @$order_data['inv_code'] . '</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['delivery_name'] . '
                </li>';
        if (!empty($order_data['delivery_company_name'])) {
            $template .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['delivery_company_name'] . '</li>';
        }
        $template .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['delivery_address'] . ' - ' . $order_info['delivery_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; ' . @$order_data['delivery_city'] . '-' . $order_data['delivery_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['delivery_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['delivery_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['delivery_mobile_no'] . '
                </li>
            </ul>';

        $template .= '</div>
        </div>        
        <div class="form" style="width:100%;"> ';
        $invoice .= ' <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
					<td style="width:15%">
						<img src="' . base_url('uploads/customizeimg/' . $basiciteminfo['basecolorpath']) . '" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
										<td style="border-bottom:1px solid #CCC;"><strong>' . $basiciteminfo['cart_code'] . '</strong></td>
									</tr>
									<tr>
										<td>Body Design</td>
										<td>' . $basiciteminfo['basetitle'] . '</td>
									</tr>
									<tr>
										<td>Color</td>
										<td>' . $basiciteminfo['bc_title'] . '</td>
										<td>' . $basiciteminfo['basecolorprice'] . '</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>' . count($jarinfo) . '</td>
										<td>Price breakup as below</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>' . $basiciteminfo['motorname'] . '</td>
										<td>' . $basiciteminfo['motorprice'] . '</td>
									</tr> ';
        if ($basiciteminfo['canvas_text'] != '') {
            $invoice .= '	<tr>
										<td>Personalised message</td>
										<td>' . $basiciteminfo['canvas_text'] . '</td>
											<td>' . $basiciteminfo['textprice'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['occasion_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Occasion</td>
										<td>' . $basiciteminfo['occasion_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['message_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Box Message</td>
										<td>' . $basiciteminfo['message_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['package_id'] != '' && !empty($basiciteminfo['package_id'])) {
            $invoice .= '		<tr>
										<td>Packaging</td>
										<td>' . $basiciteminfo['packagename'] . '</td>
										<td>' . $basiciteminfo['packageprice'] . '</td>
									</tr> ';
        }
        $invoice .= '			</tbody>
							</table> ';

        if (count($jarinfo) > 0) {
            $invoice .= '	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
            foreach ($jarinfo as $jar) {

                $jar_count += $jar['qty'];
                $invoice .= '<tr>
										<td>
												<img src="' . base_url("uploads/customizeimg/jar/" . $jar['jarimgpath']) . '" alt="" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" >											
										</td>
										<td>' . $jar['jarname'] . '</td>
										<td style="text-align:center;color:#F7000A;">
											' . $jar['qty'] . ' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.' . number_format($jar['price']) . '
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. ' . number_format($jar['qty'] * $jar['price']) . '
										</td>
									</tr> ';
            }
        }

        $invoice .= '	</tbody>
							</table>
							
					</td>
				</tr>
            </table> ';





        $invoice .= '<table style="width:100%; padding:20px 0 40px 0;">
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. ' . number_format($order_data['sub_total'], 2, '.', '') . '</b></th>
                </tr>';
        // $invoice.='<tr>/<td></td>/<td></td>/<td></td>/<th style="text-align:right;">GST18%</th><th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['tax'],2,'.','').'</b></th></tr>';

        $invoice .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;">Rs. ' . number_format($order_data['amount'], 2, '.', '') . '</th>
                </tr>';

        $invoice .= '<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">orders@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    <p style="font-size:14px; margin-left:40px; line-height:25px;">
                Warm Regards<br>
                Vidiem<br>
                044-6635 6635 / 77110 06635<br>
            </p>';

        $invoice = '
   <style>h1 {
    margin-top: -5px;
}</style>
   <div style="border:1px solid black;">
   <div class="container inCon">
      <div style="border:1px solid black;">
   <div class="container inCon">
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="float:left;"><ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:12px; text-transform:uppercase;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road, Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA. 
               |   <span style="list-style:none;line-height:28px; display:inline-block;">Phone</span> : &nbsp; 044-6635 6635 / 77110 06635  | Website</span> : &nbsp; http://vidiem.in/
                 | GST NO</span> : &nbsp; 33AAACM6280D1ZT </li>
            </ul></div>
       
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
         <div style="width:100%;float:right;"><h1 style="color:#000000;">PROFORMA INVOICE</h1> 

              <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;">Order Date:&nbsp; ' . date("d-M-Y", strtotime(@$order_data['created'])) . ' 
                 | Order No. :&nbsp;' . @$order_data['inv_code'] . ' | Order From :  ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . ' </h3> 

<div class="detail" style="float:left; width:50%;">
            
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">Billing Address</h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['billing_name'] . '
                </li>';
        if (!empty($order_data['billing_company_name'])) {
            $invoice .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; ' . @$order_data['billing_company_name'] . '</li>';
        }
        $invoice .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['billing_address'] . '-' . $order_data['billing_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp; ' . @$order_data['billing_city'] . '-' . $order_data['billing_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['billing_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['billing_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['billing_mobile_no'] . '
                </li>
            </ul>
        </div>
         
         <div class="contact" style="float:left; width:49%;">
            

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">Shipping Address</h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['delivery_name'] . '
                </li>';
        if (!empty($order_data['delivery_company_name'])) {
            $invoice .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; ' . @$order_data['delivery_company_name'] . '</li>';
        }
        $invoice .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['delivery_address'] . '-' . $order_data['delivery_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp; ' . @$order_data['delivery_city'] . '-' . $order_data['delivery_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['delivery_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['delivery_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['delivery_mobile_no'] . '
                </li>
            </ul>';

        $invoice .= '</div>
        </div>        
        <div class="form" style="width:100%;"> ';

        $invoice .= ' <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
					<td style="width:15%">
						<img src="' . base_url('uploads/customizeimg/' . $basiciteminfo['basecolorpath']) . '" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
										<td style="border-bottom:1px solid #CCC;"><strong>' . $basiciteminfo['cart_code'] . '</strong></td>
									</tr>
									<tr>
										<td>Body Design</td>
										<td>' . $basiciteminfo['basetitle'] . '</td>
									</tr>
									<tr>
										<td>Color</td>
										<td>' . $basiciteminfo['bc_title'] . '</td>
										<td>' . $basiciteminfo['basecolorprice'] . '</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>' . $jar_count . '</td>
										<td>Price Breakup Below</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>' . $basiciteminfo['motorname'] . '</td>
										<td>' . $basiciteminfo['motorprice'] . '</td>
									</tr> ';
        if ($basiciteminfo['canvas_text'] != '') {
            $invoice .= '	<tr>
										<td> Personalised message </td>
										<td>' . $basiciteminfo['canvas_text'] . '</td>
										<td>' . $basiciteminfo['textprice'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['occasion_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Occasion</td>
										<td>' . $basiciteminfo['occasion_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['message_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Box Message</td>
										<td>' . $basiciteminfo['message_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['package_id'] != '' && !empty($basiciteminfo['package_id'])) {
            $invoice .= '		<tr>
										<td> Packaging </td>
										<td>' . $basiciteminfo['packagename'] . '</td>
                                        <td>' . $basiciteminfo['packageprice'] . '</td>
									</tr> ';
        }
        $invoice .= '			</tbody>
							</table> ';

        if (count($jarinfo) > 0) {
            $invoice .= '	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;">Jar Information</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
            foreach ($jarinfo as $jar) {
                $invoice .= '<tr>
										<td>
												<img src="' . base_url("uploads/customizeimg/jar/" . $jar['jarimgpath']) . '" alt="" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" >
												<br/>
												<span>' . $jar['capacityname'] . '|' . $jar['typeofjarname'] . '|' . $jar['typeofhandlename'] . '|' . $jar['typeoflidname'] . '
											
										</td>
										<td>' . $jar['jarname'] . '</td>
										<td style="text-align:center;color:#F7000A;">
											' . $jar['qty'] . ' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.' . number_format($jar['price']) . '
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. ' . number_format($jar['qty'] * $jar['price']) . '
										</td>
									</tr> ';
            }
        }

        $invoice .= '	</tbody>
							</table>
							
							<table border="0"  cellspacing="5" style="width:600px;border:1px solid #CCC;margin-bottom:10px;padding:10px;font-size:11px;">
					 
							<tr>
                                <td>
                                    <span style="color:#ff0000;font-size:12px;"><strong>Warranty Information</strong>
                                    </span>
                                    <br><br>
							            - 2 Years Warranty on Product <br> 
                                        - 5 Years Warranty on Motor <br> 
                                        <span style="color:#ff0000;font-size:10px;">
                                        <i>(For Domestic Purpose Only)</i>
                                        <br>
                                        Non Returnable / No Cancellation in all vidiem by you orders
                                        </span>
                                </td>
                            </tr>
                        </table>
							
					</td>
				</tr>
            </table>
							
					</td>
				</tr>
            </table> ';





        $invoice .= '<table style="width:100%; padding:20px 0 40px 0;">
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. ' . number_format($order_data['sub_total'], 2, '.', '') . '</b></th>
                </tr>';
        // $invoice.='<tr>/<td></td>/<td></td>/<td></td>/<th style="text-align:right;">GST18%</th><th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['tax'],2,'.','').'</b></th></tr>';

        $invoice .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">Package Price</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. ' . number_format($order_data['packageprice'], 2, '.', '') . '</b></th>
                </tr>';

        $invoice .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;">Rs. ' . number_format($order_data['amount'], 2, '.', '') . '</th>
                </tr>';

        $invoice .= '<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.| If you have any questions about this invoice, please write us to orders@vidiem.in </td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    </div>';



        $this->load->library('m_pdf');
        $this->m_pdf->pdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            7, // margin_left
            3, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5
        ); // margin footer
        //generate the PDF from the given html
        $file_name = 'uploads/invoice/vidiem_billing_Invoice.pdf';
        $this->m_pdf->pdf->WriteHTML($invoice);
        $attachdata = $this->m_pdf->pdf->Output($file_name, 'S');
        
         $attachdata2 = 'uploads/dealer/orders/'.$order_data['receipt_file'];
          $cc_mail=$dealer_info['admin_email'].','.$dealer_info['email'];
        //  $cc_mail=$admin_to_mail_list.','.$cc_mail1;
          $to_mail=$order_info['billing_emailid'];
         $this->FunctionModel->send_office_mail_dealer($to_mail,$cc_mail, $template2, $client_mail_subject, 'orders@vidiem.in', $attachdata,$attachdata2);
        // $this->FunctionModel->send_office_mail_dealer('naveenkumar.pixel@gmail.com', $template2, $client_mail_subject, 'orders@vidiem.in', $attachdata,$attachdata2);
       
        $sms_content    = "Thank you for shopping with Vidiem through our Dealer " . $dealer_info['display_name'] .' - '.$dealer_info['location_name']. ". Your order number " . $order_info['inv_code'] . " is under production. We'll share the tracking details once the shipment is ready. -VIDIEM";
            $this->ProjectModel->SMSContent($clt_info['mobile_no'], $sms_content);
            
            /** dealer sms content */
            $sms_content    = "Dear Dealer" . $dealer_info['display_name'] . ' - '.$dealer_info['location_name']. ", Your Vidiem By You order number " . $order_info['inv_code'] . " is under Production. We'll share the tracking details once the shipment is ready. -VIDIEM";
            $this->ProjectModel->SMSContent($dealer_info['mobile_no'], $sms_content);       
            
        }
         /****** Amount Paid Dealer Counter  *******/
         
         /****** Amount Paid Online  *******/
        
        if($order_pass_type=='Online Pay')
        {
            
        }
         /****** Amount Paid Dealer Online  *******/
         
          if($order_pass_type=='Admin Invoice')
        {
                $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

                $mail_content = '';
                $client_mail_subject                = 'Vidiem By You - Order Reference No :'.$order_info['inv_code'] .'   Vidiem Invoice Generated | '. $dealer_info['display_name'] . '-' . $dealer_info['location_name'] ;
                $mail_content                       .= $mail_header;
                $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                            <h2> Hello '. $dealer_info['display_name'].'<br> We appreciate you joining our team! </h2>,
                                                           
                                                        </div>
                                                        <br><br>
                                                        <div>
                                                        Please see the Vidiem invoice attached. By You place the Order No '.$order_info['inv_code'] .' for the item with the Reference No   '.$order_info['order_no'] .' at ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . '.
                                                       
                                                        </div>
                                                        
                                                        ';
                $mail_content                        .= '<p>Regards</p>
                                                        <p>Vidiem Team</p>';
    
                $mail_content                        .= '</div>';
                
                $attachdata = 'uploads/dealer/orders/'.$order_info['vidiem_invoice'];
                $to_mail=$dealer_info['admin_email'].','.$dealer_info['email'];
                $cc_mail=$admin_mail_ids.',whchennai@mayaappliances.com';
                $this->FunctionModel->send_dealer_attach_mail($to_mail,$cc_mail, $mail_content, $client_mail_subject,  'orders@vidiem.in',$attachdata);
        }
          /****** Admin Invoice End  *******/
          
           /****** Dealer Invoice Start  *******/
        if($order_pass_type=='Dealer Invoice')
        {
                $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

                $mail_content = '';
                $client_mail_subject                = 'Vidiem By You - Order Reference No :'.$order_info['inv_code'] .'   Dealer Invoice Generated | '. $dealer_info['display_name'] . '-' . $dealer_info['location_name'] ;
                $mail_content                       .= $mail_header;
                $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                        <h2> Greetings, Vidiem. <br> We appreciate your partnership. </h2>,
                                                       
                                                    </div>
                                                    <br><br>
                                                    <div>
                                                    You may access the Dealer Invoice here. By You Order No : '.$order_info['inv_code'] .' for the order with the Reference No  '.$order_info['order_no'] .' at the ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . ' against your shared vidiem invoice.
                                                   
                                                    </div>
                                                    
                                                    ';
                $mail_content                        .= '<p>Regards</p>
                                                    <p>Sincerely,</p>
                                                    <p>Team ' . $dealer_info['display_name'] . '</p>';

                $mail_content                        .= '</div>';
                
                
                $attachdata = 'uploads/dealer/orders/'.$order_info['receipt_file'];
               // $cc_mail=$dealer_info['admin_email'].','.$dealer_info['email'].',whchennai@mayaappliances.com';
               $cc_mail=$dealer_info['admin_email'].','.$dealer_info['email'];
                $to_mail=$admin_mail_ids;
                $this->FunctionModel->send_dealer_attach_mail($to_mail,$cc_mail, $mail_content, $client_mail_subject,  'orders@vidiem.in',$attachdata);

        }
         /****** Dealer Invoice End *******/
        
        
    }
    
         public function UploadDealerInvoiceNotification($order_id)
    {
           
           $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

        $mail_content = '';


        $order_info             = $this->FunctionModel->Select_Fields_Row('dealer_user_id,client_id,inv_code,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, dealer_id, pg_type,dealer_invoice', 'vidiem_customorder', array('id' => $order_id));
          //echo '<pre>';print_r($order_info); die;
  
            if (isset($order_info['dealer_user_id']) && !empty($order_info['dealer_user_id'])) {
            $dealer_info        = $this->FunctionModel->getDealerLocationInfo($order_info['dealer_user_id']);
            
            }
           
          
           
             $client_mail_subject                = 'Vidiem By You - Order Reference No :'.$order_info['code'] .'   Dealer Invoice Generated | '. $dealer_info['display_name'] . '-' . $dealer_info['location_name'] ;
            $mail_content                       .= $mail_header;
            $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                        <h2> Greetings, Vidiem. <br> We appreciate your partnership. </h2>,
                                                       
                                                    </div>
                                                    <br><br>
                                                    <div>
                                                    You may access the Dealer Invoice here. By You order for the Order No: '.$order_info['code'] .'   with the Reference No:   '.$order_info['order_no'] .' at the ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . ' against your shared vidiem invoice.
                                                   
                                                    </div>
                                                    
                                                    ';
            $mail_content                        .= '<p>Regards</p>
                                                    <p>Sincerely,</p>
                                                    <p>Team ' . $dealer_info['display_name'] . '</p>';

            $mail_content                        .= '</div>';
            
            $attachdata = 'uploads/dealer/orders/'.$order_info['dealer_invoice'];
          
            $cc_mail=$dealer_info['admin_email'].','.$dealer_info['email'];
            //$to_mail ='orders@vidiem.in, itsupport@mayaappliances.com,saravanan.p@mayaappliances.com';
            $to_mail='orders@vidiem.in, itsupport@mayaappliances.com,saravanan.p@mayaappliances.com,saranmini.85@gmail.com,prodmgsrk@mayaappliances.com,john@pixel-studios.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,itsupport@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';
           
        
         
                  $this->FunctionModel->send_dealer_attach_mail($to_mail,$cc_mail, $mail_content, $client_mail_subject,  'orders@vidiem.in',$attachdata);
            
              

    }




    public function Custom_NewOrderNotification($order_id)
    {

        $admin_to_mail_list='saravanan.p@mayaappliances.com,naveenkumar.pixel@gmail.com,john@pixel-studios.com,prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,itsupport@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com';

        $mail_header = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                        <span>
                            <h1 style="color:#00BFFF;">
                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                            </h1>
                        </span>';

        $mail_content = '';


        $order_info             = $this->FunctionModel->Select_Fields_Row('dealer_user_id,client_id,inv_code,billing_name,amount,billing_emailid,billing_mobile_no, order_no, payment_source, dealer_id, pg_type', 'vidiem_customorder', array('id' => $order_id));
        
        if (isset($order_info['dealer_user_id']) && !empty($order_info['dealer_user_id'])) {
            $dealer_info        = $this->FunctionModel->getDealerLocationInfo($order_info['dealer_user_id']);
        }

        $clt_info               = $this->FunctionModel->Select_Fields_Row('mobile_no,email', 'vidiem_clients', array('id' => $order_info['client_id']));

        if ($clt_info['mobile_no'] == '')
            $clt_info['mobile_no'] = $order_info['billing_mobile_no'];

        if ($clt_info['email'] == '')
            $clt_info['email']  = $order_info['billing_emailid'];

        $sms_content            = 'Your Customize Order on vidiem Invoice Code ' . $order_info['inv_code'] . ' successfully Completed. Thanks for choosing vidiem';
        $this->ProjectModel->SMS($clt_info['mobile_no'], $sms_content);

        $sms_content            = 'New Order On Vidiem Invoice Code ' . $order_info['inv_code'] . '. Invoice Amount' . $order_info['amount'];
        $this->ProjectModel->SMS(AdminMobile, $sms_content);

        //	$subject='New Order on Vidiem Site';
        if (isset($order_info['payment_source']) && $order_info['payment_source'] == 'counter' && empty( $order_info['pg_type'] ) ) {
            $client_mail_subject                = 'Vidiem By You - Showing Interest '. $dealer_info['display_name'] . ' - ' . $dealer_info['location_name'] ;
            $mail_content                       .= $mail_header;
            $mail_content                       .= ' <div style="width:100%;text-align:center;">
                                                        <h2> Hi ' . $order_info['billing_name'] . '</h2>,
                                                        <h2> Thanks for choosing to shop with us! </h2>
                                                    </div>
                                                    <br><br>
                                                    <div>
                                                    Thanks for showing interest in Vidiem By You ' . $dealer_info['display_name'] . ' - ' . $dealer_info['location_name'] . '.
                                                    </div>
                                                    
                                                    ';
            $mail_content                        .= '<p>Regards</p>
                                                    <p>Vidiem Team</p>';

            $mail_content                        .= '</div>';
            $this->FunctionModel->send_office_mail($dealer_info['email'], $mail_content, $client_mail_subject, InfoMail);
           // $this->FunctionModel->send_office_mail($admin_to_mail_list, $mail_content, $client_mail_subject, InfoMail);

            $admin_mail_subject                 = 'New order – Vidiem by You – ' . $order_info['inv_code'].' | '. $dealer_info['display_name'] . '-' . $dealer_info['location_name'];
            $admin_mail_content                  = $mail_header;
            $admin_mail_content                  .= '<div style="width:100%;text-align:center;">
                                                            <h2>Dear Team,</h2>  
                                                            <br>&nbsp;&nbsp; 
                                                            New Order on Vidiem By You From Dealer ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . ' 
                                                            <br>Invoice Code' . $order_info['inv_code'] . '. Invoice Amount' . $order_info['amount'].'
                                                            <br><br>
                                                            </div>
                                                    <div>
                                                        <p>Regards</p>
                                                        <p>Vidiem Team</p>
                                                    </div>';
            $admin_mail_content                 .= '</div>';

        } else {
            $dealer_mail_content = '';
            if (isset($order_info['dealer_id']) && !empty($order_info['dealer_id'])) {
                 $dealer_data=$dealer_info['display_name'] .' - '.$dealer_info['location_name'];
                $client_mail_subject            = 'New order – Vidiem by You '. $order_data['order_no'] . ' | ' . $dealer_data;
                $mail_content                   .= $mail_header;
                $dealer_mail_content            .= '<div style="width:100%;text-align:center;">
                                                        <h2>Dear '.$dealer_info['display_name'] . '-' . $dealer_info['location_name'].',</h2>
                                                        <br> Thank you for your order at Vidiem. 
                                                        We’ll send a confirmation when your order processed further.  
                                                        If you would like to know the status of your order please visit Vidiem.in 
                                                        <br>Order Code ' . $order_info['inv_code'].'
                                                        <br><br></div>
                                                        <div>
                                                            <p>Regards</p>
                                                            <p>Vidiem Team</p>
                                                        </div>';
                $dealer_mail_content                   .= '</div>';

                $mail_content                .= '
                                                <div style="width:100%;text-align:center;">
                                                    <h2> Hi ' . $order_info['billing_name'] . '</h2>,
                                                    <h2> Thanks for choosing to shop with us! </h2>
                                                </div>
                                                <br><br>
                                                <div>
                                                We’re happy to confirm your order on ' . date('d/m/Y') . ' Your order number is ' . $order_info['order_no'] . ' at ' . $dealer_info['display_name'] . '-' . $dealer_info['location_name'] . ' . As you can see, we’re getting it ready under strict supervision. We’ll send you a shipping confirmation soon! Stay tuned!
                                                </div>
                                                <div style="text-align:center">Happy Cooking, Love Team Vidiem </div>
                                                <br><br>
                                                <p>Regards</p>
                                                <p>Vidiem Team</p>
                                                </div>
                                                ';


                $this->FunctionModel->send_office_mail($dealer_info['email'], $mail_content, $client_mail_subject, InfoMail);
                $this->FunctionModel->send_office_mail($dealer_info['dealer_admin_email'], $dealer_mail_content, $client_mail_subject, InfoMail);
                
            } else {
                $client_mail_subject            = 'Vidiem Order Confirmation - ' . $order_info['inv_code'];
                $mail_content               .= $mail_header;
                $mail_content                .= '
                                                <div style="width:100%;text-align:center;">
                                                    <h2> Hi ' . $order_info['billing_name'] . '</h2>,
                                                    <h2> Thanks for choosing to shop with us! </h2>
                                                </div>
                                                <br><br>
                                                <div>
                                                We’re happy to confirm your order on ' . date('d/m/Y') . ' Your order number is ' . $order_info['order_no'] . '. As you can see, we’re getting it ready under strict supervision. We’ll send you a shipping confirmation soon! Stay tuned!
                                                </div>
                                                <div style="text-align:center">Happy Cooking, Love Team Vidiem </div>
                                                <br><br>
                                                <p>Regards</p>
                                                <p>Vidiem Team</p>
                                                </div>
                                                ';
            }

            $admin_mail_subject                 = 'New order – Vidiem by You – ' . $order_info['inv_code'];;
            $admin_mail_content                  = $mail_header;
            $admin_mail_content                     = '<div style="width:100%;text-align:center;border:1px solid black;margin:30px;padding:30px;font-family:arial;">
                                                        <span>
                                                            <h1 style="color:#00BFFF;">
                                                                <img src="'. base_url('assets/front-end/images/logo.png').'" style="display:block; margin:4px auto 0 auto" />
                                                            </h1>
                                                        </span>';
            $admin_mail_content                     .= '<h2>Dear Team,</h2>
                                                            <br>  
                                                            <br>&nbsp;&nbsp; 
                                                            New Order on Vidiem By You. 
                                                            <br>Invoice Code' . $order_info['inv_code'] . '. Invoice Amount' . $order_info['amount'].'
                                                            <br><br>
                                                            <p>Regards</p>
                                                            <p>Vidiem Team</p>
                                                            </div>';
            $admin_mail_content                     .= '</div>';
        }
        
        $this->FunctionModel->send_office_mail($clt_info['email'], $mail_content, $client_mail_subject, InfoMail);

        // $this->FunctionModel->sendmail1(AdminMail,$msg,$subject,InfoMail);
         if($order_info['payment_source'] != 'counter')
         {
             $this->FunctionModel->sendmail('saravanan.p@mayaappliances.com,naveenkumar.pixel@gmail.com,john@pixel-studios.com,prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,itsupport@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com',$msg,$subject,InfoMail);
         }
         
        // $this->FunctionModel->sendmail('',$msg,$subject,InfoMail);

      //  $this->FunctionModel->send_office_mail('durairaj.pixel@gmail.com, john@pixel-studios.com', $admin_mail_content, $admin_mail_subject, InfoMail);

        if (isset($order_info['dealer_id']) && !empty($order_info['dealer_id']) && $order_info['payment_source'] == 'counter' && empty( $order_info['pg_type'] ) ) {
            #showing interest
            $sms_content    = 'Thanks for showing interest with our Dealer ' . $dealer_info['display_name'] .' - '.$dealer_info['location_name']. ' on Vidiem By You. To confirm order, please pay online or in bill counter. -VIDIEM -VIDIEM';
            $this->ProjectModel->SMSContent($clt_info['mobile_no'], $sms_content);

            /*** Dealer sms content */
            $sms_content    = 'Dear Dealer ' . $dealer_info['display_name'] . ' - '.$dealer_info['location_name']. ', Our Customer showing interest on Vidiem By You. To confirm order ' . $order_info['order_no'] . ', please collect the amount in bill counter. -VIDIEM';
            $this->ProjectModel->SMSContent($dealer_info['mobile_no'], $sms_content);
        } else if (isset($order_info['dealer_id']) && !empty($order_info['dealer_id'])) {

            $sms_content    = "Thank you for shopping with Vidiem through our Dealer " . $dealer_info['display_name'] .' - '.$dealer_info['location_name']. ". Your order number " . $order_info['inv_code'] . " is under production. We'll share the tracking details once the shipment is ready. -VIDIEM";
            $this->ProjectModel->SMSContent($clt_info['mobile_no'], $sms_content);
            /** dealer sms content */
            $sms_content    = "Dear Dealer" . $dealer_info['display_name'] . ' - '.$dealer_info['location_name']. ", Your Vidiem By You order number " . $order_info['inv_code'] . " is under Production. We'll share the tracking details once the shipment is ready. -VIDIEM";
            $this->ProjectModel->SMSContent($dealer_info['mobile_no'], $sms_content);
        } else {
            $sms_content    = 'Thank you for shopping with Vidiem. Your order number ' . $order_info['inv_code'] . ' is under process. We\'ll share the tracking details once the shipment is ready. -VIDIEM';
            $this->ProjectModel->SMSContent($clt_info['mobile_no'], $sms_content, '1107164362643761375');
        }
    }
    public function dealer_login_shwing_interest()
    {
        
    }

    public function Cartdestroy($cart_id)
    {


        $UpdateData = array(
            'IsActive'      => "2",
            'ModifiedDate'      => date('Y-m-d H:i:s')
        );
        $this->FunctionModel->Update($UpdateData, 'vidiem_carts', array('cart_id' => $cart_id));

        $UpdateData = array(
            'Isactive'      => "2",
            'modifieddate'      => date('Y-m-d H:i:s')
        );
        $this->FunctionModel->Update($UpdateData, 'vidiem_cart_details', array('cart_id' => $cart_id));


        $this->FunctionModel->Update($UpdateData, 'vidiem_cart_jar', array('cart_id' => $cart_id));
    }

    // Order Invoicing

    public function CustomOrderInvoicing($order_id)
    {

        $order_data         = $this->FunctionModel->Select_Row('vidiem_customorder', array('id' => $order_id));
        $basiciteminfo      = $this->getOrderBasicDetails($order_id);
        $jarinfo            = $this->getOrderJarsDetails($order_id);
        $jar_count          = 0;

        $order_no           = $order_data['order_no'] ?? '';
        $client             = $this->FunctionModel->Select_Row('vidiem_clients', array('id' => $order_data['client_id']));

        if ($client['email'] == '') {
            $client['email'] = $order_data['billing_emailid'];
        }
        if (isset($order_data['dealer_id']) && !empty($order_data['dealer_id'])) {
            $dealer_info        = $this->FunctionModel->Select_Fields_Row('display_name,dealer_erp_code,location_code', 'vidiem_dealers', array('id' => $order_data['dealer_id']));
        }
        
        if (isset($order_data['payment_source']) && $order_data['payment_source'] == 'counter' && $order_data['payment_status'] == 'pending') {
             $dealer_data=$dealer_info['display_name'] .' - '.$dealer_info['location_code'];
             
            $client_mail_subject = 'Vidiem By You - Reference No : ' . $order_data['order_no'];
            $client_mail_msg     = '
                    <div>
                        <span > Dear ' . $client['name'] ?? $order_data['billing_name'] . ', 
                            <br>Thanks for showing interest in Vidiem By You. 
                            <br><br>
                        </span><hr>
                        <span><br>Regards<br><br>Vidiem Team </span>
                    </div>
                    ';

            $template2 = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;" >
        <span ><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></span>
        <span > Dear ' . ($client['name'] ?? @$order_data['billing_name']) . ', <br>Thanks for showing interest in Vidiem By You.<br><br>To confirm your order please pay at billing counter. </span>
         
        <hr> Thank you for shopping with us!<br>Team Vidiem  <br><br>  </div>';
        } else {

            if (isset($order_data['dealer_id']) && !empty($order_data['dealer_id'])) {
                 $dealer_data=$dealer_info['display_name'] .' - '.$dealer_info['location_code'];

                $client_mail_subject = 'New order – Vidiem by You | ' . $dealer_data;
                $template2 = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;" >
                <span ><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></span>
                <div style="width:100%;text-align:center" ><h2> Hi ' . ($client['name'] ?? @$order_data['billing_name']) . ', <br>Thanks for choosing to shop with us!</h2></div>
                <hr><div style="text-align:center">We’re happy to confirm your order on ' . date('d/m/Y') . '! Your order number is ' . @$order_data['order_no'] . ' at ' . $dealer_info['display_name'] . '-' . $dealer_info['location_code'] . ' As you can see, we’re getting it ready under strict supervision. We’ll send you a shipping confirmation soon! Stay tuned!<br></div>
                
                <div style="width:100%;text-align:center">Happy Cooking, Love Team Vidiem </div><hr><br><br> Regards<br>Vidiem Team    </div>';
            } else {
                $client_mail_subject = 'New Order - Vidiem By You';
                $template2 = '<div style="border:1px solid black;margin:30px;padding:30px;font-family:arial;" >
                <span ><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></span>
                <span > Dear Customer, <br>Thank you for your order at Vidiem Online Store. Please find the attached proforma invoice for your order reference. 
                Once your package ships we will send an email with a link to track your order. <br><br>If you have questions about your order, you can email us at orders@vidiem.in. </span>
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;">Order Date:&nbsp; ' . date("d-M-Y", strtotime(@$order_data['created'])) . '  | Order No. :&nbsp;' . @$order_data['inv_code'] . '| Order From : www.vidiem.in  </h3>  
                <hr> Thank you for shopping with us!<br>Team Vidiem  <br><br>  <span style="font-size:12px; text-transform:uppercase;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road,<br> Oggiam Thoraipakkam, 
                <br>Chennai - 600097, Tamilnadu, INDIA.  <br> Phone : &nbsp; 044-6635 6635 / 77110 06635  | Website  : &nbsp;  <a href="https://www.vidiem.in">vidiem.in</a>             | GST NO  : &nbsp; 33AAACM6280D1ZT </span></div>';
            }
        }


        $template = '
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">';

        $template .= "<title>Invocie</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900italic,900,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
<style>
     .inTi li{font-family: arial;list-style: none;padding-top:10px;}
     .fullIn{width:80%;margin: 0 auto;padding:20px 5%;background-color:#f8f8f8; over-flow:hidden; overflow-x:scroll}
     .inCon{ width: 800px;font-family: Roboto, sans-serif; border: solid 2px #00bfff; margin: 0 auto;font-family:arial; box-sizing:border-box; padding: 1% 30px; margin-top:40px; }
</style>
</head>";
        $template .= '<body style="margin:0; padding:0;">
    <div class="fullIn">
    <ul class="inTi">
        <li></li>
    </ul>';

        $template .= '<div >
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></div>
        
        <div style="width:30%;float:right;"><h1 style="color:#00BFFF;">PROFORMA INVOICE</h1></div>
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
        <div class="detail" style="float:left; width:35%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:14px; text-transform:uppercase;">No. 3/140, Old Mahabalipuram Road,
Oggiam Thoraipakkam,<br>Chennai - 600097, Tamilnadu, INDIA.</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Landline</span> : &nbsp; 044-6635 6635 / 77110 06635
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Website</span> : &nbsp; http://vidiem.in/
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">GST NO</span> : &nbsp; 33AAACM6280D1ZT
                </li>
            </ul>
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">BILL TO </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['billing_name'] . '
                </li>';
        if (!empty($order_data['billing_company_name'])) {
            $template .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['billing_company_name'] . '</li>';
        }
        $template .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['billing_address'] . ' - ' . @$order_data['billing_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; ' . @$order_data['billing_city'] . '-' . $order_data['billing_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['billing_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['billing_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['billing_mobile_no'] . '
                </li>
            </ul>
        </div>
        <div class="logo" style="float:left; width:35%; "></div>
         <div class="contact" style="float:right; width:30%; margin-top:-15px;">
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">DATE</span> :&nbsp;
                &nbsp;' . date("d-M-Y", strtotime(@$order_data['created'])) . '</li>
                 <li style="font-size:14px;"><span style="width:40%;list-style:none;line-height:28px; display:inline-block;">PROFORMA INVOICE</span> :&nbsp;
                &nbsp;' . @$order_data['inv_code'] . '</li>
            </ul>

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#3B4E87;;">SHIPPING ADDRESS </h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['delivery_name'] . '
                </li>';
        if (!empty($order_data['delivery_company_name'])) {
            $template .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['delivery_company_name'] . '</li>';
        }
        $template .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['delivery_address'] . ' - ' . @$order_data['delivery_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City-Zip</span> : &nbsp; ' . @$order_data['delivery_city'] . '-' . $order_data['delivery_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['delivery_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['delivery_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['delivery_mobile_no'] . '
                </li>
            </ul>';

        $template .= '</div>
        </div>        
        <div class="form" style="width:100%;"> ';
        $invoice .= ' <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
					<td style="width:15%">
						<img src="' . base_url('uploads/customizeimg/' . $basiciteminfo['basecolorpath']) . '" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
										<td style="border-bottom:1px solid #CCC;"><strong>' . $basiciteminfo['cart_code'] . '</strong></td>
									</tr>
									<tr>
										<td>Body Design</td>
										<td>' . $basiciteminfo['basetitle'] . '</td>
									</tr>
									<tr>
										<td>Color</td>
										<td>' . $basiciteminfo['bc_title'] . '</td>
										<td>' . $basiciteminfo['basecolorprice'] . '</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>' . count($jarinfo) . '</td>
										<td>Price breakup as below</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>' . $basiciteminfo['motorname'] . '</td>
										<td>' . $basiciteminfo['motorprice'] . '</td>
									</tr> ';
        if ($basiciteminfo['canvas_text'] != '') {
            $invoice .= '	<tr>
										<td>Personalised message</td>
										<td>' . $basiciteminfo['canvas_text'] . '</td>
											<td>' . $basiciteminfo['textprice'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['occasion_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Occasion</td>
										<td>' . $basiciteminfo['occasion_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['message_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Box Message</td>
										<td>' . $basiciteminfo['message_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['package_id'] != '' && !empty($basiciteminfo['package_id'])) {
            $invoice .= '		<tr>
										<td>Packaging</td>
										<td>' . $basiciteminfo['packagename'] . '</td>
										<td>' . $basiciteminfo['packageprice'] . '</td>
									</tr> ';
        }
        $invoice .= '			</tbody>
							</table> ';

        if (count($jarinfo) > 0) {
            $invoice .= '	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
            foreach ($jarinfo as $jar) {

                $jar_count += $jar['qty'];
                $invoice .= '<tr>
										<td>
												<img src="' . base_url("uploads/customizeimg/jar/" . $jar['jarimgpath']) . '" alt="" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" >											
										</td>
										<td>' . $jar['jarname'] . '</td>
										<td style="text-align:center;color:#F7000A;">
											' . $jar['qty'] . ' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.' . number_format($jar['price']) . '
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. ' . number_format($jar['qty'] * $jar['price']) . '
										</td>
									</tr> ';
            }
        }

        $invoice .= '	</tbody>
							</table>
							
					</td>
				</tr>
            </table> ';





        $invoice .= '<table style="width:100%; padding:20px 0 40px 0;">
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. ' . number_format($order_data['sub_total'], 2, '.', '') . '</b></th>
                </tr>';
        // $invoice.='<tr>/<td></td>/<td></td>/<td></td>/<th style="text-align:right;">GST18%</th><th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['tax'],2,'.','').'</b></th></tr>';

        $invoice .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;">Rs. ' . number_format($order_data['amount'], 2, '.', '') . '</th>
                </tr>';

        $invoice .= '<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.</td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">If you have any questions about this invoice, please write us to below email id</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;">orders@vidiem.in</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    <p style="font-size:14px; margin-left:40px; line-height:25px;">
                Warm Regards<br>
                Vidiem<br>
                044-6635 6635 / 77110 06635<br>
            </p>';

        $invoice = '
   <style>h1 {
    margin-top: -5px;
}</style>
   <div style="border:1px solid black;">
   <div class="container inCon">
      <div style="border:1px solid black;">
   <div class="container inCon">
        <div style="float:left;"><h1 style="color:#00BFFF;"><img src="' . base_url('assets/front-end/images/logo.png') . '" style="display:block; margin:4px auto 0 auto"/></h1></div>
        <div style="float:left;"><ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <li style="font-size:12px; text-transform:uppercase;">Maya Appliances Pvt Ltd,<br>No. 3/140, Old Mahabalipuram Road, Oggiam Thoraipakkam, Chennai - 600097, Tamilnadu, INDIA. 
               |   <span style="list-style:none;line-height:28px; display:inline-block;">Phone</span> : &nbsp; 044-6635 6635 / 77110 06635  | Website</span> : &nbsp; http://vidiem.in/
                 | GST NO</span> : &nbsp; 33AAACM6280D1ZT </li>
            </ul></div>
       
        <p style="clear:both;"></p>
    <div class="header_bottom" style="width:100%; padding:10px 0;">
         <div style="width:100%;float:right;"><h1 style="color:#000000;">PROFORMA INVOICE</h1> 

              <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;">Order Date:&nbsp; ' . date("d-M-Y", strtotime(@$order_data['created'])) . ' 
                 | Order No. :&nbsp;' . @$order_data['inv_code'] . ' | Order From : www.vidiem.in </h3> 

<div class="detail" style="float:left; width:50%;">
            
            <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">Billing Address</h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['billing_name'] . '
                </li>';
        if (!empty($order_data['billing_company_name'])) {
            $invoice .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; ' . @$order_data['billing_company_name'] . '</li>';
        }
        $invoice .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['billing_address']. ' - ' . @$order_data['billing_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp; ' . @$order_data['billing_city'] . '-' . $order_data['billing_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['billing_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['billing_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['billing_mobile_no'] . '
                </li>
            </ul>
        </div>
         
         <div class="contact" style="float:left; width:49%;">
            

             <ul style="width:100%; display:inline-block; margin:0; padding:0;list-style:none;">
                <h3 style="color:#fff;padding:10px 5px;font-size:14px; background:#F7000A;;">Shipping Address</h3>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Name</span> : &nbsp; ' . @$order_data['delivery_name'] . '
                </li>';
        if (!empty($order_data['delivery_company_name'])) {
            $invoice .= '<li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Company</span> : &nbsp; ' . @$order_data['delivery_company_name'] . '</li>';
        }
        $invoice .= '</li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Address</span> : &nbsp; ' . @$order_data['delivery_address'] . '  - ' . @$order_data['delivery_address2'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">City</span> : &nbsp; ' . @$order_data['delivery_city'] . '-' . $order_data['delivery_zip'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">State</span> : &nbsp; ' . @$order_data['delivery_state'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Country</span> : &nbsp; ' . @$order_data['delivery_country'] . '
                </li>
                <li style="font-size:14px;"><span style="width:22%;list-style:none;line-height:28px; display:inline-block;">Mobile</span> : &nbsp; ' . @$order_data['delivery_mobile_no'] . '
                </li>
            </ul>';

        $invoice .= '</div>
        </div>        
        <div class="form" style="width:100%;"> ';

        $invoice .= ' <table style="width:100%; padding:20px 0 40px 0;">
                <tr>
					<td style="width:15%">
						<img src="' . base_url('uploads/customizeimg/' . $basiciteminfo['basecolorpath']) . '" style="margin: 0; border: 0; padding: 0; display: block;" width="160" height="160">
					</td>
					<td style="width:85%">
						<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="border-bottom:1px solid #CCC;"><strong>Customization Code</strong></td>
										<td style="border-bottom:1px solid #CCC;"><strong>' . $basiciteminfo['cart_code'] . '</strong></td>
									</tr>
									<tr>
										<td>Body Design</td>
										<td>' . $basiciteminfo['basetitle'] . '</td>
									</tr>
									<tr>
										<td>Color</td>
										<td>' . $basiciteminfo['bc_title'] . '</td>
										<td>' . $basiciteminfo['basecolorprice'] . '</td>
									</tr>
									<tr>
										<td>Selected Jars</td>
										<td>' . $jar_count . '</td>
										<td>Price Breakup Below</td>
									</tr>
									<tr>
										<td>Motor Power</td>
										<td>' . $basiciteminfo['motorname'] . '</td>
										<td>' . $basiciteminfo['motorprice'] . '</td>
									</tr> ';
        if ($basiciteminfo['canvas_text'] != '') {
            $invoice .= '	<tr>
										<td> Personalised message </td>
										<td>' . $basiciteminfo['canvas_text'] . '</td>
										<td>' . $basiciteminfo['textprice'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['occasion_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Occasion</td>
										<td>' . $basiciteminfo['occasion_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['message_text'] != '') {
            $invoice .= '	<tr>
										<td>Gift Box Message</td>
										<td>' . $basiciteminfo['message_text'] . '</td>
									</tr> ';
        }
        if ($basiciteminfo['package_id'] != '' && !empty($basiciteminfo['package_id'])) {
            $invoice .= '		<tr>
										<td> Packaging </td>
										<td>' . $basiciteminfo['packagename'] . '</td>
                                        <td>' . $basiciteminfo['packageprice'] . '</td>
									</tr> ';
        }
        $invoice .= '			</tbody>
							</table> ';

        if (count($jarinfo) > 0) {
            $invoice .= '	<table border="0" cellpadding="7" cellspacing="0" style="width:600px;border:1px solid #CCC; margin-bottom: 20px;">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #CCC;"></th>
										<th style="border-bottom:1px solid #CCC;">Jar Information</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">No. Jars</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Unit Price</th>
										<th style="text-align:center;border-bottom:1px solid #CCC;">Total Price</th>
									</tr>
								</thead>
								<tbody> ';
            foreach ($jarinfo as $jar) {
                $invoice .= '<tr>
										<td>
												<img src="' . base_url("uploads/customizeimg/jar/" . $jar['jarimgpath']) . '" alt="" style="margin: 0; border: 0; padding: 0; display: block;" width="60" height="60" >
												<br/>
												<span>' . $jar['capacityname'] . '|' . $jar['typeofjarname'] . '|' . $jar['typeofhandlename'] . '|' . $jar['typeoflidname'] . '
											
										</td>
										<td>' . $jar['jarname'] . '</td>
										<td style="text-align:center;color:#F7000A;">
											' . $jar['qty'] . ' Jars
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs.' . number_format($jar['price']) . '
										</td>
										<td style="text-align:center;color:#F7000A;">
											Rs. ' . number_format($jar['qty'] * $jar['price']) . '
										</td>
									</tr> ';
            }
        }

        $invoice .= '	</tbody>
							</table>
							
							<table border="0"  cellspacing="5" style="width:600px;border:1px solid #CCC;margin-bottom:10px;padding:10px;font-size:11px;">
					 
							<tr>
                                <td>
                                    <span style="color:#ff0000;font-size:12px;"><strong>Warranty Information</strong>
                                    </span>
                                    <br><br>
							            - 2 Years Warranty on Product <br> 
                                        - 5 Years Warranty on Motor <br> 
                                        <span style="color:#ff0000;font-size:10px;">
                                        <i>(For Domestic Purpose Only)</i>
                                        <br>
                                        Non Returnable / No Cancellation in all vidiem by you orders
                                        </span>
                                </td>
                            </tr>
                        </table>
							
					</td>
				</tr>
            </table>
							
					</td>
				</tr>
            </table> ';





        $invoice .= '<table style="width:100%; padding:20px 0 40px 0;">
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">SubTotal</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. ' . number_format($order_data['sub_total'], 2, '.', '') . '</b></th>
                </tr>';
        // $invoice.='<tr>/<td></td>/<td></td>/<td></td>/<th style="text-align:right;">GST18%</th><th style="padding:10px 0;text-align:right;"><b>Rs. '.number_format($order_data['tax'],2,'.','').'</b></th></tr>';

        $invoice .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;">Package Price</th>
                    <th style="padding:10px 0;text-align:right;"><b>Rs. ' . number_format($order_data['packageprice'], 2, '.', '') . '</b></th>
                </tr>';

        $invoice .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th style="text-align:right;font-size:14px;">TOTAL</th>
                    <th style="color:#fff;padding:10px 0; background:#F7000A;;text-align:right;">Rs. ' . number_format($order_data['amount'], 2, '.', '') . '</th>
                </tr>';

        $invoice .= '<tr><td></td><td style="font-size:12px;">Note: This is computer generated invoice hence no signature required.| If you have any questions about this invoice, please write us to orders@vidiem.in </td></tr>
                  <tr><td>&nbsp;</td></tr>
                  <tr><td colspan="4" style="text-align:center; font-size:12px;"><b>Thank You For Your Association with Vidiem</b></td></tr>
            </table>
        </div>
    </div>
    </div>';



        $this->load->library('m_pdf');
        $this->m_pdf->pdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            7, // margin_left
            3, // margin right
            5, // margin top
            5, // margin bottom
            5, // margin header
            5
        ); // margin footer
        //generate the PDF from the given html
        $file_name = 'uploads/invoice/vidiem_billing_Invoice.pdf';
        $this->m_pdf->pdf->WriteHTML($invoice);
        $attachdata = $this->m_pdf->pdf->Output($file_name, 'S');

        if (isset($order_data['payment_source']) && $order_data['payment_source'] == 'counter' && $order_data['payment_status'] == 'pending') {
            $attachdata = '';
        }
        $this->FunctionModel->send_office_mail($client['email'], $template2, $client_mail_subject, 'orders@vidiem.in', $attachdata);
         $this->FunctionModel->sendmail('prodmgsrk@mayaappliances.com,palani.j@mayaappliances.com,venkatesan@mayaappliances.com,em@mayaappliances.com,syed.m@mayaappliances.com,itsupport@mayaappliances.com,balakrishnan.s@mayaappliances.com,thulasiraman.s@mayaappliances.com,onlinesales@mayaappliances.com,mktg1@mayaappliances.com,qasrk@mayaappliances.com,anandan.c@mayaappliances.com,murugan.k@mayaappliances.com,satheyaraaj.t@mayaappliances.com',$template,'New Order - Vidiem By You','orders@vidiem.in',$attachdata);
           $this->FunctionModel->sendmail('saravanan.p@mayaappliances.com,john@pixel-studios.com,naveenkumar.pixel@gmail.com',$template2,'New Order - Vidiem By You','orders@vidiem.in',$attachdata);
        //$this->FunctionModel->send_office_mail('durairaj.pixel@gmail.com, john@pixel-studios.com', $template2, $client_mail_subject, 'care@vidiem.in', $attachdata);
        /*  $this->FunctionModel->sendmail('prodmgsrk@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('palani.j@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('venkatesan@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('em@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('syed.m@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('ramakrishnan.n@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('itsupport@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('balakrishnan.s@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('thulasiraman.s@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('onlinesales@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('mktg1@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('qasrk@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('anandan.c@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('rnd@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('murugan.k@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      $this->FunctionModel->sendmail('satheyaraaj.t@mayaappliances.com',$template,'New Order - Vidiem By You','care@vidiem.in',$attachdata);
      */

        // $this->FunctionModel->sendmail('itsupport@mayaappliances.com',$template,'New Order Invoice','care@vidiem.in',$attachdata);
        return true;
    }

    public function customcurrentOrder($client_id)
    {
        $this->db->where_in('status', ['1', '2', '5']);
        $data = $this->db->get_where('vidiem_customorder', array('client_id' => $client_id, 'payment_status' => 'success'))->result_array();
        return $data;
    }


    public function getOrderBasicDetails($order_id)
    {
        $cartarr            = $this->CustomizeModel->getDataActiveById($order_id, "vidiem_customorder", "id");
        $orderitemdetails   = array();

        if ($cartarr->id) {
            $this->db->select(" o.inv_code,o.cart_code,op.order_id,op.base_id,op.basetitle,op.basepath,op.baseprice,op.bc_id,op.bc_title,op.basecolorpath,op.basecolorprice,op.motor_id,op.motorname,op.motorbasepath,op.motorprice,op.bm_text_id,op.desktopleft,op.desktoptop,op.textprice,op.canvas_text,op.message_text,op.occasion_text,op.package_id,op.packagename,op.packagebasepath,op.packageprice,cat.name as catname,op.desktopleft,op.desktoptop ");
            // $this->db->select(" o.inv_code,o.cart_code,op.order_id,op.base_id,op.basetitle,op.basepath,op.baseprice,op.bc_id,op.bc_title,op.basecolorpath,op.basecolorprice,op.motor_id,op.motorname,op.motorbasepath,op.motorprice,op.bm_text_id,op.desktopleft,op.desktoptop,op.textprice,op.canvas_text,op.package_id,op.packagename,op.packagebasepath,op.packageprice,cat.name as catname,op.desktopleft,op.desktoptop ");

            $this->db->join('vidiem_customorder  o', ' o.id=op.order_id and o.Isactive=1 ');
            $this->db->join('vidiem_category cat', ' cat.id=o.category_id and cat.status=1 ');
            $this->db->where(" op.IsActive=1 ");
            $this->db->where(" op.order_id= " . $cartarr->id);

            $dataarr = $this->db->get_where(' vidiem_custom_order_products op ')->row();

            $orderitemdetails = (array)$dataarr;
        }

        return $orderitemdetails;
    }

    public function getOrderJarsDetails($order_id)
    {
        $cartarr = $this->CustomizeModel->getDataActiveById($order_id, "vidiem_customorder", "id");
        $orderjars = array();
        if ($cartarr->id) {

            $this->db->select("oj.cart_jar_id, oj.jar_id,oj.jarname,oj.jarimgpath,oj.qty,oj.price,cc.capacityname,tl.typeoflidname,tj.typeofjarname,th.typeofhandlename ");

            $this->db->join('vidiem_customorder  o', ' o.id=oj.order_id and o.Isactive=1 ');
            $this->db->join('vidiem_category cat', ' cat.id=o.category_id and cat.status=1 ');
            $this->db->join('vidiem_jar j', ' j.jar_id=oj.jar_id  ');
            $this->db->join('vidiem_typeofjar  tj', ' tj.typeofjar_id=j.typeofjar_id  ');
            $this->db->join('vidiem_typeofhandle  th', ' th.typeofhandle_id=j.typeofhandle_id  ');
            $this->db->join('vidiem_typeoflid  tl', ' tl.typeoflid_id=j.typeoflid_id ');
            $this->db->join('vidiem_capacity  cc', ' cc.capacity_id=j.capacity_id ');

            $this->db->where(" oj.Isactive=1 ");
            $this->db->where(" oj.order_id= " . $cartarr->id);

            $dataarr = $this->db->get_where(' vidiem_custom_order_jars oj ')->result_array();

            $orderjars = (array)$dataarr;
        }

        return $orderjars;
    }

    public function custom_Select_Orders()
    {
       // print_r('GG'); die;

        $this->db->select('vidiem_dealers.dealer_erp_code, vidiem_dealers.display_name,vidiem_dealer_locations.location_code, vidiem_dealer_locations.location_name,o.*,if(o.client_id=0,o.delivery_name,c.name) as name ,if(o.client_id=0,o.delivery_emailid,c.email) as email,if(o.client_id=0,o.delivery_mobile_no,c.mobile_no) as mobile_no');
        $this->db->join('vidiem_clients c', 'c.id=o.client_id', 'left');
        $this->db->join('vidiem_dealers', 'vidiem_dealers.id = o.dealer_id', 'left');
         $this->db->join('vidiem_dealer_locations', 'vidiem_dealer_locations.id = o.dealer_location_id', 'left');
        if (isset($_POST['order_type']) && $_POST['order_type'] == 1) {
            $this->db->where('o.dealer_id is NOT NULL', null, FALSE);
            $this->db->where('o.dealer_id !=', 0);
        }

        if (isset($_POST['dealer_id']) && !empty($_POST['dealer_id'])) {
            $this->db->where('o.dealer_id', $_POST['dealer_id']);
        }
        // $this->db->group_by('o.pg_type');

        $this->db->order_by('o.id', 'DESC');

        $query = $this->db->get_where('vidiem_customorder o', array('o.status !=' => 4, 'o.payment_status' => 'success'));
        //echo $this->db->last_query(); exit;
        return $query->result_array();
    }

    public function custom_Select_unCompletedOrders()
    {
         // print_r('GG'); die;
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c', 'c.id=o.client_id');
        $this->db->order_by("id", "desc");
        $query =  $this->db->get_where('vidiem_customorder o', array('o.status !=' => 4, 'o.payment_status !=' => 'success'));
       
         return $query->result_array();
    }

    public function custom_Select_Cancelled_Order()
    {
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c', 'c.id=o.client_id');
        $query = $this->db->get_where('vidiem_customorder o', array('o.status' => 4));
        return $query->result_array();
    }

    public function custom_Select_Cancel_Requests()
    {
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c', 'c.id=o.client_id');
        $query = $this->db->get_where('vidiem_customorder o', array('o.status' => 1, 'o.cancel_request' => 1));
        return $query->result_array();
    }


    public function SalesReport($from, $to, $status = null, $reportuser = null)
    {
        $this->db->select('o.*,c.name,c.email,c.mobile_no');
        $this->db->join('vidiem_clients c', 'c.id=o.client_id', 'left');
        $this->db->where('DATE(o.created) >=', $from);
        $this->db->where('DATE(o.created) <=', $to);
        if (!empty($status)) {
            $this->db->where('o.status', $status);
        }
        if (!empty($reportuser)) {
            $this->db->where('o.client_id', $reportuser);
        }
        $query = $this->db->get_where(' vidiem_customorder o', array('o.status !=' => 4, 'o.payment_status' => 'success'));

        // print_r($this->db->last_query());
        //  die();

        return $query->result_array();
    }

    public function ProductReport($from, $to, $status = null, $reportuser = null)
    {
        $this->db->select('o.*,c.name,c.email,c.mobile_no,op.name as productname,op.price as product_price,op.qty as product_qty,op.amount as subtotal_amt');
        $this->db->join('vidiem_clients c', 'c.id=o.client_id', 'left');
        $this->db->join('vidiem_order_products op', 'o.id=op.order_id');
        $this->db->where('DATE(o.created) >=', $from);
        $this->db->where('DATE(o.created) <=', $to);
        if (!empty($status)) {
            $this->db->where('o.status', $status);
        }
        if (!empty($reportuser)) {
            $this->db->where('o.client_id', $reportuser);
        }
        $query = $this->db->get_where('vidiem_order o', array('o.status !=' => 4, 'o.payment_status' => 'success'));

        // print_r($this->db->last_query());
        //  die();

        return $query->result_array();
    }
    public function calculatepackageprice($cartid, $base_id, $nojar)
    {

        $this->db->select("  bp.* ");
        $this->db->join('vidiem_basemodel  bm', ' bm.base_id=bp.base_id and bm.Isactive=1 ');
        $this->db->where(" bp.IsActive=1 ");
        $this->db->where(" bp.base_id='" . $base_id . "' ");
        $this->db->where(" 1=(case 
                    when noofjar>='" . $nojar . "' and isgreater=0 then '1' 
                    when noofjar<='" . $nojar . "' and isgreater=1 then '1' end) ");

        $this->db->order_by('noofjar', 'asc');
        $this->db->limit(1);

        $jarpricearr = $this->db->get_where(' vidiem_base_package bp ')->result_array();
        return $jarpricearr[0];
    }

    public function getMotorDetailById($motorId, $baseId)
    {
        $this->db->select('m.*,bm.basepath as base_motor_image');
        $this->db->join('vidiem_motors m', 'm.motor_id = bm.motor_id');
        $query = $this->db->get_where('vidiem_basemodel_motor bm', array('bm.isactive' => 1, 'bm.base_id' => $baseId, 'bm.motor_id' => $motorId));
        return $query->row_array();
    }
}
