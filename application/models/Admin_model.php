<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'admin';
		parent::__construct();
    }

	public function conditions()
	{
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$admins = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $admins;
	}

	public function add()
	{
		$data = [
			'username' => $this->input->post('username'),
			'nickname' => $this->input->post('nickname'),
			'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
			'pin' => $this->input->post('pin'),
		];

		db_timestamp('created', $data);

		return $this->create($data);
	}

	public function edit_profile()
	{
		$data = [
			'username' => $this->input->post('username') ?? $this->session_user->username,
			'nickname' => $this->input->post('nickname') ?? $this->session_user->nickname,
			'password' => $this->input->post('password') ? password_hash($this->input->post('password'), PASSWORD_BCRYPT) : $this->session_user->password,
			'pin' => $this->input->post('pin') ?? $this->session_user->pin,
		];

		db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
		return $this->update($data, $this->session_user->id);
	}

	public function edit()
	{
		$data = [];

		if ($this->input->post('username')) $data['username'] = $this->input->post('username');
		if ($this->input->post('nickname')) $data['nickname'] = $this->input->post('nickname');
		if ($this->input->post('password')) $data['password'] = $this->input->post('password');
		if ($this->input->post('pin')) $data['pin'] = $this->input->post('pin');
		if ($this->input->post('status') != NULL && in_array($this->input->post('status'), [0,1])) $data['status'] = $this->input->post('status');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('admin_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		return $this->delete($this->input->post('dentist_id'));
	}
}
