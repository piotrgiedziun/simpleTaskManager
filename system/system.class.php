<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * System class
 * allows include files, display errors
 */
class System {
    
    /*
     * only static acces 
     */
    private function __construct() {}
    
    /*
     * System initialization
     * extracts from the address URL logic of class, methods, parms
     */
    public static function init() {
        /*
         * extracting information form GET request
         * remove first slash, get first index element form $_GET
         */
        $get_key = substr(key($_GET), 1);

        /*
         * explode when there is more data
         * eg.
         * Following URL will be converted to array of elements
         * controller/function/parm1 => array('contoller', 'function', 'parm1')
         */
        if(is_numeric(strpos($get_key, '/'))) 
            $get_keys = explode('/', $get_key);
        else 
            $get_keys = array($get_key);

        /*
         * Only alphanumeric characters are allowed
         * otherwise throws 404
         */
        foreach($get_keys as $value)
            if($value!= '' && !preg_match('/^[a-zA-Z0-9]*$/', $value))
                self::show_404('URL constains disallowed characters.');

        /*
         * class name extraction logic
         */
        if(isset($get_keys[0]) && file_exists('controllers/'.strtolower($get_keys[0]).'.class.php'))
            $class = strtolower($get_keys[0]);
        elseif(isset($get_keys[0]) && strlen($get_keys[0]) != 0) 
            self::show_404('Invalid class');
        else
            $class = 'index';

        self::load_controller(strtolower($class));

        
        /*
         * Create instans of $class
         */
        $class_obj = new $class();

        /**
         * method name extraction logic
         */
        if(isset($get_keys[1]) && method_exists($class_obj, strtolower($get_keys[1])))
            $method = strtolower($get_keys[1]);
        elseif(isset($get_keys[1]) && strlen($get_keys[1]) != 0)
            self::show_404('Invalid method');
        else
            $method = 'index';
        
        /*
         * parms extraction logic
         */
        $parms = array();
        for($i = 2; $i<count($get_keys); $i++)
            array_push($parms, $get_keys[$i]);

        /*
         * call class method with parms
         */
        call_user_func_array(array($class_obj, $method), $parms);
    }
    
     /**
     * Load contoller class
     * @param String $class_name 
     */
    public static function load_controller($class_name) {
        self::load('controllers', $class_name);
    }
    
    /**
     * Load model class
     * @param String $class_name 
     */
    public static function load_model($class_name) {
        self::load('models', $class_name);
    }
    
    /**
     * Load system class
     * @param String $class_name 
     */
    public static function load_system($class_name) {
        self::load('system', $class_name);
    }
    
    /*
     * @parm String $dir 
     * @param String $file_name
     */
    private static function load($dir, $file_name) {
        if(!file_exists($dir.'/'.$file_name.'.class.php'))
            self::show_404('[SYSTEM ERROR] file '.$file_name.' ('.$dir.') not found.');
        
        require_once($dir.'/'.$file_name.'.class.php');
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