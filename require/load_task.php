
<?php
require_once 'connection.php';
require_once 'Object/tasksObj.php';

if(isset($_POST['id_exam']))
{
	$id_exam=$_POST['id_exam'];

	if ($id_exam!=0)
    {
        $tasks = Tasks::select_tasks_for_exam($id_exam);
        if (!$tasks) die($connection->error);

        $row_tasks = $tasks->num_rows;

		$output = "<option value='choice'>Выберите задание</option>";

		for ($j = 0; $j < $row_tasks; ++$j)
		{
			$tasks->data_seek($j);
			$row_task = $tasks->fetch_array(MYSQLI_ASSOC);

			$output .= "<option value='";
			$output .= $row_task['id'];
			$output .= "'>";
			$output .= $row_task['name_task'];
			$output .= "</option>";
		}

		echo $output;
	}
}
else {
    echo 'Ошибка загрузки данных!';
}
?>
