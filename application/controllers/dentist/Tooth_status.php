<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tooth_status extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->tooth_status->get_all(),
                'status' => 1
            ]
        ]);
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->tooth_status->where(['tooth_status.id' => $this->input->post('tooth_status_id')])->get(),
                'status' => 1
            ]
        ]);
    }

    public function add()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->tooth_status->add() ? 1 : 0
            ]
        ]);
    }

    public function edit()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->tooth_status->edit() ? 1 : 0
            ]
        ]);
    }

    public function delete()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->tooth_status->remove() ? 1 : 0
            ]
        ]);
    }
}