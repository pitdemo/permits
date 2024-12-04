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
        <li class="active">Change Password</li>
      </ul>
      
      <!--.breadcrumb-->
      
      
      <!--#nav-search--> 
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      <div class="alert alert-info" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?><br></div>
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Change Password</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            
            <form class="form-horizontal" name="change_password" id="change_password" method="post">
               <div class="control-group">
                <label class="control-label" for="form-field-1">Current Password</label>
                <div class="controls">
                  <input type="password" value="<?php echo set_value('current_password'); ?>" name="current_password" id="current_password" placeholder="" />
                  <?php echo form_error('current_password'); ?>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="form-field-1">New password</label>
                <div class="controls">
                  <input type="password" value="<?php echo set_value('new_password'); ?>" id="new_password" name="new_password" placeholder="" />
                  <?php echo form_error('new_password'); ?>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="form-field-1">Retype password</label>
                <div class="controls">
                  <input type="password" value="<?php echo set_value('retype_password'); ?>" name="retype_password" id="retype_password" placeholder="" />
                  <?php echo form_error('retype_password'); ?>
                </div>
              </div>
              <div class="control-group">
                <div class="controls">
                  <button class="btn btn-info" type="submit" name="change"> Change Now </button>
                  &nbsp; &nbsp; &nbsp;
                  <button class="btn" type="reset" onClick="javascript:window.history.back()"> Cancel </button>
                </div>
              </div>
              
              <!--/row-->
              
            </form>
            
            <!--PAGE CONTENT ENDS HERE--> 
          </div>
        </div>
        <div class="clearfix"></div><br/><br/>
      <?php $this->load->view('layouts/footer');?>
    </div>
    
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<!--<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> -->

<?php $this->load->view('layouts/footer_script');?>

<script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.3.custom.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.ui.touch-punch.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.easy-pie-chart.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.sparkline.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.pie.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/flot/jquery.flot.resize.min.js"></script> 
 

<!--inline scripts related to this page--> 

<script type="text/javascript">
			$(function() {
			
				$('.dialogs,.comments').slimScroll({
			        height: '300px'
			    });
				
				$('#tasks').sortable();
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
				var oldie = $.browser.msie && $.browser.version < 9;
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: oldie ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
				});
			
			
			
			
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaings",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ];
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  $.plot(placeholder, data, {
				
				series: {
			        pie: {
			            show: true,
						tilt:0.8,
						highlight: {
							opacity: 0.25
						},
						stroke: {
							color: '#fff',
							width: 2
						},
						startAngle: 2
						
			        }
			    },
			    legend: {
			        show: true,
					position: "ne", 
				    labelBoxBorderColor: null,
					margin:[-30,15]
			    }
				,
				grid: {
					hoverable: true,
					clickable: true
				},
				tooltip: true, //activate tooltip
				tooltipOpts: {
					content: "%s : %y.1",
					shifts: {
						x: -30,
						y: -50
					}
				}
				
			 });
			
			 
			  var $tooltip = $("<div class='tooltip top in' style='display:none;'><div class='tooltip-inner'></div></div>").appendTo('body');
			  placeholder.data('tooltip', $tooltip);
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$(this).data('tooltip').show().children(0).text(tip);
					}
					$(this).data('tooltip').css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$(this).data('tooltip').hide();
					previousPoint = null;
				}
				
			 });
			
			
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js');?>"></script>
<script type="text/javascript">

$(document).ready(function(){
	//alert("test");
	//Validation
	var validator = $("#change_password").validate({
	
	onkeyup: false,
	errorClass:'error_msg',
	
	rules:
	{
		current_password:
		{
			 required:true
			 
		},
		new_password:
		{
			 required:true
		},
		retype_password:
		{
			 required:true,
			 equalTo: "#new_password"
		}
	
	
	
	
	
	},
	messages:
	{
		current_password:
		{
			required: "The current password field is required"
		},
		new_password:
		{
			required: "The new password field is required"
		},
		retype_password:
		{
			required: "The confirm password field is required",
			equalTo: "Please confirm password same as new password."
		},
		debug:true
	},
	errorPlacement: function(error, element)
	{
		error.appendTo(element.parent());
	},
	submitHandler: function()
	{
		//$("#enabled_js").val("1");
		document.change_password.submit();
	},
	
	wrapper: "div"
	
	});
	
	
	
});

</script>

</body>
</html>
