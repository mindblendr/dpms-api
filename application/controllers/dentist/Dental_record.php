<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dental_record extends MY_Controller
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
                'data' => $this->dental_record->get_all(),
                'status' => 1
            ]
        ]);
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->dental_record->where(['dental_record.id' => $this->input->post('dental_record_id')])->get(),
                'status' => 1
            ]
        ]);
    }

    public function add()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->dental_record->add() ? 1 : 0
            ]
        ]);
    }

    public function edit()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->dental_record->edit() ? 1 : 0
            ]
        ]);
    }

    public function delete()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->dental_record->remove() ? 1 : 0
            ]
        ]);
    }
}