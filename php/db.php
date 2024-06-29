<?php
$conn = mysqli_connect('localhost', 'root', '', 'AviaCompany');
if ($conn->connect_error)
    die("Couldn't connect to the database: " . $conn->connect_error);
?>