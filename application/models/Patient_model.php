<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'patient';
		parent::__construct();
    }

	public function conditions()
	{
		switch ($this->session_user->type) {
			case 2:
				$this->db->where(['patient.dentist_id' => $this->session_user->id]);
				break;
			default:
				break;
		}
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$patients = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $patients;
	}

	public function add()
	{
		$data = [
			'firstname' => $this->input->post('firstname'),
			'middlename' => $this->input->post('middlename'),
			'lastname' => $this->input->post('lastname'),
			'age' => $this->input->post('age'),
			'gender' => $this->input->post('gender'),
			'religion' => $this->input->post('religion'),
			'nationality' => $this->input->post('nationality'),
			'address' => $this->input->post('address'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => $this->input->post('address_2'),
			'address_3' => $this->input->post('address_3'),
			'address_4' => $this->input->post('address_4'),
			'address_5' => $this->input->post('address_5'),
			'occupation' => $this->input->post('occupation'),
			'dental_insurance' => $this->input->post('dental_insurance'),
			'effective_date' => $this->input->post('effective_date'),
			'guardian_firstname' => $this->input->post('guardian_firstname'),
			'guardian_middlename' => $this->input->post('guardian_middlename'),
			'guardian_lastname' => $this->input->post('guardian_lastname'),
			'guardian_occupation' => $this->input->post('guardian_occupation'),
			'consultation_reason' => $this->input->post('consultation_reason'),
			'home_number' => $this->input->post('home_number'),
			'office_number' => $this->input->post('office_number'),
			'fax_number' => $this->input->post('fax_number'),
			'mobile_number' => $this->input->post('mobile_number'),
			'email_address' => $this->input->post('email_address'),
			'signature' => $this->input->post('signature'),
			'consent_agreement' => $this->input->post('consent_agreement'),
			'picture' => $this->input->post('picture'),
		];
		
		switch ($this->session_user->type) {
			case 1:
				$data['dentist_id'] = $this->input->post('dentist_id');
				break;
			case 2:
				$data['dentist_id'] = $this->session_user->id;
				break;
			
			default:
				return FALSE;
				break;
		}

		db_timestamp('created', $data, $this->session_user->id, $this->session_user->type);
		db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
		return $this->create($data);
	}

	public function edit()
	{
		$patient = $this->get($this->input->post('patient_id'));
		$data = [];

		if ($this->input->post('firstname')) $data['firstname'] = $this->input->post('firstname');
		if ($this->input->post('middlename')) $data['middlename'] = $this->input->post('middlename');
		if ($this->input->post('lastname')) $data['lastname'] = $this->input->post('lastname');
		if ($this->input->post('age')) $data['age'] = $this->input->post('age');
		if ($this->input->post('gender')) $data['gender'] = $this->input->post('gender');
		if ($this->input->post('religion')) $data['religion'] = $this->input->post('religion');
		if ($this->input->post('nationality')) $data['nationality'] = $this->input->post('nationality');
		if ($this->input->post('address')) $data['address'] = $this->input->post('address');
		if ($this->input->post('address_1')) $data['address_1'] = $this->input->post('address_1');
		if ($this->input->post('address_2')) $data['address_2'] = $this->input->post('address_2');
		if ($this->input->post('address_3')) $data['address_3'] = $this->input->post('address_3');
		if ($this->input->post('address_4')) $data['address_4'] = $this->input->post('address_4');
		if ($this->input->post('address_5')) $data['address_5'] = $this->input->post('address_5');
		if ($this->input->post('occupation')) $data['occupation'] = $this->input->post('occupation');
		if ($this->input->post('dental_insurance')) $data['dental_insurance'] = $this->input->post('dental_insurance');
		if ($this->input->post('effective_date')) $data['effective_date'] = $this->input->post('effective_date');
		if ($this->input->post('guardian_firstname')) $data['guardian_firstname'] = $this->input->post('guardian_firstname');
		if ($this->input->post('guardian_middlename')) $data['guardian_middlename'] = $this->input->post('guardian_middlename');
		if ($this->input->post('guardian_lastname')) $data['guardian_lastname'] = $this->input->post('guardian_lastname');
		if ($this->input->post('guardian_occupation')) $data['guardian_occupation'] = $this->input->post('guardian_occupation');
		if ($this->input->post('consultation_reason')) $data['consultation_reason'] = $this->input->post('consultation_reason');
		if ($this->input->post('home_number')) $data['home_number'] = $this->input->post('home_number');
		if ($this->input->post('office_number')) $data['office_number'] = $this->input->post('office_number');
		if ($this->input->post('fax_number')) $data['fax_number'] = $this->input->post('fax_number');
		if ($this->input->post('mobile_number')) $data['mobile_number'] = $this->input->post('mobile_number');
		if ($this->input->post('email_address')) $data['email_address'] = $this->input->post('email_address');
		if ($this->input->post('signature')) $data['signature'] = $this->input->post('signature');
		if ($this->input->post('consent_agreement')) $data['consent_agreement'] = $this->input->post('consent_agreement');
		if ($this->input->post('picture')) $data['picture'] = $this->input->post('picture');
		
		if ($data) {		
			switch ($this->session_user->type) {
				case 1:
					$data['dentist_id'] = $this->input->post('dentist_id');
					break;
				case 2:
					if ($this->session_user->id == $patient->dentist_id) {
						break;
					}
					return FALSE;
			}

			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('patient_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		$patient = $this->select(['id', 'dentist_id'])->get($this->input->post('patient_id'));
		if ($this->session_user->type == 2 && $this->session_user->id != $patient->dentist_id) {
			return FALSE;
		}
		return $this->delete($this->input->post('patient_id'));
	}
}
