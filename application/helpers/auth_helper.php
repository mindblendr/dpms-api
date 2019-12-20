<?php

use \Firebase\JWT\JWT as JWT;

function jwtEncode($values)
{
	$CI = get_instance();
	try {
		return JWT::encode($values, $CI->config->item('jwt')['secret']);
	} catch (\Throwable $th) {
		return FALSE;
	}
}

function jwtDecode($jwt)
{	$CI = get_instance();
	try {
		return JWT::decode($jwt, $CI->config->item('jwt')['secret'], $CI->config->item('jwt')['algo']);
	} catch (\Throwable $th) {
		return FALSE;
	}
}

function cors()
{
	// Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
	}
}

function checkAuthPath()
{
	$CI = get_instance();
	cors();
	
	$path = str_replace('_', '-', strtolower(explode('?', ltrim($_SERVER['REQUEST_URI'], '/'))[0]));

	$found = FALSE;
	$auth_guards = [];
	$jwt;
	foreach ($CI->config->item('auth_routes') as $key => $value) {
		$path = str_replace('_', '-', $path);
		$key = str_replace('_', '-', $key);
		if (strpos($path, $key) === 0) {
			$found = TRUE;
			$auth_guards = $value;
		}
	}
	
	if ($found) {
		// Check if auth_guards are valid guards (in $config['auth_guards'])
		foreach ($auth_guards as $index => $auth_guard) {
			if (! in_array($auth_guard, $CI->config->item('auth_guards'))) {
				return FALSE;
			}
		}
		
		// api guard needs a 'token' param
		if (in_array('api', $auth_guards) ) {
			if ($CI->input->get('token') == SETTINGS['api_key']) {
				return TRUE;
			}
		} 
		
		// get jwt 
		$auth_header = $CI->input->get_request_header('Authorization', FALSE);
		if ($auth_header) {
			$auth_header = explode(' ', $auth_header);
			if (in_array($auth_header[0], $CI->config->item('auth_headers'))) {
				$jwt = $auth_header[1];
			}
		}
		
		if (isset($jwt)) {
			$decoded_token = jwtDecode($jwt);

			/**
			 * [auth_id] => 9
			 * [auth_session_id] => e6a0a0198996c073fe36ea5d9d4a218d
			 * [auth_guard] => admin
			 * [iat] => 1565675272
			 * [exp] => 1565761672
			 */
			
			if (isset($decoded_token->auth_guard)) {
				$valid_guard = FALSE;
				if (in_array('admin', $auth_guards) && $decoded_token->auth_guard == 'admin') {
					$valid_guard = TRUE;
				} else if (in_array('dentist', $auth_guards) && $decoded_token->auth_guard == 'dentist') {
					$valid_guard = TRUE;
				} else if (in_array('auth', $auth_guards)) {
					$valid_guard = TRUE;
				}
				
				if ($valid_guard) {
					$CI->session_user = $CI->db
											->select($decoded_token->auth_guard . '.*')
											->from($decoded_token->auth_guard)
											->where([
												$decoded_token->auth_guard . '.id' => $decoded_token->auth_id,
												$decoded_token->auth_guard . '.session_id' => $decoded_token->auth_session_id
											])
											->get()
											->row();	

					if ($CI->session_user) {
						switch ($decoded_token->auth_guard) {
							case 'admin':
								$CI->session_user->type = 1;
								break;
							case 'dentist':
								$CI->session_user->type = 2;
								break;
							default:
								break;
						}
						return $CI->session_user;
					}
				}
			} 
		} 
		
		return FALSE;
	} else {
		return TRUE;
	}
}