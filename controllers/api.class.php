<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ApiController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function tasks($action = '') {
        $this->set_output('api');
    }
    
    public function users($action = '') {
        
    }
}
