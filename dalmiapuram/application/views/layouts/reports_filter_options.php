<?php
    $zone_id=(isset($filters[$status.'zone_id'])) ? explode(',',$filters[$status.'zone_id']) : array();

    $department_id=(isset($filters[$status.'department_id'])) ? explode(',',$filters[$status.'department_id']) : array();

    $user_id=(isset($filters[$status.'user_id'])) ? explode(',',$filters[$status.'user_id']) : array();
    
    $approval_status=(isset($filters[$status.'approval_status'])) ? explode(',',$filters[$status.'approval_status']) : array();

    $contractor_id=(isset($filters[$status.'contractor_id'])) ? explode(',',$filters[$status.'contractor_id']) : array();


    $subscription_date_start=(isset($filters[$status.'subscription_date_start'])) ? $filters[$status.'subscription_date_start'] : date('d/m/Y',strtotime("-30 days"));

    $subscription_date_end=(isset($filters[$status.'subscription_date_end'])) ? $filters[$status.'subscription_date_end'] : date('d/m/Y'); 

    $flammables=(isset($filters[$status.'flammables'])) ? $filters[$status.'flammables'] : '';

    $selected_work_types=(isset($filters[$status.'work_types'])) ? $filters[$status.'work_types'] : '';

    $selected_is_peptalk=(isset($filters[$status.'is_peptalk'])) ? $filters[$status.'is_peptalk'] : '';

?>
<div class="filters">
      <form role="form" id="<?php echo $status; ?>_form" name="<?php echo $status; ?>_form" data-ajax-url="<?php echo base_url().$this->data['controller'].'ajax_'.$this->data['method'].'_fetch_data/'; ?>" data-url="<?php echo base_url().$this->data['controller'].$this->data['method'].'/'; ?>" method="post">
            <div class="row">
                <div class="col-lg-4 col-md-2 col-sm-6 width117">
                    <div class="form-group">
                        <label for="status" class="edit-label">Zones</label><br />
             					      <select class="form-control select2" multiple="multiple" name="zone_id" id="zone_id" style="width:400px;">
                                      
                                      <?php 	
                                                foreach($zones as $list)
                                                {
                                      ?>
                                      <option value="<?php echo $list['id'];?>" 
                                        <?php if(in_array($list['id'],$zone_id)) { ?> selected="selected" <?php } ?> ><?php echo $list['name'];?></option>
                                      <?php 
                                                  }
                                      ?>
                            </select> 
           		   </div>
               </div>

               <div class="col-lg-3 col-md-2 col-sm-6 width117">
                  <div class="form-group">
                      <label for="status" class="edit-label">Departments</label>
                        <select class="form-control select2" multiple="multiple" name="department_id" id="department_id" style="width:300px;">          
                                  <?php   
                                            foreach($departments as $list)
                                            {
                                  ?>
                                  <option value="<?php echo $list['id'];?>" 
                                    <?php if(in_array($list['id'],$department_id)) { ?> selected="selected" <?php } ?> ><?php echo $list['name'];?></option>
                                  <?php 
                                            }
                                  ?>
                        </select> 
                 </div>
               </div>

               <div class="col-lg-3 col-md-2 col-sm-6 width117">
                  <div class="form-group">
                      <label for="status" class="edit-label">Users</label>
                        <select class="form-control select2" multiple="multiple" name="user_id" id="user_id" style="width:400px;">          
                                  <?php   
                                            foreach($users as $list)
                                            {
                                  ?>
                                  <option value="<?php echo $list['id'];?>" 
                                    <?php if(in_array($list['id'],$user_id)) { ?> selected="selected" <?php } ?> ><?php echo $list['name'];?></option>
                                  <?php 
                                              }
                                  ?>
                        </select> 
                 </div>
               </div>                          
     </div>       
     <div class="row">    
         <div class="col-lg-2 col-md-2 col-sm-6 width117">
                <div class="form-group">
                <label class="control-label labeledit" for="date01">Permit Start Date</label>
                      <div class="controls">
                          <div class="input-group date">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" class="form-control date-picker" name="subscription_date_start" readonly id="subscription_date_start<?php echo $status; ?>" value="<?php echo $subscription_date_start; ?>">
                          </div>
                      </div>
                </div>
         </div>                                                                              
         <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                   <div class="form-group">
                        <label class="control-label labeledit" for="date01">Permit End Date</label>
                        <div class="controls">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control date-picker" name="subscription_date_end" readonly id="subscription_date_end<?php echo $status; ?>"  value="<?php echo $subscription_date_end; ?>">
                            </div>
                        </div>
                   </div>
           </div>                                                
           <div class="col-lg-3 col-md-6 col-sm-6 width117">
              <div class="form-group">
                  <label for="status" class="edit-label">Contractors</label>
                        <select class="form-control select2" name="contractor_id" id="contractor_id" style="width:300px;" multiple="multiple">
                                        <?php   
                                            foreach($contractors as $list)
                                            {
                                        ?>
                                        <option value="<?php echo $list['id'];?>" 
                      <?php if(in_array($list['id'],$contractor_id)) { ?> selected="selected" <?php } ?> ><?php echo $list['name'];?></option>
                                        <?php 
                                            }
                                        ?>
                        </select> 
             </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 width117">
              <div class="form-group">
                  <label for="status" class="edit-label">Approval Status</label>
                        <select class="form-control select2" name="approval_status" id="approval_status" style="width:300px;" multiple="multiple">
                                        <?php   
                                                 
                                          foreach($job_approvals as $approve_id => $approve_name)
                                                  {
                                        ?>
                                        <option value="<?php echo $approve_id;?>" 
                                          <?php if(in_array($approve_id,$approval_status)) { ?> selected="selected" <?php } ?> ><?php echo $approve_name;?></option>
                                        <?php 
                                                    }
                                        ?>
                        </select> 
             </div>
          </div>                                              
          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-3 full-width">
                  <div class="form-group">
                                <label for="search"  class="none invisible edit-label ">Search</label>
                                 <div class="clearfix"></div>
                                <button class="btn btn1 search_report_data" type="button" data-form-name="<?php echo $status; ?>" ><i class="fa fa-search"></i> <span class="text-hidden">Search</span></button>&nbsp;<a href="javascript:void(0);"  style="padding-top:10px;" class="reset" data-status="<?php echo $status; ?>">Reset</a>
                    </div>
               </div>                                                       
        </div>   

        <?php
        if(isset($is_flammable))
        {

        ?>
        <div class="row">     
             <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                      <div class="form-group">
                           <label class="control-label labeledit" for="date01">Ignition of Flammables</label>
                                <div class="controls">
                                     <select class="form-control select2" name="flammables" id="flammables" >
                                          <option value="" selected="selected"></option>
                                                  <?php
                                                  $a=array(YES,NO);

                                                  foreach($a as $val)
                                                  {
                                                      if($val==$flammables)
                                                       $sel='selected=selected';
                                                        else
                                                        $sel='';  
                                                  ?>
                                                  <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $val; ?></option>    
                                                  <?php
                                                  }
                                                  ?>
                                       </select>         
                               </div>
                     </div>
             </div>  

             <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                              <div class="form-group">
                                                              <label class="control-label labeledit" for="date01">Work Type</label>
                                                              <div class="controls">
                                                                   <select class="form-control work_types select2" name="work_types" id="work_types" multiple="multiple">
                                    <option value="">- - Show All - - </option>
                                    <?php 
                  $work_types=array('height_work','general_work','hot_work');
                                        foreach($work_types as $list)
                    {
                      if(in_array($list,$selected_work_types))
                      $sel='selected=selected';
                      else
                      $sel='';
                  ?>
                                    <option value="<?php echo $list;?>" <?php echo $sel; ?> ><?php echo ucfirst(str_replace('_',' ',$list));?></option>
                                    <?php } ?>
                                </select>         
                                                              </div>
                                                      </div>
                                                          </div>      

            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                 <div class="form-group">
                    <label class="control-label labeledit" for="date01">Peptalk</label>
                      <div class="controls">
                                <select class="form-control select2" name="is_peptalk" id="is_peptalk" >
                                          <option value="" selected="selected" >- - Show All - -</option>
                                                  <?php
                                                  $a=array(YES,NO);

                                                  foreach($a as $val)
                                                  {
                                                      if($val==$selected_is_peptalk)
                                                       $sel='selected=selected';
                                                        else
                                                        $sel='';  
                                                  ?>
                                                  <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $val; ?></option>    
                                                  <?php
                                                  }
                                                  ?>
                                       </select>                              
                      </div>
                    </div>
                 </div>                                                                                              
            </div>  
        <?php
        }
        ?>                 
                         
       
       </form>       
</div>  

  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script><link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

<script type="text/javascript">
$(document).ready(function() { 

    $( ".date-picker" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy',
      maxDate:'0',
      onSelect: function(dateText, inst) { $('#'+$(this).attr('id')).val(dateText); }
    });

});
</script>