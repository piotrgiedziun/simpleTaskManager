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
    private $connection;
    
    function __construct($server, $user, $password, $database, $prefix='') { 
        $this->server = $server; 
        $this->user = $user; 
        $this->password = $password; 
        $this->database = $database; 
        $this->prefix = $prefix; 
    }

    function connect() {         
        $this->connection = @mysql_connect($this->server,$this->user,$this->passwrod); 
        if(!$this->connection)
            System::show_error('Database connection error');
        
        if(!@mysql_select_db($this->database, $this->connection))
            System::show_error('Can not connect to database.');

        $this->clean_data();
    }
    
    function close() { 
        if(!@mysql_close($this->connection))
             System::show_error('Error while closing database'); 
    }
    
    private function clean_data() {
        $this->server = ''; 
        $this->user = ''; 
        $this->password = ''; 
        $this->database = ''; 
        $this->prefix = ''; 
    }
}