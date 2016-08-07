<?php
    require_once 'login.php';

    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

    if ($connection->connect_error) die($connection->connect_error);

    $connection->set_charset("utf8");
    setlocale(LC_ALL, 'ru_RU.utf-8', 'rus_RUS.utf-8', 'ru_RU.utf8');
?>