$(document).ready(function() {


	// Show Matched Transaction Info in Popup 
	$('body').on('click','.show_matched_records',function() {
		
		var id=$(this).attr('data-id');
		
		var permit_no=$(this).attr('data-permit-no');
		
		var data = new FormData();
		
		data.append('id',id);
		
		data.append('permit_no',permit_no);
		
		$.ajax({
			url: base_url+'excavations/ajax_show_jobs_history/',
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
							"url" : base_url+"excavations/printout",	
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