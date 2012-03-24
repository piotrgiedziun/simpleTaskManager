<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * API controller class
 */
class ApiController extends Controller {
    
    public function __construct() {
        parent::__construct();
        System::load_model('Task');
    }
    
    public function get_user_token() {
        $username = @$_POST['username'];
        $password = @$_POST['password'];

        if(!isset($username) || !isset($password)) 
            $this->set_json_error('Invalid data');
            
        $user_data = User::data_is_valid($username, $password, true);
        if($user_data) {
            $u = new User($user_data);
            $this->set_json_output(array(
                'user_token'    => $u->get_user_token()
            ));
        }else{
            $this->set_json_error('Invalid username or password', 3);
        }      
    }
    
    public function get_session_token() {
        Database::delete('api_tokens', 'expiration_date <= '.time());
        
        $session_token = md5(uniqid());
        
        $unassigned_tokens_count = Database::count('api_tokens', array(
            'user_id'   => -1
        ));
        
//        if($unassigned_tokens_count > 50) {
//            /**
//             * get oldest unasigned token
//             */
//            $oldest_token_data = Database::select('token', 'api_tokens', array(
//                'user_id'   => -1
//            ), '`expiration_date` ASC', 1);
//            
//            if(!isset($oldest_token_data->token))
//                $this->set_json_error('Internal error', 0);
//            
//            $session_token = $oldest_token_data->token;
//        }
        
        Database::insert('api_tokens', array(
            'user_id'           => -1,
            'token'             => $session_token,
            'expiration_date'   => time()+(24*60*60) //24h
        ));
        
        $this->set_json_output(array(
            'session_token'    => $session_token
        ));
    }
    
    public function assign() {
        $session_token = @$_POST['session_token'];
        $user_token_hash = @$_POST['user_token_hash'];
        
        if(!isset($session_token) || !isset($user_token_hash))
            $this->set_json_error('Invalid data');
        
        $user_data = mysql_fetch_object(Database::query('SELECT * FROM `users` WHERE MD5(CONCAT(`user_token`,"'
                .mysql_escape_string($session_token).'")) = "'.mysql_escape_string($user_token_hash).'"'));
        
        if(!is_object($user_data)) 
            $this->set_json_error('Invalid user token hash');
        
        $u = new User($user_data);
        
        $api_token = Database::select('*', 'api_tokens', array(
            'token' => $session_token
        ), null, 1);
        
        if(!is_object($api_token))
            $this->set_json_error('Session expired', 1);
        
        if($api_token->user_id != -1)
            $this->set_json_error('Session already assigned', 2);
        
        Database::update('api_tokens', array(
            'user_id'           => $u->get_id(),
            'expiration_date'   => time()+(24*60*60) //24h
        ), array(
            'token'             => $session_token
        ));
        
        $this->set_json_output(array(
            'status'    => 'succes'
        ));
    }
    
    private function _get_user_by_token($session_token) {
        
        if($session_token==null && is_logged()) return $this->logged_user();
        
        $api_token = Database::select('*', 'api_tokens', array(
            'token' => $session_token
        ), null, 1);
        
        if(!is_object($api_token) || !isset($api_token->user_id))
             $this->set_json_error('Your session token is not valid', 3);
        
        $user_data = Database::select('*', User::table, array(
            'id' => $api_token->user_id
        ), null, 1);
     
        if(!is_object($user_data))
            $this->set_json_error('User not found', -1);
        
        return new User($user_data);
    }
    
    private function _validate_signature($signature, $user_token, $parms) {
        if($signature==null) return;
        
        $parm_string = '';
        foreach($parms as $index=>$value)
            $parm_string .= $index.'='.$value.'&';
        
        $parm_string = substr($parm_string, 0, -1);
        
        if(md5(API_SECRET_KEY.$user_token.$parm_string)!=$signature)
            $this->set_json_error('Invalid signature', 5);    
    }
    
    /**
     *  User managment
     *  - create account (username, password, mail)
     */
    public function user($type = NULL) {
        
        $username = @$_POST['username'];
        $password = @$_POST['password'];
        $mail     = @$_POST['mail'];
        
        if($type != "create" || !isset($username) || !isset($password) || !isset($mail))
           $this->set_json_error('Invalid parms');
            
        $u = new User();
        $u->set_username($username);
        $u->set_password($password);
        $u->set_mail($mail);

        $result = new Validation();

        if($result->is_valid()){
            $u->create();
            $this->set_json_output(array(
                'status'   => 'succes',
                'user_token'    => $u->get_user_token()
            ));
        }else{
            //validation issue code 100
            $this->set_json_error((String)$result, 100);
        }
    }
    
    /**
     * @param String $action
     * - create - create new task
     * - update_message - update task message taks with specified id
     * - update_status - update task message taks with specified id
     * - delete - delete taks with specified id
     * - get - get all task (for logged user)
     */
    public function tasks($type = NULL) {
        
        $session_token = @$_POST['session_token'];
        $signature = @$_POST['signature'];
        
        if(!in_array($type, array('create', 'update', 'delete', 'get'))) {
            $this->set_json_error('Invalid parms');
        }
        
        if((!isset($session_token) || !isset($signature)) && !is_logged())
            $this->set_json_error('Invalid parms');
        elseif(is_logged()) {
            $session_token = null;
            $signature = null;
        }
            
        $u = $this->_get_user_by_token($session_token);

        switch($type) {
            case 'create':
                $message   = @$_POST['message'];
                $priority  = @$_POST['priority'];
                $status_id = @$_POST['status_id'];
                $deadline  = @$_POST['deadline'];
                
                $this->_validate_signature($signature, $u->get_user_token(), array(
                    'message'          => $message,
                    'priority'         => $priority,
                    'status_id'        => $status_id,
                    'deadline'         => $deadline,
                    'session_token'    => $session_token
                ));
                
                $t = new Task();
                $t->set_message($message);
                $t->set_user_id($u->get_id());
                $t->set_priority($priority);
                $t->set_status_id($status_id);
                $t->set_deadline($deadline);
                
                $result = new Validation();

                if(!$result->is_valid())
                    $this->set_json_error((String)$result);
  
                $t->create();
                $this->set_json_output(array(
                    'status'   => 'succes'
                ));
            break;
        
            case 'update':
                
                $parms_name = array('message', 'status_id', 'priority', 'deadline');
                $parms_values = array();
                
                foreach($parms_name as $index=>$parm) {
                    if(isset($_POST[$parm]))
                        $parms_values[$parm] = $_POST[$parm];
                    else
                        unset($parms_name[$index]);
                }
                $parms_values['task_id'] = @$_POST['task_id'];
                $parms_values['session_token'] = $session_token;
                
                if(!is_numeric($parms_values['task_id']))
                    $this->set_json_error('Invalid parms');
                                
                $this->_validate_signature($signature, $u->get_user_token(), $parms_values);
                
               $t = Task::get_task($parms_values['task_id']);
               
               /**
                * task not found or current user is not the owner
                */
               if(!is_object($t) || $t->get_user_id() != $u->get_id())
                   $this->set_json_error('task not found', 4);               
               
                foreach($parms_name as $index) {
                    call_user_func_array(array($t, 'set_'.$index), array($parms_values[$index]));
                }
                
                $result = new Validation();

                if(!$result->is_valid())
                    $this->set_json_error((String)$result);
                
                $t->update($parms_name);
                $this->set_json_output(array(
                    'status'   => 'succes'
                ));  
            break;
                        
            case 'delete':
                $task_id = @$_POST['task_id'];
                
                if(!is_numeric($task_id))
                    $this->set_json_error('Invalid parms');
                
                $this->_validate_signature($signature, $u->get_user_token(), array(
                    'task_id'          => $task_id,
                    'session_token'    => $session_token
                ));
                
                $t = Task::get_task($task_id);
               
                /**
                 * task not found or current user is not the owner
                 */
                if(!is_object($t) || $t->get_user_id() != $u->get_id())
                   $this->set_json_error('task not found', 4);
               
                $t->delete();
               
                 $this->set_json_output(array(
                     'status'   => 'succes'
                 ));  
            break;
        
            case 'get':
                $task_id = @$_POST['task_id'];
                
                if(isset($task_id) && is_numeric($task_id)) {
                    $this->_validate_signature($signature, $u->get_user_token(), array(
                        'task_id'          => $task_id,
                        'session_token'    => $session_token,
                    ));

                    $t = Task::get_task($task_id);
               
                    /**
                     * task not found or current user is not the owner
                     */
                    if(!is_object($t) || $t->get_user_id() != $u->get_id())
                      $this->set_json_error('task not found', 4);  

                    $this->set_json_output(array(
                        'task'   => $t->getArray()
                    ));
                }else{
                    $this->_validate_signature($signature, $u->get_user_token(), array(
                        'session_token'    => $session_token
                    ));

                    $tasks = Task::get_tasks($u->get_id());

                    /**
                     * task not found or current user is not the owner
                     */
                    if(!is_array($tasks))
                       $this->set_json_error('Internal error', -1);
                    
                    foreach($tasks as $index=>$task) {
                        $tasks[$index] = $task->getArray();
                    }

                    $this->set_json_output(array(
                        'tasks'   => $tasks
                    ));
                }
            break;
        
        }
    }
}
