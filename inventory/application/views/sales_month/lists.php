<?php $this->load->view('layouts/header');?>
<?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
?>
<head>
<style type="text/css">
td.center1
{
    text-align:right;
}
.center_rupee
{
    text-align:left;
}

td .test_dem p{
 font-weight: bold;
}
.item{
  text-align:center;
  font-weight: bold;
  color:#0b6cbc;
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
        <li class="active">Manage Sales</li>
      </ul>
      <!--.breadcrumb-->
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="sales_form" id="sales_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
                <input type="hidden" id="check_segment" value="<?php echo $uri_data;?>">
                <input type="hidden" id="min_date" name="min_date" value="<?php echo date('Y-m-d');?>">
                <input type="hidden" id="max_date" name="max_date" value="<?php echo date("Y-m-d", strtotime("-9 months", strtotime(date('Y-m-d'))))?>">
            <div class="row-fluid">
             <div class="row-fluid">
            
             <span style="margin-top:10px;font-size:15px;color:#555"><b>DATE FROM</b></span>
             <input type="text" style="width:125px" name="end_date" id="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="Sales end date" readonly>&nbsp;&nbsp;&nbsp;
              <span style="margin-top:10px;font-size:15px;color:#555"><b>DATE TO </b></span>&nbsp;&nbsp; 
             <input type="text" style="width:125px"  name="start_date" id="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Sales start date" readonly>&nbsp;&nbsp;&nbsp;
             <span style="margin-top:10px;font-size:15px;color:#555"><b>ITEMWISE</b></span>
             <select name="item_id[]" multiple="multiple" id="item_id" style="width:316px;margin-top:-10px">
                       <option></option>
                       <?php
                        if(!empty($items))
                        {
                            $srch_items = explode(",",$get['chk_item_id']);
                            foreach($items as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['item_code'].'-'.$item['item_name']; ?></option>
                        <?php
                             }
                        }
    
                        ?>
            </select>&nbsp;&nbsp;
           
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
           &nbsp;&nbsp; 
            </div>
              <!-- <div class="row-fluid" style="padding-left:80px"> --> 
            <!--  <select name="person[]" multiple="multiple" id="person" style="width:316px;margin-top:-10px">
        <option></option>
                       <?php
                        if(!empty($persons))
                        {
                            $srch_items = explode(",",$get['chk_person']);
                            foreach($persons as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['sales_person_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp; -->
            
            <!-- <select name="item_id[]" multiple="multiple" id="item_id" style="width:316px;margin-top:-10px">
        <option></option>
                       <?php
                        if(!empty($items))
                        {
                            $srch_items = explode(",",$get['chk_item_id']);
                            foreach($items as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['item_code'].'-'.$item['item_name']; ?></option>
                        <?php
                             }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
           
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a> -->
            
           <!--  </div> -->
        <br>
         <?php if($this->session->userdata('session_user_type')!='viewer'){?>
       
       <?php } ?>
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
               <table id="table_report" class="table table-striped table-bordered table-hover remove_header">
                  <!--  <thead>
       
                      <tr>
                          <?php 
                          
                            for($i=0;$i<$head_count;$i++)
                            {?>
                                 <th></th>
                            <?php }?>
                      </tr>

                    </thead> 
        -->
                 
                  <tbody>
     
                  </tbody>
            </table>
          </div>
             
         <!-- <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_pdf()" type="button">Export PDF</button>-->
             <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_csv()" type="button">Export CSV</button>
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



  jQuery.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) 
  {

    if(oSettings.oFeatures.bServerSide === false)
    {
      var before = oSettings._iDisplayStart;
      oSettings.oApi._fnReDraw(oSettings);
      // iDisplayStart has been reset to zero - so lets change it back
      oSettings._iDisplayStart = before;
      oSettings.oApi._fnCalculateEnd(oSettings);
    }
// draw the 'current' page
oSettings.oApi._fnDraw(oSettings);
};

$('.start_date').datetimepicker(
{
  format:'Y-m-d',
  timepicker:false,
  maxDate: 'now',
  
});

$('.end_date').datetimepicker(
{
  format:'Y-m-d',
  timepicker:false,
  maxDate: 'now',

}); 

$(window).load(function(){
  if($("#check_segment").val() == "")
  {
    $("#start_date").val($("#min_date").val());
    $("#end_date").val($("#max_date").val());
   /* var end_date = new  date('Y-m-d');
    var start_date = new date("Y-m-d", strtotime("-9 months", strtotime(end_date)));
    $("#start_date").val(end_date);*/
    //$('.start_date').datetimepicker('setDate', (new Date()) );
  }
 
});


//start 
$('#person').select2({
allowClear: true,
placeholder: "- - Sales Personwise - - "}); // select box select2 plugin


$('#item_id').select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin


var table = "";
var head_count=<?php echo $head_count?>;
var atargets=[];
for(i=0;i<head_count;i++)
{
    atargets.push(i);
}

$('#table_report').dataTable( 
{
  "processing": true,
  "pageLength": 65,
  "serverSide": true,
  "aaSorting": [[ 0, "asc" ]],

  "aoColumnDefs": [ { "bSortable": false, "aTargets": atargets } ], 

  "hideEmptyCols": true,  

  "ajax": {url :"<?php echo base_url()?>sales_month/datafetch/<?php echo $uri_data;?>",type: "post"},
 "fnInitComplete": function(oSettings) {
        $('.remove_header thead').hide();
    },
    createdRow: function(row, data, dataIndex){
         var item_title = $('td:eq(0)', row).find('p[data-yourattr]').data("yourattr");
         //alert(item_title);
        // If name is "Ashton Cox"
        if(item_title == 'item'){
          //alert(data[0].attr('class'));
            // Add COLSPAN attribute
            $('td:eq(0)', row).attr('colspan', 11);
            //$('td:eq(0)', row).attr('halign','center');
            //$('td:eq(0)', row).attr('font-color','red');


            // Hide required number of columns
            // next to the cell with COLSPAN attribute
            $('td:eq(1)', row).css('display', 'none');
            $('td:eq(2)', row).css('display', 'none');
            $('td:eq(3)', row).css('display', 'none');
            $('td:eq(4)', row).css('display', 'none');
            $('td:eq(5)', row).css('display', 'none');
            $('td:eq(6)', row).css('display', 'none');
            $('td:eq(7)', row).css('display', 'none');
            $('td:eq(8)', row).css('display', 'none');
            $('td:eq(9)', row).css('display', 'none');
            $('td:eq(10)', row).css('display', 'none');
            $('td:eq(11)', row).css('display', 'none');

            // Update cell data
            this.api().cell($('td:eq(1)', row)).data('N/A');
        }
    }
/*  "headerCallback": function( thead, data, start, end, display ) {
    var response = this.api().ajax.json();      
    var heading = response['header'];
    var count = response['header_count'];

    for(i=0;i<count;i++)
    {
      if(heading[i]!='undefined')
      {
       $(thead).find('th').eq(i).html(heading[i]);      
      }
      else
      {
        $(thead).find('th').eq(i).html('');       
      }
    } 
    
  },*/
});
      
});
      
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
      function fnGetSelected( oTableLocal )
      {
        return oTableLocal.$('tr.row_selected');
      }
  
      function chk_search() // manual search function
      {
    
          var frm = document.sales_form;
          ids="";
          /*ids_person="";
          $("#person").each(function() {
              ids_person +=$(this).val();
          });*/
    
          $("#item_id").each(function() {
                ids +=$(this).val();
          });
        
          var start = new Date(frm.start_date.value);
          var end   = new Date(frm.end_date.value);

          var month_diff = start.getMonth() - end.getMonth() 
          + (12 * (start.getFullYear() - end.getFullYear()));

          if(frm.item_id.value == "" && frm.start_date.value == "" && frm.end_date.value == "")
          {   
          $.growl.error({ message: "You must select atleast one!" });
          }
          else if( frm.start_date.value != "" && frm.end_date.value == "" )
          {
        
          $.growl.error({ message: "You must select end date!" });
          }
          else if( frm.start_date.value == "" && frm.end_date.value != "" )
          {
           $.growl.error({ message: "You must select start date!" });
          }
          else if(  frm.start_date.value  < frm.end_date.value &&  frm.start_date.value != "" && frm.end_date.value != ""   )
          {
          $.growl.error({ message: "End date can not be after start date!" });
          }
          else if(month_diff >= 10)
          {
          $.growl.error({ message: "Month difference cannot be exceed 10!" });

          }
          else
          {
                var url = "";
                url += (frm.item_id.value != "")?'/item_id/'+ids:"";
                /*url += (frm.person.value != "")?'/person/'+ids_person:"";*/
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";

                window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
          }
         }
        
        function reset_srh() // reset function 
        {
          window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
        }

        function export_csv() // download csv document
        {         
                var value = $('.dataTables_filter input').val();
                console.log(value); // <-- the value
                var frm = document.sales_form;
                ids="";
                $("#item_id").each(function() {
                    ids +=$(this).val();
                });
        
              /*  ids_person="";
                $("#person").each(function() {
                    ids_person +=$(this).val();
                });*/
        
                url="";
                url += (frm.item_id.value != "")?'/item_id/'+ids:"";
                //url += (frm.person.value != "")?'/person/'+ids_person:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                var url = $("#base_url").val()+"/datafetch/option_type/csv"+url;
                window.open(url);
            
        }

    
       </script>
</body>
</html>
