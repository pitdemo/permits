$(document).ready(function() {

  $('body').on('input', '.numinput', function() {
      this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1');
  });

  $('body').on('change', '.numinput', function() {
      if(this.value == '-' || this.value == '-.' || this.value == '.'){
          this.value = '';
      }
  });
	
	//$('.bulk_action').click(function()
	$('body').on('click','.bulk_action',function() 
	{
		if($(this).attr('data-checked'))
		var cl='.'+$(this).attr('data-checked');
		else
		var cl='.bulk_box,.checkbox';
		
		  if($(this).is(':checked'))
		  {
			  $(cl).prop('checked',true);
		  }
		  else
		  {
			 $(cl).prop('checked',false);
		  }
	});

	
	$('#gritter_success,#gritter_required').click(function()
	{
		var msg=$(this).attr('data-msg');
		
		var title=$(this).attr('data-title');
		
		$.gritter.removeAll({
			after_close: function(){
				$.gritter.add({
					position: 'top-right',
					title: title,
					text: msg,
					class_name: 'gritter-success',
					time: ''
				});
			}
		});
		return false;
	});		
    
    //Edit Given ID
    $(document).on('change','.change_action',function(){
             if($('option:selected',this).val()=='edit'){
                 var url=$('option:selected',this).data('url');
                 window.location.href=url+$('option:selected',this).data('id');
             }
			 if($('option:selected',this).val()=='account_notes'){
                 var url=$('option:selected',this).data('url');
                 window.location.href=url+$('option:selected',this).data('fund_account_number');
             }
			 if($('option:selected',this).val()=='associate_pi_account'){
                 var url=$('option:selected',this).data('url');
                 window.location.href=url+$('option:selected',this).data('id');
             }
			 if($('option:selected',this).val()=='pending'){
                 var url=$('option:selected',this).data('url');
                 window.location.href=url+$('option:selected',this).data('id');
             }
			 if($('option:selected',this).val()=='late'){
                 var url=$('option:selected',this).data('url');
                 window.location.href=url+$('option:selected',this).data('id');
             }
    });
	
});
    
function change_status(ele)
{
	var ele=$(ele);
	var url=ele.data('url');
	var status_id=ele.data('id');
	
	// If bulk status change
	if(ele.data('bulk')){
		if($('.bulk_box:checked').length==0){
			alert('Please select atleast one!');
			return false;
		}
		var status_id = [];
		$('.bulk_box').each(function(){ 
			if(this.checked){
				status_id.push($(this).val());
			}
		});
	 }

	$.ajax({
		type:"post",
		url:url,
		data:{
			'status':ele.data('status'),
			'id':status_id
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
				$table.bootstrapTable('refresh');
			}		
			$('.bulk_action').prop('checked',false);
			return false;	
		}
	});
}
