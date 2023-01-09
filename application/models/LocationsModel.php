<?php
class LocationsModel extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->library('session');
		$this->load->database();
    }

	public function getLocation( $id ) {
        return $this->db->where(array('dealer_id'=>$id,'is_deleted'=>1))->get('vidiem_dealer_locations')->result();
    }

    public function delete($table, $array, $id, $column){
       return $this->db->where($column,$id)->update($table,$array);
    }

    function getInfoByRandomColumn( $table, $id ) {
        return $this->db->select('location.*,sale.id as sale_user_id,sale.user_id as s_user_name, sale.user_code as s_user_code,sale.password as s_password,counter.id as counter_user_id,counter.user_id as c_user_name, counter.user_code as c_user_code,counter.password as c_password,')
                        ->from('vidiem_dealer_locations as location')
                        ->join('vidiem_dealer_users as sale','sale.location_id = location.id and sale.user_type = "sale_person"','left')
                        ->join('vidiem_dealer_users as counter ','counter.location_id = location.id and counter.user_type = "counter_person"','left')
                        ->where('location.id', $id)
                        ->get($table)->row();
    }
}
?>