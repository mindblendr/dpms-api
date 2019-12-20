<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends MY_Controller
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
                'data' => $this->transaction->get_all(),
                'status' => 1
            ]
        ]);
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->transaction->where(['transaction.id' => $this->input->post('transaction_id')])->get(),
                'status' => 1
            ]
        ]);
    }

    public function add()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->transaction->add() ? 1 : 0
            ]
        ]);
    }

    public function edit()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->transaction->edit() ? 1 : 0
            ]
        ]);
    }

    public function delete()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->transaction->remove() ? 1 : 0
            ]
        ]);
    }
}