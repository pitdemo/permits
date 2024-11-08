$(window).load(function() 
{
	get_jobs_count(); // call function on page load

	window.setInterval(function(){
	  get_jobs_count();
	}, 20000); // call function for each 20 seconds

	var gritter_trigger = $('#gritter_trigger').val();

	function get_jobs_count()
	{
		$.ajax({
			url: base_url+'jobs/ajax_fetch_jobs_count',
			type: 'POST',
			data: {},
			cache: false,
			dataType: 'json',
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			beforeSend: function(){ },
			success: function(data, textStatus, jqXHR)
			{
				// console.log(data);

				var time = 0;
				
				// waiting jobs
				if(data.waiting_jobs_count != 0)
				{
					$('#waiting_jobs_count').text(data.waiting_jobs_count);
					$('ul #waiting_jobs_list').empty();
					$('ul #waiting_jobs_list_header').text('You have '+data.waiting_jobs_count+' waiting job(s)');
					
					$.each( data.waiting_jobs_list, function( key, value ) {
					  $('ul #waiting_jobs_list').append('<a href="'+base_url+'jobs/form/id/'+key+'/jobs/myjobs/user_role/IA/">'+value+'</a>');

					  if(gritter_trigger != '')
					  {
						  setTimeout( function()
	                      {
						  	$('#gritter_jobs_list').attr('data-title','Waiting Job!')
						  						   .attr('data-class-name','gritter-danger')
						  						   .attr('data-msg','<a href="'+base_url+'jobs/form/id/'+key+'/jobs/myjobs/user_role/IA/">'+value+'</a>')
						  						   .trigger('click');
						  }, time);
						  time += 1000;
					  }
					});
				}
				else
				{
					$('#waiting_jobs_count').text('');
					$('ul #waiting_jobs_list').empty();
					$('ul #waiting_jobs_list_header').text('No waiting jobs found');
				}

				// approved jobs 
				if(data.approved_jobs_count != 0)
				{
					$('#approved_jobs_count').text(data.approved_jobs_count);
					$('ul #approved_jobs_list').empty();
					$('ul #approved_jobs_list_header').text('You have '+data.approved_jobs_count+' approved job(s)');
					//var time = 0;
					$.each( data.approved_jobs_list, function( key, value ) {
					  $('ul #approved_jobs_list').append('<a href="'+base_url+'jobs/form/id/'+key+'/jobs/myjobs/user_role/IA/">'+value+'</a>');
					  // alert(gritter_trigger);
					  if(gritter_trigger != '')
					  {
					  	setTimeout( function()
                      	{
					  		$('#gritter_jobs_list').attr('data-title','Approved Job!')
					  							   .attr('data-class-name','gritter-success')
					  							   .attr('data-msg','<a href="'+base_url+'jobs/form/id/'+key+'/jobs/myjobs/user_role/IA/">'+value+'</a>')
					  							   .trigger('click');
					  	}, time);
					  	time += 1000;
					  }
					});
				}
				else
				{
					$('#approved_jobs_count').text('');
					$('ul #approved_jobs_list').empty();
					$('ul #approved_jobs_list_header').text('No approved jobs found');
				}
			},
			error: function(data, textStatus,errorThrown)
			{
				$('#error').show();
									
				$('#error_msg').html(data.failure);
			}
		});
	}
	
	$('#gritter_jobs_list').click(function()
  	{	
    	var msg=$(this).attr('data-msg');
    
    	var title=$(this).attr('data-title');

    	var class_name=$(this).attr('data-class-name') ? $(this).attr('data-class-name') : 'gritter-success';

        $.gritter.add({
          position: 'bottom-right', // 'top-right' for top to bottom
          title: title,
          text: msg,
          class_name: class_name,
          time: 5000,
          speed: 'fast'
        });

    	return false;
  	});
})
