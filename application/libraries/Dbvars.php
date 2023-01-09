<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Dbvars Library
* Simplifies storing variables in database, for example configuration variables.
* 
* You must create table first.
**/
/*

CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`key`)
)

*/
/**
* Use:
*     $this->load->database();
*     $this->load->library('dbvars');
*     
* To set value: $this->dbvars->key = 'value';
* To get value:    $this->dbvars->key
* To check if the variable isset: $this->dbvars->__isset($key);
* To unset variable use: $this->dbvars->__unset($key);
* As of PHP 5.1.0 You can use isset($this->dbvars->key), unset($this->dbvars->key);
*
* @version: 0.1 (c) _andrew 27-03-2008
**/
class Dbvars {
    const TABLE = 'vidiem_site_config';
    //Table where variables will be stored.
    
    private $data;
    private $ci;
    
    function __construct()
    {
        $this->ci =& get_instance();
    
        $q = $this->ci->db->get(self::TABLE);
        foreach ($q->result() as $row)
           {
               $this->data[$row->title] = $row->value;
           }
           $q->free_result();

    }

    function __get($title){
        return $this->data[$title];
    }
    
    function __set($title, $value){
        if (isset($this->data[$title])){
            $this->ci->db->where('title', $title);
            $this->ci->db->update(self::TABLE, array('value' => $value));
        } else {
            $this->ci->db->insert(self::TABLE, array('title' => $title, 'value' => $value));
        }
        $this->data[$title] = $value;
    }
        
    /**  As of PHP 5.1.0  */
    function __isset($title) {
        return isset($this->data[$title]);
    }

    /**  As of PHP 5.1.0  */
    function __unset($title) {
        $this->ci->db->delete(self::TABLE, array('title' => $title));    
        unset($this->data[$title]);
    }    
}
?>