<?php $this->load->view('layouts/admin_header',array('page_name'=>'Check Lists')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
</style>
<!-- start: Content -->
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>SOPS/WI</a></li>
                            </ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            
                                    <!--progress bar start-->
                                    <section class="panel">
                                    <div class="panel-body">
                    <?php $this->load->view('layouts/msg'); $plant_types=$this->plant_types; $plant_types=(array_slice($plant_types,0,count($plant_types)-1));

                        $user_instructions=unserialize(USER_INSTRUCTIONS);
                    
                    ?>
                    <a id='create' href="<?php echo base_url().$this->data['controller'].'form/'; ?>" role="button" class="pull-right btn btn btn-success"><i class="fa fa-pencil"></i>Create</a>
                    <div id="no-more-tables" class="overflow768">     
                    
                    <div class="row">    
                        <div class="col-sm-3">
                              <b>Search by</b>   <select name="department_id" id="department_id" class="form-control">
                                    <option value="">- - Show All - - </option>
                                    <?php if(!empty($departments)){

                                        foreach($plant_types as $key => $plant)
                                        {
                                            echo '<optgroup label="'.$plant.'">';
                                                foreach($departments as $list)
                                                {
                                                    if($list['plant_type']==$key)
                                                    {
                                                    ?>
                                            <option value="<?php echo $list['id'];?>" <?php if(isset($id) && $id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                            <?php 
                                                    }
                                                }
                                                echo '</optgroup>';
                                            }
                                        } ?>
                                </select>                        
                       </div>     

                       <div class="col-sm-4" >
                                <b >Record Type</b><br/>  
                                <?php
                                foreach($user_instructions as $key => $user_instruction)
                                {
                                    $chk=$record_type==$key ? 'checked' : '';

                                    echo '<input type="radio" name="record_type" '.$chk.' class="record_type" value="'.$key.'" />&nbsp;'.$user_instruction.'&nbsp;&nbsp;';
                                }
                                ?>
                               
                       </div>    

                        <div class="col-sm-3" >
                                <b >&nbsp;</b><br/>  
                                <input type="button" name="search" id="search" value="Search" class="btn btn-success" />        
                       </div>  

                     </div>  
                        <br>
                        
                        <table class="table custom-table table-striped" id="table"
                                                 data-toggle="table"
                                                 data-pagination="true"
                                                 data-search="true"
                                                 data-cache="false"
                                                 data-sort-name="first_name" 
                                                 data-sort-order="asc"
                                                  data-page-size="20"   
                                                 data-page-list="[5, 10, 20, 50, 100, 200]">
                        <thead>
                            <tr>
                                <th data-field='chk_box' width="20px;" class="bg-img-none" ><input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                                <th data-field='sl_no' width="210px" data-sortable="true">SL NO</th>
                                <th data-field='description' width="100px" data-sortable="true">Description</th>
                                <th data-field='status' width="70px" data-sortable="true">Status</th>
                                <th data-field='action' width="150px">Action</th>
                            </tr>
                        </thead>
                           <tbody>
                              <?php
                              if($checklists->num_rows()>0)
                              {
                                 $checklists=$checklists->result_array();
                                 
                                 $i=0;
                                 
                                    foreach($checklists as $data)
                                    {
                                        $status=$data['status'];
                                        
                                        $id=$data['id'];                                        
                                    
                                        switch($status)
                                        {
                                            case STATUS_ACTIVE:
                                                            $status_class='success';
                                                            break;  
                                            case STATUS_INACTIVE:
                                                            $status_class='danger';
                                                            break;  
                                        }

                                        $path=preg_replace('/[^A-Za-z0-9]/', '',$data['sl_no']);

                                        /*$this->db->where('id',$id);

                                        $this->db->update(SOPS,array('file_name'=>$path.'.pdf'));*/
                                        
                                        $chk_box = "<center><input type='checkbox'  name='record[]'  class='checkbox ".$status."'   data-status='".$status."' value='".$id."'><center>";                            
                                        
                                        $status = '<span class="label label-'.$status_class.'" data-id="'.$id.'" data-status="'.$status.'">'.ucfirst($status)."</span>";                        
                              ?>      
                                    <tr class="<?php echo ($i%2==0) ? 'odd' : 'even'; ?>">
                                    <td><?php echo $chk_box; ?></td>
                                    <td  style="text-align: center;"><?php echo $data['sl_no']; ?></td>
                                    <td  style="text-align: center;"><?php echo wordwrap($data['description'],60,'<br />'); ?></td>
                                    <td class="" style="text-align: center;"><?php echo $status; ?></td>
                                    <td class="" style="text-align: center;">
                                        <a href="<?php echo base_url().$this->data['controller'].'form/'.$id; ?>">Edit</a>
                                    </td></tr>
                              <?php 
                                        $i++;
                                    }
                              }
                             
                              ?>
                                
                             </tbody>              
                        </table>            
                    <div>&nbsp;</div>   

                <div class="col-lg-12 tax-con">
                    <a class="btn btn-success" onclick="change_status(this);" data-url='<?php  echo base_url().$this->data['controller'];?>ajax_update_status' data-status='active' data-bulk='bulk'>Set as Active</a>
                    <a class="btn btn-danger" onclick="change_status(this);" data-url='<?php  echo base_url().$this->data['controller'];?>ajax_update_status' data-status='inactive' data-bulk='bulk'>Set as Inactive</a>
                    <!-- <a class="btn btn-primary" onclick="change_status(this);" data-url='<?php  echo base_url().$this->data['controller'];?>ajax_update_status' data-status='deleted' data-bulk='bulk'>Set as Closed</a>          -->                    
                </div>

            </div>

        </div>
        <!--/col--> 

    </div>
    <!--/row--> 

</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer'); ?>
<script>
    var $table = $('#table');
    var $base_url='<?php echo base_url();?>';
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
 function change_status(ele)
 {
        var ele=$(ele);
        var url=ele.data('url');
        var status_id=ele.data('id');
        // If bulk status change
        if(ele.data('bulk')){            
            if($('.checkbox:checked').length==0){
                alert('Please select atleast one!');
                return false;
            }
            var $ele_text= ele.text();
            var status_id = [];
            $('.checkbox').each(function(){ 
                if(this.checked){
                    status_id.push($(this).val());
                }
            });
        }

        if(confirm('Are you sure change selected records status to '+ele.data('status')+'?'))
        {
                $.ajax({
                    type:"post",
                    url:url,
                    data:{
                        'status':ele.data('status'),
                        'id':status_id                        
                    },
                    beforeSend: function() {
                        if(ele.data('bulk')){                    
                            ele.html('<i class=\"fa fa-dot-circle-o\"></i> Processing');
                        }
                    },
                    success:function(data){
                        if(data=='active'){
                            ele.removeClass('label-danger');
                            ele.addClass('label-success');
                            ele.data('status','active');
                            ele.html('Active');
                        }
                        else if(data=='inactive'){
                            ele.removeClass('label-success');
                            ele.addClass('label-danger');
                            ele.data('status','inactive');
                            ele.html('Inactive');
                        }
                        else if(data=='deleted' || data=='bulk'){   
                             ele.text($ele_text);
                            
                        }       
                        $('.bulk_action').prop('checked',false);
                        window.location=document.URL;
                        return false;   
                    }
                });
        }

    }   
    
    $(document).ready(function(e) 
    {
        
        $('#search').click(function()
        {
            var department_id=$('#department_id').val();

            var record_type=$('.record_type:checked').val();

            var params='/record_type/'+record_type;

            if(department_id!='')
                params=params+'/department_id/'+department_id;

            window.location='<?php echo base_url().$this->data['controller']; ?>index'+params; 

        });

       
    });

  
    </script>