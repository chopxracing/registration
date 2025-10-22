<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "regusers";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed". $conn->connect_error);
} else {
    "Успех";
}
?>