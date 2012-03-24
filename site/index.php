<?php
/**
 * Simple Task Manager CMS
 * @source https://github.com/piotrgiedziun/simple-task-manager
 * @git https://github.com/piotrgiedziun/simple-task-manager.git
 */
ini_set("session.gc_maxlifetime","2592000");
session_set_cookie_params( 86400*30 );

session_start();

define('SYSTEM', 1);

require_once('config/constants.php');
require_once('system/global.functions.php');
require_once('system/system.class.php');

System::load_system('database');
System::load_system('controller');
System::load_system('validation');

Database::connect();

System::init_app_layer();

Database::close();