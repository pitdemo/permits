$(document).ready(function() 
{

	 $('body').on('click','.add_more',function() 
	{

		 var button=$('button[type="submit"]').length;

	    if(button==0)
	    {
	    	alert('Sorry, you can\'t be add new row');

	    	return false;
	    }

	      var row_id=total_rows=$('table#table5 tr:last').attr('data-row-id');

	      var codes_id=$('.temp_tags'+row_id).val();	   

	      console.log('Inside '+codes_id+' = '+row_id);

	      /*if(codes_id!='')
	      {*/
	          $('#response').html('');

	          //var total_rows=$('#total_rows').val();  

	          total_rows++;

	          $('#total_rows').val(total_rows);    
	       
	          var $tr    = $('table#table5 tr:last').closest('.tr_clone');
	          var $clone = $tr.clone();
	          $clone.find(':text').val('');
	          $clone.find('input').val('');
	          $clone.find('select').val('');
	          $clone.find('select').prop("disabled",true);     
	          $clone.find('.error').remove();

	          $clone.find('.temp_row'+row_id).html(total_rows);	      
	          $clone.find('.temp_row'+row_id).attr('class','p12 ft32 temp_row'+total_rows);	                
	          $clone.find('.temp_tags'+row_id).attr('id','temporary_tag_nos['+total_rows+']');
	          $clone.find('.temp_tags'+row_id).attr('name','temporary_tag_nos['+total_rows+']');
	          $clone.find('.temp_tags'+row_id).attr('data-attr',total_rows);
	          $clone.find('.temp_tags'+row_id).attr('class','form-control temporary_tags temp_tags'+total_rows);


	          $clone.find('#temporary_lock_nos'+row_id).html('');
	          $clone.find('#temporary_lock_nos'+row_id).attr('id','temporary_lock_nos'+total_rows);

	          $clone.find('.temporary_lock_nos'+row_id).attr('name','temporary_lock_nos['+total_rows+']');	   
	          $clone.find('.temporary_lock_nos'+row_id).attr('id','temporary_lock_nos['+total_rows+']');
	          $clone.find('.temporary_lock_nos'+row_id).attr('class','form-control temporary_lock_nos'+total_rows);	          

	          $clone.find('.temporary_pa'+row_id).attr('name','temporary_pa['+total_rows+']');	   
	          $clone.find('.temporary_pa'+row_id).attr('id','temporary_pa['+total_rows+']');	          
	          $clone.find('.temporary_pa'+row_id).attr('data-attr',total_rows);
	          $clone.find('.temporary_pa'+row_id).attr('data-date-field','temporary_pa_signdates'+total_rows);
	          $clone.find('.temporary_pa'+row_id).attr('class','form-control authority_sign temporary_pa'+total_rows);	          

	          $clone.find('.temporary_pa_signdates'+row_id).attr('name','temporary_pa_signdates['+total_rows+']');	   
	          $clone.find('.temporary_pa_signdates'+row_id).attr('id','temporary_pa_signdates['+total_rows+']');	
	          $clone.find('.temporary_pa_signdates'+row_id).attr('class','form-control temporary_pa_signdates'+total_rows);

	          $clone.find('.temporary_ia'+row_id).attr('name','temporary_ia['+total_rows+']');	   
	          $clone.find('.temporary_ia'+row_id).attr('id','temporary_ia['+total_rows+']');	          
	          $clone.find('.temporary_ia'+row_id).attr('data-attr',total_rows);	         
	          $clone.find('.temporary_ia'+row_id).attr('class','form-control authority_sign temporary_ia'+total_rows);

	          $clone.find('.temporary_ia_signdates'+row_id).attr('name','temporary_ia_signdates['+total_rows+']');	   
	          $clone.find('.temporary_ia_signdates'+row_id).attr('id','temporary_ia_signdates['+total_rows+']');	
	          $clone.find('.temporary_ia_signdates'+row_id).attr('class','form-control temporary_ia_signdates'+total_rows);

	          $clone.find('.temporary_iso'+row_id).attr('name','temporary_iso['+total_rows+']');	   
	          $clone.find('.temporary_iso'+row_id).attr('id','temporary_iso['+total_rows+']');	
	          $clone.find('.temporary_iso'+row_id).attr('class','form-control authority_iso_sign temporary_iso'+total_rows);

	          $clone.find('.temporary_iso_signdates'+row_id).attr('name','temporary_iso_signdates['+total_rows+']');	   
	          $clone.find('.temporary_iso_signdates'+row_id).attr('id','temporary_iso_signdates['+total_rows+']');	
	          $clone.find('.temporary_iso_signdates'+row_id).attr('class','form-control  temporary_iso_signdates'+total_rows);

	          $clone.find('.isolation_re_equipment_row1'+row_id).attr('name','isolated_re_tagno1['+total_rows+']');	   
	          $clone.find('.isolation_re_equipment_row1'+row_id).attr('id','isolated_re_tagno1['+total_rows+']');
	          $clone.find('input[name="isolated_re_tagno1['+total_rows+']"]').attr('disabled',true);

	          $clone.find('.isolation_re_equipment_row2'+row_id).attr('name','isolated_re_tagno2['+total_rows+']');	   
	          $clone.find('.isolation_re_equipment_row2'+row_id).attr('id','isolated_re_tagno2['+total_rows+']');
	          $clone.find('input[name="isolated_re_tagno2['+total_rows+']"]').attr('disabled',true);

	          $clone.find('.isolation_re_equipment_row3'+row_id).attr('name','isolated_re_tagno3['+total_rows+']');	   
	          $clone.find('.isolation_re_equipment_row3'+row_id).attr('id','isolated_re_tagno3['+total_rows+']');
	          $clone.find('input[name="isolated_re_tagno3['+total_rows+']"]').attr('disabled',true);


	          $clone.find('.temporary_re_pa'+row_id).attr('name','temporary_re_pa['+total_rows+']');	   
	          $clone.find('.temporary_re_pa'+row_id).attr('id','temporary_re_pa['+total_rows+']');	          
	          $clone.find('.temporary_re_pa'+row_id).attr('data-attr',total_rows);
	          $clone.find('.temporary_re_pa'+row_id).attr('data-issuing-field','temporary_re_ia'+total_rows);
	          $clone.find('.temporary_re_pa'+row_id).attr('data-date-field','temporary_re_pa_signdates'+total_rows);
	          $clone.find('.temporary_re_pa'+row_id).attr('class','form-control temporary_re_pa authority_sign temporary_re_pa'+total_rows);

	          $clone.find('.temporary_re_pa_signdates'+row_id).attr('name','temporary_re_pa_signdates['+total_rows+']');	   
	          $clone.find('.temporary_re_pa_signdates'+row_id).attr('id','temporary_re_pa_signdates['+total_rows+']');	
	          $clone.find('.temporary_re_pa_signdates'+row_id).attr('class','form-control temporary_re_pa_signdates'+total_rows);

	          $clone.find('.temporary_re_ia'+row_id).attr('name','temporary_re_ia['+total_rows+']');	   
	          $clone.find('.temporary_re_ia'+row_id).attr('id','temporary_re_ia['+total_rows+']');	          
	          $clone.find('.temporary_re_ia'+row_id).attr('data-attr',total_rows);	         
	          $clone.find('.temporary_re_ia'+row_id).attr('class','form-control authority_sign temporary_re_ia'+total_rows);

	          $clone.find('.temporary_re_ia_signdates'+row_id).attr('name','temporary_re_ia_signdates['+total_rows+']');	   
	          $clone.find('.temporary_re_ia_signdates'+row_id).attr('id','temporary_re_ia_signdates['+total_rows+']');	
	          $clone.find('.temporary_re_ia_signdates'+row_id).attr('class','form-control temporary_re_ia_signdates'+total_rows);

	          $clone.find('.temporary_re_iso'+row_id).attr('name','temporary_re_iso['+total_rows+']');	   
	          $clone.find('.temporary_re_iso'+row_id).attr('id','temporary_re_iso['+total_rows+']');	
	          $clone.find('.temporary_re_iso'+row_id).attr('class','form-control  authority_iso_sign temporary_re_iso'+total_rows);

	          $clone.find('.temporary_re_iso_signdates'+row_id).attr('name','temporary_re_iso_signdates['+total_rows+']');	   
	          $clone.find('.temporary_re_iso_signdates'+row_id).attr('id','temporary_re_iso_signdates['+total_rows+']');	
	          $clone.find('.temporary_re_iso_signdates'+row_id).attr('class','form-control temporary_re_iso_signdates'+total_rows);

	          $clone.find('#add'+row_id).attr('data-row-id',total_rows); 
	          $clone.find('#remove'+row_id).attr('data-row-id',total_rows); 

	          $clone.find('#remove'+row_id).attr('id','remove'+total_rows);    
	          $clone.find('#add'+row_id).attr('id','add'+total_rows); 

	         
	          $tr.after($clone);     
	          
	          $('.temp_tags'+total_rows).prop('disabled',false);

	          $('table#table5 tr:last').attr('id','row'+total_rows); 
	          $('table#table5 tr:last').attr('data-row-id',total_rows);  
	       /*}
	    else
	     $('#response').html('<div class="alert alert-danger">Please complete current row</div>');     */

	});    


	  $('body').on('click','.remove_rows',function()
	  {
		    var row_id=$(this).attr('id');

		    row_id=row_id.match(/\d+/);		

		    //alert($('table#table5 tr').length);		   
		    var temporary_ia_signdates=$('.temporary_ia_signdates'+row_id).val();

		    var button=$('button[type="submit"]').length;

		    if(button==0 || temporary_ia_signdates!='')
		    {
		    	alert('Sorry, you can\'t be delete this row');

		    	return false;
		    }

			    if($('table#table5 tr').length>7)
			    {
			         var codes_id=$('.temp_tags'+row_id).val();	   

			         if(codes_id!='')
			         {
			            if(confirm('Are you sure to remove this row?'))
			            {
			              $('#row'+row_id).remove();
			            }
			         }
			         else		        
			              $('#row'+row_id).remove();
			    }
			    else
			    {
			        alert('Atleast one row should be must');

			        return false;
			    } 
	  });


	
	$('body').on('change','.temporary_tags',function()	
	{
		
		var val=$(this).val();
		
		var data_attr=$(this).attr('data-attr');
		
		var checker = {};

		var checkers = {};
		
		var is_flag=0;

		//$('select[name="temporary_iso['+data_attr+']"]').html('<option value="">Select</option>');	
		
		if(val!='')
		{
			var  r=1;

			var is_check=$('.temporary_tags').filter(function () 
			{

				var id=$(this).data('attr');

				if($(this).val()!='')
				{
					//var allow_equip=$('#allow_equip'+val).html(); && allow_equip==0
					
					if ( checker[this.value])
					{
						alert('You already selected this tag no ');
						
						$(this).val('');
						
						is_flag=1;

						return false;
					}
					else
					{
						var v=$('input[name="temporary_re_iso_signdates['+id+']"]').val();

						if(v=='')
						checker[this.value] = true;
					}	

					r++;
				}
					return this.value;

				});
			
				if(is_flag==0)
				{
					$('.temporary_pa'+data_attr).removeAttr('disabled');
					$('.temporary_ia'+data_attr).removeAttr('disabled');
					$('.temporary_iso'+data_attr).removeAttr('disabled');
					
					var loto=$(this).find(':selected').attr('data-loto');
					
					var data_iso=$(this).find(':selected').attr('data-iso');

					var isolate_type_id= $(this).find(':selected').attr('data-isolate-type-id');

					console.log('Isolate type '+isolate_type_id);

					var data = new FormData();	
					
						data.append('isolation_type_id',isolate_type_id);
						
						$.ajax({
							url: base_url+'jobs_isolations/ajax_get_isolation_users/',
							type: 'POST',
							"beforeSend": function(){  },
							data: data,
							cache: false,
							dataType: 'json',
							processData: false, // Don't process the files
							contentType: false, // Set content type to false as jQuery will tell the server its a query string request
							success: function(data, textStatus, jqXHR)
							{
								if(data.success)
								{
								 	$('select[name="temporary_iso['+data_attr+']"]').html(data.success);
								}				
							},
							error: function(jqXHR, textStatus, errorThrown)
							{
								
							}
						});					
					
					//data_iso_name=$('.data-iso-name'+data_iso+' option:selected').text();
					
					//alert(data_iso_name);
					
					//$('.temporary_iso'+data_attr).html('<option value="'+data_iso+'" selected>'+data_iso_name+'</option>');
					
					$('#temporary_lock_nos'+data_attr).html(loto);
					
					$('.temporary_lock_nos'+data_attr).val(loto);
				}
		}
		else
		{
			$('#temporary_lock_nos'+data_attr).html('');	
			$('.temporary_lock_nos'+data_attr).val('');
			
			$('.temporary_pa'+data_attr).attr('disabled','disabled').val('');
			$('.temporary_ia'+data_attr).attr('disabled','disabled').val('');
			$('.temporary_iso'+data_attr).attr('disabled','disabled').val('');

			$('.temporary_pa_signdates'+data_attr).val('');
			$('.temporary_iso'+data_attr).html('<option value="" selected>Select</option>');
		}
		
			var t=$('.temporary_tags').filter(function () {
				if(this.value!='')
    			return !!this.value;
			}).length;
			
			if(t!=0)
			$('#table6 :input,#table6 select').attr('disabled',true).val(''); //$(this).val('');						
			else
			{
				$('#performing_authority_id3').removeAttr('disabled');
			}
		
		///alert(loto+' - '+val);
		
	});

	$('body').on('click','.show_matched_records',function() {
		
		var id=$(this).attr('data-id');
		
		var permit_no=$(this).attr('data-permit-no');
		
		var data = new FormData();
		
		data.append('id',id);
		
		data.append('permit_no',permit_no);
		
		$.ajax({
			url: base_url+'jobs_isolations/ajax_show_jobs_history/',
			type: 'POST',
			"beforeSend": function(){ console.log('Before Send'); },
			data: data,
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			success: function(data, textStatus, jqXHR)
			{
				$('.modal-title').html(data.fund_account_information);
				
				$('#matched_result').html(data.response);
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				$('#matched_result').html('Invalid Credentials');
			}
		});
	});

	$('body').on('click','.print_out',function() {
				
					var print_id=$(this).attr('data-id');
					
					var data = new FormData();			
					
					data.append('id',print_id);		
					
						$.ajax({    
							"type" : "POST",
							"url" : base_url+"jobs_isolations/printout",	
							data:data,	
							type: 'POST',
							processData: false,
							contentType: false,
							dataType:"json",
							success:function(data, textStatus, jqXHR){
								
								//alert('Status '+textStatus);alert(data); return false;return false;
										var newWin = window.open(data.file_path, '', 'left=0,top=0,width=900,height=600,toolbar=0,scrollbars=0,status=0');
										//newWin.document.write(data);
										newWin.document.close();
										newWin.focus();
										//newWin.print();
										newWin.onload = function() {    };
										//newWin.close();
										newWin.print();
										//return false; 
							},
							error: function(jqXHR, textStatus, errorThrown){
								//if fails     
								
								alert('ERror');
							}
					  });		
					
				
				 });

});