<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * User controller class
 */
class UserController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
        
    public function logout() {
        if(isset($_SESSION['logged_user'])) {
            $_SESSION['logged_user'] = NULL;
            session_destroy();
        }
        redirect('user/login');
    }
    
    public function change_password() {
         if(!is_logged())
            show_404();
        
        $data = array();
        $new_password = @$_POST['new_password'];
        $old_password = @$_POST['old_password'];
        
        if(isset($new_password) && isset($old_password)) {
            $user_data = User::data_is_valid($this->logged_user()->get_username(), $old_password);
            if($user_data) {
                $u = new User($user_data);
                $u->set_password($new_password);
                
            $result = new Validation();

                if($result->is_valid()){
                    $u->update('password');
                    show_message('succes message');
                }else{
                    $data['is_error'] = $result;
                }
            }else{
                $data['is_error'] = 'Invalid password';
            }      
        }

        $this->render('template', array(
            'body'  => $this->render('change_password', $data, TRUE)
        ));
    }
    
    public function profile($id = NULL, $username = NULL) {
        /**
         * get user data
         * if $id is not valid show user profile
         */
        if(!is_numeric($id) && !is_logged()){
            show_404('User not found');
        }elseif(is_numeric($id) && isset($username)) {
            $u = User::get_user($id);
            if($u->get_username() != $username)
                show_404('User not found');
        }elseif($id == NULL && is_logged()) {
            $u = $this->logged_user();
        }else{
            show_404('User not found');
        }

        if(!$u)
            show_404('User not found');
        
        if(is_logged())
            $logged_account = $this->logged_user()->get_id()==$u->get_id()?TRUE:FALSE;
        else
            $logged_account = FALSE;
        
        $this->render('template', array(
            'body'  => $this->render('user_profile', array(
                'user'  => $u,
                'logged_account' => $logged_account
            ), TRUE)
        ));
    }
    
    public function login() {
        /**
         * redirect to base_url if is logged
         */
        if(is_logged())
            redirect();
        
        $data = array();
        $username = @$_POST['username'];
        $password = @$_POST['password'];
        
        if(isset($username) && isset($password)) {
            
            $user_data = User::data_is_valid($username, $password);
            if($user_data) {
                $remember = @$_POST['remember'];
                if(isset($remember) && $remember == 'remember') {
                    setcookie( session_name(), session_id(), time() + 86400*30, '/' );
                }
                $_SESSION['logged_user'] = serialize($user_data);
                show_message('succes message', base_url());
            }else{
                $data['is_error'] = true;
            }      
        }

        $this->render('template', array(
            'body'  => $this->render('login', $data, TRUE)
        ));
    }
    
    public function delete() {
        if(!is_logged())
            show_404();
            
        $u = $this->logged_user();
        $u->delete();
        
        $_SESSION['logged_user'] = NULL;
        session_destroy();
        show_message("account has been deleted<br/> <br/> Don't worry.<br /><strong>We still love You <3</strong>", base_url());
    }
    
    public function signup() {
        $data = array();
        $username = @$_POST['username'];
        $password = @$_POST['password'];
        $mail     = @$_POST['mail'];

        if(isset($username) && isset($password) && isset($mail)) {

            $u = new User();
            $u->set_username($username);
            $u->set_password($password);
            $u->set_mail($mail);

            $result = new Validation();

            if($result->is_valid()){
                $u->create();
                show_message('account created');
            }else{
                $data['is_error'] = $result;
            }
        }
        
        $this->render('template', array(
            'body'  => $this->render('create_account', $data, TRUE)
        ));
    }
}