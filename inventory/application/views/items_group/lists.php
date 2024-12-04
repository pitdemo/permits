<?php $this->load->view('layouts/header');?>

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
        <li class="active">Manage Items Group</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="items_group_form" id="items_group_form" method="post">
         <div class="row-fluid" style="margin-top : 20px"> 
         <?php if($this->session->userdata('session_user_type')!='viewer'){?>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>items_group/create_items_group'" type="button">+ Create Item Group</button>
          
          <?php } ?>
          <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
               <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                    <th class="center" width="10%">Group ID</th>
                      <th class="center" width="25%">Name</th>
                      <th class="center" width="15%">Items</th>
                      <th class="center" width="20%">Date</th>
                      <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>
                      <?php } ?> 
                       <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin' ){?>
                      <th class="center" width="20%">Action</th> 
                      <?php } ?>                                                         
                    </tr>
                  </thead>
                  <tbody>
                      
                      </tbody>
            </table>
          </div>
             
          
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
<style>
#table_report td
{
 text-align: center;
}
.sweet-alert { overflow-y: visible !important; }
</style>

<!--page specific plugin scripts--> 
<script src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script type="text/javascript">
$(function() 
{
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
  $('#table_report').dataTable(
  {
    "processing": true,
    "serverSide": true,
    "aaSorting": [[ 0, "desc" ]],
    <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
     "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5 ] } ], 
     <?php } ?>
    "ajax": { url :"<?php echo base_url()?>items_group/datafetch/", type: "post"},
    "columns": 
    [
      { "data": "id" },
      { "data": "item_group_name" },
      { 
        "mRender": function(data,type,full)
        {
          var id = full['id'];
          var encodedString = btoa(full['id']);
          //var name = "Erter";
          //return '<a href="<?php echo base_url(); ?>items/item_history/'+encodedString+'">'+full['items_count']+'</a>'; 
          if(full['active_count_only'] != '0')
          {
          return '<a href="javascript:void(0)" onclick="get_items_details('+full['id']+ ', \'' + full['item_group_name'] + '\');" title="View">'+full['active_count_only']+'</a>';
          }
          else
          {
          return '-';
          }
         // alert(items_array);
         /* if(full['stock'] != 0)
          {
          return '<a href="<?php echo base_url(); ?>items/item_history/'+encodedString+'">'+full['stock']+'</a>'; 
          }
          else
          {
          return full['stock'];
          }*/
        }
      },
      { 
        "mRender":function(data,type,full)
        {
        var date_created = full['created'];
        var dateAr1 = date_created.split('-');
        var sYear = dateAr1[0];
        var sMonth = dateAr1[1].toString();
        var dateAr2 = dateAr1[2].split(" ");
        var sDay = dateAr2[0];
          
        var created_date = sYear + '-' + sMonth + '-'+ sDay ;
        return  created_date;
          
        } 
      },
       <?php if($this->session->userdata('session_user_type')=='super_admin' ){?>
      {   
        "mRender":  function (data,type,full)                              
        {
          //console.log(full['status']);
          var data = full['status'];
          var id = full['id'];
          //return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
          if(data == 'inactive')
          {
            return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/inactive.png" title="Change Active" alt="no image"></a>';
          }
          else
          return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
        }
      },
      <?php } ?>
   
      <?php if($this->session->userdata('session_user_type')=='admin'){?>
      
      {   
        "mRender":  function (data,type,full)                              
        {
          //console.log(full['status']);
          var data = full['status'];
          var id = full['id'];
          var current = new Date();
        var get_current_date = formatDate(current);
         // Days you want to subtract
        var dateAr = get_current_date.split('-');
        var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
        var date = new Date(dateAr[0],dateAr[1]-1,dateAr[2]);
        var get_current_date_new = formatDate(date);
        var newdate = new Date(date);
        newdate.setDate(newdate.getDate() - 6); // minus the date
        var nd = new Date(newdate);
        var last_six = formatDate(nd);
        var date_created = full['created'];

        // Plus the Date

        var cal_six =new Date(date_created);
        cal_six.setDate(cal_six.getDate() + (6));
        var last_date = formatDate(cal_six);



        var dateAr1 = date_created.split('-');
        var sYear = dateAr1[0];
        var sMonth = (Number(dateAr1[1])).toString();
        var dateAr2 = dateAr1[2].split(" ");
        var sDay = dateAr2[0];
          
        var created_date = sYear + '-0' + sMonth + '-'+ sDay ;
        //alert(created_date);
          if(data == 'active')
                                {
                  
                               //  if(created_date >= last_six && created_date >= get_current_date_new)
                // if(created_date > last_six && created_date <= get_current_date_new)
                if(last_date >= get_current_date_new)
                  {
                return '<img style="cursor:pointer;" onClick="change_status('+id+',this);"  src="<?php echo base_url()?>assets/images/active.png" style="cursor:pointer;" title="Change Inactive">';
                  }
                  else
                  {
     return '<img src="<?php echo base_url()?>assets/images/expired.png" title="Date Expired" style="cursor:pointer;">';
                  
                  }
                                }
                              if(data == 'inactive')
                                {
                                   return '<img src="<?php echo base_url()?>assets/images/inactive.png" title="Change Active">';
                                }
      }
    },
      
      <?php } ?>
         <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type') == 'admin' ){?>
      {   
        "mRender":  function (data,type,full)                              
        {
          var id = full['id'];
          var encodedString = btoa(full['id']);
          //console.log(encodedString); 
          //return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
          return '<a href=<?php echo base_url()?>items_group/edit_item/'+encodedString+' class="btn btn-mini btn-info" type="button" title="Edit"><i class="icon-edit bigger-120"></i></a><button type="button" style="cursor:pointer;" onClick="delete_group_item('+id+');" class="btn btn-mini btn-danger" title="Delete"><i class="icon-trash bigger-120"></i></button>';
        }
      },
      <?php } ?>
      
    ],  

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
      function get_items_details(group_id,group_name,element) // get items details based on group id
            {
        
                 $.ajax({
                   url: '<?php echo base_url();?>items_group/ajax_get_items_details',
                   type: 'POST',
                   async : false,
                   data: { group_id:group_id },
                   success: function(data){ 
                    if(data == "")
                    {
                        swal({  
                                title:group_name , 
                                text: "<b>"+"No Records Found"+"</b>", 
                                html: true 
                        });
                    }
                    else
                    {
                          swal({  
                                title:group_name , 
                                text: data, 
                                html: true 
                        });
                     }
                   }
         });            
            }
      
      function delete_group_item(item_group_id,element)
      {
        var choice=confirm("Do you wish to continue?");
        if (choice==true)
        {
          var oTable = $('#table_report').dataTable();
          $(element).parents('tr').addClass('row_selected');
          var anSelected = fnGetSelected( oTable );
          $.ajax({
          url: '<?php echo base_url();?>items_group/delete_item',
          type: 'POST',
          data: { item_group_id:item_group_id },
          success: function(){
            if ( anSelected.length !== 0 )
             {
              oTable.fnDeleteRow( anSelected[0] );
             }
             
            if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
            {
              $("#succ_msg").show();
              $("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Item Group has been deleted successfully.<br>');
            }
            else {
              $("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Item Group has been deleted successfully.<br></div>');
            }
                 oTable.fnStandingRedraw();
    
          }
          });                   
        }
        else
        {
          return false;
        }
      }
      function change_status(item_group_id,element)
      {
        var table = $('#table_report').dataTable();
                if(confirm("Do you wish to continue?"))
                {
        $.ajax({
          url: '<?php echo base_url();?>items_group/change_status',
          type: 'POST',
          data: { item_group_id:item_group_id },
          beforeSend: function() { $(element).attr('src','<?php echo base_url();?>'+'assets/images/loader.gif'); },
          success: function(msg){
            if($.trim(msg) == 'inactive')
            {
              $(element).attr('src','<?php echo base_url();?>'+'assets/images/inactive.png');
              $(element).attr('title','Change Active');
            }
            else
            {
              $(element).attr('src','<?php echo base_url();?>'+'assets/images/active.png');
              $(element).attr('title','Change Inactive');
            }
            
            if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
            {
              $("#succ_msg").show();
              $("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Item Group status has been Changed successfully.<br>');
            }
            else {
              $("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Item Group status has been Changed successfully.<br></div>');
            }
            table.fnStandingRedraw();
          }
          });
                }
                else
                    return false;
      }


    </script>
</body>
</html>
