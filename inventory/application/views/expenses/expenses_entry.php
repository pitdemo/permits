<?php $this->load->view('layouts/header');?>
<style type="text/css">
    .sweet-alert h2 {
        font-size:20px !important;
    }
    input[type="text"] { width:150px; }
select{width:150px;}
</style>
 <?php  
      if(SITE_WORK == 'progress')
{
   echo "<script>alert('work in progress');</script>";
  
}

 ?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<body>
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li>
            <a href="<?php echo base_url();?>expenses">Manage Expenses</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Expense Entry</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
       <a href="javascript:void(0);" id="add_more" class="btn btn-info" style="float:right"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a>
      <!--/.page-header-->
      
      <div class="row-fluid" style="margin-top:30px"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
         
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form action="" method="post" name="expense_form" id="expense_form">
               <input type="hidden" name="e_id" id="e_id" value="" >
               <input type="hidden" name="f_id" id="f_id" value="" > 
                <table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
                      <th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending">Expense Category *</th>
                      <th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Expense Amount *</th>
                      <th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Expense Date</th>
                      <th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending">Expense Description *</th>
                      
                      <!--<th class="center" width="15%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Action</th>-->
                    </tr>
                  </thead>
                  
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                  <tr class="odd">
                    <td valign="top" class="dataTables_empty">
                    <input type="hidden" name="categories[]" style="width:200px"  id="categories"/>
            
                          </td>
                            <td valign="top" class="dataTables_empty"><input type="text" class='amount_box' name="amounts[]" /></td>
                             <td valign="top" class="dataTables_empty">  <input type="text"  name="expense_date[]" class="receipt_entry_date" placeholder="Expense date" /></td>
                            <td valign="top" class="dataTables_empty"><textarea name="description[]]" rows="2"></textarea></td>
                   
                 
                  </tr>
                </tbody>
              </table>
          
                <button type="submit" style="float:left; margin-left:10px; margin-top:10px;" name="add" class="btn btn-info" > Submit <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
     
    </div>
  </div>
    </form>
            
        <!--     PAGE CONTENT ENDS HERE
          </div>
        </div> -->
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
	<?php $this->load->view('layouts/footer_script');?> 
    <script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.0.min.js')?>"></script> 
    
		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
    <script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
		<script type="text/javascript">
    $(function(){
  
// amount conversion script code
  $(".amount_box").blur(function(){
    res =  accounting.formatMoney($(this).val(),'');
    $(this).val(res);
});
//end 


  
  // select2 load remote data code start
 $("#categories").select2({
                  allowClear: true,
                  placeholder: "- - Select - - ",
                   minimumInputLength: 1,                 
                   quietMillis: 100,
                   multiple:false,
                    ajax: { 
                      url: "<?php echo  base_url(); ?>expenses/ajax_get_active_expenses_category/",
                      dataType: 'json',
                      cache: true,
                    quietMillis: 200,
                      data: function (term, page) {
                        return {
                          q: term, // search term
                          page_limit: 10,
                          s:15,
                        };
                      },
                      results: function (data, page) { // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter remote JSON data
                        var myResults = [];
                                               /* var supplier_list = [];
                                                var customer_list = [];*/
                            $.each(data, function (index, item) {
                                                          myResults.push({
                                id: item.id,
                                text:item.internal
                              });
                              console.log(myResults);
                                                            
                            });
                                                    
                                                        
                                                        
                            return {
                              results: myResults
                            };
                         
                      }
                    },
          
                });
 
 
  $('#table_report').on('click','.remove',function(){
      if(confirm('Are you confirm?'))
      {
          $(this).parents('tr').remove();
      }
      else
        return false;
    });
  k=1;
  $('#add_more').click(function(){
      /*var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="categories[]" style="width:200px" id="categories'+k+'" data-id="'+k+'" /></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]" id="amounts'+k+'></td><td valign="top" class="dataTables_empty"> <input type="text"  name="expense_date[]" class="receipt_entry_date'+k+'" placeholder="Expense date" id="expense_date'+k+'" ></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="description[]"  id="description'+k+'"></textarea><br><a href="javascript:void(0)" class="remove"><span style="float:right;margin-right:180px">(X)</span></a></td></tr>';*/
      var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="hidden" name="categories[]" style="width:200px" id="categories'+k+'" data-id="'+k+'" /></td><td valign="top" class="dataTables_empty"><input type="text" class="amount_box" name="amounts[]"></td><td valign="top" class="dataTables_empty"> <input type="text"  name="expense_date[]" class="receipt_entry_date'+k+'" placeholder="Receipt date" ></td><td valign="top" class="dataTables_empty"><textarea rows="2" name="description[]"></textarea><br><a href="javascript:void(0)" class="remove"><span style="float:right;margin-right:180px">(X)</span></a></td></tr>';
      $('#table_report tr:last').after(add_html);
      
      $('.receipt_entry_date'+k+'').datetimepicker(
      {
            format:'Y-m-d',
            maxDate : '<?php echo date('Y-m-d'); ?>',
          timepicker:false
        }); 
        
        
        // ajax server side
          $("#categories"+k+"").select2({
                  allowClear: true,
                  placeholder: "- - Select - - ",
                   minimumInputLength: 1,                 
                   quietMillis: 100,
                   multiple:false,
                    ajax: { 
                      url: "<?php echo  base_url(); ?>expenses/ajax_get_active_expenses_category/",
                      dataType: 'json',
                      cache: true,
                    quietMillis: 200,
                      data: function (term, page) {
                        return {
                          q: term, // search term
                          page_limit: 10,
                          s:15,
                        };
                      },
                      results: function (data, page) { // parse the results into the format expected by Select2.
                        // since we are using custom formatting functions we do not need to alter remote JSON data
                        var myResults = [];
                                                 /*var supplier_list = [];
                                                var customer_list = [];*/
                            $.each(data, function (index, item) {
                             /* lastchar = item.id;
                                                            res = lastchar.substr(lastchar.length - 1);
                                                           if(res=='s')
                                                           {
                                                               supplier_list.push({
                                id: item.id,
                                text:item.internal
                                   });
                                                           }
                                                            else
                                                            {
                                                                customer_list.push({
                                id: item.id,
                                text:item.internal
                                   });
                                                            }*/
                                                            myResults.push({
                                id: item.id,
                                text:item.internal
                              });
                              console.log(myResults);
                            });
                                                
                                                         /*if(supplier_list.length > 0)
                                                        {
                                                             myResults.push({
                                                                    text: 'Suppliers',
                                                                    children:supplier_list
                                                                });    
                                                        }
                                                        if(customer_list.length > 0)
                                                        {
                                                               myResults.push( {
                                                                    text: 'Customers',
                                                                    children:customer_list
                                                                }); 
                                                        }*/
                            return {
                              results: myResults
                            };
                         
                      }
                    },
          
                });
                
                
        // amount conversion script code
          $(".amount_box").blur(function(){
                 res =  accounting.formatMoney($(this).val(),'');
                 $(this).val(res);
                });
        //end 
        
        //quantity textbox allow only number script start
        /*$('.qtyNumeric').keydown(function (e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {
              e.preventDefault();
              } else {
          var key = e.keyCode;
              if (!((key == 8) || (key == 9) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
            e.preventDefault();
          }
        }
    });*/
//end


// get select2 selected values.
/*$('body').on('change',"#supplier"+k,function() { 
  q=$(this).data('id');
  var c_id = $(this).val();
  $('#re_id'+q).attr('value',c_id);
  var cst_id=c_id.substring(0,c_id.length - 2);

  $("#re_id"+k).attr('value',c_id);

  var result=0;
  if(c_id!=''){

  $.ajax({
    type:'post',
    url:'<?php echo base_url();?>receipts/transactions/'+c_id,
    data:{id:cst_id},
    success:function(data){
      if(data=='false')
      {
        $('#error_show'+q).show();
        $("#ot_link"+q).show();
      }
      else
      {
        result=data;
        $("#tr_link"+q).show();
        $("#ot_link"+q).show();
      }

    }

  });
  }
  $('#error_show'+q).hide();
  $("#tr_link"+q).hide();
  $("#ot_link"+q).hide();

    }); */

// OutStanding Open Dynamically using ColorBOx......
/*$('body').on('click',"#tr_link"+k,function() { 
  j=$(this).data('id');
  var cc_id=$("#re_id"+j).val();
  $.colorbox({
                         href:'<?php echo base_url();?>receipts/transactions/'+cc_id,
                         iframe:true, 
                         reposition:true,
                         opacity:0.7 , 
                         rel:'group1',
                         slideshow:false,
                         height:"90%",
                         width:"80%",
                     });
});*/
/*
$('body').on('click',"#ot_link"+k,function() { 
  j=$(this).data('id');
  var cc_id=$("#re_id"+j).val();
  $.colorbox({
                         href:'<?php echo base_url();?>receipts/out_transactions/'+cc_id,
                         iframe:true, 
                         reposition:true,
                         opacity:0.7 , 
                         rel:'group1',
                         slideshow:false,
                         height:"90%",
                         width:"80%",
                     });
});*/


        
        k++;
        
    });
  
  $('.receipt_entry_date').datetimepicker(
 {
  format:'Y-m-d',
  maxDate : '<?php echo date('Y-m-d'); ?>',
   timepicker:false
 });  
  
   // validation for while clicking the submit button
                 $("#expense_form" ).submit(function( event ) {
                      var date_err=categories_err=amounts_err=description_err=0;
                      var err_msg='';
                        
                       
                      // validation for expense date   
                    $('input[name="expense_date[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 date_err++;
                              
                            }
                        });
                            

                    $('input[name="categories[]"]').each(function(){
                            if($(this).val()=='')
                            {
                                 categories_err++;  
                            }
                        });
                     
          //validate  Amount
          $('input[name="amounts[]"]').each(function(){
                if($(this).val()=='')
              {
                 amounts_err++; 
              }
            
          });
                  //validate Description
          $('textarea[name="description[]"]').each(function(){
                if($(this).val()=='')
              {
                 description_err++; 
              }
            
          });

                       
                                        
                    if(categories_err!=0)
                    {
                        err_msg+="\n *  All Expense Category field is required ";
                    }
                    
                       if(amounts_err!=0)
                    {
                        err_msg+="\n *  All Expense Amount field is required ";
                    }
          
           if(description_err!=0)
                    {
                        err_msg+="\n *  All Description field is required ";
                    }
                       
           if(date_err!=0)
                    {
                         err_msg+= "\n * Expense date field is required";
                    }
                       
                    if(date_err==0&&categories_err==0&&amounts_err==0&&description_err==0&&date_err==0)
               {
          
          if($('#f_id').val()=='')
          {
            console.log('Form sub');
            
            $('#f_id').val(1);
            
            return true;
          }
          else
          {
            console.log('Form Not sub');
            
            return false;
          }
          
        }
             else
             {
                        swal(err_msg);  // sweetalert syntax
                        return false;
             }
                       
                   }); 
    
});
		
		</script>
 </body>
</html>
