<?php
require("db.php");
$sql="";
if ($_GET['date'] != "")
    $sql = "AND DATE(f.departure)='{$_GET['date']}'";

$sql="SELECT f.id, f.from, f.destination, f.departure, f.arrival, p.model, p.img FROM flights f JOIN planes p ON p.id = f.plane_id 
        WHERE f.from LIKE '%{$_GET['from']}%' AND f.destination LIKE '%{$_GET['to']}%' $sql ORDER BY f.departure";

$q = mysqli_query($conn, $sql);
$data = array();
while ($row = $q->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();
