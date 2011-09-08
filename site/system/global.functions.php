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