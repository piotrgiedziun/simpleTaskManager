<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * Index Controller class
 */
class IndexController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->render('template', array(
            'body' => $this->render('tasks_main', array(), TRUE)
        ));
    }
}