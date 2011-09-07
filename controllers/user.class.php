<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * User controller class
 */
class UserController extends Controller {
    
    public function __construct() {
        parent::__construct();
        /**
         * Include additional models lib
         */
        System::load_model('user');
    }
    
    public function index() {
        $this->render("template");
    }
    
    public function create_account($parm1=NULL, $parm2=NULL) {
        $u = new User();
        $u->set_username("JDtest");
        $u->set_password("totest");
        $u->set_mail("totest");
        
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
