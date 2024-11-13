<?php $this->load->view('layouts/admin_header',array('page_name'=>'Listing')); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>Checklists</a></li>
                                <li><a href="javascript:void(0);">Permits</a></li>
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
                                         
                                         <a href="<?php echo base_url().$this->data['controller'].'permit_checklists/'; ?>" role="button" class="pull-right btn btn btn-success">Checklists</a>
										 <div>&nbsp;</div>
	            <table class="table custom-table table-striped" id="table"
						           data-toggle="table"
					               data-pagination="true"
								   data-search="true"
								   data-sort-name="name" 
                                   data-sort-order="asc"
                                    data-page-size="20"   
					               data-page-list="[5, 10, 20, 50, 100, 200]">
              <thead>
                <tr>
                	<th data-field='chk_box' width="20px;" class="bg-img-none" >
                    <input type="checkbox" name="checkbox1"  class='bulk_action'></th>
                   <th data-field='company_name'  data-sortable="true">Name</th>
                   <th data-field='objectives' width="210px" data-sortable="true">Objectives</th>
                   <th data-field='ppe' width="210px" data-sortable="true">PPE's</th>
                  <th data-field='status' class="center" width="70px">Status</th>
                  <th data-field='action' class="center" width="150px">Action</th>
                </tr>
              </thead>
              
 				 <tbody>
                  <?php
					 	foreach($data as $department)
						{
							
                            $i=0;

							$status=$department['status'];

                            $objectives=$department['objectives'];
							
							$id=$department['id'];
							
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
                        <td><?php echo $objectives; ?></td>
                        <td>&nbsp;</td>
                        <td class="" style="text-align: center;"><?php echo $status; ?></td>
                        <td class="" style="text-align: center;"><a href="<?php echo base_url().$this->data['controller'].'permit_form/'.base64_encode($id); ?>">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo base_url().$this->data['controller'].'permit_checklists/permit_id/'.$id; ?>" style="color:red;">Checklists</a></td></tr>
                  <?php	
				  			$i++;
						}
				 
				 
				  ?>
                  	
				 </tbody>              
        
            </table>                       
            
            <div>&nbsp;</div>
        <div class="col-lg-12 tax-con">
             <a class="btn btn-success update_status"  data-status='active' data-bulk='bulk'>Set as Active</a>
             <a class="btn btn-danger update_status"    data-status='inactive' data-bulk='bulk'>Set as Inactive</a>             
        </div>
                                  
                                            
                                            
                                        </div>
                                    </section>
                                    <!--progress bar end-->

                              

                            
                        </div>
                    </div>

                </section>
            </div>
            <!-- Right side column. Contains the navbar and content of the page -->
            
        </div>
<script src="<?php echo base_url(); ?>assets/js/checklists.js"></script>        
<?php $this->load->view('layouts/footer'); ?>        