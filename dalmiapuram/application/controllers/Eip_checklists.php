<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eip_checklists extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','departments_model','Zones_model'));	
			
		
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}
	public function index() // list the item lists
	{
		$this->security_model->chk_is_admin();    

		$c_id = array_search('zone_id',$this->uri->segment_array());
        $id='';
		
		$where='1=1';
        if($c_id !==FALSE && $this->uri->segment($c_id+1))
        {
            $id = $this->uri->segment($c_id+1);  
			  
            $this->data['id']=$id;
			
			$where.=' AND zone_id = "'.$id.'"';
        }  
		

		$this->data['zones'] = $this->Zones_model->get_details(array('conditions'=>'status!= "'.STATUS_DELETED.'"'))->result_array();

		$check_lists=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number,status','column'=>'equipment_name','dir'=>'asc','where_condition'=>$where));

        $this->data['checklists']=$check_lists;
		
		$this->load->view($this->data['controller'].'lists',$this->data);
	}

	public function form($id='')
	{
		$this->security_model->chk_is_admin();    

		$this->data['zones'] = $this->Zones_model->get_details(array('conditions'=>'status!= "'.STATUS_DELETED.'"'))->result_array();	

		$this->data['brand_details']=array();

		if(!empty($id))
		{
			 $brands= $this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number,status,zone_id','column'=>'equipment_name','dir'=>'asc','where_condition'=>$where="id ='".$id."'"));
			 if($brands->num_rows()>0)
			 	$this->data['brand_details']=$brands->row_array();
		}
			
		$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'trim|required');
		$this->form_validation->set_rules('equipment_number', 'Equipment Number', 'trim|required');
		$this->form_validation->set_rules('zone_id', 'Zone id', 'trim|required');

		$this->form_validation->set_error_delimiters('<div class="error-val">', '</div>');	

		if($this->form_validation->run() == TRUE)
		{
			$item_details = array(
										'equipment_name' => strip_tags($this->input->post('equipment_name')),		
										'zone_id' => strip_tags($this->input->post('zone_id')),		
										'equipment_number' => strip_tags($this->input->post('equipment_number')),										
										'modified'=>date('Y-m-d H:i:s'),									
									);			
			if(!empty($id))
			{											
				$this->db->where('id',$id);
				$this->db->update(EIP_CHECKLISTS,$item_details); //update
			}
			else
				$this->db->insert(EIP_CHECKLISTS,$item_details);
				
			$this->session->set_flashdata('message','Data has been updated successfully.'); 

			redirect($this->data['controller']);
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
        $this->db->update(EIP_CHECKLISTS);
		
		#echo $this->db->last_query(); 
        echo $response; exit;
    }
	
	
	public function ajax_get_eip_checklists()
	{

		error_reporting(0);
		$isolations=$this->public_model->get_data(array('table'=>ISOLATION,'select'=>'name,id,record_type,isolation_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'));
		
		
		$isolations=$isolations->result_array();

		$zone_id=$this->input->post('zone_id');

		$fetch=$this->public_model->get_data(array('table'=>EIP_CHECKLISTS,'select'=>'equipment_name,id,equipment_number','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND zone_id="'.$zone_id.'" AND equipment_number!=""','column'=>'equipment_name','dir'=>'asc'));
		
		$num_rows=$fetch->num_rows();

		$checklists=$fetch->result_array();

		$equipment_descriptions=(isset($_POST['equipment_descriptions'])) ? json_decode($_POST['equipment_descriptions']) : array();

		$equipment_tag_nos=(isset($_POST['equipment_tag_nos'])) ? json_decode($_POST['equipment_tag_nos']) : array();

		$isolate_types=(isset($_POST['isolate_types'])) ? json_decode($_POST['isolate_types']) : array();

		$equipment_remarks=(isset($_POST['equipment_remarks'])) ? json_decode($_POST['equipment_remarks']) : array();

		$equipment_radio=(isset($_POST['equipment_radio'])) ? json_decode($_POST['equipment_radio']) : array();

		$remarks_issuing_approval=(isset($_POST['remarks_issuing_approval'])) ? $_POST['remarks_issuing_approval'] : '';

		$count=0;

		#echo '<pre>'; print_r($equipment_descriptions);

		if(isset($equipment_descriptions))
			$count=count($equipment_descriptions);

		#echo '<pre>'; print_r($equipment_descriptions);

		#echo '<br /> count '.$count;

		$disable_all=($remarks_issuing_approval=='Yes') ? "disabled='disabled'" : '';
		
		if($num_rows>0)
		{
			$rows='<TR>
	        <TD colspan=2 class="tr8 td25"><P style="text-align:center;">Yes/No</P></TD>
	        <TD colspan=3 class="tr8 td25 border_right"><P style="text-align:center;">Description of Equipment</P></TD>
	        <TD colspan=2 class="tr8 td25"><P style="text-align:center;">Equipment Tag No.</P></TD>
	        <TD colspan=3 class="tr8 td25 "><P style="text-align:center;">Isolation Type</P></TD>
	        <TD colspan=2 class="tr8 td25 remove_border_right"><P style="text-align:center;">Remarks</P></TD>
	    	</TR>';

			for($i=1;$i<=$num_rows;$i++)
			{
				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment='';

				$disabled="disabled='disabled'"; $radio_yes_check="checked='checked'";

				$radio_check='Yes';

				if($count>0)
				{
					$radio_check=(isset($equipment_radio->$i)) ? $equipment_radio->$i : 'Yes';

					#echo '<br /> Radio '.$radio_check;

					if($radio_check=='Yes')
						$radio_yes_check="checked='checked'";
					else
					{	$radio_no_check="checked='checked'"; $radio_yes_check='';	$disabled=''; }	

					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';

				}

				if($disable_all!='')
					$disabled=$disable_all;

				$gen_checklist=$this->generate_checklists($checklists,$i,$description_equipment,$count,$disable_all);

				$generate_checklist=$gen_checklist['select'];

				$equipment_number=$gen_checklist['equipment_number'];

				$generate_isolations=$this->generate_isolations($isolations,$i,$type_isolation,$disable_all,$radio_check);

				$remarks=(isset($equipment_remarks->$i)) ? $equipment_remarks->$i : '';

				$input="<input type='radio' data-type='radio' data-id='".$i."' ".$disable_all." class='is_equipment_radio equipment_radio".$i."' ".$radio_yes_check." name='equipment_radio[".$i."]' value='Yes'/>Yes&nbsp;<input data-type='radio' type='radio' ".$disable_all." class='is_equipment_radio equipment_radio".$i."'  data-id='".$i."' name='equipment_radio[".$i."]' ".$radio_no_check." value='No'/>No ";

				$rows.='<TR><TD colspan=2 class="tr10 td54"><P style="text-align:center;">'.$input.'</P></TD><TD class="tr10 td24 border_right" colspan="3">'.$generate_checklist.'</TD><TD class="tr10 td8 border_right" colspan="2"><input   type="text" readonly class="form-control equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" value="'.$equipment_number.'"  /></td><TD  colspan="3" class="tr10 td56 border_right">'.$generate_isolations.'</td><TD  colspan="2" class="tr10 td56 border_right remove_border_right"><input type="text" class="form-control equipment_remarks'.$i.'" name="equipment_remarks['.$i.']" id="equipment_remarks['.$i.']" value="'.$remarks.'" '.$disabled.'/></td></tr>';
			}

			

			for($i=EIP_CHECKLIST_ADDITIONAL_ROWS_START;$i<=EIP_CHECKLIST_ADDITIONAL_ROWS_END;$i++)
			{
				$radio_yes_check=$radio_no_check=$type_isolation=$description_equipment=$equipment_tag_no='';

				$disabled="disabled='disabled'"; $radio_no_check="checked='checked'";

				$radio_check='No'; $initial=1;

				if($count>0)
				{
					$radio_no_check='';

					$radio_check=(isset($equipment_radio->$i)) ? $equipment_radio->$i : 'Yes';

					#echo '<br /> Radio '.$radio_check;

					if($radio_check=='Yes')
						$radio_yes_check="checked='checked'";
					else
					{	$radio_no_check="checked='checked'";	 }	

					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';

					$equipment_tag_no=(isset($equipment_tag_nos->$i)) ? $equipment_tag_nos->$i : '';

					$initial=2;
				}

				if($initial==2)
				{
					if($disable_all!='')
						$disabled=$disable_all;
				}
				else
				$disable_all='';

				$generate_isolations=$this->generate_isolations($isolations,$i,$type_isolation,$disable_all,$radio_check);

				$remarks=(isset($equipment_remarks->$i)) ? $equipment_remarks->$i : '';

				$input="<input type='radio' data-type='text' data-id='".$i."' ".$disable_all." class='is_equipment_radio equipment_radio".$i."' ".$radio_yes_check." name='equipment_radio[".$i."]' value='Yes'/>Yes&nbsp;<input type='radio' ".$disable_all." data-type='text' class='is_equipment_radio equipment_radio".$i."'  data-id='".$i."' name='equipment_radio[".$i."]' ".$radio_no_check." value='No'/>No ";

				if($initial==1)
				{
					if($radio_check=='No')
					{
						$disable_all=$disabled;
					}	
					else
						$disabled='';
				}	

				$rows.='<TR><TD colspan=2 class="tr10 td54"><P style="text-align:center;">'.$input.'</P></TD><TD class="tr10 td24 border_right" colspan="3"><input type="text" class="form-control equipment_descriptions'.$i.'" value="'.$description_equipment.'"  name="equipment_descriptions['.$i.']" id="equipment_descriptions['.$i.']" '.$disable_all.' /></TD><TD class="tr10 td8 border_right" colspan="2"><input   type="text"  class="form-control equipment_tag_no'.$i.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" value="'.$equipment_tag_no.'"  '.$disable_all.'/></td><TD  colspan="3" class="tr10 td56 border_right">'.$generate_isolations.'</td><TD  colspan="2" class="tr10 td56 border_right remove_border_right"><input type="text" class="form-control equipment_remarks'.$i.'" name="equipment_remarks['.$i.']" id="equipment_remarks['.$i.']" value="'.$remarks.'" '.$disabled.'/></td></tr>';
			}

		}
		else
		{
			$rows='<TR>
        <TD colspan=2 class="tr8 td25"><P style="text-align:center;">S.No</P></TD>
        <TD colspan=3 class="tr8 td25 border_right"><P style="text-align:center;">Description of Equipment</P></TD>
        <TD colspan=4 class="tr8 td25"><P style="text-align:center;">Equipment Tag No.</P></TD>
        <TD colspan=3 class="tr8 td25 "><P style="text-align:center;">Isolation Type</P></TD>
   		 </TR>';

   		 	#echo '<pre>'; print_r($equipment_descriptions);

			for($i=1;$i<=EIP_CHECKLIST_MAX_ROWS;$i++)
			{

				$radio_yes_check=$radio_no_check=$description_equipment=$type_isolation=$equipment_tag_no='';

				if($count>0)
				{
					$description_equipment=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

					$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';

					$equipment_tag_no=(isset($equipment_tag_nos->$i)) ? $equipment_tag_nos->$i : '';

					if($disable_all!='' && $description_equipment=='' && $type_isolation=='')
						break;
				}

				$generate_isolations=$this->generate_isolations($isolations,$i,$type_isolation,$disable_all);


				$rows.='<TR><TD colspan=2 class="tr10 td54"><P style="text-align:center;">'.$i.'</P></TD><TD class="tr10 td24 border_right" colspan="3"><input type="text" class="form-control" value="'.$description_equipment.'" name="equipment_descriptions['.$i.']" id="equipment_descriptions['.$i.']" '.$disable_all.' /></TD><TD class="tr10 td8 border_right" colspan="4"><input   type="text"  class="form-control" value="'.$equipment_tag_no.'" name="equipment_tag_nos['.$i.']" id="equipment_tag_no['.$i.']" '.$disable_all.'/></td><TD  colspan="3" class="tr10 td56 border_right remove_border_right">'.$generate_isolations.'</td></tr>';
			}	
		}


		echo json_encode(array('rows'=>$rows,'zone_id'=>$zone_id,'num_rows'=>$num_rows)); exit;
	}

	public function generate_checklists($checklists,$i,$selected_checklist='',$is_existing_selection,$disable_all)
	{
		$select='<select name="equipment_descriptions['.$i.']" '.$disable_all.' id="equipment_descriptions['.$i.']" class="form-control equipment_descriptions'.$i.' equip_desc" data-id="'.$i.'">';		//<option value="" selected="selected">- - Select - -</option>

		$j=1;

		$eq_number='';

		foreach($checklists as $fet)
		{							  
			$id=$fet['id'];
			  
			$name=$fet['equipment_name'];

			$equipment_number=$fet['equipment_number'];
			  
			$chk='';
			 
			 if($is_existing_selection>0)
			 {
			 	if($selected_checklist==$id) $chk='selected';
			 }
			 else
			 { 
				 if($j==$i) $chk='selected';
			 }	
			
			if($chk!='')
			$eq_number=$equipment_number;		

			$select.='<option value="'.$id.'" '.$chk.' data-eq-no='.$equipment_number.'>'.$name.'</option>';

			$j++;

		 }

		 $select.='</select>';	

		 return array('select'=>$select,'equipment_number'=>$eq_number);;
	}

	public function generate_isolations($isolations,$i,$isolate_type='',$disable_all,$radio_check='')
	{

		#echo '<pre>'; print_r($isolations);

		if($radio_check=='No')
			$disable_all='disabled';

		$select='<select name="isolate_types['.$i.']" '.$disable_all.' id="isolate_type['.$i.']" class="form-control isolate_type'.$i.'" data-id="'.$i.'"><option value="" selected="selected">- - Select - -</option>';

		 foreach($isolations as $fet)
		 {
	 		  $record_type=$fet['record_type'];
											  
			  $id=$fet['id'];
			  
			  $name=$fet['name'];
			  
			  $chk='';
			  
			  if($record_type=='isolation_type')
			  {
					if($isolate_type==$id) $chk='selected';

	 				$select.='<option value="'.$id.'" '.$chk.'>'.$name.'</option>';
	 		  }	

		 }

		 $select.='</select>';	

		 return $select;
	}

	public function ajax_get_sop_wi()
	{
		$file_name=$this->input->post('file_name');

		$ret='<embed src="'.$file_name.'" frameborder="0" width="100%" height="800px"  class="show_image" id="show_image_emb">';

		echo json_encode(array('response'=>$ret));

		exit;
	}
}
?>
