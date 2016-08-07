<?php
    require_once('databaseObj.php');

	class Tasks extends DatabaseObject {
		protected static $table_name = "tasks";
		protected static $db_fields=array('id', 'name_task', 'text_task','id_exam');

		public $id;
		public $name_task;
		public $text_task;
		public $id_exam;

		public static function get_db_fields() {
			return self::$db_fields;
		}

        public static function select_tasks_for_exam($id_exam) {
            global $connection;
            $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE id_exam = "' . $id_exam . '"';
            return $connection->query($sql);
        }

	}
?>
