<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
?>
<style type="text/css">
td.center1
{
		text-align:right;
}
a.save-collection {
        margin-right: 1em;
    }
</style>

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
        <li class="active">Outstanding Report</li>
      </ul>
   </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="sales_form" id="sales_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid">
        
         <div class="row-fluid">
            <form name="sales_form" id="sales_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
             <select name="user_type" id="user_type" style="width:206px;margin-top:0">
               <option value="customer" <?php echo ($get['chk_usertype'] == 'customer')?'selected="selected"':"";?>>Customers</option>
                 <option value="supplier" <?php echo ($get['chk_usertype'] == 'supplier')?'selected="selected"':"";?>>Suppliers</option>
                 
                 
          <?php /*?>  <?php
                $user_types = unserialize(USER_TYPES);
                foreach($user_types as $role)
                {
                    
            ?>
                    <option value="<?php echo $role ?>" <?php echo ($get['chk_usertype'] == 'supplier')?'selected="selected"':"";?>><?php echo ucfirst($role); ?></option>
            <?php
                }          
            ?><?php */?>
            </select>&nbsp;&nbsp; 
            
            <select name="salesman_list_customer[]" multiple="multiple" id="salesman_list_customer" class="salesman_list_customer" style="width:250px">
			 	<option></option>
                       <?php
                        if(!empty($salesman_list_customer))
                        {
                            $srch_items = explode(",",$get['chk_sales_person_customer']);
                            foreach($salesman_list_customer as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['sales_person_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
                    
                     <select name="salesman_list_supplier[]" multiple="multiple" id="salesman_list_supplier" class="salesman_list_supplier" style="width:250px">
			 	<option></option>
                       <?php
                        if(!empty($salesman_list_supplier))
                        {
                            $srch_items = explode(",",$get['chk_sales_person_supplier']);
                            foreach($salesman_list_supplier as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['sales_person_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
            <select name="person[]" multiple="multiple" id="person" class="person" style="width:316px;margin-top:0px;">
			 	       <?php
                        if(!empty($persons))
                        {
							$srch_items = explode(",",$get['chk_person']);
                            foreach($persons as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['customer_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
                    
                                        
                     <select name="person_supplier[]" multiple="multiple" id="person_supplier" class="person_supplier" style="width:316px;margin-top:0;">
			 	<option></option>
                       <?php
                        if(!empty($person_suppliers))
                        {
                            $srch_items = explode(",",$get['chk_person_supplier']);
                            foreach($person_suppliers as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['supplier_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
                    
                    
                    
                 <!--   <input type="hidden" name="person[]" style="width:200px"  id="person" />-->
             <button class="btn btn-info" type="button" onClick="chk_search()"  style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
            
            <br>
           <button class="btn btn-info" style="float:right; margin-left:10px; margin-top:21px;" onClick="export_csv()" type="button">Export CSV</button>
            </div>
        <!--PAGE CONTENT BEGINS HERE-->
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
      
          <div class="table-outer" style="margin-top:10px">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="3%"> ID</th>
                        <th class="center" width="10%">Name</th>
                         <th class="center" width="10%">Salesman</th>
						  <th class="center" width="10%">Outstanding</th>
                         <th class="center" width="10%">0-30</th>
                        <th class="center" width="10%">30-60</th>
                        <th class="center" width="10%">60-90</th>
                        <th class="center" width="10%">90-120</th>
                        <th class="center" width="10%"> >120</th>
                      <th class="center" width="10%">Total</th>
                                         
                    </tr>
                  </thead>
                  
                  <tfoot>
            <tr>
             <th></th>
                  <th></th>
                  <th></th>
                   <th></th>
                   <th></th>
                  <th> </th>
                  <th></th>
                   <th></th>
                    <th></th>
                      <th></th>
            </tr>
          
        </tfoot>
                  <tbody>
     
    </tbody>
            </table>
          </div>
             
         <!-- <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_pdf()" type="button">Export PDF</button>-->
             <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:20px;" onClick="export_csv()" type="button">Export CSV</button>
          <div class="clearfix"></div>
          <br/>
        
        </div>
        
         </form>
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div>
      <br/>
      <br/>
            <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<!--/.fluid-container#main-container--> 

<!--<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> -->

<!--basic scripts--> 

<?php $this->load->view('layouts/footer_script');?>
<!--page specific plugin scripts--> 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>


<script type="text/javascript">

			$(function() {
			$('.person_supplier').hide(); 
			  $('.salesman_list_supplier').hide(); 
		  if(localStorage.getItem('selection') == 'customer' ){				
			  $('.person').show(); 
			  $('.person_supplier').hide(); 
			  $('.salesman_list_customer').show(); 
			  
			  $('.salesman_list_supplier').hide(); 
			  $('.btn').show();
			  localStorage.removeItem('selection');
			  }
			  
				  if(localStorage.getItem('selection') == 'supplier' ){				
				  
					   $('.person_supplier').show(); 
					    $('.salesman_list_supplier').show(); 
					   $('.salesman_list_customer').hide(); 
					   $('.person').hide();
						$('.btn').show(); 
						localStorage.removeItem('selection');

				  }
			
					$('#user_type').select2({
					allowClear: true,
					placeholder: "- - Customers - - "}); // select box select2 plugin
					
		         	$('#person').select2({
					allowClear: true,
					placeholder: "- - Customers - - "}); // select box select2 plugin
					
					$('#person_supplier').select2({
					allowClear: true,
					placeholder: "- - Suppliers - - "}); // select box select2 plugin
			
			$('#salesman_list_customer').select2({
					allowClear: true,
					placeholder: "- - Sales Persons - - "}); // select box select2 plugin
				
			$('#salesman_list_supplier').select2({
					allowClear: true,
					placeholder: "- - Sales Persons - - "}); // select box select2 plugin
										
	$('#user_type').live('change', function () {
    if ((this.value) == 'customer') {
     $('.person').show(); 
	 $('.person_supplier').hide(); 
	  $('.salesman_list_customer').show(); 
	  $('.salesman_list_supplier').hide(); 
	 $('.btn').show();
	  localStorage.setItem('selection','customer');
    }
	
	else if ((this.value) == 'supplier') {
		//alert(this.value);
     $('.person_supplier').show(); 
	 $('.person').hide();
	  $('.salesman_list_supplier').show(); 
	   $('.salesman_list_customer').hide(); 
	 $('.btn').show(); 
	   localStorage.setItem('selection','supplier');
    }
	
	
		   });
		  $('#salesman_list_customer').change(function() {
		  	//$('#persons').prop('disabled', $(this).val() != '');
			$("#person option[value='']").attr('selected', true);
			 $("#person").load("<?php echo base_url("outstanding/salesman_list_customer");?>" + "/" + $('#salesman_list_customer').val()+"/"+$("#person").val());
			 if( $('#user_type').val() == 'customer')
			 {
				$('.person').show(); 
				 $('.person_supplier').hide(); 
				  $('.salesman_list_customer').show(); 
				  $('.salesman_list_supplier').hide(); 
			 }
			 
			}).change(); // And invoke immediately
 
		   
	$('#salesman_list_supplier').change(function() {
      		$("#person_supplier option[value='']").attr('selected', true);
			 $("#person_supplier").load("<?php echo base_url("outstanding/salesman_list_supplier");?>" + "/" + $('#salesman_list_supplier').val()+"/"+$("#person_supplier").val());
			 if( $('#user_type').val() == 'supplier')
			 {
				$('.person_supplier').show(); 
	 $('.person').hide();
	  $('.salesman_list_supplier').show(); 
	   $('.salesman_list_customer').hide();  
			 }
			}).change(); // And invoke immediately
 			   
					
			
					$('#table_report').dataTable( {
						
						
						 "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
							 
							 //outstanding
							 
							  var iTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][3].replace(/\,/g,''));
			   iTotalamount += number*1;
            }
			
			
        
            var iPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][3].replace(/\,/g,''));
			iPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var outstanding = accounting.formatMoney(iPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var Total_outstanding = accounting.formatMoney(iTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});

							 
		    var iTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][4].replace(/\,/g,''));
			   iTotalamount += number*1;
            }
			
			
        
            var iPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][4].replace(/\,/g,''));
			iPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var last_thirty = accounting.formatMoney(iPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var Total_last_thirty = accounting.formatMoney(iTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});


// thirty-sixty amount

		    var iDebitTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][5].replace(/\,/g,''));
			   iDebitTotalamount += number*1;
            }
			
			
        
            var iDebitPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][5].replace(/\,/g,''));
			iDebitPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var thirty_sixty = accounting.formatMoney(iDebitPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var total_thirty_sixty = accounting.formatMoney(iDebitTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
 
 
// sixty-ninety amount

		    var iDebitTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][6].replace(/\,/g,''));
			   iDebitTotalamount += number*1;
            }
			
			
        
            var iDebitPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][6].replace(/\,/g,''));
			iDebitPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var sixty_ninety = accounting.formatMoney(iDebitPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var total_sixty_ninety = accounting.formatMoney(iDebitTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});

// ninety_onetwenty amount

		    var iDebitTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][7].replace(/\,/g,''));
			   iDebitTotalamount += number*1;
            }
			
			
        
            var iDebitPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][7].replace(/\,/g,''));
			iDebitPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var ninety_onetwenty = accounting.formatMoney(iDebitPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var total_ninety_onetwenty = accounting.formatMoney(iDebitTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
// above_onetwenty amount

		    var iDebitTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][8].replace(/\,/g,''));
			   iDebitTotalamount += number*1;
            }
			
			
        
            var iDebitPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][8].replace(/\,/g,''));
			iDebitPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var above_onetwenty = accounting.formatMoney(iDebitPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var total_above_onetwenty = accounting.formatMoney(iDebitTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
// total amount

		    var iDebitTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][9].replace(/\,/g,''));
			   iDebitTotalamount += number*1;
            }
			
			
        
            var iDebitPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][9].replace(/\,/g,''));
			iDebitPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var last_thirty =accounting.formatMoney(iPageamount);
			var sub_total = accounting.formatMoney(iDebitPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var Total_last_thirty =accounting.formatMoney(iTotalamount);
			var total = accounting.formatMoney(iDebitTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});

			
            var nCells = nRow.getElementsByTagName('th');
           // nCells[1].innerHTML = '<b style="text-align:right">Rs.</b>' + last_thirty +   '<br> Rs.'+ Total_last_thirty ;
		   nCells[3].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+outstanding +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+Total_outstanding +"<br>" ;  
       nCells[4].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+last_thirty +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+Total_last_thirty +"<br>" ;
	    nCells[5].innerHTML= "<div style=text-align:left;>" + '<br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+thirty_sixty +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+total_thirty_sixty +"<br>" ;
		nCells[6].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+sixty_ninety +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+total_sixty_ninety +"<br>" ;
		nCells[7].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+ninety_onetwenty +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+total_ninety_onetwenty +"<br>" ;
		nCells[8].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+above_onetwenty +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+total_above_onetwenty+"<br>" ;
		nCells[9].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+sub_total +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+ total +"<br>" ;
	    
		},
                        "aaSorting": [],
				// dom: "Tfrtip",
					//"dom": 'T<"clear">lfrtip',
					"ajax": {
								 "url" : '<?php echo base_url();?>outstanding/ajax_get_customers_list/<?php echo $url; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center1" },{ "sClass": "center1" },{ "sClass": "center1" },{ "sClass": "center1" },{ "sClass": "center1" },
					{ "sClass": "center1" },
					{ "sClass": "center1" },
				  						
					],
								
				});
			//end
				/*if(window.location.hash)
				{
					oTable1.fnFilter(window.location.hash.substring(1));
				}				*/
					
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			 function chk_search() // manual search function
	       {
		   				
		     var frm = document.sales_form;
			 
			   ids_person="";
               $("#person").each(function() {
			        ids_person +=$(this).val();
                });
				
				ids_salesman_list_customer="";
               $("#salesman_list_customer").each(function() {
                    ids_salesman_list_customer +=$(this).val();
                });
				
				
				ids_salesman_list_supplier="";
               $("#salesman_list_supplier").each(function() {
                    ids_salesman_list_supplier +=$(this).val();
                });
				
				 ids_person_supplier="";
               $("#person_supplier").each(function() {
                    ids_person_supplier +=$(this).val();
                });
				
						
				
				/*$.ajax({
						url: '<?php echo base_url();?>outstanding/salesman_list_customer/'+$('#salesman_list_customer').val()+'/'+$("#person").val()+'',
						type: 'GET',
						success: function(response){
							$("#person").html(response);
							console.log(hello);
							return false
								}
						});*/
				 /*if( frm.salesman_list_customer.value =='' && frm.user_type.value == "customer"  &&  frm.person.value  == "" )
				    {
			     $.growl.error({ message: "You must select Customer / Sales Person!" });
              }
			  
			 
		     
		      else
		      {*/
                var url = "";
               
                url += (frm.user_type.value != "customer")?'/user_type/'+frm.user_type.value:"";
				url += (frm.person.value != "")?'/person/'+ids_person:"";
				url += (frm.person_supplier.value != "")?'/person_supplier/'+ids_person_supplier:"";
				url += (frm.salesman_list_customer.value != "")?'/sales_person_customer/'+ids_salesman_list_customer:"";
				url += (frm.salesman_list_supplier.value != "")?'/sales_person_supplier/'+ids_salesman_list_supplier:"";
			    window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
			 // }
	       }
			
		
		   
		     function reset_srh() // reset function 
	       {
		      window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
	       }
        
         function export_csv() // download csv document
        {
              
             var frm = document.sales_form;
                  ids_person="";
               $("#person").each(function() {
                    ids_person +=$(this).val();
                });
				
				 ids_person_supplier="";
               $("#person_supplier").each(function() {
                    ids_person_supplier +=$(this).val();
                });
                
				
                ids_salesman_list_customer="";
               $("#salesman_list_customer").each(function() {
                    ids_salesman_list_customer +=$(this).val();
                });
				
				ids_salesman_list_supplier="";
               $("#salesman_list_supplier").each(function() {
                    ids_salesman_list_supplier +=$(this).val();
                });
				
				search_url="";
				 search_url += (frm.user_type.value != "customer")?'/user_type/'+frm.user_type.value:"";
				search_url += (frm.person.value != "")?'/person/'+ids_person:"";
				search_url += (frm.person_supplier.value != "")?'/person_supplier/'+ids_person_supplier:"";
				search_url += (frm.salesman_list_customer.value != "")?'/sales_person_customer/'+ids_salesman_list_customer:"";
				search_url += (frm.salesman_list_supplier.value != "")?'/sales_person_supplier/'+ids_salesman_list_supplier:"";
				
                var url = $("#base_url").val()+"/ajax_get_customers_list/option_type/csv"+search_url;
               window.open(url);
            
        }
        
		</script>
</body>
</html>
