<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * System class
 * allows include files, display errors
 */
class System {
    /**
     * only static acces 
     */
    private function __construct() {}
    
    /**
     * Application layer initialization
     * extracts from the address URL logic of class, methods, parms
     */
    public static function init_app_layer() {
        /**
         * extracting information form GET request
         * remove first slash, get first index element form $_GET
         */
        $get_key = substr(key($_GET), 1);

        /**
         * include routes
         * search for existings key
         */
        include('config/routes.php');
 
        foreach($routes as $find=>$replace)
            if($find == $get_key)
                $get_key = $replace;
        
        /**
         * explode when there is more data
         * replace '-' to '/', you might use both seperators
         * --------------------------------------------------------------
         * @example
         * Following URL will be converted to array of elements
         * controller/function/parm1 => array('contoller', 'function', 'parm1')
         */
        $get_key = str_replace('-', '/', $get_key);
        if(is_numeric(strpos($get_key, '/'))) 
            $get_keys = explode('/', $get_key);
        else 
            $get_keys = array($get_key);

        /**
         * Only alphanumeric characters and '_' (but can not start with '_') are allowed
         * otherwise throws 404
         */
        foreach($get_keys as $value)
            if($value!= '' && (!preg_match('/^[a-zA-Z0-9_]*$/', $value) || $value[0] == '_') )
                show_error('URL constains disallowed characters.');

        /*
         * class name extraction logic
         */
        if(isset($get_keys[0]) && file_exists('controllers/'.strtolower($get_keys[0]).'.class.php'))
            $class = strtolower($get_keys[0]);
        elseif(isset($get_keys[0]) && strlen($get_keys[0]) != 0) 
            show_404('Invalid class');
        elseif(file_exists('controllers/index.class.php'))
            $class = 'index';
        else
            show_404('Create index class');

        self::load_controller(strtolower($class));

        /**
         * Create instans of $classController
         */
        $class = ucfirst($class).'Controller';
        $class_obj = new $class();

        /**
         * method name extraction logic
         */
        if(isset($get_keys[1]) && in_array($get_keys[1], get_class_methods($class))
               && method_exists($class_obj, strtolower($get_keys[1])))
            $method = strtolower($get_keys[1]);
        elseif(isset($get_keys[1]) && strlen($get_keys[1]) != 0)
            show_404('Invalid method');
        elseif(in_array('index', get_class_methods($class)))
            $method = 'index';
        else
            show_404();
        
        /**
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
    
    /**
     * @parm String $dir 
     * @param String $file_name
     */
    private static function load($dir, $file_name) {
         $file_name = strtolower($file_name);
         if(!preg_match('/^\w+$/', $file_name))
            show_error('[SYSTEM ERROR] file name contains illegal characters');
               
        if(!file_exists($dir.'/'.$file_name.'.class.php'))
            show_error('[SYSTEM ERROR] file '.$file_name.' ('.$dir.') not found.');
        
        require_once($dir.'/'.$file_name.'.class.php');
    }
    
    /**
     * get data form confing file
     * sandbox mode
     */
    public static function get_config($type, $index) {
        if(!file_exists('config/'.$type.'.php'))
            show_error('Config file "'.$type.'" not found');
        {
            include('config/'.$type.'.php');
            
            if(!isset($config[$index]))
                show_error('Config index "'.$index.'" not found');
            
            return $config[$index];
        }
    }
}