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
            send($conn, array ("msg" =>"Заполните все поля!"));

        mysqli_query($conn, "INSERT INTO flights(`from`, destination, departure, arrival, plane_id) 
            VALUES ('{$_POST['from']}', '{$_POST['to']}', '{$_POST['dep']}', '{$_POST['arr']}', '{$_POST['plane']}')");

        $ans['from'] = $_POST['from'];
        $ans['to'] = $_POST['to'];
    } 
    else if ($_POST['table'] == "planes") {
        if ($_POST['model'] == '')
            send($conn, array ("msg" =>"Поле 'модель' должно быть заполнено!"));

        $img = $_POST['img'];
        if ($img == '') $img = 'default.webp';

        mysqli_query($conn, "INSERT INTO planes(model, img) VALUES ('{$_POST['model']}', '$img')");

        $ans['model'] = $_POST['model'];
    } 
    else if ($_POST['table'] == "users") {
        if ($_POST['is_admin'] == '' || $_POST['name'] == '' || $_POST['login'] == '' || $_POST['pswd'] == '')
            send($conn, array ("msg" =>"Заполните все поля!"));

        $p = md5($_POST['pswd']);
        mysqli_query($conn, "INSERT INTO users(`name`, `login`, `password`, is_admin) 
            VALUES ('{$_POST['name']}', '{$_POST['login']}', '$p', '{$_POST['is_admin']}')");

        $ans['user'] = $_POST['name'];
    }
    send($conn, $ans);
} 
catch (Throwable $th) {
    send($conn, array ("msg" =>"Произошла ошибка :("));
}
finally {
    $conn->close();
}
