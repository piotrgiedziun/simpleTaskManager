<?php
/**
 * Task class
 */
class Task {
    private $id;
    private $user_id;
    private $message;
    private $completed;
    private $updated;
    private $created;
    
        /**
     * Load user form database
     * @param Task $task
     */
    public function __construct($task = NULL) {
        if($task == NULL) return;
        
        $this->id        = $user->id;
        $this->user_id   = $user->user_id;
        $this->message   = $user->message;
        $this->completed = $user->completed;
        $this->updated   = $user->updated;
        $this->created   = $user->created;
    }
    
    /**
     * @return taks owner id 
     */
    public function get_id() {
        return $this->id;
    }
    
    /**
     * @return taks owner id 
     */
    public function get_user_id() {
        return $this->user_id;
    }
      
    /**
     * @return taks status (boolean)
     */
    public function get_completed() {
        return $this->completed;
    }
    
    /**
     * @return taks updated time 
     */
    public function get_updated() {
        return $this->updated;
    }
    
    /**
     * @return taks created time 
     */
    public function get_created() {
        return $this->created;
    }
    
}