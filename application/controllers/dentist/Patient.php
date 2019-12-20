<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends MY_Controller
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
                'data' => $this->patient->get_all(),
				'total' => $this->patient->total,
				'per_page' => $this->patient->limit,
				'no_of_pages' => $this->patient->no_of_pages,
				'page' => $this->patient->page,
                'status' => 1
            ]
        ]);
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->patient->where(['patient.id' => $this->input->post('patient_id')])->get(),
                'status' => 1
            ]
        ]);
    }

    public function add()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->patient->add() ? 1 : 0
            ]
        ]);
    }

    public function edit()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->patient->edit() ? 1 : 0
            ]
        ]);
    }

    public function delete()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->patient->remove() ? 1 : 0
            ]
        ]);
    }
}