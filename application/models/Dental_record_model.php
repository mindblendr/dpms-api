<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dental_record_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'dental_record';
		parent::__construct();
    }

	public function conditions()
	{
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$dental_records = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $dental_records;
	}

	public function add()
	{
		$data = [
			'patient_id' => $this->input->post('patient_id'),
			'xray_preriapical' => $this->input->post('xray_preriapical'),
			'xray_preriapical_tooth_number' => $this->input->post('xray_preriapical_tooth_number'),
			'xray_panoramic' => $this->input->post('xray_panoramic'),
			'xray_cephalometric' => $this->input->post('xray_cephalometric'),
			'xray_occlusal' => $this->input->post('xray_occlusal'),
			'xray_occlusal_upper_lower' => $this->input->post('xray_occlusal_upper_lower'),
			'xray_other' => $this->input->post('xray_other'),
			'xray_specify_others' => $this->input->post('xray_specify_others'),
			'gingivitis' => $this->input->post('gingivitis'),
			'early_periodontitis' => $this->input->post('early_periodontitis'),
			'moderate_periodontitis' => $this->input->post('moderate_periodontitis'),
			'advanced_periodontitis' => $this->input->post('advanced_periodontitis'),
			'class_molar' => $this->input->post('class_molar'),
			'overjet' => $this->input->post('overjet'),
			'overbite' => $this->input->post('overbite'),
			'midline_deviation' => $this->input->post('midline_deviation'),
			'crossbite' => $this->input->post('crossbite'),
			'orthodontic' => $this->input->post('orthodontic'),
			'stayplate' => $this->input->post('stayplate'),
			'others' => $this->input->post('others'),
			'specify_others' => $this->input->post('specify_others'),
			'clenching' => $this->input->post('clenching'),
			'clicking' => $this->input->post('clicking'),
			'trismus' => $this->input->post('trismus'),
			'muscle_spasm' => $this->input->post('muscle_spasm'),
		];

		db_timestamp('created', $data, $this->session_user->id, $this->session_user->type);
		return $this->create($data);
	}

	public function edit()
	{
		$data = [];
		if ($this->input->post('patient_id')) $data['patient_id'] = $this->input->post('patient_id');
		if ($this->input->post('xray_preriapical') !== NULL && in_array($this->input->post('xray_preriapical'), [0, 1])) $data['xray_preriapical'] = $this->input->post('xray_preriapical');
		if ($this->input->post('xray_preriapical_tooth_number') !== NULL && in_array($this->input->post('xray_preriapical_tooth_number'), [0, 1])) $data['xray_preriapical_tooth_number'] = $this->input->post('xray_preriapical_tooth_number');
		if ($this->input->post('xray_panoramic') !== NULL && in_array($this->input->post('xray_panoramic'), [0, 1])) $data['xray_panoramic'] = $this->input->post('xray_panoramic');
		if ($this->input->post('xray_cephalometric') !== NULL && in_array($this->input->post('xray_cephalometric'), [0, 1])) $data['xray_cephalometric'] = $this->input->post('xray_cephalometric');
		if ($this->input->post('xray_occlusal') !== NULL && in_array($this->input->post('xray_occlusal'), [0, 1])) $data['xray_occlusal'] = $this->input->post('xray_occlusal');
		if ($this->input->post('xray_occlusal_upper_lower') !== NULL && in_array($this->input->post('xray_occlusal_upper_lower'), [0, 1])) $data['xray_occlusal_upper_lower'] = $this->input->post('xray_occlusal_upper_lower');
		if ($this->input->post('xray_other') !== NULL && in_array($this->input->post('xray_other'), [0, 1])) $data['xray_other'] = $this->input->post('xray_other');
		if ($this->input->post('xray_specify_others')) $data['xray_specify_others'] = $this->input->post('xray_specify_others');
		if ($this->input->post('gingivitis') !== NULL && in_array($this->input->post('gingivitis'), [0, 1])) $data['gingivitis'] = $this->input->post('gingivitis');
		if ($this->input->post('early_periodontitis') !== NULL && in_array($this->input->post('early_periodontitis'), [0, 1])) $data['early_periodontitis'] = $this->input->post('early_periodontitis');
		if ($this->input->post('moderate_periodontitis') !== NULL && in_array($this->input->post('moderate_periodontitis'), [0, 1])) $data['moderate_periodontitis'] = $this->input->post('moderate_periodontitis');
		if ($this->input->post('advanced_periodontitis') !== NULL && in_array($this->input->post('advanced_periodontitis'), [0, 1])) $data['advanced_periodontitis'] = $this->input->post('advanced_periodontitis');
		if ($this->input->post('class_molar') !== NULL && in_array($this->input->post('class_molar'), [0, 1])) $data['class_molar'] = $this->input->post('class_molar');
		if ($this->input->post('overjet') !== NULL && in_array($this->input->post('overjet'), [0, 1])) $data['overjet'] = $this->input->post('overjet');
		if ($this->input->post('overbite') !== NULL && in_array($this->input->post('overbite'), [0, 1])) $data['overbite'] = $this->input->post('overbite');
		if ($this->input->post('midline_deviation') !== NULL && in_array($this->input->post('midline_deviation'), [0, 1])) $data['midline_deviation'] = $this->input->post('midline_deviation');
		if ($this->input->post('crossbite') !== NULL && in_array($this->input->post('crossbite'), [0, 1])) $data['crossbite'] = $this->input->post('crossbite');
		if ($this->input->post('orthodontic') !== NULL && in_array($this->input->post('orthodontic'), [0, 1])) $data['orthodontic'] = $this->input->post('orthodontic');
		if ($this->input->post('stayplate') !== NULL && in_array($this->input->post('stayplate'), [0, 1])) $data['stayplate'] = $this->input->post('stayplate');
		if ($this->input->post('others') !== NULL && in_array($this->input->post('others'), [0, 1])) $data['others'] = $this->input->post('others');
		if ($this->input->post('specify_others')) $data['specify_others'] = $this->input->post('specify_others');
		if ($this->input->post('clenching') !== NULL && in_array($this->input->post('clenching'), [0, 1])) $data['clenching'] = $this->input->post('clenching');
		if ($this->input->post('clicking') !== NULL && in_array($this->input->post('clicking'), [0, 1])) $data['clicking'] = $this->input->post('clicking');
		if ($this->input->post('trismus') !== NULL && in_array($this->input->post('trismus'), [0, 1])) $data['trismus'] = $this->input->post('trismus');
		if ($this->input->post('muscle_spasm') !== NULL && in_array($this->input->post('muscle_spasm'), [0, 1])) $data['muscle_spasm'] = $this->input->post('muscle_spasm');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('dental_record_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		return $this->delete($this->input->post('dental_record_id'));
	}
}
