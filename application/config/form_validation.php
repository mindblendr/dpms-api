<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
	'dentist_add' => [
		[
			'field' => 'firstname',
			'label' => 'Firstname',
			'rules' => ['required'],
		],
		[
			'field' => 'lastname',
			'label' => 'Lastname',
			'rules' => ['required'],
		],
		[
			'field' => 'password',
			'label' => 'Password',
			'rules' => ['required'],
		],
		[
			'field' => 'confirm_password',
			'label' => 'Confirm Password',
			'rules' => ['required', 'matches[password]'],
		],
		[
			'field' => 'pin',
			'label' => 'Pin',
			'rules' => ['required', 'exact_length[4]'],
			'errors' => [
				'exact_length' => 'The {field} must be {param} digits.'
			]
		],
		[
			'field' => 'status',
			'label' => 'Status',
			'rules' => ['required', 'in_list[0,1]'],
		]
	],
	'dentist_edit' => [
		[
			'field' => 'confirm_password',
			'label' => 'Confirm Password',
			'rules' => ['matches_not_required[password]'],
		],
		[
			'field' => 'pin',
			'label' => 'Pin',
			'rules' => ['exact_length[4]'],
			'errors' => [
				'exact_length' => 'The {field} must be {param} digits.'
			]
		],
		[
			'field' => 'status',
			'label' => 'Status',
			'rules' => ['in_list[0,1]'],
		]
	]
];