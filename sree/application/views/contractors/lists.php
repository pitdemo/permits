<?php $this->load->view('layouts/admin_header',array('page_name'=>'Listing')); 

$plant_types=$this->plant_types;

?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
</style>
<!-- start: Content -->

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i><?php echo ucfirst(rtrim($this->data['controller'],'/')); ?></a></li>
                                <li class="active"><a href="javascript:void(0);">Listing</a></li>
                            </ul>
                        
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-lg-12">


                        
                            
                                    <!--progress bar start-->
                                    <section class="panel">
        <div class="panel-body">
            <?php $this->load->view('layouts/msg'); ?>
            <a href="<?php echo base_url().$this->data['controller'].'form/'; ?>" role="button" class="pull-right btn btn btn-success"><i class="fa fa-pencil"></i>Create</a>
            <div>&nbsp;</div>
          <div id="no-more-tables" class="overflow768">

           <div class="row">    
                  <div class="col-sm-3">
                          <b>Search by</b>   <select class="form-control plant_type">
                                  <option value="">- - Show All - - </option>
                                  <?php
                                      foreach($plant_types as $key => $plant){?>
                                  <option value="<?php echo $key;?>" <?php if(isset($selected_plant_type) && $selected_plant_type==$key) { ?> selected="selected" <?php } ?>><?php echo $plant;?></option>
                                  <?php } ?>
                              </select>                        
                  </div>     
           </div>

            <table class="table custom-table table-striped" id="table"
						           data-toggle="table"
					               data-pagination="true"
								   data-search="true"
								   data-sort-name="name" 
                                   data-sort-order="asc"
					               data-page-list="[5, 10, 20, 50, 100, 200]">
              <thead>
                <tr>
                	<th data-field='chk_box' width="20px;" class="bg-img-none" ><input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                     
                   <th data-field='name' width="210px" data-sortable="true">Name</th>
                   <th data-field='contact_no' width="210px" data-sortable="true">Contact no</th>
                   <th data-field='plant_type' width="210px" data-sortable="true">Plant Type</th>
                  <th data-field='status' class="center" width="70px">Status</th>
                  <th data-field='action' class="center" width="150px">Action</th>
                </tr>
              </thead>
              
 				 <tbody>
                  <?php
				  if($contractors->num_rows()>0)
				  {
					 $contractors=$contractors->result_array();
					 
					 $i=0;
					 
					 	foreach($contractors as $department)
						{
							
							$status=$department['status'];
							
							$id=$department['id'];
							
							$contact_no=$department['contact_no'];

              $p_type=$this->plant_types[$department['plant_type']];
							
							switch($status)
							{
								case STATUS_ACTIVE:
												$status_class='success';
												break;	
								case STATUS_INACTIVE:
												$status_class='danger';
												break;	
							}
							
							$chk_box = "<center><input type='checkbox'  name='record[]'  class='checkbox ".$status."'   data-status='".$status."' value='".$id."'><center>";							
							
							$status = '<span class="label label-'.$status_class.'" data-id="'.$id.'" data-status="'.$status.'">'.ucfirst($status)."</span>";						
				  ?>	  
                  		<tr class="<?php echo ($i%2==0) ? 'odd' : 'even'; ?>">
                        <td><?php echo $chk_box; ?></td>
                       
                        <td  style="text-align: center;"><?php echo $department['name']; ?></td>
                        <td  style="text-align: center;"><?php echo $contact_no; ?></td>
                        <td  style="text-align: center;"><?php echo $p_type; ?></td>
                        <td class="" style="text-align: center;"><?php echo $status; ?></td>
                        <td class="" style="text-align: center;"><a href="<?php echo base_url().$this->data['controller'].'form/'.base64_encode($id); ?>">Edit</a></td></tr>
                  <?php	
				  			$i++;
						}
				  }
				 
				  ?>
                  	
				 </tbody>              
        
            </table>            
          

          <div class="col-sm-12 scroll-img  visible-sm"><img src="<?php echo base_url();?>assets/img/scroll-to-view.png"> Drag to scroll</div>
          <div>&nbsp;</div>
          
        </div>   
        
        <div class="col-lg-12 tax-con">
             <a class="btn btn-success update_status"  data-status='active' data-bulk='bulk'>Set as Active</a>
             <a class="btn btn-danger update_status"    data-status='inactive' data-bulk='bulk'>Set as Inactive</a>     
             <a class="btn btn-primary update_status"   data-status='deleted' data-bulk='bulk'>Set as Closed</a>                             
        </div>
                            
      </div>
     
    </div>
    <!--/col--> 
    
  </div>
  <!--/row--> 
  
</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); $this->load->view('layouts/footer'); ?>
<script src="<?php echo base_url(); ?>assets/js/zones.js"></script> 
<script>
    var $table = $('#table');
		$table.bootstrapTable({
		    method: 'post',
		    contentType: 'application/x-www-form-urlencoded',
            //Verifying the data is null or not
            responseHandler:function(res) {
                if(res.rows==null){
                    $table.bootstrapTable('removeAll');
                }
                return res;
            }
		});
</script>
<script>
$(document).ready(function(e) {
    $('.plant_type').on('change',function() {
        window.location='<?php echo base_url().$this->data['controller'].'index/plant_type/'; ?>'+$(this).val(); 
    });
});
</script>