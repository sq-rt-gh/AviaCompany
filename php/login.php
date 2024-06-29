<?php
require("db.php");

function send($conn, $msg)
{
    echo $msg;
    $conn->close();
    exit();
}

if ($_POST['isLogin'] == "true") {
    if ($_POST['login'] == '' || $_POST['pswd'] == '')
        send($conn, "Заполните все поля!");

    $row = mysqli_query($conn, "SELECT * FROM users WHERE `login`='{$_POST['login']}'")->fetch_assoc();

    if (!$row)
        send($conn, "Логин не существует");
    if ($row['password'] != md5($_POST['pswd']))
        send($conn, "Пароль неверный");

    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['is_admin'] = $row['is_admin'];
    send($conn, "ok");
}

if ($_POST['isLogin'] == "false") {
    if ($_POST['login'] == '' || $_POST['name'] == '' || $_POST['pswd'] == '' || $_POST['pswd2'] == '')
        send($conn, "Заполните все поля!");

    if ($_POST['pswd'] != $_POST['pswd2'])
        send($conn, "Пароли не совпадают!");

    if (mysqli_query($conn, "SELECT * FROM users WHERE login='{$_POST['login']}'")->fetch_assoc())
        send($conn, "Такой логин уже используется!");

    $p = md5($_POST['pswd']);
    if (mysqli_query($conn, "INSERT INTO users(name,login,password) VALUES('{$_POST['name']}', '{$_POST['login']}', '{$p}');")) {
        $row = mysqli_query($conn, "SELECT * FROM users WHERE `login`='{$_POST['login']}'")->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['is_admin'] = $row['is_admin'];
        send($conn, "ok");
    }
    send($conn, "Произошла ошибка :(");
}
