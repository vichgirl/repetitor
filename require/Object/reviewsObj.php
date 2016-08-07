<?php
require_once('databaseObj.php');

class Reviews extends DatabaseObject {
    protected static $table_name = "reviews";
	protected static $db_fields=array('id', 'name_user', 'text','begin_date','end_date', 'foto', 'check_review');

	public $id;
	public $name_user;
	public $text;
	public $begin_date;
	public $end_date;
	public $foto;
    public $check_review;

	public static function get_db_fields() {
		return self::$db_fields;
	}

    public static function select_check_review() {
        global $connection;
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE check_review = "1"';
        return $connection->query($sql);
    }

    public static function select_check_review_for_num($start,$num) {
        global $connection;
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE check_review = "1" order by end_date DESC LIMIT '. $start.', '. $num.' ';
        return $connection->query($sql);
    }

    public static function select_review_with_photo() {
        global $connection;
        $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE foto != ""';
        return $connection->query($sql);
    }
}
?>
