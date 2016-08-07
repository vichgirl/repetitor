<?php
	function check_required_fields($required_array) {
		$fields_errors = array();
		foreach ($required_array as $fieldname => $name) {
			if  ( ($_POST[$fieldname] == "")  || (!isset($_POST[$fieldname])) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)) {
				$fields_errors[] = "поле <strong>'" . $name . "'</strong> обязательно для заполнения.";
			}
		}
	return $fields_errors;
	}

	function check_rus($rus_text_array) {
	$fields_errors = array();
		foreach ($rus_text_array as $fieldname => $name) {
			if (!preg_match("/^[А-Яа-яЁё\s]+$/", $_POST[$fieldname])) {
				$fields_errors[] = "поле <strong>'" . $name . "'</strong> может содержать только буквы русского алфавита.". $_POST[$fieldname]. "";
			}
		}
	return $fields_errors;
	}

	function check_max_field_lengths($field_length_array) {
		$fields_errors = array();
		foreach ($field_length_array as $fieldname => $maxlength) {
			if (mb_strlen(trim(($_POST[$fieldname]))) > $maxlength) {
				$fields_errors[] = "максимальная длина поля <strong>'" . $fieldname . "'</strong> составляет " . $maxlength . " символов.";
			}
		}
		return $fields_errors;
	}

	function check_min_field_lengths($field_min_length_array) {
		$fields_errors = array();
		foreach ($field_min_length_array as $fieldname => $minlength) {
			if (mb_strlen(trim(($_POST[$fieldname]))) < $minlength) {
				$fields_errors[] = "минимальная длина поля <strong>'" . $fieldname . "'</strong> составляет " . $minlength . " символов.";
			}
		}
		return $fields_errors;
	}

	function display_errors($error_array) {
		echo '<p><strong>Пожалуйста, проверьте следующие поля:</strong></p>';
		echo '<ul>';
		foreach ($error_array as $error) {
			echo '<li>' . $error . '</li>';

		}
		echo '</ul>';
	}
?>
