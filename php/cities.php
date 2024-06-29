<?php
require("db.php");

$data = array();
$data['from'] = mysqli_query($conn, "SELECT DISTINCT f.from FROM flights f")->fetch_all();
$data['to'] = mysqli_query($conn, "SELECT DISTINCT f.destination FROM flights f")->fetch_all();

echo json_encode($data);
$conn->close();
