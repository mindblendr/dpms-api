<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medical_history extends MY_Controller
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
                'data' => $this->medical_history->get_all(),
                'status' => 1
            ]
        ]);
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->medical_history->where(['medical_history.id' => $this->input->post('medical_history_id')])->get(),
                'status' => 1
            ]
        ]);
    }

    public function add()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->medical_history->add() ? 1 : 0
            ]
        ]);
    }

    public function edit()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->medical_history->edit() ? 1 : 0
            ]
        ]);
    }

    public function delete()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->medical_history->remove() ? 1 : 0
            ]
        ]);
    }
}