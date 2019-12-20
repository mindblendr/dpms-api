<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My404 extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {        
        $this->json->_exit('Not found!', 404);
	}
	
}
