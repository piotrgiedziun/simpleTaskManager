<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Database class
 * communication bettwen application and mysql server
 * All methods are static, available at the application layer
 */
class Database {
    /**
     * table prefix
     * @deprecated (might be for future usage)
     */
    private static $prefix;
    
    /**
     * stores a reference to the connection
     * @var connection 
     */
    private static $connection;

    /**
     * Connect to MySQL database
     * System::get_config works like sandbox 
     * (this data is not stored in variables that might by dupmped dumped)
     * --------------------------------------------------------------
     * @see index.php
     */
    static function connect() {         
        self::$connection = @mysql_connect(
                System::get_config('database', 'server'),
                System::get_config('database', 'user'), 
                System::get_config('database', 'password')
        ); 
        
        if(!self::$connection)
            System::show_error('Database connection error');
        
        if(!@mysql_select_db(System::get_config('database', 'database'), self::$connection))
            System::show_error('Can not connect to database.');
    }
    
    /**
     * Select statement
     * --------------------------------------------------------------
     * @param String $what data to be retrieved (eg. "*", "id")
     * @param String $from table name (eh. "Users")
     * @param String/Array $where - where statement (eg. array('id'=>1, 'uid'=>2), "id = 2")
     * @param String $order_by order by statement (eg. "id ASC", "price DESC")
     * @param int/String $limit - limit statement (eg. "1", "0,10")
     * --------------------------------------------------------------
     * @return array of objects/object
     * will return array by default, object while $limit sattement equals "1"
     * --------------------------------------------------------------
     * @example
     *  
     * Database::select('*', self::table, array('id'=>2), null, 1)
     * will return object stdClass Object (...)
     * 
     * Database::select('*', self::table, array('id'=>2))
     * will return array of objects array( stdClass Object (...) )
     */
    public static function select($what, $from, $where = array(), $order_by = NULL, $limit = NULL) {
        $query_sql = 'SELECT '.mysql_escape_string($what).' FROM `'.mysql_escape_string($from).'`';
        
        if(is_array($where) && count($where) > 0) {
            $query_sql .= ' WHERE ';
            foreach($where as $key=>$value)
                $query_sql .= '`'.$key.'` = "'.mysql_escape_string($value).'" AND ';
            
            //remove last AND
            $query_sql = substr($query_sql, 0, -4);
        }elseif(!is_array($where) && strlen($where) > 0) {
            $query_sql .= ' WHERE '.$where;
        }
        
        if($order_by != NULL)
            $query_sql .= ' ORDER BY '.mysql_escape_string($order_by);
        
        if($limit != NULL)
            $query_sql .= ' LIMIT '.mysql_escape_string($limit);

        $results = self::query($query_sql);
        
        if($limit == '1') {
            $return = mysql_fetch_object($results);
        }else{
            $return = array();
            while ($row = mysql_fetch_object($results)) {
                $return[] = $row;
            }
        }

        return $return;
    }
    
    /**
     * Insert statement
     */
    public static function insert($table, $data) {
        if(!is_array($data)) return;
        
        $query_sql = 'INSERT INTO `'.mysql_escape_string($table).'` (';
        
        foreach($data as $index=>$value)
            $query_sql .= '`'.mysql_escape_string($index).'`, ';
        
        //remove last comma
        $query_sql = substr($query_sql, 0, -2).') VALUES (';
        
        foreach($data as $index=>$value)
            $query_sql .= '"'.mysql_escape_string($value).'", ';
        
        //remove last comma
        $query_sql = substr($query_sql, 0, -2).');';
        
        return self::query($query_sql) ? mysql_insert_id() : false;
    }
    
    /**
     * 
     */
    public static function update($table, $data, $where) {
        if(!is_array($data)) return;
        
        $query_sql = 'UPDATE `'.mysql_escape_string($table).'` SET ';
        
        foreach($data as $index=>$value)
            $query_sql .= '`'.mysql_escape_string($index).'` = "'.mysql_escape_string($value).'", ';
        
        //remove last comma
        $query_sql = substr($query_sql, 0, -2);
        
        if(is_array($where)) {
            $query_sql .= ' WHERE ';
            foreach($where as $key=>$value)
                $query_sql .= '`'.$key.'` = "'.mysql_escape_string($value).'" AND ';
            
            //remove last AND
            $query_sql = substr($query_sql, 0, -4);
        }else{
            $query_sql .= ' WHERE '.mysql_escape_string($where);
        }
        
        return self::query($query_sql);
    }
    
    /**
     * 
     */
    public static function query($query_sql) { 
        
        $result  = mysql_query($query_sql, self::$connection); 

        if (!$result ) { 
            System::show_error('Error while getting data form mysql');
            return 0; 
        }

        return $result; 
    }
    
    /**
     * Close connection
     * @see index.php
     */
    static public function close() { 
        if(!@mysql_close(self::$connection))
             System::show_error('Error while closing database'); 
    }
}