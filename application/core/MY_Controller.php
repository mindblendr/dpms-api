<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        if (! checkAuthPath()) {
            $this->json->_exit('Unauthorized!', 401);
        }
	}

    public function data_validation($config, $data = NULL, $error_convert_keys = NULL)
    {
        if ( ! empty($data) OR ! is_null($data)) {
            $this->form_validation->set_data($data);
        }

        if (is_array($config)) {
            foreach ($config as $key) {
                if ($this->form_validation->run($key) == FALSE) {
                    $errors = $this->form_validation->error_array();

                    // $errors = array_values($errors);
                    // for ($i=0; $i < count($errors); $i++) { $errors[$i] = $errors[$i]; }

                    $this->json->_display([
                        'context' => [
                            'errors' => $errors,
                            'status' => 0
                        ],
						'status' => 1
					]);
                }
                $this->form_validation->reset_validation();
            }
        } else {
            if ($this->form_validation->run($config) == FALSE) {
                $errors = $this->form_validation->error_array();

                // $errors = array_values($errors);
                // for ($i=0; $i < count($errors); $i++) { $errors[$i] = $errors[$i]; }

                $this->json->_display([
                    'context' => [
                        'errors' => $errors,
                        'status' => 0
                    ],
					'status' => 1
				]);
            }
        }
        $this->form_validation->reset_validation();
    }

}