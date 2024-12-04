<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : notes_model.pph
 * Project        : Accounting Software
 * Creation Date  : 26-06-2015
 * Author         : K.Panneer selvam
 * Description    : Log functionality to track all the changes
*********************************************************************************************/	
class Notes_model extends CI_Model {

	public	function __construct()
	{
		parent::__construct();
	}
	public function insert_notes($notes_arr=NULL) // insert the notes in notes table
	{
        $this->db->insert('notes',$notes_arr);
	}
    
}