<?php $this->load->view('layouts/header',array('page_name'=>'Listing')); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">
<div class="right-side strech">
  <section class="content">
      <div class="row">
          <div class="col-md-12">
              <!--breadcrumbs start -->
              <ul class="breadcrumb">
                  <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>EIP's</a></li>
                  <li class="active"><a href="javascript:void(0);" id="bread_crumb"><?php echo $filters['filter_status']; ?></a></li>
              </ul>
          
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
                      <!--progress bar start-->
                      <section class="panel">
                          <div class="panel-body ">
<?php $this->load->view('layouts/msg'); $this->load->view('layouts/marquee'); $status_arr=array('PA'=>'Performing Authority','IA'=>'Issuing Authority','Isolation'=>'Isolations','All'=>'All'); $active=''; ?>
        <ul class="nav tab-menu nav-tabs" id="myTab">
        <?php
                              $s=0;
                              #$status_arr=unserialize(CLOSED_PERMITS);
        foreach($status_arr as $status => $status_name)
        {
        ?>
        
        <li <?php echo ($s==0) ? 'class="active"' : ''; ?>><a href="#<?php echo $status; ?>" data-status="<?php echo $status; ?>"><?php echo ucfirst($status_name); ?></a></li>
            
        <?php 
          $s++;
        }
                              ?>
                    </ul>
                          <div class="panel-body">
                                    <div id="myTabContent" class="tab-content">
                                        <?php
                                        foreach($status_arr as $status => $status_name)
                                        {
                if($filters['filter_status']==$status)
                $active='active';
                else
                $active='';
                
                $params_url=(isset($filters[$status.'approval_status'])) ? $filters[$status.'approval_status'] : '';
                
                $zone_id=(isset($filters[$status.'zone_id'])) ? $filters[$status.'zone_id'] : '';
                
                $subscription_date_start = (isset($filters[$status.'subscription_date_start'])) ? $filters[$status.'subscription_date_start'] : date('d/m/Y',strtotime("-30 days"));
                $subscription_date_end = (isset($filters[$status.'subscription_date_end'])) ? $filters[$status.'subscription_date_end'] : date('Y/m/d',strtotime("+30 days"));
                                        ?>      
                                        <input type="hidden" id="<?php echo $status; ?>_role" value="<?php echo $params_url; ?>" />
                                          <div class="tab-pane <?php echo $active; ?>" id="<?php echo $status; ?>">
                                          
                                              <div class="filters">
                                                      <form role="form" id="<?php echo $status; ?>_form" name="<?php echo $status; ?>_form" method="post">
                                                      
                                                          <div class="row">
                                                          
                                                            <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
                                                                    <div class="form-group">
                                                                    <label class="control-label labeledit" for="date01">Permit Start Date</label>
                                                                    <div class="controls">
                                                                        <div class="input-group date">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                            <input type="text" class="form-control date-picker" name="<?php echo $status; ?>subscription_date_start" id="<?php echo $status; ?>subscription_date_start" data-date-format="dd/mm/yyyy" readonly value="<?php echo $subscription_date_start; ?>">
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
                                                                            <input type="text" class="form-control date-picker" name="<?php echo $status; ?>subscription_date_end" id="<?php echo $status; ?>subscription_date_end" data-date-format="dd/mm/yyyy" readonly value="<?php echo $subscription_date_end; ?>">
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                                </div>
                                                                
                                                              <div class="col-lg-2 col-md-2 col-sm-6 width117">
                                                                  <div class="form-group">
                                                                      <label for="status" class="edit-label">Select Zone</label>
                                                                          <select class="form-control" name="zone_id" id="zone_id" style="width:200px;">
                                                                                  <option value="">- - Select Zone - - </option>
                                                                                  <?php   
                                                                                            foreach($zones as $list)
                                                                                            {
                                                                                  ?>
                                                                                  <option value="<?php echo $list['id'];?>" <?php if($zone_id==$list['id']) { ?> selected="selected" <?php } ?> ><?php echo $list['name'];?></option>
                                                                                  <?php 
                                                                                              }
                                                                                  ?>
                                                            </select> 
                                                                  </div>
                                                                </div>
                                                              
                                                            <div class="col-lg-2 col-md-1 col-sm-2 col-xs-3 full-width">
                                                                <div class="form-group">
                                                                              <label for="search" class="none invisible edit-label ">Search</label>
                                                                                <div class="clearfix"></div>
                                                                              <button class="btn btn1 search_data" type="button" data-form-name="<?php echo $status; ?>"><i class="fa fa-search"></i> <span class="text-hidden">Search</span></button>&nbsp;<a href="javascript:void(0);"  style="padding-top:10px;" class="reset" data-status="<?php echo $status; ?>">Reset</a>
                                                                  </div>
                                                          </div>                                                         
                                                                
                                                                
                                                            </div>       
                                                        </form>       
                                              </div>   
                                              
                                                                                    
                                                      <div id="no-more-tables" class="overflow768">
                                                  <table width="100%" class="table datatable custom-table table-striped select-all " id="<?php echo $status; ?>_table"
                        data-toggle="table"
                        data-hover="true" 
                        data-striped="true" 
                        data-smart-display="true" 
                        data-sort-name="id" 
                        data-sort-order="desc"
                        data-page-size="20"   
                        data-search="true"                            
                        data-pagination="true"
                        data-side-pagination="server"
                        data-export-types="['excel', 'pdf']"
                        data-export-options='{"fileName": "EIP_<?php echo $status_arr[$status]; ?>_report"}'
                        data-show-export="true"
                        data-page-list="[5, 10, 20, 50, 100, 200]">
                                          
                    <thead>
                      <tr>
                          <th data-field='eip_no' width="210px" class="center" data-sortable="true">EIP No</th>
                          <th data-field='section' width="210px" data-sortable="true">Section</th>
                          <th data-field='area' width="100px" data-sortable="true">Area</th>
                          <th data-field='date_start' width="100px">Date Start</th>
                          <th data-field='date_end' width="100px">Date End</th>
                          <th data-field='approval_status' class="center" width="75px">Approval Status</th>
                          <th data-field='waiating_approval_by' class="center" width="75px">Waiting / Last Approved By</th>
                          <th data-field='status' class="center" width="75px">Job Status</th>
                      </tr>
                    </thead>
              
                  </table>                  
                                    </div>
                                          </div>
                                        <?php
                                        }
                                        ?>
                
                                      </div>
    </div>
          
                  </div>       
                      </section>
                      <!--progress bar end-->
                
          </div>
      </div>

  </section>
</div>
<!-- Right side column. Contains the navbar and content of the page -->
<?php $this->load->view('jobs/popup_show_jobs_history_modal'); ?> 
</div>
<?php $this->load->view('layouts/footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.thickbox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.thickbox.css" rel="stylesheet" media="screen" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jobs_isolations.js"></script>
<!-- for datepicker -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ui/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>assets/ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script>

$(document).ready(function()
{
$('.date-picker').datepicker({ 
autoclose: true,
dateFormat: 'dd/mm/yy',
maxDate: '0' 
});

$('body').on('click','.sl_no',function()
{
var isoloation_permit_no=$(this).attr('data-isoloation_permit_no');
var url = "<?php echo base_url(); ?>jobs/ajax_show_energy_info/id/"+isoloation_permit_no+"?TB_iframe=true&keepThis=true&width=1050&height=550";

tb_show("Energy Isolation Permit Form", url);       
}); 

$('#myTab a').click(function (e)
{
e.preventDefault();

$(this).tab('show');

$('.bulk_action').removeAttr('checked');

var attr=$(this).attr('href');

$('#bread_crumb').html(attr);

var $refresh_table=$(attr+'_table');

var status=$(this).attr('data-status');

console.log('AA ' +attr+' - '+$refresh_table);

var i=0;

var params_url='user_role/'+status+'/';

params_url+=$(attr+'_role').val();

$('form#'+status+'_form').find(':input[type=hidden],select,:input[type=text]').each(function ()
{
index= $(this).attr('name');

value= $.trim(encodeURI($(this).val()));

if(value!='' && typeof index!=='undefined' && value!='all')
{ 
if(index==status+'subscription_date_start' || index==status+'subscription_date_end')
value=value.replace(/\//g, '-');

params_url+=index+'/'+value+'/'; i++;

}
});      


$refresh_table.bootstrapTable('refresh', {
method:'post',
responseHandler: function(res) { console.log('Test'); },
url: base_url+'jobs_isolations/ajax_fetch_data/'+params_url
}).on('page-change.bs.table', function (e, size, number) {

//var x=confirm('Are you sure '+size+' , '+number); if(x==false) return false;

//console.log('Event: page-change.bs.table');
}).on('post-body.bs.table', function (data) {
//console.log('Event: '+data);
}).on('all.bs.table', function (e, name, args) {
  // console.log('load-success');
}); 

console.log('SSS '+params_url);

window.history.pushState("", "", '<?php echo base_url().$this->data['controller'];?>index/'+params_url);        
});

$('.search_data').click(function()
{
var form_id=$(this).attr('data-form-name');
//if(form_id=='all')
var params_url='user_role/'+form_id+'/';

var i=0;
//Pushing values in Query Parameters
$('form#'+form_id+'_form').find(':input[type=hidden],select,:input[type=text]').each(function ()
{
index= $(this).attr('name');

value= $.trim(encodeURI($(this).val()));

if(value!='' && typeof index!=='undefined' && value!='all')
{ 
if(index==form_id+'subscription_date_start' || index==form_id+'subscription_date_end')
value=value.replace(/\//g, '-');

params_url+=index+'/'+value+'/'; i++;

}
});
$('#'+form_id+'_table').bootstrapTable('refresh', {
method:'post',
url: base_url+'jobs_isolations/ajax_fetch_data/'+params_url
});   
        
window.history.pushState("", "", '<?php echo base_url().$this->data['controller'];?>index/'+params_url);      
return false;
}); //Filter Form Submit Ends Here


$('a[href=#<?php echo $filters['filter_status']; ?>]').trigger('click');
});
</script>

<!--<script src="<?php echo base_url(); ?>assets/js/jspdf.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jspdf.plugin.autotable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-table-export.js"></script>
<script src="<?php echo base_url(); ?>assets/js/tableExport.js"></script>-->