
<?php
require_once 'connection.php';
require_once 'Object/handbooksObj.php';

if(isset($_POST['id_subject']))
{
	$id_subject=$_POST['id_subject'];

	if ($id_subject!=0)
    {
		$handbooks = Handbooks::select_handbooks_for_subject($id_subject);
		if (!$handbooks) die($connection->error);

		$rows_handbooks = $handbooks->num_rows;

		$output = "<option value='choice'>Выберите тему</option>";

		for ($j = 0; $j < $rows_handbooks; ++$j)
		{
			$handbooks->data_seek($j);
			$row_handbook = $handbooks->fetch_array(MYSQLI_ASSOC);

			$output .= "<option value='";
			$output .= $row_handbook['id'];
			$output .= "'>";
			$output .= $row_handbook['name'];
			$output .= "</option>";
		}

		echo $output;
	}
}
else {
    echo 'Ошибка загрузки данных!';
}
?>
