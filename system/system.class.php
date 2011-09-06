<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * System class
 * allows include files, display errors
 */
class System {
    
    /**
     * Load model class
     * @param String $class_name 
     */
    public static function load_model($class_name) {
        self::load($class_name, 'models/'.$class_name.'.class.php');
    }
    
    /**
     * Load system class
     * @param String $class_name 
     */
    public static function load_system($class_name) {
        self::load($class_name, 'system/'.$class_name.'.class.php');
    }
    
    /*
     * @parm String $file_name - display in error log
     * @param String $file_path - path to file
     */
    private static function load($file_name, $file_path) {
        if(!file_exists($file_path))
            self::show_404('[SYSTEM ERROR] file '.$file_name.' not found.');
        
        require_once($file_path);
    }
    
    /*
     * Display 404 message.
     * Break code execution after calling.
     * @parm String $message (additional)
     */
    public static function show_404($message = '') {
        ob_end_clean();
        echo '[404] '.$message;
        exit;
    }
}