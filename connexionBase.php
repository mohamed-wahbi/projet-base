<?php
function OpenBase() {
    $conn = mysqli_connect("localhost", "root", "WwW.wahbibreak2000", "projet");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
?>