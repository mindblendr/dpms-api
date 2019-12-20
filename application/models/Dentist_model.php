<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dentist_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'dentist';
		parent::__construct();
    }

	public function conditions()
	{
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$dentists = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $dentists;
	}

	public function add()
	{
		$data = [
			'username' => $this->input->post('username'),
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
			'pin' => $this->input->post('pin'),
		];

		db_timestamp('created', $data);
		return $this->create($data);
	}

	public function edit_profile()
	{
		$data = [];
		if ($this->input->post('username')) $data['username'] = $this->input->post('username');
		if ($this->input->post('firstname')) $data['firstname'] = $this->input->post('firstname');
		if ($this->input->post('lastname')) $data['lastname'] = $this->input->post('lastname');
		if ($this->input->post('password')) {
			$data['raw_password'] = $this->input->post('password');
			$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
		}
		if ($this->input->post('pin')) $data['pin'] = $this->input->post('pin');
		if (in_array($this->input->post('status') !== NULL && $this->input->post('status'), [0,1])) $data['status'] = $this->input->post('status');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->session_user->id);
		}
	}

	public function edit()
	{
		$data = [];
		if ($this->input->post('username')) $data['username'] = $this->input->post('username');
		if ($this->input->post('firstname')) $data['firstname'] = $this->input->post('firstname');
		if ($this->input->post('lastname')) $data['lastname'] = $this->input->post('lastname');
		if ($this->input->post('password')) {
			$data['raw_password'] = $this->input->post('password');
			$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
		}
		if ($this->input->post('pin')) $data['pin'] = $this->input->post('pin');
		if ($this->input->post('status') !== NULL && in_array($this->input->post('status'), [0,1])) $data['status'] = $this->input->post('status');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('dentist_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		return $this->delete($this->input->post('dentist_id'));
	}
}
