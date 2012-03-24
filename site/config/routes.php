<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * Routes conging file
 * 
 * eg.
 * $routes = array();
 * $routes['index/test']    = 'test'; 
 * 
 * now 
 * (http://site/index/test = http://site/test)
 * 
 */

$routes = array();
$routes['dashboard']    = 'index/dashboard';
$routes['signup']       = 'user/signup';