$(document).ready(function() {

	   function ShowLocalDate()
    {
         /* var dNow = new Date();
          
          var localdate= ( (dNow.getDate()<10?'0':'') + dNow.getDate() ) + '-' + ( ((dNow.getMonth()+1)<10?'0':'') + (dNow.getMonth()+1) ) + '-' + dNow.getFullYear() + ' ' + ( (dNow.getHours()<10?'0':'') + dNow.getHours() ) + ':' +
           ( (dNow.getMinutes()<10?'0':'') + dNow.getMinutes() );
          
          return localdate;*/

          var localdate='';

          $.ajax({
          url: base_url+'confined_permits/get_system_time/',
          type: 'POST',
          "beforeSend": function(){ console.log('Before Send'); },         
          cache: false,
          dataType: 'json',
          async: false,
          processData: false, // Don't process the files
          contentType: false, // Set content type to false as jQuery will tell the server its a query string request
          success: function(data, textStatus, jqXHR)
          {
            localdate=data.response;
          }          
        });
        
            return localdate;
    }

$('#acceptance_performing_id').change(function() {
        
        var va=$(this).val();       
        
        $('#acceptance_performing_date').val('');
        
        var eip=$('input[name=is_isoloation_permit]:checked').val();
        
        if(va!='')        
        {
          $('#acceptance_performing_date').val(ShowLocalDate());
          
          //if(eip=='N/A')
          $('#acceptance_issuing_id,#acceptance_issuing_date,#acceptance_safety_sign_id').removeAttr('disabled');
        }
        else
        $('#acceptance_issuing_id,#acceptance_issuing_date,#acceptance_safety_sign_id').attr('disabled',true).val('');
    });   

    
    $('#cancellation_performing_id').change(function() {
        
        var va=$(this).val();
        
        $('#cancellation_performing_date').val('');
        
        var eip=$('input[name=is_isoloation_permit]:checked').val();
        
        if(va!='')        
        {
          $('#cancellation_performing_date').val(ShowLocalDate());
          
          $('#cancellation_issuing_id,#cancellation_issuing_date').removeAttr('disabled');
        }
        else
        $('#cancellation_issuing_id,#cancellation_issuing_date').attr('disabled',true);
    });
    
  $('.show_button').click(function() {
    $('#show_button').val($(this).val());
  }); 
  
  $('.on_off').change(function() {
    
    var date_relate=$(this).attr('data-relate');
    
    var val=$(this).val();
    
    if(date_relate!='')
    {
      if(val=='Yes')
      {
        
        $('.'+date_relate).removeAttr('disabled');
        
        //$('#energy_form').trigger('click');   
      }
      else
      { $('.'+date_relate).attr('disabled',true);  $('.'+date_relate).removeClass('error'); }
    }
  }); 	

$('input[name=is_isoloation_permit]').change(function() {
  
  var sel_val=$(this).val();
  
  var acceptance_performing_id=$('#acceptance_performing_id').val();
  
  var id=$('#id').val();
  
  if(id=='')
  {
    $('#acceptance_issuing_id,#acceptance_issuing_date,#acceptance_performing_id,#acceptance_performing_date').val('');
    
    $('#acceptance_issuing_id,#acceptance_issuing_date').attr('disabled',true); 
  }
  console.log('Val '+sel_val);
    
    if($.inArray(sel_val, ["Existing", "yes_existing"])!==-1) 
    {
      $('select.selected_eip').select2("enable");
      
      $selected_eip.rules('add','required');
    }
    else
    {
      $('select.selected_eip').select2("disable")
      
      $("select.selected_eip").select2("val", "");  
      
      $selected_eip.rules('remove','required');
    }
  
});  

$('#contractor_id').change(function() {
  
    if($(this).val()=='others')
    {
      $('#other_contractors').show(); 
    }
    else
      $('#other_contractors').hide().val('');
  
  
});

$('input[name=is_isoloation_permit]').change(function() {
  
  var sel_val=$(this).val();
  
  var acceptance_performing_id=$('#acceptance_performing_id').val();
  
  var id=$('#id').val();
  
  if(id=='')
  {
    $('#acceptance_issuing_id,#acceptance_issuing_date,#acceptance_performing_id,#acceptance_performing_date').val('');
    
    $('#acceptance_issuing_id,#acceptance_issuing_date').attr('disabled',true); 
  }
  console.log('Val '+sel_val);
    
    if($.inArray(sel_val, ["Existing", "yes_existing"])!==-1) 
    {
      $('select.selected_eip').select2("enable");
      
      $selected_eip.rules('add','required');
    }
    else
    {
      $('select.selected_eip').select2("disable")
      
      $("select.selected_eip").select2("val", "");  
      
      $selected_eip.rules('remove','required');
    }
  
});


$(".precautions_options").click(function() {
  
  var at=$(this).attr('data-attr');
  
  //console.log('Lenght : '+$('input[name="hazards_options['+at+']"]:checked').length);
  var checked_length=$('input[name="precautions_options['+at+']"]:checked').length;
  
  if(checked_length>0)
  $('input[name="precautions['+at+']"]').removeAttr('disabled');
  else
  $('input[name="precautions['+at+']"]').attr('disabled',true);
  
  
  if($(this).attr('data-other'))
  {
    if($(this).is(':checked'))
    $('#'+$(this).attr('data-other')).show();
    else
    $('#'+$(this).attr('data-other')).hide();
    
  }
});

$(".precautions").click(function() {
  
  var at=$(this).attr('data-attr');
  
  var haz_val=$('input[name="hazards['+at+']"]:checked').val();
  
  var pre_val=$(this).val();
  
  console.log('REv : '+haz_val);
  
  if(haz_val!='Yes')
  {
    if(pre_val!='N/A')
    {
      alert('Please select N/A');
    
      $(this).removeAttr('checked');
    }
  }
  
  var is_checkbox=$(this).attr('data-checkbox');
  
  var data_attr=$(this).attr('data-attr');
  
  if(pre_val=='N/A')
  {
    if(is_checkbox)
    {
       $('input[name="precautions_options['+data_attr+']"]').removeAttr('checked').attr('disabled',true);
    }
  }
  else
  { 
    if(is_checkbox)
    $('input[name="precautions_options['+data_attr+']"]').removeAttr('disabled');
    
  }
  
});

$(".hazards").click(function() {
  
  var at=$(this).attr('data-attr');
  
  var chk=$(this).attr('data-checkbox');
  
  $('input[name="precautions['+at+']"]').removeAttr('disabled');
  
  $('input[name="precautions['+at+']"]').removeAttr('checked');

  console.log($(this).val()+' = '+at);
  
  if($(this).val()=='No')
  {
    $('input[name="precautions['+at+']"]:eq(1)').prop('checked', true);
    
    $('input[name="precautions_options['+at+']"]').removeAttr('checked').attr('disabled',true);

    $('input[name="precautions_text['+at+']"]').val('').attr('disabled',true);
  }
  else
  {
    $('input[name="precautions_options['+at+']"]').removeAttr('disabled',true);    

    $('input[name="precautions_text['+at+']"]').removeAttr('disabled',true);  
  } 
    
});

$('.required_ppe').change(function()
{
  var data_other=$(this).attr('data-other');
  
  if(typeof data_other!=='undefined')
  { 
    if($(this).is(':checked'))
    $('#'+data_other).removeAttr('disabled');
    else
    {
      $('#'+data_other).attr('disabled','disabled');
      
      $('#'+data_other).val('');
    }
  } 
});

$(".hazard_option").change(function()
{   
  var val=$(this).val();
  
  var is_checkbox=$(this).attr('data-checkbox');
  
  var data_attr=$(this).attr('data-attr');
  
  if(val=='No')
  {
    if(is_checkbox)
    {
       $('input[name="hazards_options['+data_attr+']"]').removeAttr('checked').attr('disabled',true).removeClass('error');
    }
    
    // $('input[name="precautions_options['+data_attr+']"]').removeAttr('checked').attr('disabled',true);
  }
  else
  { 
    if(is_checkbox)
    $('input[name="hazards_options['+data_attr+']"]').removeAttr('disabled');
    
  }

});

$(".hazards:checked").each(function(index,value) {
   
   if($(this).attr('data-checkbox') && $(this).val()=='No')
   $('input[name="hazards_options['+$(this).attr('data-attr')+']"]').removeAttr('checked').attr('disabled',true);
   
 
});


 $('.schedule_time').change(function() { 

          var data_time_field = $(this).attr('data-time-field');

          var data_time_attr = $(this).attr('data-time-attr');

          var approval_status = $(this).attr('data-ia-approval');


          console.log('Approval Status '+approval_status);

          var data_id=$(this).attr('data-id');

          var val = $(this).val();

          fields=''; //'.extended_oxygen_','.extended_gases_','.extended_carbon_','.extended_carbon_',

          var arr = ['.watch_person_','.watch_other_person_','.extended_pa_','.extended_sa_','.extended_ia_'];

          if(approval_status=='')
          {
	              $.each(arr, function( index, value ) {
	                fields+=value+data_time_field+data_id+',';
	              });

	              fields = fields.slice(0,-1);  

	              if(val=='')
	              {
	                $(fields).attr('disabled',true).val(''); 

	                $('.extended_time_period'+data_id).val('');	                
	              }
	              else
	              {
	                  $(fields).removeAttr('disabled');   

	                  $('.extended_time_period'+data_id).val(data_time_field);
	                  data_id = parseInt(data_id);

	                 // alert(data_time_field+' = '+(data_id+1)+' = '+$('#schedule_date'+(data_id+1)).val());

	                  if(data_time_field=='to')
	                  {
	                  	 if($('#schedule_date'+(data_id+1)).length>0)
	                  	 {
	                  	 	if($('#schedule_date'+(data_id+1)).val()!='')
	                  	 	{
	                  	 		alert('Sorry, you extending too many entry. Please refresh this page again');
	                  	 		
		                  	 	$(this).val('').trigger('change').attr('disabled',true);	              
		                  	 	
		                  	 	return false;
	                  	 	}
	                  	 	else
	                  	 	$('#schedule_date'+(data_id+1)).attr('disabled',true);	
	                  	 }

	                  }
	              }
          }
          else if(approval_status=='Waiting')
          {    
              $.each(arr, function( index, value ) 
              {
                    field = value+data_time_field+data_id;

                    console.log(field+' = '+$(field).attr('data-ia-approval'));

                    if($(field).attr('data-ia-approval')=='Approved')
                    {
                    	$(field).attr('disabled',true);

                    	console.log('Ture disabled '+field+' = '+$(field).attr('data-ia-approval'));
                    }  
                    else
                     {
                     	console.log('Else Remove disabled '+field+' = '+$(field).attr('data-ia-approval'));

                     	$(field).removeAttr('disabled');
                     } 

                     if($('.extended_pa_'+data_time_field+data_id).attr('data-ia-approval')=='Waiting')
                     	$('.extended_pa_'+data_time_field+data_id).attr('disabled',true)	
              });  
             
          }              
      });


	// Show Matched Transaction Info in Popup 
	$('body').on('click','.show_matched_records',function() {
		
		var id=$(this).attr('data-id');
		
		var permit_no=$(this).attr('data-permit-no');
		
		var data = new FormData();
		
		data.append('id',id);
		
		data.append('permit_no',permit_no);
		
		$.ajax({
			url: base_url+'confined_permits/ajax_show_jobs_history/',
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
							"url" : base_url+"confined_permits/printout",	
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

 	$('#self_cancellation').click(function() 
    {
        
        var x = confirm('Are you sure to cancel this permit without IA approval?');

        $('#self_cancellation_description').val('');

          if(x==true)
          {
             $('#self_cancellation_section').show();
          }
          else
          $('#self_cancellation_section').hide();
    
    });    
 var counter = 1; // define textbox counts
    
    $("#append").click( function(e) {

        e.preventDefault();
        
        /*if(counter >= 15)
        {
          alert("Only 15 textboxes allowed");
          return false;
        }*/

        $(".inc").append('<div class="controls watch_person_div"><input class="form-control watch_person_textbox" type="text" name="watch_other_person_names[]"><a href="javascript:void(0);" class="remove_this btn btn-danger add_remove_btn">Remove</a><br></div>');

        counter++;

        return false;
        });

    $('body').on('click', '.remove_this', function() 
    {
        var x=confirm('Are you sure remove this data?');

        if(x==true)
        {
          $(this).parent().remove();
          counter--;         
        } 

        return false;
    });    

});