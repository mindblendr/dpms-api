<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medical_history_model extends MY_Model
{
    
	public function __construct()
	{
		$this->table = 'medical_history';
		parent::__construct();
    }

	public function conditions()
	{
		return parent::conditions();
	}
	
	public function get_all($paginate = TRUE, $with_trashed = FALSE, $order_by = null, $get_users = NULL) {
		$medical_histories = parent::get_all($paginate, $with_trashed, $order_by, ['created', 'updated', 'deleted']);
		return $medical_histories;
	}

	public function add()
	{
		$data = [
			'patient_id' => $this->input->post('patient_id'),
			'previous_doctor' => $this->input->post('previous_doctor'),
			'doctor_address' => $this->input->post('doctor_address'),
			'is_in_good_health' => $this->input->post('is_in_good_health'),
			'is_in_med_treatment' => $this->input->post('is_in_med_treatment'),
			'condition_being_treated' => $this->input->post('condition_being_treated'),
			'had_illness_or_operation' => $this->input->post('had_illness_or_operation'),
			'what_illnes_or_operation' => $this->input->post('what_illnes_or_operation'),
			'is_taking_medication' => $this->input->post('is_taking_medication'),
			'what_medication' => $this->input->post('what_medication'),
			'is_smoker' => $this->input->post('is_smoker'),
			'tried_dangerous_drugs' => $this->input->post('tried_dangerous_drugs'),
			'allergic_local_anesthetics' => $this->input->post('allergic_local_anesthetics'),
			'allergic_sulfa_drugs' => $this->input->post('allergic_sulfa_drugs'),
			'allergic_aspirin' => $this->input->post('allergic_aspirin'),
			'allergic_penicillin_antibiotic' => $this->input->post('allergic_penicillin_antibiotic'),
			'allergic_latex' => $this->input->post('allergic_latex'),
			'allergic_others' => $this->input->post('allergic_others'),
			'allergic_others_specify' => $this->input->post('allergic_others_specify'),
			'bleeding_time' => $this->input->post('bleeding_time'),
			'is_pregnant' => $this->input->post('is_pregnant'),
			'is_nursing' => $this->input->post('is_nursing'),
			'is_taking_birth_control_pills' => $this->input->post('is_taking_birth_control_pills'),
			'blood_type' => $this->input->post('blood_type'),
			'blood_pressure' => $this->input->post('blood_pressure'),
			'has_high_blood_pressure' => $this->input->post('has_high_blood_pressure'),
			'has_low_blood_pressure' => $this->input->post('has_low_blood_pressure'),
			'has_epilepsy_convultions' => $this->input->post('has_epilepsy_convultions'),
			'has_aids_hiv_infection' => $this->input->post('has_aids_hiv_infection'),
			'has_std' => $this->input->post('has_std'),
			'has_stomachtroubles_ulcers' => $this->input->post('has_stomachtroubles_ulcers'),
			'has_fainting_seizures' => $this->input->post('has_fainting_seizures'),
			'has_rapid_weightloss' => $this->input->post('has_rapid_weightloss'),
			'has_rad_therapy' => $this->input->post('has_rad_therapy'),
			'has_joint_replacement' => $this->input->post('has_joint_replacement'),
			'has_heart_surgery' => $this->input->post('has_heart_surgery'),
			'has_heart_attack' => $this->input->post('has_heart_attack'),
			'has_thyroid_problems' => $this->input->post('has_thyroid_problems'),
			'has_heart_disease' => $this->input->post('has_heart_disease'),
			'has_heart_murmur' => $this->input->post('has_heart_murmur'),
			'has_hepa_liver_disease' => $this->input->post('has_hepa_liver_disease'),
			'has_rheumatic_fever' => $this->input->post('has_rheumatic_fever'),
			'has_hay_fever_allergies' => $this->input->post('has_hay_fever_allergies'),
			'has_respiratory_problems' => $this->input->post('has_respiratory_problems'),
			'has_hepa_jaundice' => $this->input->post('has_hepa_jaundice'),
			'has_tubercolosis' => $this->input->post('has_tubercolosis'),
			'has_swollen_ankles' => $this->input->post('has_swollen_ankles'),
			'has_kidney_disease' => $this->input->post('has_kidney_disease'),
			'has_diabetes' => $this->input->post('has_diabetes'),
			'has_chest_pain' => $this->input->post('has_chest_pain'),
			'has_stroke' => $this->input->post('has_stroke'),
			'has_cancer_tumors' => $this->input->post('has_cancer_tumors'),
			'has_anemia' => $this->input->post('has_anemia'),
			'has_angina' => $this->input->post('has_angina'),
			'has_asthma' => $this->input->post('has_asthma'),
			'has_emphysema' => $this->input->post('has_emphysema'),
			'has_bleeding_problems' => $this->input->post('has_bleeding_problems'),
			'has_head_injuries' => $this->input->post('has_head_injuries'),
			'has_arthritis_rheumatism' => $this->input->post('has_arthritis_rheumatism'),
			'has_others' => $this->input->post('has_others'),
			'has_others_specify' => $this->input->post('has_others_specify'),
		];

		db_timestamp('created', $data, $this->session_user->id, $this->session_user->type);
		return $this->create($data);
	}

	public function edit()
	{
		$data = [];
		if ($this->input->post('previous_doctor')) $data['previous_doctor'] = $this->input->post('previous_doctor');
		if ($this->input->post('doctor_address')) $data['doctor_address'] = $this->input->post('doctor_address');
		if ($this->input->post('is_in_good_health') !== NULL && in_array($this->input->post('is_in_good_health'), [0, 1])) $data['is_in_good_health'] = $this->input->post('is_in_good_health');
		if ($this->input->post('is_in_med_treatment') !== NULL && in_array($this->input->post('is_in_med_treatment'), [0, 1])) $data['is_in_med_treatment'] = $this->input->post('is_in_med_treatment');
		if ($this->input->post('condition_being_treated')) $data['condition_being_treated'] = $this->input->post('condition_being_treated');
		if ($this->input->post('had_illness_or_operation')) $data['had_illness_or_operation'] = $this->input->post('had_illness_or_operation');
		if ($this->input->post('what_illnes_or_operation')) $data['what_illnes_or_operation'] = $this->input->post('what_illnes_or_operation');
		if ($this->input->post('is_taking_medication') !== NULL && in_array($this->input->post('is_taking_medication'), [0, 1])) $data['is_taking_medication'] = $this->input->post('is_taking_medication');
		if ($this->input->post('what_medication')) $data['what_medication'] = $this->input->post('what_medication');
		if ($this->input->post('is_smoker') !== NULL && in_array($this->input->post('is_smoker'), [0, 1])) $data['is_smoker'] = $this->input->post('is_smoker');
		if ($this->input->post('tried_dangerous_drugs')) $data['tried_dangerous_drugs'] = $this->input->post('tried_dangerous_drugs');
		if ($this->input->post('allergic_local_anesthetics')) $data['allergic_local_anesthetics'] = $this->input->post('allergic_local_anesthetics');
		if ($this->input->post('allergic_sulfa_drugs')) $data['allergic_sulfa_drugs'] = $this->input->post('allergic_sulfa_drugs');
		if ($this->input->post('allergic_aspirin')) $data['allergic_aspirin'] = $this->input->post('allergic_aspirin');
		if ($this->input->post('allergic_penicillin_antibiotic')) $data['allergic_penicillin_antibiotic'] = $this->input->post('allergic_penicillin_antibiotic');
		if ($this->input->post('allergic_latex')) $data['allergic_latex'] = $this->input->post('allergic_latex');
		if ($this->input->post('allergic_others')) $data['allergic_others'] = $this->input->post('allergic_others');
		if ($this->input->post('allergic_others_specify')) $data['allergic_others_specify'] = $this->input->post('allergic_others_specify');
		if ($this->input->post('bleeding_time')) $data['bleeding_time'] = $this->input->post('bleeding_time');
		if ($this->input->post('is_pregnant') !== NULL && in_array($this->input->post('is_pregnant'), [0, 1])) $data['is_pregnant'] = $this->input->post('is_pregnant');
		if ($this->input->post('is_nursing') !== NULL && in_array($this->input->post('is_nursing'), [0, 1])) $data['is_nursing'] = $this->input->post('is_nursing');
		if ($this->input->post('is_taking_birth_control_pills') !== NULL && in_array($this->input->post('is_taking_birth_control_pills'), [0, 1])) $data['is_taking_birth_control_pills'] = $this->input->post('is_taking_birth_control_pills');
		if ($this->input->post('blood_type')) $data['blood_type'] = $this->input->post('blood_type');
		if ($this->input->post('blood_pressure')) $data['blood_pressure'] = $this->input->post('blood_pressure');
		if ($this->input->post('has_high_blood_pressure') !== NULL && in_array($this->input->post('has_high_blood_pressure'), [0, 1])) $data['has_high_blood_pressure'] = $this->input->post('has_high_blood_pressure');
		if ($this->input->post('has_low_blood_pressure') !== NULL && in_array($this->input->post('has_low_blood_pressure'), [0, 1])) $data['has_low_blood_pressure'] = $this->input->post('has_low_blood_pressure');
		if ($this->input->post('has_epilepsy_convultions') !== NULL && in_array($this->input->post('has_epilepsy_convultions'), [0, 1])) $data['has_epilepsy_convultions'] = $this->input->post('has_epilepsy_convultions');
		if ($this->input->post('has_aids_hiv_infection') !== NULL && in_array($this->input->post('has_aids_hiv_infection'), [0, 1])) $data['has_aids_hiv_infection'] = $this->input->post('has_aids_hiv_infection');
		if ($this->input->post('has_std') !== NULL && in_array($this->input->post('has_std'), [0, 1])) $data['has_std'] = $this->input->post('has_std');
		if ($this->input->post('has_stomachtroubles_ulcers') !== NULL && in_array($this->input->post('has_stomachtroubles_ulcers'), [0, 1])) $data['has_stomachtroubles_ulcers'] = $this->input->post('has_stomachtroubles_ulcers');
		if ($this->input->post('has_fainting_seizures') !== NULL && in_array($this->input->post('has_fainting_seizures'), [0, 1])) $data['has_fainting_seizures'] = $this->input->post('has_fainting_seizures');
		if ($this->input->post('has_rapid_weightloss') !== NULL && in_array($this->input->post('has_rapid_weightloss'), [0, 1])) $data['has_rapid_weightloss'] = $this->input->post('has_rapid_weightloss');
		if ($this->input->post('has_rad_therapy') !== NULL && in_array($this->input->post('has_rad_therapy'), [0, 1])) $data['has_rad_therapy'] = $this->input->post('has_rad_therapy');
		if ($this->input->post('has_joint_replacement') !== NULL && in_array($this->input->post('has_joint_replacement'), [0, 1])) $data['has_joint_replacement'] = $this->input->post('has_joint_replacement');
		if ($this->input->post('has_heart_surgery') !== NULL && in_array($this->input->post('has_heart_surgery'), [0, 1])) $data['has_heart_surgery'] = $this->input->post('has_heart_surgery');
		if ($this->input->post('has_heart_attack') !== NULL && in_array($this->input->post('has_heart_attack'), [0, 1])) $data['has_heart_attack'] = $this->input->post('has_heart_attack');
		if ($this->input->post('has_thyroid_problems') !== NULL && in_array($this->input->post('has_thyroid_problems'), [0, 1])) $data['has_thyroid_problems'] = $this->input->post('has_thyroid_problems');
		if ($this->input->post('has_heart_disease') !== NULL && in_array($this->input->post('has_heart_disease'), [0, 1])) $data['has_heart_disease'] = $this->input->post('has_heart_disease');
		if ($this->input->post('has_heart_murmur') !== NULL && in_array($this->input->post('has_heart_murmur'), [0, 1])) $data['has_heart_murmur'] = $this->input->post('has_heart_murmur');
		if ($this->input->post('has_hepa_liver_disease') !== NULL && in_array($this->input->post('has_hepa_liver_disease'), [0, 1])) $data['has_hepa_liver_disease'] = $this->input->post('has_hepa_liver_disease');
		if ($this->input->post('has_rheumatic_fever') !== NULL && in_array($this->input->post('has_rheumatic_fever'), [0, 1])) $data['has_rheumatic_fever'] = $this->input->post('has_rheumatic_fever');
		if ($this->input->post('has_hay_fever_allergies') !== NULL && in_array($this->input->post('has_hay_fever_allergies'), [0, 1])) $data['has_hay_fever_allergies'] = $this->input->post('has_hay_fever_allergies');
		if ($this->input->post('has_respiratory_problems') !== NULL && in_array($this->input->post('has_respiratory_problems'), [0, 1])) $data['has_respiratory_problems'] = $this->input->post('has_respiratory_problems');
		if ($this->input->post('has_hepa_jaundice') !== NULL && in_array($this->input->post('has_hepa_jaundice'), [0, 1])) $data['has_hepa_jaundice'] = $this->input->post('has_hepa_jaundice');
		if ($this->input->post('has_tubercolosis') !== NULL && in_array($this->input->post('has_tubercolosis'), [0, 1])) $data['has_tubercolosis'] = $this->input->post('has_tubercolosis');
		if ($this->input->post('has_swollen_ankles') !== NULL && in_array($this->input->post('has_swollen_ankles'), [0, 1])) $data['has_swollen_ankles'] = $this->input->post('has_swollen_ankles');
		if ($this->input->post('has_kidney_disease') !== NULL && in_array($this->input->post('has_kidney_disease'), [0, 1])) $data['has_kidney_disease'] = $this->input->post('has_kidney_disease');
		if ($this->input->post('has_diabetes') !== NULL && in_array($this->input->post('has_diabetes'), [0, 1])) $data['has_diabetes'] = $this->input->post('has_diabetes');
		if ($this->input->post('has_chest_pain') !== NULL && in_array($this->input->post('has_chest_pain'), [0, 1])) $data['has_chest_pain'] = $this->input->post('has_chest_pain');
		if ($this->input->post('has_stroke') !== NULL && in_array($this->input->post('has_stroke'), [0, 1])) $data['has_stroke'] = $this->input->post('has_stroke');
		if ($this->input->post('has_cancer_tumors') !== NULL && in_array($this->input->post('has_cancer_tumors'), [0, 1])) $data['has_cancer_tumors'] = $this->input->post('has_cancer_tumors');
		if ($this->input->post('has_anemia') !== NULL && in_array($this->input->post('has_anemia'), [0, 1])) $data['has_anemia'] = $this->input->post('has_anemia');
		if ($this->input->post('has_angina') !== NULL && in_array($this->input->post('has_angina'), [0, 1])) $data['has_angina'] = $this->input->post('has_angina');
		if ($this->input->post('has_asthma') !== NULL && in_array($this->input->post('has_asthma'), [0, 1])) $data['has_asthma'] = $this->input->post('has_asthma');
		if ($this->input->post('has_emphysema') !== NULL && in_array($this->input->post('has_emphysema'), [0, 1])) $data['has_emphysema'] = $this->input->post('has_emphysema');
		if ($this->input->post('has_bleeding_problems') !== NULL && in_array($this->input->post('has_bleeding_problems'), [0, 1])) $data['has_bleeding_problems'] = $this->input->post('has_bleeding_problems');
		if ($this->input->post('has_head_injuries') !== NULL && in_array($this->input->post('has_head_injuries'), [0, 1])) $data['has_head_injuries'] = $this->input->post('has_head_injuries');
		if ($this->input->post('has_arthritis_rheumatism') !== NULL && in_array($this->input->post('has_arthritis_rheumatism'), [0, 1])) $data['has_arthritis_rheumatism'] = $this->input->post('has_arthritis_rheumatism');
		if ($this->input->post('has_others') !== NULL && in_array($this->input->post('has_others'), [0, 1])) $data['has_others'] = $this->input->post('has_others');
		if ($this->input->post('has_others_specify')) $data['has_others_specify'] = $this->input->post('has_others_specify');
		
		if ($data) {
			db_timestamp('updated', $data, $this->session_user->id, $this->session_user->type);
			return $this->update($data, $this->input->post('medical_history_id'));
		}

		return FALSE;
	}

	public function remove()
	{
		return $this->delete($this->input->post('medical_history_id'));
	}
}
