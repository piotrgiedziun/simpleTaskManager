<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Users class file
 */

class User {
    private $id;
    private $username;
    private $password;
    private $mail;
    private $created;
    
    public function __construct() {
        //@TODO: insert data
    }
    
    /*
     * Allows insert username
     * validate user name (4-10 alphanumeric chars)
     * @param String $username 
     */
    public function set_username($username) {
        if( !preg_match('/^[a-zA-Z0-9]{4,10}$/', $username) )
            return Validation::Error("Invalid username");
        
        $this->username = mysql_escape_string($username);
    }
    
    /*
     * Allows insert password
     * validate password (4-25 chars)
     * @param String $password 
     */
    public function set_password($password) {
        if(strlen($password) < 4 || strlen($password) > 25 )
            return Validation::Error("Invalid password");
        
        $this->password = mysql_escape_string($password);
    }
    
    /*
     * Allows insert mail
     * validate mail [login]@[domain].[top-level domain]
     * @param String $mail 
     */
    public function set_mail($mail) {
        if( !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $mail) )
            return Validation::Error('Invalid email');
        
        $this->mail = mysql_escape_string($mail);
    }
    
    /*
     * 
     */
    public function insert() {
        //set current time
        $this->created = time();
        
        //@TODO: generate query
    }
}