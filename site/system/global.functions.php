<?php

/**
 * @return String base_url
 * @see /config/constants.php
 */
function base_url() {
    return BASE_URL;
}

/**
 * break code execution and move to $url
 * @param String $url 
 */
function redirect($url='') {
    header('location: '.(is_numeric(strpos($url, 'http://'))?$url:(base_url().$url)));
    exit;  
}

/**
 * return true when user is logged
 * @return boolean
 */
function is_logged() {
    return isset($_SESSION['logged_user'])?true:false;
}

/**
 * show message
 * render new template with message
 * @param String type $message
 * @param String $redirect_url (default NULL)
 */
function show_message($message='', $redirect_url=NULL) {
     $c = new Controller();
     
     //@TODO: javascript redirect
     if($redirect_url != NULL) {
        $c->javascript_add('setTimeout(\'window.location = "'.$redirect_url.'"\', 5000);');
        $message .= '<br /><a href="'.$redirect_url.'">Click here to continue</a>';
     }
     
     $c->render('template', array(
        'body'  => $message
     ));
     exit;
}

/**
 * Display 404 message.
 * Break code execution after calling.
 * @parm String $message (additional)
 */
 function show_404($message = 'Page not found') {
    include('views/404_page.php');
    exit;
 }
    
 /**
  * Display error message.
  * Break code execution after calling.
  * @parm String $message (additional)
  */
 function show_error($message = '') {
    include('views/error_page.php');
    exit;
 }
 
 /**
  * generate salt
  */
 function generate_salt(){
    $string = '';
    $possible = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    for($i=0;$i < 6;$i++) {
        $char = $possible[mt_rand(0, strlen($possible)-1)];
        $string .= $char;
    }

    return $string;
 }