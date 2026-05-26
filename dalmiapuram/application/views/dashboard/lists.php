<?php 

$this->load->view('layouts/header',array('page_name'=>'Overview')); ?>

<!-- start: Content -->
<div class="main dashboard-con min-height">
  <div class="row">
    <div class="col-lg-8">
      <h1>Welcome <?php echo ucfirst($this->session->userdata('first_name')); ?></h1>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-6">
          <div class="panel panel-default custom-box column">
            <div class="panel-heading">COMMON PERMITS
              <ul class="head-action pull-right">
                <li><a href="<?php echo base_url(); ?>jobs/"><i class="fa fa-plus"></i><span>Add New</span></a></li>
              </ul>
            </div>
			
            <?php
			$pos='';
			
				if(in_array(1,$status))	
				$pos=array_search(1,$status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs/index/approval_status/1">'.$status_counts[$pos].'</a>';
				}
			?>	
			
            <div class="panel-body">
			
              <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending IA Authorization Permits</span> <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
            <?php
			
			$pos='';
			
				if(in_array(3,$status))	
				$pos=array_search(3,$status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs/day_in_process/approval_status/3">'.$status_counts[$pos].'</a>';
				}
			
			?>
            <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending IA Completion Permits</span> 
            <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            </div>
			
            
		<div class="panel-body">
        
        <?php
		
			$pos='';
			
				if(in_array(4,$status))	
				$pos=array_search(4,$status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs/closed_permits/approval_status/4/">'.$status_counts[$pos].'</a>';
				}
		?>		
			
              <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Competed Permits</span> <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
        <?php
		
			$pos='';
			
				if(in_array(7,$status))	
				$pos=array_search(7,$status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs/day_in_process/approval_status/7">'.$status_counts[$pos].'</a>';
				}
		?>		
            
            <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending IA Extended Permits</span> 
            <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
            </div>            
			
		
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 col-sm-6">
          <div class="panel panel-default custom-box edit-con column">
            <div class="panel-heading">EIP
              <ul class="head-action pull-right">
                <li><a href="<?php echo base_url(); ?>jobs_isolations/" title="View All">View All</a></li>
              </ul>
            </div>
            <div class="panel-body">
            
           <div class="panel-body">
			
            <?php
			
			$pos='';
			
				if(in_array(1,$eip_status))	
				$pos=array_search(1,$eip_status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($eip_status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs_isolations/index/user_role/IA/approval_status/1">'.$eip_status_counts[$pos].'</a>';
				}
			
			?>
            
              <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending (B) Section</span> 
              <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
            
            <?php
			
			$pos='';
			
				if(in_array(3,$eip_status))	
				$pos=array_search(3,$eip_status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($eip_status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs_isolations/index/user_role/Isolation/approval_status/3">'.$eip_status_counts[$pos].'</a>';
				}
			
			?>
            
            <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending Isolator</span> 
            <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
            </div>
            
            <div class="panel-body">
            
           <?php
			
			$pos='';
			
				if(in_array(5,$eip_status))	
				$pos=array_search(5,$eip_status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($eip_status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs_isolations/index/user_role/PA/approval_status/5">'.$eip_status_counts[$pos].'</a>';
				}
			
			?>
            
			
              <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending (D) Section</span> 
              <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
           <?php
			
			$pos='';
			
				if(in_array(8,$eip_status))	
				$pos=array_search(8,$eip_status);
				
				$pending_ia_authorization_permits=0;
				
				if($pos>=0)
				{
					if(isset($eip_status_counts[$pos])>0)	
					$pending_ia_authorization_permits='<a href="'.base_url().'jobs_isolations/index/user_role/All/approval_status/8">'.$eip_status_counts[$pos].'</a>';
				}
			
			?>
            
            <div class="col-lg-6 col-sm-6 col-xs-6"> <span class="custom-label">Pending (G) Work Completion</span> 
            <span class="custom-value"><?php echo $pending_ia_authorization_permits; ?></span> </div>
            
            </div>
              
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <!--/col-->
    
    
    <!--/.col--> 
    
  </div>
  <!--/row--> 
  
</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); ?>



<script type="text/javascript">
		
		function equalHeight(group) {
		 tallest = 0;
		 group.each(function() {
		  thisHeight = $(this).height();
		  if(thisHeight > tallest) {
		   tallest = thisHeight;
		  }
		 });
		 group.height(tallest);
		}
		$(document).ready(function() {
		 equalHeight($(".column"));
		 equalHeight($(".column-2"));
		});
		</script>

<?php $this->load->view('layouts/footer'); ?>