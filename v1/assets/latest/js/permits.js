$(document).ready(function() {

  $('body').on('click','.re_energized_log',function()
  {
    
    var id=$(this).attr('data-id');

    var jobs_loto_id=$(this).attr('data-loto-id');

    var job_id=$(this).attr('data-job-id');

    $('#log_title').html($('.equipment_descriptions'+id+' option:selected').html());

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


  $('body').on('click','.show_image',function()
    {
      
      var id=$(this).attr('data-src');

      $('#attached_image').html($(this).attr('title'));

      //$('.show_image').attr('src',id);


          $.ajax({    
            "type" : "POST",
            dataType: 'json',
            "beforeSend": function(){  },
            "url" : base_url+'eip_checklists/ajax_get_sop_wi/',
            "data" : {'file_name' : id},
            success: function(data){
              $('#show_pdf_information').html(data.response);
            }
          });     

          //document.getElementById("show_image_emb").src=id;
        
    });

    $('#show_records_modal').on('hidden.bs.modal', function (e) {
          $('.show_image').attr('src','');
    });

  if($('select.select3').length>0)
  {
    $('select.select3').select2().on('change', function (e) 
    {
        var desc=$(this).find(':selected').data('desc');

        var target=$(this).attr('data-target');

        $('#'+target).html('');

        console.log('Data Target ',target+' = '+desc);

        if(desc!='')
        {
          desc=base_url+'uploads/sops_wi/'+desc;

          $('#'+target).html('<a href="javascript:void(0);" class="show_image" title="View Description" data-src="'+desc+'" data-bs-toggle="modal" data-bs-target="#modal-full-width">Show Desc</a>');
        }
    });
    
  }

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
  
  $('body').on('change', '.jobs_loto_ids', function() {

    var val = $(this).attr('data-id');

    var jobs_loto_id=$(this).val();

    if($(this).is(':checked')==true)
    {

        var returnData='<tr id="jobs_loto_id_jobs'+val+'"><td colspan="9" class="jobs_loto_id_jobs'+val+'">&nbsp;</td></tr>';

        $('tr#jobs_loto_id'+val+':last').after(returnData);

        var data = new FormData();  

        data.append('row_id',val);

        data.append('id',$('#id').val());

        data.append('jobs_loto_id',jobs_loto_id);

        data.append('equipment_number',$('.equipment_tag_no'+val).val());

        data.append('data_disabled',$(this).attr('data-disabled'));

        if($('.isolated_name_approval_datetime'+val).val()=='' && $(this).is(':disabled')==false)
            $('.isolated_user_ids'+val).removeAttr('disabled');

        $.ajax({
          url: base_url+'jobs/ajax_get_lotos_jobs/',
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
            $('.jobs_loto_id_jobs'+val).html(data.rows);
          },
          error: function(jqXHR, textStatus, errorThrown)
          {
                console.log('ajax_get_isolation_users Error ')
          }
        });
        


    } else
    {

      $('tr#jobs_loto_id_jobs'+val).remove();
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
    data.append('job_id',$('#id').val());

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
          if($(this).val()!='' && $(this).val()!='9999')
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


      if(val!='')
      {
          var tag_no=$('option:selected', this).attr('data-eq-no');
          var tag_text=$('option:selected', this).text();
          
          if(val=='9999'){
            $('.equipment_tag_no'+data_id).removeAttr('readonly');
            $('.equipment_descriptions_name'+data_id).removeAttr('disabled');
            $('.equipment_descriptions_name'+data_id).val('');
            $('.equipment_descriptions_name'+data_id).show();
          } else {
            $('.equipment_descriptions_name'+data_id).hide();
            $('.equipment_descriptions_name'+data_id).val(tag_text);
            $('.equipment_descriptions_name'+data_id).attr('disabled',true);
            $('.equipment_tag_no'+data_id).attr('readonly',true);
          }
          var data = new FormData();  
          data.append('equipment_descriptions_id',val);
          data.append('permit_id',$('#id').val());

          $.ajax({
            url: base_url+'eip_checklists/ajax_generate_isolations/',
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
              $('.isolate_type'+data_id).html(data.options);		
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
             
            }
          });

          $('.equipment_tag_no'+data_id).val(tag_no);
          $('.isolate_type'+data_id).removeAttr('disabled');
          $('.isolated_tagno1'+data_id).removeAttr('disabled');
          $('.isolated_tagno2'+data_id).removeAttr('disabled'); 
      } else
      {

        $('tr#equip_row_id'+data_id).find('input:text').val('');  
        $('.equipment_descriptions_name'+data_id).hide();
        $('tr#equip_row_id'+data_id).find('select').val('');  
        $('.equipment_tag_no'+data_id).attr('readonly',true);
        $('.isolate_type'+data_id).attr('disabled',true);
        $('.isolated_tagno1'+data_id).attr('disabled',true);
        $('.isolated_tagno2'+data_id).attr('disabled',true);
        $('.isolated_user_ids'+data_id).attr('disabled',true);
        

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

      console.log('dDDDDDDDd ',$('.re_energized').is(':visible'));
      var n=1;
      if($('.re_energized').is(':visible')==true)
      {
          console.log('rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr ');

          $('.re_energized').each(function(i, obj) {

              if($(this).prop('checked')==false && $(this).is(':visible')==true){              
                  n=2;
                  alert('Please confirm the Re-Energization ');
                  return false;
              }
          });
      }

      console.log('nnnnnnnnnnnnnnnnnnnnnnn ',n);
      if(n==1){ 
     
      $('#tab'+current_step).removeClass('active');
      $('.tab'+current_step).removeClass('active show');

      $('#tab'+next_step).addClass('active');
      $('.tab'+next_step).addClass('active show'); 
      }

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
    minimumInputLength: 0,                 
    quietMillis: 100,

    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
        url: base_url+"common/ajax_dropdown_get_values/",
        dataType: 'json',
        cache: true,
        quietMillis: 200,
        data: function (term, page) {
          return {
            q: 'a', // search term
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

      console.log('is Change ----- ',ischange);

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
    minimumInputLength: 0,                 
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

        console.log('aaaaaaaaaaaaaaaaaaaaa ',$(element).attr('name')+' ===== '+$(element).attr('data-change'));

        if($(element).attr('name')=='zone_id' && $(element).attr('data-change')=='yes')
        avi_load_lotos();
    }
});

$(".select2").select2({placeholder: "- - Select - - "});

 function avi_load_lotos()
 {
      var data = new FormData();  

      if($('#zone_id').val()!='')
      {
         data.append('zone_id',$('#zone_id').val());
         data.append('avi_id',$('#id').val());

         $.ajax({
         url: base_url+'avis/ajax_get_avi_eip_checklists/',
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

           if(data.num_rows==0){
              $('.form_submit').attr('disabled',true);
           } else {
              $('.form_submit').prop('disabled',false);
           }
           
         },
         error: function(data, textStatus, errorThrown)
         {
           $('#isolation_table').html(data.failure);	
           $('.form_submit').attr('disabled',true);
         }
         });
      }
 }

 


});