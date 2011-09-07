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
    const table = 'Users';
    
    /**
     * Load user form database
     * @param User $user
     */
    public function __construct($user = NULL) {
        if($user == NULL) return;
        
        $this->id       = $user->id;
        $this->username = $user->username;
        $this->mail     = $user->mail;
        $this->created  = $user->created;
    }
    /**
     * Allows insert username
     * validate user name (4-10 alphanumeric chars)
     * @param String $username 
     */
    public function set_username($username) {
        if( !preg_match('/^[a-zA-Z0-9]{4,10}$/', $username) )
            return Validation::Error("Invalid username");
        
        $this->username = strtolower($username);
    }
    
    /**
     * Allows insert password
     * validate password (4-25 chars)
     * @param String $password 
     */
    public function set_password($password) {
        if(strlen($password) < 4 || strlen($password) > 25 )
            return Validation::Error("Invalid password");
        
        $this->password = md5($password);
    }
    
    /**
     * Allows insert mail
     * validate mail [login]@[domain].[top-level domain]
     * @param String $mail 
     */
    public function set_mail($mail) {
        if( !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $mail) )
            return Validation::Error('Invalid email');
        
        $this->mail = strtolower($mail);
    }
    
    /**
     * @return user id
     */
    public function get_id() {
        return $this->id;
    }
    
    /**
     * @return username
     */
    public function get_username() {
        return $this->username;
    }
    
    /**
     * @return user mail
     */
    public function get_mail() {
        return $this->mail;
    }
    
    /**
     * @return user creation date
     */
    public function get_created() {
        return $this->created;
    }
    
    /**
     * Insert new user to database
     */
    public function insert() {
        //set current time
        $this->created = time();
        
        Database::insert(self::table, array(
            'username'  => strip_tags(mysql_escape_string($this->username)),
            'password'  => mysql_escape_string($this->password),
            'mail'      => mysql_escape_string($this->mail),
            'created'   => $this->created
        ));
    }
    
    /**
     * Get user ith specific id
     * @return User/ will show 404
     */
    public static function get_user($id = NULL) {
        if(!is_numeric($id)) System::show_404 ('Invalid user id');
        
        $result = Database::select('*', self::table, array('id'=>$id), NULL, 1);
        
        if($result) {
            $u = new User($result);
            return $u;
        }else{
            System::show_404('User not found');
        }
    }
    
    /**
     * checks whether the user data is correct
     * @return false - when data is invalid
     * @return new User() when data is valid
     */
    public static function data_is_valid($username, $password) {
        print_r(Database::select('*', self::table, array('id'=>2), null, 1));
        Database::update(self::table, array('password'=>'tajne'), array('id'=>2));
    }
}