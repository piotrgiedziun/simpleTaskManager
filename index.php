<?php
/*
 * Simple Task Manager CMS
 */
session_start();
ob_start();
define('SYSTEM', 1);
define('DEBUG', 1);

require_once('system/system.class.php');

System::load_system('database');
System::load_system('controller');
System::load_system('validation');

Database::connect();

System::init();
