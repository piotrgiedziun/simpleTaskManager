<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Users class file
 */

class User {
    private $id;
    private $username;
    private $password;
    private $mail;
    private $user_token;
    private $created;
    private $updated;
    const table = 'users';
    
    /**
     * Load user form database
     * @param User $user
     */
    public function __construct($user = NULL) {
        if($user == NULL) return;
        
        $this->id         = $user->id;
        $this->username   = $user->username;
        $this->mail       = $user->mail;
        $this->user_token = $user->user_token;
        $this->created    = $user->created;
    }
    /**
     * Allows insert username
     * validate user name (4-10 alphanumeric chars)
     * @param String $username 
     */
    public function set_username($username) {
        if( !preg_match('/^[a-zA-Z0-9]{4,20}$/', $username) )
            return Validation::Error('Invalid username. Must be 4 to 20 length and might use only alphanumeric characters');

        $result = Database::select('username', self::table, array('username'=>$username), NULL, 1);

        if(is_object($result)) 
            return Validation::Error('Username already taken');
        
        $this->username = strtolower($username);
    }
    
    /**
     * Allows insert password
     * validate password (4-25 chars)
     * @param String $password 
     */
    public function set_password($password) {
        if(strlen($password) < 4 || strlen($password) > 25 )
            return Validation::Error('Invalid password. Must be 4 to 25 length');
        
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
        
        $result = Database::select('mail', self::table, array('mail'=>$mail), NULL, 1);

        if(is_object($result)) 
            return Validation::Error('Mail already taken');
        
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
     * @return user token
     */
    public function get_user_token() {
        return $this->user_token;
    }
    
    /**
     * @return user creation date
     */
    public function get_created() {
        return $this->created;
    }
    
    /**
     * Insert new user to database
     * @return true/false
     */
    public function create() {
        //set current time
        $this->created = time();
        $this->user_token = uniqid();
        
        $row_id = Database::insert(self::table, array(
            'username'   => strip_tags(mysql_escape_string($this->username)),
            'password'   => mysql_escape_string($this->password),
            'mail'       => mysql_escape_string($this->mail),
            'user_token' => $this->user_token,
            'created'    => $this->created,
            'updated'    => $this->created
        ));
        
        return is_numeric($row_id) ? true : false;
    }
    
    /**
     * Update user data
     * @param generlic list
     * @return true/false
     */
    public function update() {
        if(!is_numeric($this->id)) return false;
        
        $fields = func_get_args();
        $this->updated = time();
        
        foreach($fields as $field)
            if(isset($this->$field))
                Database::update(
                    self::table,
                    array($field => $this->$field, 'updated'=>$this->updated),
                    array('id'=>$this->id)
                );
        
        return true;
    }
    
    /**
     * Delete user
     * @return status (true/false)
     */
    public function delete() {
        if(!is_numeric($this->id)) return false;
        Database::delete(self::table, array(
            "id" => $this->id
        ));
        
        return true;
    }
    
    /**
     * Get user ith specific id
     * @return User/ will show 404
     */
    public static function get_user($id) {
        if(!is_numeric($id)) 
            show_404 ('Invalid user id');
        
        $result = Database::select('id,username,mail,user_token,created', self::table, array('id'=>$id), NULL, 1);
        
        if($result) {
            $u = new User($result);
            return $u;
        }else{
            show_404('User not found');
        }
    }
    
    /**
     * Get array of users
     * @return Array of Users/show 404
     */
    public static function get_users() {
        
        $result = Database::select('id,username,mail,user_token,created', self::table);
        
        if(count($result) == 0)
            show_error('No users found');
        
        $users = array();
        
        foreach($result as $user_data)
            $users[] = new User($user_data);

        return $users;
    }
    
    /**
     * checks whether the user data is correct
     * @return false when data is invalid
     * @return user_data when data is valid
     */
    public static function data_is_valid($username, $password, $is_md5=false) {
        
        $user_data = Database::select(
                'id,username,mail,user_token,created',
                self::table,
                array('username'=>$username, 'password'=>$is_md5?$password:md5($password)),
                null,
                1);

        return is_object($user_data)&&isset($user_data->id) ? $user_data : false;        
    }
}