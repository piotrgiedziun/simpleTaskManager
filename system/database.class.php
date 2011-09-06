<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Database class
 * communication bettwen application and mysql server
 */

class Database {
    private $server;
    private $user;
    private $password;
    private $database;
    private $prefix;
    
    function __construct($server, $user, $password, $database, $prefix='') { 
        $this->server = $server; 
        $this->user = $user; 
        $this->password = $password; 
        $this->database = $database; 
        $this->prefix = $prefix; 
    }
    //@TODO: connection method
}