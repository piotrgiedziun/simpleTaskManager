<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * Data Validation class is a container of errors associated
 * with incorrectly entered data
 */

class Validation {
    /**
     * static array contains error messages
     * @var array of String 
     */
    private static $messages = array();
        
    /**
     * static function to insert error messages from application side
     */
    public static function Error($message) {
        self::$messages[] = $message;
    }

    /**
     * validaiton state
     * @return boolean
     */
    public function is_valid() {
        return empty(self::$messages);
    }
    
    /**
     * simple way to print formated data
     */
    public function __toString() {
        $string = '';
            foreach (self::$messages as $message)
                $string .= $message.'<br/>';
        
        return $string;
    }
    
    /**
     * claen message data (for more than one validation usage)
     */
    public function clear() {
        self::$messages = array();
    }
}