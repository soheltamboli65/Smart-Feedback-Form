<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username   = "root";    // default XAMPP username
$password   = "";        // default XAMPP password is empty
$dbname     = "feedback";  // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode([
    'success' => false,
    'error'   => "Connection failed: " . $conn->connect_error
  ]));
}
?>
