<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class IndexController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        if(is_logged()) {
            $this->set_output('Hi '.$this->logged_user()->get_username().'!');
        }else{
            $this->set_output('index form index');     
        }
    }
}