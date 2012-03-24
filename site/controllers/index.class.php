<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * Index Controller class
 */
class IndexController extends Controller {
    
    public function __construct() {
        parent::__construct();
        System::load_model('Task');
    }
    
    public function index() {
        if(is_logged())
            redirect('dashboard');
			
        $this->render('template', array(
            'body' => $this->render('home', NULL, TRUE)
        ));
    }
    
    public function dashboard() {
        if(!is_logged())
            redirect();
        
        $data = array();
        $data['tasks'] = Task::get_tasks($this->logged_user()->get_id());
        
        $this->render('template', array(
            'body' => $this->render('tasks_main', $data, TRUE)
        )); 
    }
}