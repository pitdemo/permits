<?php

$zones = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();

function dropdown($master_data,$selected_data)
{
    $return='';

    $selected_data=explode(',',$selected_data);

    foreach($master_data as $data):

      $sel = in_array($data['id'],$selected_data) ? 'selected' : '';

      $return.='<option value="'.$data['id'].'" '.$sel.'>'.$data['name'].'</option>';

    endforeach;

    return $return;

}

function dropdown_status($master_data,$selected_data)
{
    $return='';

    $selected_data=explode(',',$selected_data);

    foreach($master_data as $key => $data):

      $sel = in_array($key,$selected_data) ? 'selected' : '';

      $return.='<option value="'.$key.'" '.$sel.'>'.$data.'</option>';

    endforeach;

    return $return;

}

?>


<form role="form" id="form" name="form" method="post">
    <div class="row row-cards">
        <div class="col-12"> 
            <div class="col-sm-3 col-md-2">
                <div class="mb-3">
                <label class="form-label"><b>Zones</b></label>
                <select name="zone_ids" id="zone_ids" class="form-control select2" multiple>
                    <?php echo dropdown($zones,(isset($filters['zone_ids']) && $filters['zone_ids']!='') ? $filters['zone_ids'] : ''); ?>
                </select>
                </div>
            </div> 
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label"><b>Start Date</b></label>
                    <div class="input-group date">
                        <input type="text" class="form-control date-picker" name="<?php #echo $status; ?>subscription_date_start" id="<?php #echo $status; ?>subscription_date_start" data-date-format="dd/mm/yyyy" readonly value="<?php echo (isset($filters['subscription_date_start']) && $filters['subscription_date_start']!='') ? date('d/m/Y',strtotime($filters['subscription_date_start'])) : ''; ?>">
                        <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                            </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-2">
                <div class="mb-3">
                <label class="form-label"><b>End Date</b></label>
                <div class="input-icon mb-2">
                        <input type="text" class="form-control date-picker" name="<?php #echo $status; ?>subscription_date_end" id="<?php #echo $status; ?>subscription_date_end" data-date-format="dd/mm/yyyy" readonly value="<?php echo (isset($filters['subscription_date_end']) && $filters['subscription_date_end']!='') ? date('d/m/Y',strtotime($filters['subscription_date_end'])) : ''; ?>" >
                        <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-1">
                <div class="mb-3">
                <label for="search" class="none invisible edit-label ">Search</label>
                <div class="clearfix"></div>
                <button class="form-control search_data" type="button" data-form-name="form" data-params="<?php echo $ajax_paging_params; ?>"><i class="fa fa-search"></i> <span class="text-hidden">Search</span></button>&nbsp;<a href="javascript:void(0);"  style="padding-top:10px;" data-params="<?php echo $ajax_paging_params; ?>" data-url="<?php echo base_url().$this->data['controller'].'/'.$this->router->fetch_method(); ?>" class="reset">Reset</a>
                </div>
            </div>
        </div>
    </div>
</form> 
<div class="row">&nbsp;</div>