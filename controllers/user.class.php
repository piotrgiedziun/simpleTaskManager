<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * User controller class
 */
class UserController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        //@TODO: user list (?)
        $this->set_output('user index');
    }
    
    public function logout() {
        if(isset($_SESSION['logged_user'])) {
            $_SESSION['logged_user'] = NULL;
            session_destroy();
        }
        redirect('user/login');
    }
    
    public function profile($id = NULL) {
        /**
         * get user data
         * if $id is not valid show user profile
         */
        if(!is_numeric($id) && !is_logged()){
            System::show_404('User not found');
        }elseif(is_numeric($id)) {
            $u = User::get_user($id);
        }elseif(is_logged()) {
            $u = $this->logged_user();
        }
        
        if(!$u)
            System::show_404('User not found');
        
        print_r($u);
    }
    
    public function login() {
        /**
         * redirect to base_url if is logged
         */
        if(isset($_SESSION['logged_user']))
            redirect();
        
        $data = array();
        $username = @$_POST['username'];
        $password = @$_POST['password'];
        
        if(isset($username) && isset($password) 
                && strlen($username) > 0 && strlen($password) > 0) {
            
            $user_data = User::data_is_valid($username, $password);
            if($user_data) {
                $_SESSION['logged_user'] = serialize($user_data);
                redirect();
            }else{
                $data['is_error'] = true;
            }      
        }
        
        $this->render("template", array(
            'body'  => $this->render("login", $data, TRUE)
        ));
    }
    
    public function create_account() {
        $u = new User();
        $u->set_username("test");
        $u->set_password("test");
        $u->set_mail("test@test.pl");
        
        $result = new Validation();

        if($result->is_valid()){
            $this->set_output('ok');
            $u->insert();
        }else{
            $this->set_output($result);
        }
        $this->set_output('test from test');
    }
}
