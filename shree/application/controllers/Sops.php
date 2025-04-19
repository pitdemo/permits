<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sops extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','departments_model','Zones_model'));	
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');

		$this->security_model->chk_is_admin();    
	}
	public function index() // list the item lists
	{
		$c_id = array_search('department_id',$this->uri->segment_array());

        $id=$where_condition='';
		
		$where='1=1';


        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			if($id!='')
				$where_condition =' department_id = "'.$id.'" AND ';
        }        
		
		$record_type = array_search('record_type',$this->uri->segment_array());

		if($record_type !==FALSE && $this->uri->segment($record_type+1))
        {
            $record_type = $this->uri->segment($record_type+1);  

			if($record_type!='')
				$where_condition.=' record_type="'.$record_type.'"';
        }  
        else
        {
        	$where_condition.=' record_type="'.SOPS.'"';

        	$record_type=SOPS;
        }	

        $where_condition=rtrim($where_condition,'AND ');

		$this->data['departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id,plant_type','column'=>'name','dir'=>'asc','where_condition'=>$where))->result_array();

		$check_lists=$this->public_model->get_data(array('table'=>SOPS,'select'=>'sl_no,id,description,status','column'=>'modified','dir'=>'desc','where_condition'=>$where_condition));

        $this->data['checklists']=$check_lists;

        $this->data['record_type']=$record_type;
		
		$this->load->view($this->data['controller'].'lists',$this->data);
	}

	public function form($id='',$record_type='')
	{	

		$this->data['departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id,plant_type','column'=>'name','dir'=>'asc','where_condition'=>'1=1'))->result_array();

		$this->data['brand_details']=array();

		if(!empty($id))
		{
			 $brands= $this->public_model->get_data(array('table'=>SOPS,'select'=>'id,sl_no,description,file_name,record_type,department_id','where_condition'=>$where="id ='".$id."'"));

			 if($brands->num_rows()>0)
			 	$this->data['brand_details']=$brands->row_array();
		}
			
		

		$this->load->view($this->data['controller'].'form',$this->data);
	}


	    // Change status Active, Inactive and Deleted for Company Users
    public function ajax_update_status()
	{
		$this->security_model->chk_is_admin();    
		
        $response='';

        $status = $this->input->post('status');

       

        if(is_array($this->input->post('id'))){
            $i=0;
            foreach ( $this->input->post('id') as $value) {
                $ids[$i]=$value;
                $i++;
            }
            $this->db->where_in('id', $ids);
            $status = $this->input->post('status');
            $response='bulk';
        }
        else{
            $id=$this->input->post('id');
            $this->db->where('id',$id);   
            if($status=='active'){
                $response=STATUS_INACTIVE;
            }
            else if($status=='inactive'){
                $response=STATUS_ACTIVE;
            }
            else{
                $response=STATUS_DELETED;
            }
            $status = $response;
        }
        $this->db->set('status',$status);
        $this->db->update(SOPS);
		
		#echo $this->db->last_query(); 
        echo $response; exit;
    }
	
	//Check the given mail address exists or not in DB
    public function ajax_check_symbol_exists($id='')
    {
       
        $sl_no=trim($this->input->post('sl_no'));

        $record_type=$this->input->post('record_type');

        $where_condition='sl_no="'.$sl_no.'"';

       if(trim($id)!='')
       {
          	$id=base64_decode($id);

          	$where_condition.=' AND id!="'.$id.'"';
       }  	

        $num_rows=$this->public_model->get_data(array('table'=>SOPS,'select'=>'id','where_condition'=>$where_condition))->num_rows();

        #echo $this->db->last_query();
        
        if($num_rows>0)
        echo "false";
        else
        echo "true";                
    }

    public function ajax_form_submit()
    {

    	$id=$this->input->post('id');

    	$record_type=$this->input->post('record_type');

    	$array_update=array('sl_no'=>$this->input->post('sl_no'),'description'=>$this->input->post('description'),'department_id'=>$this->input->post('department_id'),'modified'=>date('Y-m-d H:i'),'record_type'=>$record_type);

    	if($id=='')
    	{
    		$array_update['created']=date('Y-m-d H:i');

    		$this->db->insert(SOPS,$array_update);

    		$id=$this->db->insert_id();	
    	}
    	else
    	{
    		$this->db->where('id',$id);

    		$this->db->update(SOPS,$array_update);
    	}

    	$upload_csv=(isset($_FILES[0]['tmp_name'])) ? $_FILES[0]['tmp_name'] : '';

    	if($upload_csv!='')
    	{
	      $generate_file_name = str_replace(' ','_',$_FILES[0]['name']);

	      $ext = pathinfo($_FILES[0]['name'], PATHINFO_EXTENSION);

	      /*if($record_type=='sops')
	      	$file='sop';
	      else
	      	$file='wi';*/

	      $file=preg_replace('/[^A-Za-z0-9]/', '',$array_update['sl_no']);

	      $new_file = $file.'.pdf';

	      move_uploaded_file($upload_csv, FCPATH.'uploads/sops_wi/'.$new_file);

	      $this->db->where('id',$id);

	      $this->db->update(SOPS,array('file_name'=>$new_file));
		}   

		$this->session->set_flashdata('success','Data has been updated successfully');

		echo json_encode(array('response'=>'success'));

		exit;
    }


    public function update_sops()
    {

    	$get_data=$this->public_model->get_data(array('select'=>'id,sop','where_condition'=>'sop!=""','table'=>JOBS))->result_array();

    	foreach($get_data as $data):	

    		$st=' AND sl_no="'.$data['sop'].'"';

    		$id=$data['id'];

    		$sop_data=$this->public_model->get_data(array('select'=>'*','where_condition'=>'record_type="'.SOPS.'"'.$st,'table'=>SOPS))->row_array();

    		$this->db->where('id',$id);

    		$this->db->update(JOBS,array('sop_new'=>$sop_data['id']));

    	endforeach;	

    	
    	$get_data=$this->public_model->get_data(array('select'=>'id,work_instruction','where_condition'=>'work_instruction!=""','table'=>JOBS))->result_array();

    	foreach($get_data as $data):	

    		$st=' AND sl_no="'.$data['work_instruction'].'"';

    		$id=$data['id'];

    		$sop_data=$this->public_model->get_data(array('select'=>'*','where_condition'=>'record_type="'.WORK_INSTRUCTIONS.'"'.$st,'table'=>SOPS))->row_array();

    		$this->db->where('id',$id);

    		$this->db->update(JOBS,array('work_instruction_new'=>$sop_data['id']));
    		
    	endforeach;	


    }
}
?>
