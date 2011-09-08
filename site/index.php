<?php
/**
 * Simple Task Manager CMS
 */
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