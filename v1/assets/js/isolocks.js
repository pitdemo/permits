var $table = $('.report_table');

$(document).ready(function() {

	 $('.select2').select2();

     $('body').on('click','#modal-scrollable-close',function()
    {
            $('#modal-scrollable').modal('hide');
    });

       $('body').on('click','.re_energized_log',function()
        {
            
            var id=$(this).attr('data-id');

            var jobs_loto_id=$(this).attr('data-loto-id');

            var job_id=$(this).attr('data-job-id');

            $('#log_title').html($(this).attr('data-eq'));

            $('#modal-scrollable').modal('show');

            $.ajax({    
                "type" : "POST",
                dataType: 'json',
                "beforeSend": function(){  },
                "url" : base_url+'eip_checklists/ajax_get_lotos_logs/',
                "data" : {'jobs_loto_id' : jobs_loto_id,'job_id':job_id},
                success: function(data){
                $('#log_text').html(data.response);
                }
            });     
            
        });


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

		
			$table.bootstrapTable('refresh', {									
			url: base_url+'isolocks/ajax_search_'+url+'/'+params_url,method:'post'		});
			
			window.history.pushState("", "", base_url+'isolocks/'+url+'/'+params_url);   
		
		
	});
	
	$('.search').trigger('click');

});
