<?php

class Dompdf_lib {
    
	var $_dompdf = NULL;
	
	function __construct()
	{
		require_once("dompdf/dompdf_config.inc.php");
		if(is_null($this->_dompdf)){
			$this->_dompdf = new DOMPDF();
		}
	}
	
	function convert_html_to_pdf($html, $filename ='', $stream = TRUE) 
	{
		$this->_dompdf->load_html($html);
		$this->_dompdf->render();
		if ($stream) {
			$this->_dompdf->stream($filename);
		} else {
			return $this->_dompdf->output();
		}
	}
	
	function convert_html_to_pdf_view($html, $filename ='', $stream = TRUE) 
	{
		$this->_dompdf->load_html($html);
		$this->_dompdf->render();
		if ($stream) {
			$this->_dompdf->stream($filename,array("Attachment" => 0));
		} else {
			return $this->_dompdf->output();
		}
	}
	function convert_html_to_pdf_save($html, $filename ='', $stream = TRUE) 
	{
		$this->_dompdf->load_html($html);
		$this->_dompdf->render();
		if ($stream) {
			 $output = $this->_dompdf->output();
   			 file_put_contents(UPLODPATH.'uploads/'.$filename, $output);
		} else {
			return $this->_dompdf->output();
		}
	}
	
}
?>
