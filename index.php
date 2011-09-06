<?php
/*
 * Simple Task Manager CMS
 * 
 */
session_start();
ob_start();
define('SYSTEM', 1);

require_once('system/system.class.php');
System::load_system('database');
System::load_system('controller');
System::load_system('validation');

/*
 * extracting information form GET request
 */
$get_key = substr(key($_GET), 1);

if(is_numeric(strpos($get_key, '/'))) 
    $get_key = explode('/', $get_key);
else 
    $get_key = array($get_key);

//loop values and check data
foreach($get_key as $value)
    if($value!= '' && !preg_match('/^[a-zA-Z0-9]*$/', $value))
        System::show_404('URL constains disallowed characters.');

if(isset($get_key[0]) && file_exists('controllers/'.strtolower($get_key[0]).'.class.php')) {
    $class = strtolower($get_key[0]);
}else{
    $class = 'index';
}

require_once('controllers/'.strtolower($class).'.class.php');

$o = new $class;

if(isset($get_key[1]) && method_exists($o, strtolower($get_key[1])))
    $method = strtolower($get_key[1]);
else
    $method = 'index';

$parms = array();
for($i = 2; $i<count($get_key); $i++)
    array_push($parms, $get_key[$i]);

call_user_func_array(array($o, $method), $parms);