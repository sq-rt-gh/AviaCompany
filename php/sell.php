<?php
require('./db.php');
if (isset($_POST['id']) && mysqli_query($conn, "DELETE FROM tickets WHERE id = {$_POST['id']}")) {
    echo "ok";
}
else echo "Произошла ошибка :(";

$conn->close();
