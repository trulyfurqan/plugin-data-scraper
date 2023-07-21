<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		// ### Important Fix:-
		// - Below line will convert integers/floats to their correct datatypes, because otherwise MySQL return all data with "string" datatype
		// - link: https://stackoverflow.com/a/25692758
		// - link: https://forum.codeigniter.com/thread-65549-post-333789.html#pid333789
		if(isset($this->db->conn_id))
		{
			mysqli_options($this->db->conn_id, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
		}
	}
}