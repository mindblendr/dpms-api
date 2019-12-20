<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dentist extends MY_Controller
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
                'data' => $this->dentist->get_all(),
				'total' => $this->dentist->total,
				'per_page' => $this->dentist->limit,
				'no_of_pages' => $this->dentist->no_of_pages,
				'page' => $this->dentist->page,
                'status' => 1
            ]
        ]);
    }

    public function get()
    {
        $this->json->_display([
            'context' => [
                'data' => $this->dentist->where(['dentist.id' => $this->input->post('dentist_id')])->get(),
                'status' => 1
            ]
        ]);
    }

    public function edit()
    {
		$this->data_validation(['dentist_edit']);
        $this->json->_display([
            'context' => [
                'status' => $this->dentist->edit() ? 1 : 0
            ]
        ]);
    }

    public function delete()
    {
        $this->json->_display([
            'context' => [
                'status' => $this->dentist->remove() ? 1 : 0
            ]
        ]);
    }
}