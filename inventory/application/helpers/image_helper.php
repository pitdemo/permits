<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function image_thumb($path, $image_name, $width, $height,$water_mark=false)
{
	// Get the CodeIgniter super object
	$CI =& get_instance();
	
	$explode=explode('.',$image_name);
	$file_name_alone = $explode[0];

	// Path to image thumbnail
	$image_thumb = dirname($path . '/' . $image_name) . '/' .$file_name_alone . '_' . $width . '_' . $height . '.jpg';

	if( ! file_exists($image_thumb))
	{
		// LOAD LIBRARY
		$CI->load->library('image_lib');

		// CONFIGURE IMAGE LIBRARY
		$config['image_library']	= 'gd2';
		$config['source_image']		= $path . '/' . $image_name;
		$config['new_image']		= $image_thumb;
		$config['maintain_ratio']	= FALSE;
		$config['height']			= $height;
		$config['width']			= $width;
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();
		if($water_mark!==false)
		{
			$config['source_image'] = $image_thumb;
			$config['wm_type'] = 'overlay';
			$config['wm_vrt_alignment'] = 'middle';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_overlay_path']=$water_mark;
			$config['wm_opacity'] = '70';
			$CI->image_lib->initialize($config);
			$CI->image_lib->watermark();
			$CI->image_lib->clear();
		}	
	}

	// return '<img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/' . $image_thumb . '" />';
}

/* End of file image_helper.php */
/* Location: code/apps/helpers/image_helper.php */ 