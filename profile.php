<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.html");
    exit();
}
?>


<head>
    <title>Профиль</title>
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script src="./scripts/profile.js"></script>
    <script src="./scripts/jquery.js"></script>
    <style>
        .td {
            font-size: 18pt;
            text-align: center;
        }
    </style>
</head>

<header>
    <a href="index.html">AviaCompany</a>
    <div class="header-text"><?php session_start();
                                echo $_SESSION['name']; ?></div>
    <div class="btn-container">
        <?php if ($_SESSION['is_admin'] == "1") echo "<a href=\"./admin-panel.php\" class=\"btn\">Admin panel</a>"; ?>
        <a href="./php/logout.php" class="btn">Выйти</a>
    </div>
</header>

<div class="wrapper">
    <section class="flights">
        <table id="flights-table">
            <?php
            require("./php/db.php");

            $sql = "SELECT t.id, f.from, f.destination, f.departure, f.arrival, p.model, p.img FROM tickets t
                    JOIN flights f ON f.id = t.flight_id LEFT JOIN planes p ON p.id = f.plane_id
                    WHERE t.user_id = {$_SESSION['user_id']} ORDER BY f.departure";

            $q = mysqli_query($conn, $sql);
            $row = $q->fetch_assoc();

            if (!$row) {
                echo "<tr><td class='td'>У вас еще нет билетов.</td></tr>";
            }
            while ($row) {
                echo ("<tr class=\"tr\" id='ticket{$row['id']}'>
                        <td>
                            <div class=\"plane-info\">
                                <img src=\"pics/{$row['img']}\" alt=\"No image\">
                                <p>{$row['model']}</p>
                            </div>
                        </td>
                        <td>
                            <div class=\"city-info\">
                                <h3>{$row['from']}</h3>
                                <p>{$row['departure']}</p>
                            </div>
                        </td>
                        <td><p>&#8658;</p></td>
                        <td>
                            <div class=\"city-info\">
                                <h3>{$row['destination']}</h3>
                                <p>{$row['arrival']}</p>
                            </div>
                        </td>
                        <td>
                            <button onclick=\"Sell({$row['id']})\" class=\"buy-btn\" style=\"background-color: lightcoral;\">Продать</button>
                        </td>
                    </tr><tr class=\"empty\"></tr>");
                $row = $q->fetch_assoc();
            }
            echo "<tr><td colspan='5' class='td'><a href=\"./index.html\">Поиск билетов</a></td></tr>";

            $conn->close();
            ?>
        </table>
    </section>
</div>