<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/**
 * Task model class
 * 
 * status_id = array(
 *  0 => 'waiting',
 *  1 => 'in progress',
 *  2 => 'complete'  
 * );
 */
class Task {
    private $id;
    private $user_id;
    private $message;
    private $status_id = 0;
    private $priority  = 1;
    private $updated;
    private $created;
    private $deadline;

    const table = 'tasks';
    
    /**
     * statuses
     * for internal usage
     */
    const STATUS_WAITING = 0;
    const STATUS_IN_PROGRESS = 1;
    const STAUS_COMPLETE = 2;
    
    /**
     * priority
     * for internal usage
     */
    const PRIORITY_NORMAL = 1;
    const PRIORITY_HIGH = 2;
        
    /**
     * Load user form database
     * @param Task $task
     */
    public function __construct($task = NULL) {
        if($task == NULL) return;
        
        $this->id        = $task->id;
        $this->user_id   = $task->user_id;
        $this->message   = $task->message;
        $this->status_id = $task->status_id;
        $this->priority  = $task->priority;
        $this->updated   = $task->updated;
        $this->created   = $task->created;
        $this->deadline  = $task->deadline;
    }

    /**
     * convert object to array
     * for API (json)
     * @return Array 
     */
    public function getArray($fields = array('id', 'message', 'status_id', 'updated', 'created', 'deadline','priority')) {
        $output = array();
        
        foreach($fields as $field)
            $output[$field] = $this->$field;
        
        return $output;
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
     * get owner data
     * @return user
     */
    public function get_owner_data() {
        return User::get_user($this->user_id);
    }
      
    /**
     * @return taks status (int)
     *  0 => 'waiting'
     *  1 => 'in progress'
     *  2 => 'complete'  
     */
    public function get_status_id() {
        return $this->status_id;
    }
    
    /**
     * @return taks priority (int)
     * the higher the number the greater priority
     */
    public function get_priority() {
        return $this->priority;
    }
    
    /**
     * @return taks updated time 
     */
    public function get_message() {
        return $this->message;
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
    
    /**
     * @return dedline date 
     */   
    public function get_deadline() {
        return $this->deadline;
    }    
    
    /**
     * Validate message
     * all chars allowed
     * @param String $message
     */
    public function set_message($message) {
        if(strlen($message) <= 0 || strlen($message) > 255) 
            return Validation::Error('Invalid message. Must be 1 to 255 length');
        
        $this->message = strip_tags($message);
    }
    
    /**
     * assign user to task
     * @param int $user_id
     */
    public function set_user_id($user_id) {
        if(!is_numeric($user_id) || $user_id <= 0)
            return Validation::Error('Invalid user. Please login first');
        
        $this->user_id = $user_id;
    }
    
    /**
     * set priotiy
     * @param int priotiy
     */
    public function set_priority($priority) {
        if(!is_numeric($priority) || !in_array($priority, array(self::PRIORITY_NORMAL, self::PRIORITY_HIGH)))
           return Validation::Error('Invalid priority');  
           
        $this->priority = $priority;
    }
    
    /**
     * set task status id
     * @param int status
     */
    public function set_status_id($status_id) {
        if(!is_numeric($status_id) || !in_array($status_id, array(self::STATUS_WAITING,self::STATUS_IN_PROGRESS,self::STAUS_COMPLETE)))
            return Validation::Error('Invalid status id');

        $this->status_id = $status_id;
    }

    public function set_deadline($deadline) {
        if(!is_numeric($deadline) || $deadline < 0)
            return Validation::Error('Invalid deadline');
        
        $this->deadline = $deadline;
    }
    
   /**
    * Insert new task to database
    * @return true/false
    */
    public function create() {
        $this->created = time();
        
        $row_id = Database::insert(self::table, array(
            'user_id'   => $this->user_id,
            'message'   => mysql_escape_string($this->message),
            'status_id' => $this->status_id,
            'priority'  => $this->priority,
            'updated'   => $this->created,
            'created'   => $this->created,
            'deadline'  => $this->deadline
        ));
        
        return is_numeric($row_id) ? true : false;
    }
    
    /**
    * Update task
    * @param generlic list
    * @return true/false
    */
    public function update() {
        if(!is_numeric($this->id)) return false;
        
        $fields = func_get_args();
        $this->updated = time();
        
        if(is_array($fields[0]))
            $fields = $fields[0];
            
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
     * Delete task
     * @return boolean 
     */
    public function delete() {
        if(!is_numeric($this->id)) return false;
        
        Database::delete_by_id(self::table, $this->id);
        
        return true;
    }
    
    /**
     * Get task by id
     * @return task/null
     */
    public static function get_task($taks_id) {
        if(!is_numeric($taks_id)) return false;
        
        $taks_data = Database::select('*', self::table, array('id'=>$taks_id), NULL, 1);
        
        $tasks = NULL;
        
        if(is_object($taks_data))
            $tasks = new Task($taks_data);
            
        return $tasks;
    }
    
    /**
     * Get user tasks
     * @return array of tasks/false
     */
    public static function get_tasks($user_id, $statuses = array(self::STATUS_WAITING,self::STATUS_IN_PROGRESS)) {
        if(!is_numeric($user_id)) return false;
        if(!is_array($statuses) || count($statuses) < 1) return false;
        
        $where = '`user_id` = "'.mysql_escape_string($user_id).'" AND (';
        
        foreach($statuses as $status) {
            $where .= ' `status_id` = "'.mysql_escape_string($status).'" OR';
        }
        
        //remove last " OR"
        $where = substr($where, 0, -3).')';
        
        $result = Database::select('*', self::table, $where, '`deadline` ASC');
                
        $tasks = array();
        
        foreach($result as $task_data)
            $tasks[] = new Task($task_data);
        
        return $tasks;
    }
}
