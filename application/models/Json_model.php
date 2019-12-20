<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json_model extends MY_Model {

	public function _display($data = NULL, $status = 1, $header = 200)
	{
		$response	= $data;
		$response['status'] = $status;
		$response['time']	= date('Y-m-d H:i:s');
		
		if ($this->config->item('debug') && $this->db) {
			$response['output_profiler'] = $this->output_profiler->run();
		}

		$this->output
				->set_status_header($header)
				->set_content_type('application/json')
				->set_output(json_encode($response, JSON_UNESCAPED_UNICODE)) // | JSON_NUMERIC_CHECK
				->_display();
		exit;
    }
    
    public function _display_json($data = NULL, $header = 200)
	{
		$response	= $data;

		$this->output
				->set_status_header($header)
				->set_content_type('application/json')
				->set_output(json_encode($response, JSON_UNESCAPED_UNICODE)) // | JSON_NUMERIC_CHECK
				->_display();
		exit;
	}

	public function _exit($error_msg = NULL, $header = 401)
	{
		if ( ! empty($error_msg))
		{
			$response['context']['response'] 	= 'error';
			$response['context']['data'] 	= $error_msg;
			$response['context']['status'] 		= 0;
		}
		
		if ($this->config->item('debug') && $this->db) {
			$response['output_profiler'] = $this->output_profiler->run();
		}
		$response['status'] = 0;
		$this->output
				->set_status_header($header)
				->set_content_type('application/json')
				->set_output(json_encode($response, JSON_UNESCAPED_UNICODE)) // | JSON_NUMERIC_CHECK
				->_display();
		exit;
	}
}