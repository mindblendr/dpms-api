<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
    }
    
    public function admin()
    {
        // $this->data_validation([''])
        $admin = $this->admin->where([
                                    'admin.username' => $this->input->post('username'),
                                    'admin.pin' => $this->input->post('pin'),
                                    'admin.status' => 1,
                                ])->get();

        if ($admin) {
            if (password_verify($this->input->post('password'), $admin->password)) {
                $session_id = md5($admin->id . date('YmdHisu'));
                $data = [ 'session_id' => $session_id, ];

                $data = db_timestamp('updated', $data, $admin->id, 1);
                $data = db_timestamp('last_login', $data, $admin->id, 1);

                if ($this->admin->update($data, $admin->id)) {
                    $time = time();
                    $this->json->_display([
                        'context' => [
                            'data' => [
                                'jwt' => jwtEncode([
                                    'auth_id' => $admin->id,
                                    'auth_session_id' => $session_id,
                                    'auth_guard' => 'admin',
                                    'iat' => $time,
                                    'exp' => strtotime($this->config->item('jwt')['exp'], $time)
                                ]),
                                'guard' => 'admin'
                            ],
                            'status' => 1
                        ]
                    ]);
                }
            }
        }
        
        $this->json->_display([
            'context' => [
                'status' => 0
            ]
        ]);
    }

    public function dentist()
    {
        // $this->data_validation([''])
        $dentist = $this->dentist->where([
                                    'dentist.username' => $this->input->post('username'),
                                    'dentist.pin' => $this->input->post('pin'),
                                    'dentist.status' => 1,
                                ])->get();

        if ($dentist) {
            if (password_verify($this->input->post('password'), $dentist->password)) {
                $session_id = md5($dentist->id . date('YmdHisu'));
                $data = [ 'session_id' => $session_id, ];

                $data = db_timestamp('updated', $data, $dentist->id, 1);
                $data = db_timestamp('last_login', $data, $dentist->id, 1);

                if ($this->dentist->update($data, $dentist->id)) {
                    $time = time();
                    $this->json->_display([
                        'context' => [
                            'data' => [
                                'jwt' => jwtEncode([
                                    'auth_id' => $dentist->id,
                                    'auth_session_id' => $session_id,
                                    'auth_guard' => 'dentist',
                                    'iat' => $time,
                                    'exp' => strtotime($this->config->item('jwt')['exp'], $time)
                                ]),
                                'guard' => 'dentist'
                            ],
                            'status' => 1
                        ]
                    ]);
                }
            }
        }
        
        $this->json->_display([
            'context' => [
                'status' => 0
            ]
        ]);
    }
}