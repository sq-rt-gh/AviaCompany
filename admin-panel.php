<?php
session_start();
if ($_SESSION['is_admin'] != "1") {
    header("Location: ./login.html");
    exit();
}
?>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/admin-panel.css">
    <script src="./scripts/admin-panel.js"></script>
    <script src="./scripts/jquery.js"></script>
</head>

<header>
    <a href="index.html">AviaCompany</a>
    <div class="header-text">Панель администратора</div>
    <div class="btn-container">
        <a href="profile.php" class="btn">Профиль</a>
    </div>
</header>

<div id="toast"></div>
<div class="wrapper">
    <div class="choose">
        Choose table:
        <select id="select" onchange="GetData()">
            <option value="flights">flights</option>
            <option value="planes">planes</option>
            <option value="users">users</option>
        </select>
    </div>
    <div class="container">
        <table id="table">
            
        </table>
    </div>
</div>