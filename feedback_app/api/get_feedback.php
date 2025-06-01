<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'db_config.php';

// Retrieve all feedback, sorted by created_at if available, or by id descending if not.
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);

$feedbacks = [];

if ($result) {
  while ($row = $result->fetch_assoc()) {
    $feedbacks[] = $row;
  }
  echo json_encode($feedbacks);
} else {
  echo json_encode([
    'success' => false,
    'error'   => 'Error retrieving feedback: ' . $conn->error
  ]);
}

$conn->close();
?>
