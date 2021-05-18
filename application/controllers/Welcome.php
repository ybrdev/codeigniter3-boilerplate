<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('twig');
	}

	public function index()
	{
		$this->twig->display('welcome_message', $this->data);
	}
}
