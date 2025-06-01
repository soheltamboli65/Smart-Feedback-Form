<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'db_config.php';

// Collect and sanitize POST data
$name          = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
$email         = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$rating        = isset($_POST['rating']) ? (int) $_POST['rating'] : null;
$feedback_type = isset($_POST['feedback_type']) ? $conn->real_escape_string($_POST['feedback_type']) : '';
$product_used  = isset($_POST['product_used']) ? $conn->real_escape_string($_POST['product_used']) : '';
$visit_date    = isset($_POST['visit_date']) ? $conn->real_escape_string($_POST['visit_date']) : null;
$recommendation= isset($_POST['recommendation']) ? (int) $_POST['recommendation'] : null;
$message       = isset($_POST['message']) ? $conn->real_escape_string($_POST['message']) : '';
$comments      = isset($_POST['comments']) ? $conn->real_escape_string($_POST['comments']) : '';

// Basic validation for required fields
if (empty($name) || empty($message)) {
  echo json_encode([
    'success' => false,
    'error'   => 'Name and Feedback message are required.'
  ]);
  exit;
}

// Prepare SQL statement (assumes your table is named "feedback")
// Ensure that your table has columns:
// name, email, rating, feedback_type, product_used, visit_date,
// recommendation, message, comments and optionally created_at with a default timestamp
$sql = "INSERT INTO feedback (name, email, rating, feedback_type, product_used, visit_date, recommendation, message, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
  echo json_encode([
    'success' => false,
    'error'   => 'Prepare failed: ' . $conn->error
  ]);
  exit;
}

$stmt->bind_param("ssisssiss", $name, $email, $rating, $feedback_type, $product_used, $visit_date, $recommendation, $message, $comments);

if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Feedback submitted successfully!'
  ]);
} else {
  echo json_encode([
    'success' => false,
    'error'   => 'Error submitting feedback: ' . $stmt->error
  ]);
}

$stmt->close();
$conn->close();
?>
