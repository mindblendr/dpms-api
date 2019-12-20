<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
    }

    public function index()
    {
        $this->get();
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->session_user,
                'status' => 1
            ]
        ]);
    }

    public function edit()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->dentist->edit_profile() ? 1 : 0
            ]
        ]);
    }
}