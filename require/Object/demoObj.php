<?php
    require_once('databaseObj.php');

	class Demo extends DatabaseObject {
		protected static $table_name = "demo";
		protected static $db_fields=array('id', 'year', 'url','id_exam');

		public $id;
		public $year;
		public $url;
		public $id_exam;

		public static function get_db_fields() {
			return self::$db_fields;
		}

        public static function select_demo_to_exam($id_exam) {
            global $connection;
            $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE id_exam = "' . $id_exam . '" ORDER BY year DESC';
            return $connection->query($sql);
        }

	}
?>
