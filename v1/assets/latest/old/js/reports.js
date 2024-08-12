var $table = $('.report_table');

$(document).ready(function() {


	  $('body').on('click','.change_reports_status',function()
	  {
	    var id= $('.bulk_box').attr('id');

	    var table_name=$(this).attr('data-table');

	    var cl='.bulk_box';
	    
	    var chked=$(cl+':checked').length;
	     
	    if(chked==0)
	    {
	      $('#gritter_required').trigger('click');
	      
	      return false; 
	    }
	    else
	    {

	    	console.log('Repo '+$(this).attr('data-button-class'));

	        var check_box='';

	        $('.bulk_box').each(function(){ 
			if(this.checked){
				check_box+=$(this).attr('data-permit-no')+',';
			}
			});

			check_box=check_box.substring(0,(check_box.length-1));

	             
	        $('#change_reports_status_update_confirm').html('Are you sure to Self Cancel to the selected permits\'s? <br /> <b>'+check_box+'</b> <br /><br />Self Cancel Description <br /><textarea id="self_cancel_description" name="self_cancel_description" class="form-control" rows="5" cols="30"></textarea>');
	        
	        $('#change_reports_status_confirm_modal').attr('class','modal fade '+$(this).attr('data-modal-class'));

	        $('#change_reports_status_confirm_modal').attr('data-table',$(this).attr('data-table'));

	        $('#change_reports_status_confirm_modal').attr('data-table-id',$(this).attr('data-table-id'));

	        $('#change_reports_status_confirm').trigger('click');

	        $('#self_cancel_description').focus();

	        //$('#change_reports_status_confirm').attr('class','btn change_status_confirm '+$(this).attr('data-button-class'));

	        //$('#change_reports_status_confirm').attr('data-url',data_url);
	    }  
	  });  


	  $('body').on('click','.change_reports_status_confirm',function()
	  {
	  		var self_cancel_description=$('#self_cancel_description').val();


	  		if($.trim(self_cancel_description)=='')
	  		{
	  			alert('Please fill self cancel description');

	  			$('#self_cancel_description').focus();

	  			return false;

	  		}
	  		else
	  		{
		  			var ids = [];

		  			var cl='.bulk_box';
	      
				    $($(cl+':checked')).each(function ()
				      {
				        ids.push($(this).val());
				    });

				    data_url = base_url+'reports/ajax_update_status';

				    var table_name=$('#change_reports_status_confirm_modal').attr('data-table');

				    var refresh_table=$('#change_reports_status_confirm_modal').attr('data-table-id');

				    $.ajax({    
			          "type" : "POST",
			          "beforeSend": function(){ $('.change_reports_status_confirm_no').html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled'); $('.change_reports_status_confirm').html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled'); },
			          "url" : data_url,
			          "data" : {'ids':ids,table_name:table_name,self_cancel_description:self_cancel_description},
			          "dataType" : 'json',
			          success: function(data)
			          {

			          	$('.change_reports_status_confirm').removeAttr('disabled').html('Yes');

			          	$('.change_reports_status_confirm_no').removeAttr('disabled').html('No');

			          	$('#self_cancel_description').val('');

			          	$('.change_reports_status_confirm_no').trigger('click');

			            /*$(".bulk_action").prop('checked',false);
			            //console.log(data.count);return false;
			            $('#change_status_confirm_yes').html('Yes').removeAttr('disabled');
			            
			            $('#change_status_confirm_modal').modal('hide');
			            
			            $('#change_status_update_confirm').html('Are you sure?');*/
			            
			            $('#gritter_success').trigger('click');
			            
			            $('#'+refresh_table).bootstrapTable('refresh', 
			            {
			              method:'post',
			            });
			          }
			      });  

	  		}

	  });	
	 

	 $('.select2').select2();

	$('#myTab a').click(function (e)
	{	
	  		e.preventDefault();
			
	  		$(this).tab('show');
	  
	  		$('.bulk_action').removeAttr('checked');
			  
		  	var attr=$(this).attr('href');
		  
		  	var $refresh_table=$(attr+'_table');
	  			
			var status=$(this).attr('data-status');

			var data_url=$('form#'+status+'_form').attr('data-url');

			var data_ajax_url=$('form#'+status+'_form').attr('data-ajax-url');
			
			var i=0;
			
			var params_url='user_role/'+status+'/';
					 
			$('form#'+status+'_form').find(':input[type=hidden],select,:input[type=text]').each(function ()
			{
				  index= $(this).attr('name');
				  
				  value= $.trim(encodeURI($(this).val()));
				  
				  if(value!='' && typeof index!=='undefined' && value!='all')
				  { 
					  if(index=='subscription_date_start' || index=='subscription_date_end')
					  value=value.replace(/\//g, '-');

		    			if(value!='null')
					   params_url+=index+'/'+value+'/'; i++;
				  }
			});			 
			
			$refresh_table.bootstrapTable('refresh', {
			method:'post',    			
			url: data_ajax_url+params_url
			});			
		
	 	    window.history.pushState("", "", data_url+params_url);   			
		});
		
		$('body').on('click','.reset',function() 
		{
			var data_status=$(this).attr('data-status');	
				
			window.location=$('form#'+data_status+'_form').attr('data-url');
				//'<?php echo base_url().$this->data['controller'].$this->data['method']; ?>/user_role/'+data_status;			
		});
		
		
		$('.search_report_data').click(function()
		{
			var form_id=$(this).attr('data-form-name');
			//if(form_id=='all')
			var params_url='user_role/'+form_id+'/';

			var i=0;

			var data_url=$('form#'+form_id+'_form').attr('data-url');

			var data_ajax_url=$('form#'+form_id+'_form').attr('data-ajax-url');			
			//Pushing values in Query Parameters
			  $('form#'+form_id+'_form').find(':input[type=hidden],select,:input[type=text]').each(function ()
			  {
					index= $(this).attr('name');
					
					value= $.trim(encodeURI($(this).val()));
					
					if(value!='' && typeof index!=='undefined' && value!='all')
					{ 
						if(index=='subscription_date_start' || index=='subscription_date_end')
						value=value.replace(/\//g, '-');

          				if(value!='null')
						params_url+=index+'/'+value+'/'; i++;

					}
			  });

			$('#'+form_id+'_table').bootstrapTable('refresh', {
			method:'post',
			url: data_ajax_url+params_url
			});		
							  
			window.history.pushState("", "", data_url+params_url);   	
			  
			return false;
		}); 
	
	$('.export_csv').click(function()
	{
		 var tbl='#'+$(this).attr('tableexport-id');

		 var file_name = $(this).attr('tableexport-filename');		

	      $(tbl).tableExport({
	            headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
	            footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
	            formats: ["xls", "csv", "txt"],    // (String[]), filetypes for the export
	            filename: file_name,                    // (id, String), filename for the downloaded file
	            bootstrap: false,                   // (Boolean), style buttons using bootstrap
	            position: "top",                 // (top, bottom), position of the caption element relative to table
	            ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file(s)
	            ignoreCols: null,                  // (Number, Number[]), column indices to exclude from the exported file(s)
	            ignoreCSS: ".tableexport-ignore",  // (selector, selector[]), selector(s) to exclude from the exported file(s)
	            emptyCSS: ".tableexport-empty",    // (selector, selector[]), selector(s) to replace cells with an empty string in the exported file(s)
	            trimWhitespace: false,              // (Boolean), remove all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)
	            escape: 'false'
	        });
	   
	});
	
	/*$('.date-picker').datepicker({ autoclose: true,maxDate:'0', changeMonth: true,                
                changeYear: true,dateFormat: 'dd/mm/yy' });*/
	
	$('.search').click(function()
	{	
		var subscription_date_start=$('#subscription_date_start').val();
		
		var subscription_date_end = $('#subscription_date_end').val();

		var url = $(this).attr('data-url');

		params_url=''; var i=0;

		$('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		{
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if(value!='null')
					{
						index=index.replace(/\W/g, "");					
					
						params_url+=index+'/'+value+'/'; i++;
					}	
				}
		});  

		if(i>0)
		{
			$table.bootstrapTable('refresh', {									
			url: base_url+'reports/ajax_search_'+url+'/'+params_url,method:'post'		});
			
			window.history.pushState("", "", base_url+'reports/'+url+'/'+params_url);   
		}	
		
	});
	
	$('.zone_search').click(function()
	{	
		var subscription_date_start=$('#subscription_date_start').val();
		
		var subscription_date_end = $('#subscription_date_end').val();
		
		$table.bootstrapTable('refresh', {									
		url: base_url+'reports/ajax_search_zone_wise/?subscription_date_start='+subscription_date_start+'&subscription_date_end='+subscription_date_end
		});
		
		subscription_date_start=subscription_date_start.replace(/\//g, '-');
		
		subscription_date_end=subscription_date_end.replace(/\//g, '-');
		
		params_url='subscription_date_start/'+subscription_date_start+'/subscription_date_end/'+subscription_date_end;
		
		window.history.pushState("", "", base_url+'reports/zone_wise/'+params_url);   
	});
	
	$('body').on('click','.name_search',function() 
	{
		
		var params_url='';
		
		var i=0;
		//Pushing values in Query Parameters
		  $('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		  {
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if(index=='departments[]' || index=='zones[]')
					index=index.replace(/\W/g, "");
					
					console.log('Vale '+index+' - '+value);
					
					params_url+=index+'/'+value+'/'; i++;
				}
		  });  
		  
		 console.log('Params : '+params_url);
		  
		  if(i>0)
		  {
				$('#search_table').bootstrapTable('refresh', {
				method:'post',
				url: base_url+'reports/ajax_search_name_wise/'+params_url
				});		
								  
			 window.history.pushState("", "", base_url+'reports/name_wise/'+params_url);   
		  }	
		  
		return false;
		
	});
	
	$('body').on('click','.day_search',function() 
	{
		var params_url='';
		
		var i=0;
		//Pushing values in Query Parameters
		  $('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		  {
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if((index=='departments' || index=='zones') && value!='null')
					index=index.replace(/\W/g, "");
					
					//console.log('Vale '+index+' - '+value);
					
					params_url+=index+'/'+value+'/'; i++;
				}
		  });  
		  
		 console.log('Params : '+params_url);
		  
		  if(i>0)
		  {
				$('#search_table').bootstrapTable('refresh', {
				method:'post',
				url: base_url+'reports/ajax_search_jobs_category_wise/'+params_url
				});		
								  
			 window.history.pushState("", "", base_url+'reports/jobs_category_wise/'+params_url);   
		  }	
		  
		return false;
		
	});
	
	$('body').on('click','.permit_search',function() 
	{
		var params_url='';
		
		var i=0;
		//Pushing values in Query Parameters
		  $('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		  {
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if(index=='departments[]' || index=='zones[]')
					index=index.replace(/\W/g, "");
					
					console.log('Vale '+index+' - '+value);
					
					params_url+=index+'/'+value+'/'; i++;
				}
		  });  
		  
		 console.log('Params : '+params_url);
		  
		  if(i>0)
		  {
				$('#search_table').bootstrapTable('refresh', {
				method:'post',
				url: base_url+'permits/ajax_search_permits/'+params_url
				});		
								  
			 window.history.pushState("", "", base_url+'permits/lists/'+params_url);   
		  }	
		  
		return false;
		
	});
	
	$('body').on('click','.open_permits',function() 
	{
		var params_url='';
		
		var i=0;
		//Pushing values in Query Parameters
		  $('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		  {
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if(index=='departments[]' || index=='zones[]')
					index=index.replace(/\W/g, "");
					
					console.log('Vale '+index+' - '+value);
					
					params_url+=index+'/'+value+'/'; i++;
				}
		  });  
		  
		 console.log('Params : '+params_url);
		  
		  if(i>0)
		  {
				$('#search_table').bootstrapTable('refresh', {
				method:'post',
				url: base_url+'reports/ajax_search_open_permits/'+params_url
				});		
								  
			 window.history.pushState("", "", base_url+'reports/open_permits/'+params_url);   
		  }	
		  
		return false;
		
	});
	
	$('body').on('click','.time_calc_permit_search',function() 
	{
		var params_url='';
		
		var i=0;
		//Pushing values in Query Parameters
		  $('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		  {
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if(index=='departments[]' || index=='zones[]' || index=='users[]')
					index=index.replace(/\W/g, "");
					
					console.log('Vale '+index+' - '+value);
					
					params_url+=index+'/'+value+'/'; i++;
				}
		  });  
		  
		 console.log('Params : '+params_url);
		  
		  if(i>0)
		  {
				$('#search_table').bootstrapTable('refresh', {
				method:'post',
				url: base_url+'reports/ajax_search_permits_time_calc/'+params_url
				});		
								  
			 window.history.pushState("", "", base_url+'reports/permits_time_calc/'+params_url);   
		  }	
		  
		return false;
		
	});
	
	
	$('body').on('click','.time_calc_loto_search',function() 
	{
		var params_url='';
		
		var i=0;
		//Pushing values in Query Parameters
		  $('#filter_form').find(':input[type=text],:input[type=hidden],select').each(function ()
		  {
				index= $(this).attr('name');
				
				value= $.trim(encodeURI($(this).val()));
				
				if(value!='' && typeof index!=='undefined' && value!='all')
				{ 
					if(index=='subscription_date_start' || index=='subscription_date_end')
					value=value.replace(/\//g, '-');

					if(index=='departments[]' || index=='zones[]' || index=='users[]')
					index=index.replace(/\W/g, "");
					
					console.log('Vale '+index+' - '+value);
					
					params_url+=index+'/'+value+'/'; i++;
				}
		  });  
		  
		 console.log('Params : '+params_url);
		  
		  if(i>0)
		  {
				$('#search_table').bootstrapTable('refresh', {
				method:'post',
				url: base_url+'reports/ajax_search_loto_time_calc/'+params_url
				});		
								  
			 window.history.pushState("", "", base_url+'reports/loto_time_calc/'+params_url);   
		  }	
		  
		return false;
		
	});
	
	$('.search').trigger('click');

});
