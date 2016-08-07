<?php
require_once 'connection.php';
require_once 'Object/tasksObj.php';
require_once 'Object/examsObj.php';

if(isset($_POST['id_task']))
{
	$id_task=$_POST['id_task'];

	if ($id_task!=0)
    {
        $tasks = Tasks::select_by_id($id_task);
        if (!$tasks) die($connection->error);

        $row_task = $tasks->fetch_array(MYSQLI_ASSOC);

        $exams = Exams::select_by_id($row_task['id_exam']);
        if (!$exams) die($connection->error);

        $row_exam = $exams->fetch_array(MYSQLI_ASSOC);

        $output = '<h2 class="article-title tel-hide">';
        $output .= mb_substr($row_exam['name_exam'], 0, 3);
        if (mb_strlen($row_exam['name_exam']) > 3)
        {
            $output .= ' <span>';
            $output .= mb_substr($row_exam['name_exam'], mb_strpos($row_exam['name_exam'], ' '));
            $output .= '</span>';
        }
        $output .= '</h2>';
        $output .= '<h2  class="tel-hide">' . $row_task['name_task'] . '</h2>';
        $output .= '<p>' . $row_task['text_task'] . '</p>';
        echo $output;
	}
}
else {
    echo 'Ошибка загрузки данных!';
}
?>
