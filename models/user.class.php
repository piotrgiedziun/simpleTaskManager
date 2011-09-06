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
    
    public function __construct() {}
    
    public function set_data($id, $username, $mail, $created) {
        $this->id = $id;
        $this->username = $username;
        $this->mail = $mail;
        $this->created = $created;
    }
    
    /*
     * Allows insert username
     * validate user name (4-10 alphanumeric chars)
     * @param String $username 
     */
    public function set_username($username) {
        if( !preg_match('/^[a-zA-Z0-9]{4,10}$/', $username) )
            return Validation::Error("Invalid username");
        
        $this->username = strtolower($username);
    }
    
    /*
     * Allows insert password
     * validate password (4-25 chars)
     * @param String $password 
     */
    public function set_password($password) {
        if(strlen($password) < 4 || strlen($password) > 25 )
            return Validation::Error("Invalid password");
        
        $this->password = md5($password);
    }
    
    /*
     * Allows insert mail
     * validate mail [login]@[domain].[top-level domain]
     * @param String $mail 
     */
    public function set_mail($mail) {
        if( !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $mail) )
            return Validation::Error('Invalid email');
        
        $this->mail = strtolower($mail);
    }
    
    /*
     * @return user id
     */
    public function get_id() {
        return $this->id;
    }
    
     /*
     * @return username
     */
    public function get_username() {
        return $this->username;
    }
    
     /*
     * @return user mail
     */
    public function get_mail() {
        return $this->mail;
    }
    
     /*
     * @return user creation date
     */
    public function get_created() {
        return $this->created;
    }
    
    /*
     * Insert new user to database
     */
    public function insert() {
        //set current time
        $this->created = time();
        
        //@TODO: generate query
    }
    
    /*
     * checks whether the user data is correct
     * @return false - when data is invalid
     * @return new User() when data is valid
     */
    public static function data_is_valid($username, $password) {
        print_r(Database::select('*', 'Users', array('id'=>2), null, 1));
    }
}