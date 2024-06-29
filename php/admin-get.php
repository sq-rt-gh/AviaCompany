<?php
if (isset($_GET['table'])) {
    require("db.php");
    $data = array();
    $data['table'] = $_GET['table'];
}
else {
    echo "error";
    exit();
}

if ($_GET['table'] == "flights") {
    $data['planes'] = mysqli_query($conn, "SELECT * FROM planes")->fetch_all(MYSQLI_ASSOC);
    $data['flights'] = mysqli_query($conn, "SELECT * FROM flights ORDER BY `from`")->fetch_all(MYSQLI_ASSOC);
}
else if ($_GET['table'] == "planes") {
    $data['planes'] = mysqli_query($conn, "SELECT * FROM planes  ORDER BY model")->fetch_all(MYSQLI_ASSOC);
}
else if ($_GET['table'] == "users") {
    $data['users'] = mysqli_query($conn, "SELECT * FROM users ORDER BY `name`")->fetch_all(MYSQLI_ASSOC);
}

echo json_encode($data);
$conn->close();