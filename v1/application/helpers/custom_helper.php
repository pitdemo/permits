<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function generate_time($array_args)
{
  extract($array_args);
  
  $selected_value=(isset($selected_value)) ? $selected_value : '';
  
  $width=(isset($width)) ? $width : '89px';
  
  $class=(isset($class)) ? $class : '';
  
  $id=(isset($id)) ? $id : $name;
?>  
  <select name="<?php echo $name; ?>" id="<?php echo $id; ?>"  class="form-control <?php echo $class; ?>" style="width:<?php echo $width; ?>;">
      <option value="" selected="selected">Select</option>
  <?php for($i = 0; $i < 24; $i++)
    {
  
     	   $t=$i ; #% 12 ? $i % 12 : 12
      
          if($i<=9)
          $i='0'.$i;
      
      for($s=0;$s<=45;$s+=15)
      {          
          if($s==0)
          $t= ':00';
          else
          $t=':'.$s;          
          
          $t=$i.$t;         
      
          if($t==$selected_value)
          $sel="selected=selected";
          else
          $sel='';
   ?>
   <option value="<?php echo $t; ?>" <?php echo $sel; ?>><?php echo $t; ?></option>
     
  <?php } } ?>
  </select>
<?php 
}
?>