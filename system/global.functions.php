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