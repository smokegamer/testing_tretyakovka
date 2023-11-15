<?php

$servername = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'testing_tretyakovka';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Дополнительная проверка наличия соединения
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
