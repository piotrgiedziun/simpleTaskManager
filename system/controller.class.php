<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Controller class
 */
class Controller {
   protected $db;
   
   public function __construct() {      
       
   }
   
   public function __destruct() {
       ob_end_flush();
   }

   public function set_output($value) {
       echo $value;
   }
}