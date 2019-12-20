<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function is_unique_on_update($data, $params)
	{
		try {
			$column = explode('|', $params)[0];
			$id = $this->CI->input->post(explode('|', $params)[1]);
			$table = explode('.', $column)[0];
			$result = $this->CI->db->select('id')->from($table)->where([$column => $data, $table . '.id !=' => $id])->count_all_results();
			return $result <= 0;
		} catch (Exception $e) {
			return false;
		}
	}

	public function no_space($data)
	{
		if (! strpos($data, ' ')) {
			return TRUE;
		}

		return FALSE;
	}

	public function matches_not_required($data, $post_key)
	{
		if ($data) {
			if ($this->CI->input->post($post_key)) {
				return $this->CI->input->post($post_key) == $data;
			}
			return false;
		}
		return true;
	}

	public function data_exist($data, $field)
	{
		$table = explode('.', $field)[0];
		$result = $this->CI->db->select($table . '.id')->from($table)->where([$field => $data])->count_all_results();
		return $result == 1;
	}

}