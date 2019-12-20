<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'transaction';
		parent::__construct();
    }

	public function conditions()
	{
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$transactions = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $transactions;
	}

	public function add()
	{
		$data = [
			'patient_id' => $this->input->post('patient_id'),
			'dentist_id' => $this->input->post('dentist_id'),
			'tooth_number' => $this->input->post('tooth_number'),
			'date' => $this->input->post('date'),
			'procedure' => $this->input->post('procedure'),
			'amount_charged' => $this->input->post('amount_charged'),
			'amount_paid' => $this->input->post('amount_paid'),
			'balance' => $this->input->post('balance'),
			'next_appointment_date' => $this->input->post('next_appointment_date'),
		];

		db_timestamp('created', $data, $this->session_user->id, $this->session_user->type);
		return $this->create($data);
	}

	public function edit()
	{
		$data = [];

		if ($this->input->post('patient_id')) $data['patient_id'] = $this->input->post('patient_id');
		if ($this->input->post('dentist_id')) $data['dentist_id'] = $this->input->post('dentist_id');
		if ($this->input->post('tooth_number')) $data['tooth_number'] = $this->input->post('tooth_number');
		if ($this->input->post('date')) $data['date'] = $this->input->post('date');
		if ($this->input->post('procedure')) $data['procedure'] = $this->input->post('procedure');
		if ($this->input->post('amount_charged')) $data['amount_charged'] = $this->input->post('amount_charged');
		if ($this->input->post('amount_paid')) $data['amount_paid'] = $this->input->post('amount_paid');
		if ($this->input->post('balance')) $data['balance'] = $this->input->post('balance');
		if ($this->input->post('next_appointment_date')) $data['next_appointment_date'] = $this->input->post('next_appointment_date');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('transaction_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		return $this->delete($this->input->post('transaction_id'));
	}
}
