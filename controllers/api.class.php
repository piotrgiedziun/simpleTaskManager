<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Api extends Controller {
    public function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->set_output('api');
    }
}
