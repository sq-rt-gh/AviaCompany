<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_POST['flight_id'])) {
    require('./db.php');
    mysqli_query($conn, "INSERT INTO tickets(user_id, flight_id) VALUES({$_SESSION['user_id']}, {$_POST['flight_id']})");
    $conn->close();
}

header("Location: /profile.php");
exit();
?>