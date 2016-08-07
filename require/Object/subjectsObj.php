<?php
    require_once('databaseObj.php');

	class Subjects extends DatabaseObject {
		protected static $table_name = "subjects";
		protected static $db_fields=array('id', 'name_subject');

		public $id;
		public $name_subject;
		
		public static function get_db_fields() {
			return self::$db_fields;
		}

	}
?>