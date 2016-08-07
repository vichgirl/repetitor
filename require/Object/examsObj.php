<?php
    require_once('databaseObj.php');

	class Exams extends DatabaseObject {
		protected static $table_name = "exams";
		protected static $db_fields=array('id', 'name_exam');

		public $id;
		public $name_exam;
		
		public static function get_db_fields() {
			return self::$db_fields;
		}

	}
?>