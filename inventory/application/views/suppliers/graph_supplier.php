
<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
	
?>
 <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Accounting_Software</title>
        	<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			var options = {
	            chart: {
	                renderTo: 'container',
	                type: 'column'
	            },
	            title: {
	                text: 'Graph Info',
	                x: -20 //center
	            },
	            subtitle: {
	                text: '',
	                x: -20
	            },
	            xAxis: {
	                categories: []
	            },
	            yAxis: {
	                min: 0,
	                title: {
	                    text: 'Amount'
	                },
	                labels: {
	                    overflow: 'justify'
	                }
	            },
	            tooltip: {
	                formatter: function() {
	                        return '<b>'+ this.series.name +'</b><br/>'+
	                        this.x +': '+ this.y;
	                }
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                verticalAlign: 'top',
	                x: -10,
	                y: 100,
	                borderWidth: 0
	            }, 
	            plotOptions: {
	                bar: {
	                    dataLabels: {
	                        enabled: true
	                    }
	                }
	            },
	            series: []
	        }
	        
	        $.getJSON("<?php echo base_url();?>suppliers/ajax_get_supplier_graph/<?php echo $supplier_id;?>/<?php echo $url; ?>", function(json) {
				options.xAxis.categories = json[0]['data'];
	        	options.series[0] = json[1];
	        	options.series[1] = json[2];
	        	options.series[2] = json[3];
		        chart = new Highcharts.Chart(options);
	        });
	    });
		</script>
	  <script src="<?php echo base_url(); ?>js/highcharts.js" type="text/javascript"></script>
       <script src="<?php echo base_url(); ?>js/exporting.js" type="text/javascript"></script>
 
	</head>
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
            <a href="<?php echo base_url();?>suppliers">Supplier</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
		 <li>
		 	<?php echo ucfirst($supplier_details['supplier_name']); ?>
			<span class="divider"><i class="icon-angle-right"></i></span>
		 </li>
        <li class="active">Supplier Graph Info</li>
        
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 

        <div class="page-header position-relative" style="border-bottom:none !important;">
             <?php $this->load->view('layouts/sub_menu_supplier');?>
          </div>
      <!--/.page-header-->
        <br><br>  <br><br>
     <div class="row-fluid">
        <form name="graph" id="graph" method="post">
         <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class();?>" />
        <!-- <input type="text" name="range" id="range" />-->
            
            
            <select name="date_wise" id="date_wise" style="width:316px;margin-top:-10px" onChange="chk_search()">
             <option value=" ">Select</option>   
            <?php
                $day_types = array('Last 7 days','Last 30 days','custom');;
				
                foreach($day_types as $day_type)
                {
                   switch($day_type)
            {
                case 'Last 7 days':
                    $day_type1='7';
                    break;
                case 'Last 30 days':
                    $day_type1='30';
                    break;
					case 'custom':
                    $day_type1='custom';
                    break;
                
           }
		   		$search_values = explode(",",$get['chk_daytype']);
            ?>
                    <option value="<?php echo $day_type1; ?>" <?php echo in_array($day_type1,$search_values) ?'selected="selected"':"";?>><?php echo ucfirst($day_type); ?></option>
            <?php
                }          
            ?>
            </select>&nbsp;&nbsp; 
            <input type="text" style="width:125px;display:none;"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px;display:none;" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="end date" >&nbsp;&nbsp;
            <!--PAGE CONTENT BEGINS HERE-->
       
         <button class="btn btn-info" type="button" onClick="chk_search()"  style="margin-bottom:10px;display:none;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
        <div class="row-fluid"> 
          <div id="container" style="height: 400px; min-width: 600px; padding-top: 100px;"></div>
          <div class="clearfix"></div>
          <br/>
        
        </div>
         </form>  
                   

                       
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
  </div>
  <!--/#main-content--> 
</div>
<?php $this->load->view('layouts/footer_script');?>

	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 
<script type="text/javascript">
			$(function() {
            $('.start_date').datetimepicker(
                {
                    format:'Y-m-d',
                    timepicker:false,
                });	
            
            $('.end_date').datetimepicker(
                {
                    format:'Y-m-d',
                    timepicker:false,
               });	
			   
			    $('#date_wise').select2({
					allowClear: true,
					placeholder: "- - Recordwise - - "}); // select box select2 plugin
				//start
			 // Set the default dates
  	$('#date_wise').live('change', function () {
    if ((this.value) == 'custom') {
     $('.start_date').show(); 
	 $('.end_date').show(); 
	  $('.btn').show();
    }
	else if ((this.value) == '7') {
     $('.start_date').hide(); 
	 $('.end_date').hide(); 
	 $('.btn').hide();
    }
	else if ((this.value) == '30') {
     $('.start_date').hide(); 
	 $('.end_date').hide();
	  $('.btn').hide(); 
    }
		   });
			});
			
		
		function chk_search() // manual search function
	       {
			   
		       var supplier_id = "<?php echo $supplier_id;?>";
			   var frm = document.graph;
			   
			  if(frm.date_wise.value == "custom" && frm.start_date.value == "" && frm.end_date.value == "" )
		      {
			     $.growl.error({ message: "You must select date!" });
              }
		      else if(frm.date_wise.value == "custom" && frm.start_date.value != "" && frm.end_date.value == "" )
		      {
			     $.growl.error({ message: "You must select end date!" });
              }
		      else if(frm.date_wise.value == "custom" && frm.start_date.value == "" && frm.end_date.value != "" )
		      {
			     $.growl.error({ message: "You must select start date!" });
              }
		      else
		      {
                var url = "";
               
				url += (frm.date_wise.value != "")?'/day_type/'+frm.date_wise.value:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
             
			   window.location.href= $("#base_url").val()+"/graph/" + supplier_id +url;
			  
			  
			   
		      }
	       
		   }
		   
           function reset_srh() // reset function 
	       {
		       var supplier_id = "<?php echo $supplier_id;?>";
			  window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method();?>/"+supplier_id;
	       }
		   
		   

		
            
            
</script>
</body>
</html>
