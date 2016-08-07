<?php
require_once 'connection.php';
require_once 'Object/handbooksObj.php';

if(isset($_POST['id']))
{
	$id=$_POST['id'];

	if ($id!=0)
    {
		$handbooks = Handbooks::select_by_id($id);
        if (!$handbooks) die($connection->error);

        $row_handbook = $handbooks->fetch_array(MYSQLI_ASSOC);

        $output = '<h2 class="tel-hide">' . $row_handbook['name'] . '</h2>';
        $output .= '<p>' . $row_handbook['text'] . '</p>';

        echo $output;
	}
}
else {
    echo 'Ошибка загрузки данных!';
}
?>
