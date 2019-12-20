<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
    }
    
    public function admin()
    {
        // $this->data_validation(['']);
        $this->json->_display([
            'context' => [
                'status' => $this->admin->add() ? 1 : 0
            ]
        ]);
    }
    
    public function dentist()
    {
        // $this->data_validation(['']);
        $this->json->_display([
            'context' => [
                'status' => $this->dentist->add() ? 1 : 0
            ]
        ]);
    }
}