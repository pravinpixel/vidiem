<?php
class SerivceModel extends CI_Model {
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('session','Dbvars'));
        $this->load->database();
    }
   
   
     public function getDataArrById($id,$table_name,$field_name)
    {
       return  $this->db->select('*')
                ->where($field_name, $id)
                ->get($table_name)
                ->row();
	  // print_r($this->db->last_query());
		//die();
				
    }
	
	 public function getDataActiveById($id,$table_name,$field_name)
    {
       return  $this->db->select('*')
                ->where($field_name, $id)
				->where(" isactive ", "1")
                ->get($table_name)
                ->row();
	  // print_r($this->db->last_query());
		//die();
				
    }
	
	public function getDataArrMultCond($table_name,$wherecond)
    {
       return  $this->db->select('*')
                ->where($wherecond)
                ->get($table_name)
                ->row();
	  // print_r($this->db->last_query());
		//die();
				
    }
   
 
	
	public function managestateList($list='list',$where=array(),$custom=null,$search=[],$order=false)
    {
		
        $this->db->select('p.*');
       // $this->db->join('vidiem_category  c','c.id=p.category_id');	
		
        $this->db->where($where);   
        if(!empty($search)){    

			$searchqry=" (  ";
            foreach($search as $filed=>$value){ 
			   $searchqry.= $filed." like '%".$value."%' or ";			    
            }  
							
			 $searchqry= rtrim($searchqry,"or ");	
				$searchqry.=" ) ";	
			
		 $this->db->where($searchqry);
			
        }   
        if($order){ 
            $this->db->order_by($order['field'],$order['type']);    
        }else{  
            $this->db->order_by('p.createddate','desc');  
        }  
	
        if($list=='list'){  
            $dataarr= $this->db->get_where(' vidiem_servicestate p',array(),$this->input->post('length'),(int)$this->input->post('start'))->result_array(); 
			return  $dataarr;
        }else{  
            $count=$this->db->count_all_results(' vidiem_servicestate p'); 
            return (int)$count; 
        }   
    }
	
	
	public function managecityList($list='list',$where=array(),$custom=null,$search=[],$order=false)
    {
		
        $this->db->select('p.*,c.statename');
        $this->db->join('vidiem_servicestate  c','c.state_id=p.state_id');	
		
        $this->db->where($where);   
        if(!empty($search)){    

			$searchqry=" (  ";
            foreach($search as $filed=>$value){ 
			   $searchqry.= $filed." like '%".$value."%' or ";			    
            }  
							
			 $searchqry= rtrim($searchqry,"or ");	
				$searchqry.=" ) ";	
			
		 $this->db->where($searchqry);
			
        }   
        if($order){ 
            $this->db->order_by($order['field'],$order['type']);    
        }else{  
            $this->db->order_by('p.createddate','desc');  
        }  
	
        if($list=='list'){  
            $dataarr= $this->db->get_where(' vidiem_servicecity p',array(),$this->input->post('length'),(int)$this->input->post('start'))->result_array(); 
			return  $dataarr;
        }else{  
            $count=$this->db->count_all_results(' vidiem_servicecity p'); 
            return (int)$count; 
        }   
    }
	
	
	public function ManageServiceCenterList($list='list',$where=array(),$custom=[],$search=[],$order=false)
    {
		
        $this->db->select('p.*,s.statename,c.cityname');
        $this->db->join('vidiem_servicestate  s','s.state_id=p.state_id');	
        $this->db->join('vidiem_servicecity  c','c.city_id=p.city_id');	
		
        $this->db->where($where);   
        if(!empty($search)){    

			$searchqry=" (  ";
            foreach($search as $filed=>$value){ 
			   $searchqry.= $filed." like '%".$value."%' or ";			    
            }  
							
			 $searchqry= rtrim($searchqry,"or ");	
				$searchqry.=" ) ";	
			
		 $this->db->where($searchqry);
			
        }   
        if($order){ 
            $this->db->order_by($order['field'],$order['type']);    
        }else{  
            $this->db->order_by('p.createddate','desc');  
        }  
	
        if($list=='list'){  
            $dataarr= $this->db->get_where(' vidiem_servicecenter p',array(),$this->input->post('length'),(int)$this->input->post('start'))->result_array(); 
			
		//	echo $this->db->last_query();
		//	die();
			return  $dataarr;
        }else{  
            $count=$this->db->count_all_results(' vidiem_servicecenter p'); 
            return (int)$count; 
        }   
    }
	


}