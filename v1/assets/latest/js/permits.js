$(document).ready(function() {


  $('body').on('change', '.extends_date', function() {

    console.log('Extend Date');

    var val = $(this).val();

    var rowIndex= $(this).attr('data-id');

    var rowdate= $(this).attr('data-date');

    if(val!='')
    {
        $('.ext_performing_authorities_dates'+rowIndex).val(rowdate);
        $('#ext_performing_authorities_dates'+rowIndex).html(rowdate);


    } else
    {
      $('.ext_performing_authorities_dates'+rowIndex).val('');
      $('#ext_performing_authorities_dates'+rowIndex).html('');
    }

});
  
  $('body').on('change', '.equipment_tag_nos', function() {

    var val = $(this).val();

    if($(this).is(':checked')==true)
    {
        $('.isolated_user_ids'+val).removeAttr('disabled');

    } else
    {
      $('.isolated_user_ids'+val).val('');
      $('.isolated_user_ids'+val).prop('disabled',true);
    }

});

  $('body').on('change', '.isolate_types', function() {

    var data_id=$(this).attr('data-id');

    var val = $(this).val();

    var data = new FormData();  

    data.append('i',data_id);
    data.append('isolation_type_id',val);

    $.ajax({
      url: base_url+'jobs_isolations/ajax_get_isolation_users/',
      type: 'POST',
      "beforeSend": function(){  },
      data: data,
      async: false,
      cache: false,
      dataType: 'json',
      processData: false, // Don't process the files
      contentType: false, // Set content type to false as jQuery will tell the server its a query string request
      success: function(data, textStatus, jqXHR)
      {
          $('.isolated_user_ids'+data_id).removeAttr('disabled');
          $('.isolated_user_ids'+data_id).html(data.response);
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
            console.log('ajax_get_isolation_users Error ')
      }
    });

    

  });

  $('body').on('change', '.equip_desc', function() {

      var data_id=$(this).attr('data-id');

      var val = $(this).val();
      
      var is_flag=0;

			checker={};

      $('.equip_desc').filter(function () 
      {
          if($(this).val()!='')
					{
						//var allow_equip=$('#allow_equip'+val).html(); && allow_equip==0
						
						if(checker[this.value])
						{
							alert('You already selected this equipment. Please try different one');
							
              $(this).val('');
						}
						else
							checker[this.value] = true;
					}

      });


      if(val!='' && is_flag==0)
      {
          var tag_no=$('option:selected', this).attr('data-eq-no');
          $('.equipment_tag_no'+data_id).val(tag_no);

          $('.isolate_type'+data_id).removeAttr('disabled');
          $('.isolated_tagno1'+data_id).removeAttr('disabled');
          $('.isolated_tagno2'+data_id).removeAttr('disabled'); 
      } else
      {
        //  $('#equip_row_id'+data_id+' td select').val('');
        //  $('#equip_row_id'+data_id+' td select').attr('disabled',true);

         // $(this).removeAttr('disabled');
      }

  });

  $('body').on('input', '.equip_desc_text', function() {
    //jQuery('#some_text_box').on('input', function() {

    var data_id=$(this).attr('data-id');

    var val = $.trim($(this).val());
    
    console.log('ddfdf ','.equipment_descriptions'+data_id+' ========== '+val)

    if(val!='')
    {
        $('.equipment_tag_no'+data_id).removeAttr('disabled');
        $('.isolate_type'+data_id).removeAttr('disabled');
        $('.isolated_tagno1'+data_id).removeAttr('disabled');
        $('.isolated_tagno2'+data_id).removeAttr('disabled'); 
    } else
    {
        $('.equipment_tag_no'+data_id).attr('disabled',true);
        $('.isolate_type'+data_id).attr('disabled',true);
        $('.isolated_tagno1'+data_id).attr('disabled',true);
        $('.isolated_tagno2'+data_id).attr('disabled',true);
    }

});

  $(".navtab").click(function()
  {   
      var showTab=$(this).attr('data-tab');

      for(i=1;i<=3;i++)
      {
            if(showTab==i)
            {
              $('#tab'+showTab).addClass('active');
              $('.tab'+showTab).addClass('active show');
            } else
            {
              $('#tab'+showTab).removeClass('active');
              $('.tab'+showTab).removeClass('active show');
            }
      }

  });

  $(".previous_step").click(function()
  {   

      var next_step=$(this).attr('data-next-step');
      var current_step=$(this).attr('data-current-step');       

      $('#tab'+current_step).removeClass('active');
      $('.tab'+current_step).removeClass('active show');

      $('#tab'+next_step).addClass('active');
      $('.tab'+next_step).addClass('active show');

  });

  $('body').on('input', '.numinput', function() {
    this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1');
});

$('body').on('change', '.numinput', function() {
    if(this.value == '-' || this.value == '-.' || this.value == '.'){
        this.value = '';
    }
});

  // Historical
  $(".select2dropdown").select2({
    multiple: $(this).attr('data-multiple'),
    allowClear: true,
    dropdownAutoWidth : true,
    width: $(this).attr('data-width'),
    placeholder: "- - Select - - ",
    minimumInputLength: 1,                 
    quietMillis: 100,

    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
        url: base_url+"common/ajax_dropdown_get_values/",
        dataType: 'json',
        cache: true,
        quietMillis: 200,
        data: function (term, page) {
          return {
            q: term, // search term
            page_limit: 10,
            s:15,
            action_type:$(this).attr('data-type'),
            filter_value:$(this).attr('data-filter-value'),
            skip_users:$(this).attr('data-skip-users')
          };
        },
      results: function (data, page) { // parse the results into the format expected by Select2.
        // since we are using custom formatting functions we do not need to alter remote JSON data
        var myResults = [];
            $.each(data, function (index, item) {
              myResults.push({
                id: item.id,
                text:item.internal
              });
            });
            return {
              results: myResults
            };
      }
    },initSelection : function (element, callback) {
        
                  var account_text = $(element).attr('data-account-text');
                  var account_number = $(element).attr('data-account-number');
                  callback({"id":account_number,"text":account_text});
          }
}).on('change', function(e)
{     
  
      var ischange = $(this).attr('data-change');

      var val=$(this).val();

      if(ischange=='yes')
      {
          if(val!=''){
            avi_load_lotos()
          } else {
            $('#isolation_table').html('');	
          }
      }
     
 });

   // Historical
   $(".select2dropdown").select2({
    allowClear: true,
    dropdownAutoWidth : true,
    width: $(this).attr('data-width'),
    placeholder: "- - Select - - ",
    minimumInputLength: 1,                 
    quietMillis: 100,

    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
        url: base_url+"common/ajax_dropdown_get_values/",
        dataType: 'json',
        cache: true,
        quietMillis: 200,
        data: function (term, page) {
          return {
            q: term, // search term
            page_limit: 10,
            s:15,
            action_type:$(this).attr('data-type'),
            filter_value:$(this).attr('data-filter-value'),
            skip_users:$(this).attr('data-skip-users'),
            departments:$(this).attr('data-departments'),
          };
        },
      results: function (data, page) { // parse the results into the format expected by Select2.
        // since we are using custom formatting functions we do not need to alter remote JSON data
        var myResults = [];
            $.each(data, function (index, item) {
              myResults.push({
                id: item.id,
                text:item.internal
              });
            });
            return {
              results: myResults
            };
      }
    },initSelection : function (element, callback) {
        
        
        var account_text = $(element).attr('data-account-text');
        var account_number = $(element).attr('data-account-number');
        callback({"id":account_number,"text":account_text});

        if($(element).attr('name')=='job_id')
        avi_load_lotos();
    }
});

$(".select2").select2({placeholder: "- - Select - - "});

 function avi_load_lotos()
 {
      var data = new FormData();  

      if($('#job_id').val()!='')
      {
         data.append('job_id',$('#job_id').val());
         data.append('avi_id',$('#id').val());

         $.ajax({
         url: base_url+'eip_checklists/ajax_get_avi_eip_checklists/',
         type: 'POST',
         "beforeSend": function(){  },
         data: data,
         async: false,
         cache: false,
         dataType: 'json',
         processData: false, // Don't process the files
         contentType: false, // Set content type to false as jQuery will tell the server its a query string request
         success: function(data, textStatus, jqXHR)
         {
           $('#isolation_table').html(data.rows);		
           $('.job_info').html(data.job_info);		
         },
         error: function(jqXHR, textStatus, errorThrown)
         {
           $('#isolation_table').html('Failure');	
           $('.job_info').html('');		
           // is_checklist=data.num_rows; 	
         }
         });
      }
 }

 


});