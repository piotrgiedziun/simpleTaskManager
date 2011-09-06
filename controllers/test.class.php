<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Test extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->set_output('index form test');
    }
    
    public function test($parm1=NULL, $parm2=NULL) {
        print_r($parm1);
        print_r($parm2);
        System::load_model('user');

        $u = new User();
        $u->set_username("JDt");
        $u->set_password("to");

        $result = new Validation();

        if($result->is_valid()){
            $this->set_output('ok');
            $u->insert();
        }else{
            $this->set_output($result);
        }
        User::data_is_valid('', '');
        $this->set_output('test from test');
    }
}
