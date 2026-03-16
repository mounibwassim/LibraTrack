<?php
$host = "sql101.infinityfree.com";
$user = "if0_41399543";
$password = "08082005Setif";
$dbname = "if0_41399543_libratrack";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>