<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * Controller class
 * all files in controllers folder must extends this file
 */
class Controller {
    private static $output_buffer = '';
    private static $view_varivale = array();
    private $logged_user = NULL;
    private $javascript_code = array();
    
    public function __construct() {
        System::load_model('User');

        $this->logged_user = is_logged() ? new User(unserialize($_SESSION['logged_user'])) : NULL;
    }
   
    /**
     * do not call if overwrite
     * return 404 if index (in subclass not exists)
     */
    public function index() {
        System::show_404();
    }
    
    /**
     * @return User 
     */
    public function logged_user() {
        return $this->logged_user;
    }
    
   /**
    * empty output buffer and show buffer content
    */
   public function __destruct() {
       echo self::$output_buffer;
   }

   /**
    * Set data form render function (alternative for $this->render() $data param)
    * --------------------------------------------------------------
    * @see render() in this file
    * --------------------------------------------------------------
    * @param Array $data data to transferred while rendering
    */
   public function set_data($data = array()) {
       self::$view_varivale = array_merge(self::$view_varivale, $data);
   }
   
   /**
    * rendering method
    * --------------------------------------------------------------
    * @param String $view_file file name from the directory /views/
    * @param Array $data data to transferred while rendering
    * @param boolean $return_output TRUE-return output, FALSE (default) print output
    * --------------------------------------------------------------
    * @return output (only while $return_output is set to TRUE)
    */
   public function render($view_file, $data = array(), $return_output=false) {
       if(!preg_match('/^\w+$/', $view_file))
         System::show_error('File name contains illegal characters');
         
       if(!file_exists('views/'.$view_file.'.php'))
           System::show_error('View file ('.$view_file.') not found');
       
       if(is_array($data) && count($data) > 0)
           self::$view_varivale = array_merge(self::$view_varivale, $data);
       
       {
           if($return_output)
               ob_start();
           
           $javascript_code = $this->javascript_code;
           
           if(count(self::$view_varivale) > 0)
               extract(self::$view_varivale);

           include('views/'.$view_file.'.php');
           
           if($return_output) {
               $conteten = ob_get_contents();
               ob_end_clean();
               return $conteten;
           }
       }
   }
   
   /**
    * add javascript code to template
    * @param String $script (don't attach <script> tags)
    */
   public function javascript_add($script) {
       $this->javascript_code[] = $script;
   }
   
   /**
    * append output data
    */
   public function append_output($value) {
       self::$output_buffer .= $value;
   }
   
   /**
    * set output data
    */
   public function set_output($value) {
       self::$output_buffer = $value;
   }
}