<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * API controller class
 */
class ApiController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * @param String $action
     * - create - create new task
     * - update/[id] - update taks with specified id
     * - delete/[id] - delete taks with specified id
     * - get - get all task (for logged user)
     */
    public function tasks($action = '') { 
        if(!in_array($action, array('create', 'update', 'delete', 'get'))) {
            //$this->set_json_output(); (?)
        }
        
        $this->set_output(json_encode(array('id'=>'test')));
    }
    
    /**
     * @param String $action
     * - create - create new user
     * - get - return logged user data
     */
    public function users($action = '') {
        $this->set_output('api');
    }
    
    public function auth() {
        
    }
}
