$(document).ready(function() {
	
	$('body').on('click','.update_status',function() {
		
		//console.log('Updated licked');
		$('#update_confirm').html('Are you sure?');
		var status=$(this).attr('data-status');
		
		if($(this).attr('data-checked'))
		var cl='.'+$(this).attr('data-checked');
		else
		var cl='.checkbox';

		 var chked=$(cl+':checked').length;
		 
		 if(chked==0)
		 {
			 $('#gritter_required').trigger('click');
			
			return false; 
		 }
		 else
	  	 $('#confirm').attr('data-status',status).trigger('click');
	});
	
	
	$('body').on('click','.update_confirm_status',function() {
		
		//console.log('Updated licked');
		
		var status=$(this).attr('data-status');
		
		if($(this).attr('data-checked'))
		var cl='.'+$(this).attr('data-checked');
		else
		var cl='.checkbox';

		 var chked=$(cl+':checked').length;
		 
		 
		 if(chked==0)
		 {
			 $('#gritter_required').trigger('click');
			
			return false; 
		 }
		 else
		 {
	  	 	$('#confirm').attr('data-status',status).trigger('click');
		 }
	});
	
	$('.confirm_status').click(function()
	{ 
		  var status_attr=($('#confirm').attr('data-status')).split('|');
		  
		 status=status_attr[0];
		
		  var ids = [];
		  
		  $(".checkbox:checked").each(function ()
		  {
			  ids.push($(this).val());
			  
		  });
		  
			$.ajax({    
					"type" : "POST",
					"beforeSend": function(){ $('.confirm_status').html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled'); },
					"url" : $('#status_base_url').val(),
					"data" : {'ids' : ids,'status':status},
					success: function(data){
						
						$('.confirm_status').html('Yes').removeAttr('disabled');
						
						$('#confirm_modal').modal('hide');
						
						$('#update_confirm').html('Are you sure?');
						
						$('#gritter_success').trigger('click');
						
						window.location=document.URL;
					}
			});		  
	
	});
	
});
