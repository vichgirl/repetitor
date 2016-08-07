<?php
function fix_string($string) {
    $string = trim($string);
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return htmlentities($string);
}

if (isset($_POST['add'])) {

    $review = new Reviews();
    $db_fields = Reviews::get_db_fields();

	array_shift($db_fields);

    if (isset($_POST['name'])) {
        $name = fix_string($_POST['name']);
    }

    if (isset($_POST['otzyv'])) {
        $otzyv = fix_string($_POST['otzyv']);
    }

    $null = '';
    $check = 0;

    //ошибки
    $errors = array();
    $required_fields = array('name' => 'Имя','otzyv'=> 'Отзыв');
    $errors = array_merge($errors, check_required_fields($required_fields));
    $fields_with_min_lengths = array('name' => 2);
    $errors = array_merge($errors, check_min_field_lengths($fields_with_min_lengths));
    $fields_with_max_lengths = array('name' => 60);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_max_lengths));

    if (empty($errors)) {
      $value = [$name, $otzyv, $null, $null, $null, $check];

      if ($review->insert($db_fields, $value)) {
          echo "<div id='success' class='message'><a id='btn-success' class='close-mes' title='Закрыть'  href='#'>&times;</a>Спасибо за Ваш отзыв!</div>";
      }
      else {
          echo "<div id='error' class='message'><a id='btn-error' class='close-mes' title='Закрыть'  href='#');'>&times;</a>Ошибка! Отзыв не был добавлен.</div>";
      }
    }
    else {
		$message = '<div  id="error" class="message">Ошибка добавления отзыва!';
		$message .= '<br />';
		echo $message;
		// выводит список полей которые содержат ошибки
		if (!empty($errors)) {
			display_errors($errors);
			echo '</div>';
		}
	}

}
?>
