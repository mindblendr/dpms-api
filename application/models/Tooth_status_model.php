<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tooth_status_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'tooth_status';
		parent::__construct();
    }

	public function conditions()
	{
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$tooth_statuses = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $tooth_statuses;
	}

	public function add()
	{
		$data = [
			'dental_record_id' => $this->input->post('dental_record_id'),
			'tooth_number' => $this->input->post('tooth_number'),
			'upper_area' => $this->input->post('upper_area'),
			'lower_area' => $this->input->post('lower_area'),
			'left_area' => $this->input->post('left_area'),
			'right_area' => $this->input->post('right_area'),
			'center_area' => $this->input->post('center_area'),
			'status' => $this->input->post('status'),
		];

		db_timestamp('created', $data, $this->session_user->id, $this->session_user->type);
		return $this->create($data);
	}

	public function edit()
	{
		$data = [];
		if ($this->input->post('dental_record_id')) $data['dental_record_id'] = $this->input->post('dental_record_id');
		if ($this->input->post('tooth_number') !== NULL && in_array($this->input->post('tooth_number'), [0, 1])) $data['tooth_number'] = $this->input->post('tooth_number');
		if ($this->input->post('upper_area') !== NULL && in_array($this->input->post('upper_area'), [0, 1])) $data['upper_area'] = $this->input->post('upper_area');
		if ($this->input->post('lower_area') !== NULL && in_array($this->input->post('lower_area'), [0, 1])) $data['lower_area'] = $this->input->post('lower_area');
		if ($this->input->post('left_area') !== NULL && in_array($this->input->post('left_area'), [0, 1])) $data['left_area'] = $this->input->post('left_area');
		if ($this->input->post('right_area') !== NULL && in_array($this->input->post('right_area'), [0, 1])) $data['right_area'] = $this->input->post('right_area');
		if ($this->input->post('center_area') !== NULL && in_array($this->input->post('center_area'), [0, 1])) $data['center_area'] = $this->input->post('center_area');
		if ($this->input->post('status') !== NULL && in_array($this->input->post('status'), [0, 1])) $data['status'] = $this->input->post('status');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('tooth_status_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		return $this->delete($this->input->post('tooth_status_id'));
	}
}
