<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permit_checklists extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model'));
	}
	public function index()
	{
		echo 'Yes';

		exit;
	}

    public function ajax_get_permit_checklists()
    {
        $permit_ids = $this->input->post('permit_type_ids');
        $job_id=$this->input->post('job_id');
        $show_button=$this->input->post('show_button');
        $permit_checklists_nums=0;
        $response=''; $disabled='';
        if($permit_ids!='')
        {
            

            $permit_types = $this->public_model->get_data(array('table'=>PERMITSTYPES,'select'=>'name,id,objectives,ppes','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id IN('.$permit_ids.')','column'=>'name','dir'=>'asc'));

            $permit_types_nums=$permit_types->num_rows();

            if($permit_types_nums>0)
            {
                $fetch_permit_types=$permit_types->result_array();

                $jobs_checklists_values = $jobs_ppes_values = $additional_infos = array();
                
                if($job_id>0)
                {
                    $jobs_checklists=$this->public_model->join_fetch_data(array('select'=>'jp.checklists,jp.ppes,jp.additional_info,j.id,j.approval_status,j.status','table1'=>JOBSPRECAUTIONS.' jp','table2'=>JOBS.' j','join_type'=>'inner','join_on'=>'jp.job_id=j.id','where'=>'jp.job_id="'.$job_id.'"','num_rows'=>false));


                        if($jobs_checklists->num_rows()>0) {
                            $fetch_jobs_checklists=$jobs_checklists->row_array();

                            $jobs_checklists_values=$fetch_jobs_checklists['checklists']!='' ? json_decode($fetch_jobs_checklists['checklists'],true) : array();

                            $jobs_ppes_values=$fetch_jobs_checklists['ppes']!='' ? json_decode($fetch_jobs_checklists['ppes'],true) : array();

                            $additional_infos = $fetch_jobs_checklists['additional_info']!='' ? json_decode($fetch_jobs_checklists['additional_info'],true) : array();

                            $jobs_status=$fetch_jobs_checklists['status'];

                            if(in_array($jobs_status,array(STATUS_CANCELLATION)) || $show_button=='hide')
                            $disabled='disabled';

                        }
                }

                    foreach($fetch_permit_types as $permit_type):

                        $permit_id=$permit_type['id'];
                        $objectives = $permit_type['objectives'];
                        $ppes=$permit_type['ppes']!='' ? json_decode($permit_type['ppes'],true) : array();

                        $permit_checklists = $this->public_model->get_data(array('table'=>PERMITS_CHECKLISTS,'select'=>'name,id,additional_inputs,input_infos','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND permit_type_id IN('.$permit_id.')','column'=>'name','dir'=>'asc'));
                        $permit_checklists_nums=$permit_checklists->num_rows();

                                if($permit_checklists_nums>0)
                                {
                                        $fetch_permit_checklists=$permit_checklists->result_array();
                                        $permit_checklists_nums=$permit_checklists_nums/2;
                                        $permit_checklists_nums_round=round($permit_checklists_nums);

                                        $response.='<div class="row">
                                                    <div class="col-md-4 col-xl-12">
                                                        <div class="mb-3">
                                                        <label class="form-label text-red">Objective: '.$objectives.'</label>  
                                                        </div>
                                                    </div>
                                        </div>';
                                        $response.='<span style="display:none;" id="precautions_mandatory_total">'.$permit_checklists_nums.'</span>';

                                        //Start checklists rows
                                        $response.='<div class="row">';
                                        $response.='<div class="col-md-6 col-xl-6"><div class="mb-3">';
                                        
                                        
                                        $rows=0; $total_rows=0;
                                        $response.='<table class="table mb-0" border="1">
                                        <tbody>
                                            <tr>
                                                <th width="4%" colspan="2">Yes <span style="padding-left:25px;">No</span> <span style="padding-left:25px;">NA</span></th>
                                                <th width="7%">Precautions</th>
                                            </tr>';
                                        foreach($fetch_permit_checklists as $checklists):

                                            $key=$checklists['id'];
                                            $label=$checklists['name'];

                                            $data = (isset($jobs_checklists_values[$key])) ? $jobs_checklists_values[$key] : '';

                                            $y_checked = $data=='y' ? "checked='checked'" : '';
                                            $n_checked = $data=='n' ? "checked='checked'" : '';
                                            $na_checked = $data=='na' ? "checked='checked'" : '';

                                        
                                        $response.='<tr>
                                            <td colspan="2"> 
                                            <label class="form-check form-check-inline">
                                            <input class="form-check-input checklists" type="radio" 
                                            value="y" name="checklists['.$key.']" '.$y_checked.' '.$disabled.'>
                                            </label>
                                            <label class="form-check form-check-inline">
                                            <input class="form-check-input checklists" type="radio" 
                                            value="n" name="checklists['.$key.']" '.$n_checked.' '.$disabled.'>
                                            </label>
                                            <label class="form-check form-check-inline">
                                            <input class="form-check-input checklists" type="radio" 
                                            value="na" name="checklists['.$key.']" '.$na_checked.' '.$disabled.'>
                                            </label>
                                            </td>
                                            <td> 
                                            '.$label.'
                                            </td>
                                            </tr>';
                                            $rows++; $total_rows++;

                                        //Create a new set of the second table
                                        if($rows>=$permit_checklists_nums_round && $total_rows!=$permit_checklists_nums){

                                            $rows=0;

                                            $response.='</tbody></table></div></div>';
                                            $response.='<div class="col-md-6 col-xl-6"><div class="mb-3">';
                                            $response.='<table class="table mb-0" border="1">
                                            <tbody>
                                            <tr>
                                                <th width="4%" colspan="2">Yes <span style="padding-left:25px;">No</span> <span style="padding-left:25px;">NA</span></th>
                                                <th width="7%">Precautions</th>
                                            </tr>';

                                        }

                                        endforeach;
                                        $response.='</tbody></table>';
                                        $response.='</div></div>';
                                        $response.='</div>';

                                        //PPE's
                                        $response.='<div class="row">';
                                
                                        if(count($ppes)>0) {

                                            $ppes=implode(',',$ppes);

                                            $ppes = $this->public_model->get_data(array('table'=>PPE,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id IN ('.$ppes.')','column'=>'name','dir'=>'asc'));

                                            if($ppes->num_rows()>0)
                                            {
                                                $ppes_fetch=$ppes->result_array();

                                                $response.='<div class="col-md-6 col-xl-6"><div class="mb-3">';
                                                $response.='<table class="table mb-0" border="1">
                                                    <tbody>
                                                    <tr>
                                                            <th width="4%" colspan="2">Yes <span style="padding-left:25px;">No</span> <span style="padding-left:25px;">NA</span></th>
                                                            <th width="7%">PPEs Provided</th>
                                                    </tr>';
                                                    foreach($ppes_fetch as $checklists):

                                                        $key=$checklists['id'];
                                                        $label=$checklists['name'];

                                                        $data = (isset($jobs_ppes_values[$permit_id.$key])) ? $jobs_ppes_values[$permit_id.$key] : '';

                                                        $y_checked = $data=='y' ? "checked='checked'" : '';
                                                        $n_checked = $data=='n' ? "checked='checked'" : '';
                                                        $na_checked = $data=='na' ? "checked='checked'" : '';

                                                        $response.='<tr>
                                                        <td colspan="2"> 
                                                        <label class="form-check form-check-inline">
                                                        <input class="form-check-input ppes" type="radio" 
                                                        value="y" name="ppes['.$permit_id.$key.']"  '.$y_checked.' '.$disabled.'>
                                                        </label>
                                                        <label class="form-check form-check-inline">
                                                        <input class="form-check-input ppes" type="radio" 
                                                        value="n" name="ppes['.$permit_id.$key.']" '.$n_checked.' '.$disabled.'>
                                                        </label>
                                                        <label class="form-check form-check-inline">
                                                        <input class="form-check-input ppes" type="radio" 
                                                        value="na" name="ppes['.$permit_id.$key.']" '.$na_checked.' '.$disabled.'>
                                                        </label>
                                                        </td>
                                                        <td> 
                                                        '.$label.'
                                                        </td>
                                                </tr>';

                                                    endforeach;

                                                    $response.='</tbody></table>';
                                                    $response.='</div></div>';

                                            }

                                            $additional_info = (isset($additional_infos[$permit_id])) ? $additional_infos[$permit_id] : '';

                                            //Other Info
                                            $response.='<div class="col-md-6 col-xl-6"><div class="mb-3">';
                                            $response.='<label class="form-check" style="padding-left:0px;">
                                            <label class="form-label">Additional Info(If any)</label>
                                            <textarea rows="3" class="form-control" placeholder="Here can be your additional info" name="additional_info['.$permit_id.']" '.$disabled.'>'.$additional_info.'</textarea>
                                            </label>';
                                            $response.='</div></div>';

                                        }
                                }

                   endforeach;

            }
        }
        echo json_encode(array('response'=>$response,'num_rows'=>$permit_checklists_nums)); exit;

    }
	
}