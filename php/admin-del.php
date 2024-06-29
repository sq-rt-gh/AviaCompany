<?php
require("db.php");

function send($conn, $ans)
{
    echo json_encode($ans);
    $conn->close();
    exit();
}

try {
    $ans = array();
    $ans['msg'] = "ok";
    $ans['id'] = $_POST['id'];

    if ($_POST['table'] == "flights") {
        $old = mysqli_query($conn, "SELECT f.from, f.destination, f.departure, f.arrival, p.model FROM flights f 
            JOIN planes p ON p.id = f.plane_id WHERE f.id = '{$_POST['id']}'")->fetch_assoc();
        $ans['from'] = $old['from'];
        $ans['to'] = $old['destination'];
        $ans['dep'] = $old['departure'];
        $ans['arr'] = $old['arrival'];
        $ans['model'] = $old['model'];

        $q = mysqli_query($conn, "DELETE FROM `flights` WHERE id='{$_POST['id']}'");
    }
    else if ($_POST['table'] == "planes") {
        $old = mysqli_query($conn, "SELECT * FROM planes WHERE id = '{$_POST['id']}'")->fetch_assoc();
        $ans['model'] = $old['model'];
        $ans['img'] = $old['img'];

        $q = mysqli_query($conn, "DELETE FROM `planes` WHERE id='{$_POST['id']}'");
    }
    else if ($_POST['table'] == "users") {
        $old = mysqli_query($conn, "SELECT * FROM users WHERE id = '{$_POST['id']}'")->fetch_assoc();
        $ans['name'] = $old['name'];
        $ans['login'] = $old['login'];
        $ans['type'] = $old['is_admin'] == '1' ? "Admin" : "User";

        $q = mysqli_query($conn, "DELETE FROM `users` WHERE id='{$_POST['id']}'");
    }
    send($conn, $ans);
} 
catch (Throwable $th) {
    send($conn, array ("msg" =>"Произошла ошибка :("));
}
finally {
    $conn->close();
}    