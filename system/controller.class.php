<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Controller class
 * all files in controllers folder must extends this file
 */
class Controller {
    private static $output_buffer = '';
    private static $view_varivale = array();
    
    public function __construct() {}
   
   /*
    * empty output buffer and show buffer content
    */
   public function __destruct() {
       echo self::$output_buffer;
       ob_end_flush();
   }

   public function set_view_variable($variables = array()) {
   }
   
   public function render($view_file) {
       if(!preg_match('/^\w+$/', $view_file))
         System::show_error('File name contains illegal characters');
         
       if(!file_exists('views/'.$view_file.'.php'))
           System::show_error('View file ('.$view_file.') not found');
       
       {
           if(count(self::$view_varivale) > 0)
               extract(self::$view_varivale);

           include('views/'.$view_file.'.php');
           var_dump(get_defined_vars());
       }
       var_dump(get_defined_vars());
   }
   
   /*
    * set output data
    */
   public function set_output($value) {
       self::$output_buffer = $value;
   }
}