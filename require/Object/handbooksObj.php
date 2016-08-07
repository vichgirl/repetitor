<?php
    require_once('databaseObj.php');

	class Handbooks extends DatabaseObject {
		protected static $table_name = "handbooks";
		protected static $db_fields=array('id', 'name', 'text', 'id_subjects');

		public $id;
		public $name;
		public $text;
        public $id_subjects;

		public static function get_db_fields() {
			return self::$db_fields;
		}

        public static function select_handbooks_for_subject($id_subject) {
            global $connection;
            $sql = 'SELECT * FROM ' . static::$table_name . ' WHERE id_subject = "' . $id_subject . '"';
            return $connection->query($sql);
        }

	}
?>
