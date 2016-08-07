<?php
class DatabaseObject {

    public static function select_all() {
        global $connection;
        $sql = 'SELECT * FROM ' . static::$table_name;
        return $connection->query($sql);		
    }
    
    public static function select_by_id($id) {
        global $connection;
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE id ="' . $id . '"';
        return $connection->query($sql);		
    }
    
    public static function insert($db_fields, $value) {
        global $connection;
        $sql = "INSERT INTO ";
        $sql .= static::$table_name;
        $sql .= " (";
        $sql .= implode(', ', $db_fields);
        $sql .= ") VALUES ('";
        $sql .= implode("' , '", $value);
        $sql .= "' )";
        
        
        if ($connection->query($sql)) {
            return true;
        } else {
            return false;
        }
        
    }
}
?>