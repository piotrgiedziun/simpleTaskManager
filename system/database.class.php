<?php if(!defined('SYSTEM')) exit('No direct script access allowed');
/*
 * Database class
 * communication bettwen application and mysql server
 */
class Database {
    private static $prefix;
    private static $connection;

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
    
    public static function select($what, $from, $where = array(), $order_by = NULL, $limit = NULL) {
        $query_sql = 'SELECT '.mysql_escape_string($what).' FROM '.mysql_escape_string($from);
        
        if(is_array($where) && count($where) > 0) {
            $query_sql .= ' WHERE ';
            foreach($where as $key=>$value)
                $query_sql .= $key.' = "'.mysql_escape_string($value).'", ';
            
            //remove last comma
            $query_sql = substr($query_sql, 0, -2);
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
    
    public static function query($query_sql) { 
        
        $result  = mysql_query($query_sql, self::$connection); 

        if (!$result ) { 
            System::show_error('Error while getting data form mysql');
            return 0; 
        }

        return $result; 
    }
    
    static public function close() { 
        if(!@mysql_close(self::$connection))
             System::show_error('Error while closing database'); 
    }
}