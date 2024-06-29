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

    if ($_POST['table'] == "flights") {
        if ($_POST['from'] == '' || $_POST['to'] == '' || $_POST['dep'] == '' || $_POST['arr'] == '' || $_POST['plane'] == '')
            send($conn, array("msg" => "Заполните все поля!"));

        $old = mysqli_query($conn, "SELECT f.from, f.destination, f.departure, f.arrival, p.model FROM flights f 
            JOIN planes p ON p.id = f.plane_id WHERE f.id = '{$_POST['id']}'")->fetch_assoc();
        $ans['from'] = $old['from'];
        $ans['to'] = $old['destination'];
        $ans['dep'] = $old['departure'];
        $ans['arr'] = $old['arrival'];
        $ans['model'] = $old['model'];

        $q = mysqli_query($conn, "UPDATE `flights` SET `from`='{$_POST['from']}',`destination`='{$_POST['to']}',
            `departure`='{$_POST['dep']}',`arrival`='{$_POST['arr']}',`plane_id`='{$_POST['plane']}' WHERE id='{$_POST['id']}'");
    } 
    else if ($_POST['table'] == "planes") {
        if ($_POST['model'] == '')
            send($conn, array("msg" => "Поле модель должно быть заполнено!"));
        $img = $_POST['img'];
        if ($img == '')
            $img = 'default.webp';

        $old = mysqli_query($conn, "SELECT * FROM planes WHERE id = '{$_POST['id']}'")->fetch_assoc();
        $ans['model'] = $old['model'];
        $ans['img'] = $old['img'];

        $q = mysqli_query($conn, "UPDATE `planes` SET `model`='{$_POST['model']}',`img`='$img' WHERE id='{$_POST['id']}'");
    } 
    else if ($_POST['table'] == "users") {
        if ($_POST['is_admin'] == '' || $_POST['name'] == '' || $_POST['login'] == '')
            send($conn, array("msg" => "Заполните все поля!"));


        $old = mysqli_query($conn, "SELECT * FROM users WHERE id = '{$_POST['id']}'")->fetch_assoc();
        $ans['name'] = $old['name'];
        $ans['login'] = $old['login'];
        $ans['type'] = $old['is_admin'] == '1' ? "Admin" : "User";

        $q = mysqli_query($conn, "UPDATE `users` SET `name`='{$_POST['name']}',`login`='{$_POST['login']}',
            `is_admin`='{$_POST['is_admin']}' WHERE id='{$_POST['id']}'");
    }
    send($conn, $ans);
} 
catch (Throwable $th) {
    send($conn, array("msg" => "Произошла ошибка :("));
} 
finally {
    $conn->close();
}
