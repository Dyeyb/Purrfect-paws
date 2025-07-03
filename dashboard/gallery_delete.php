<?php
require_once '../conn.php';

// Validate image ID from query string
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
  die("❌ No valid image ID provided.");
}

// Fetch image path for deletion
$stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("❌ Image not found.");
}

$row = $result->fetch_assoc();
$imagePath = "gallery_images/" . $row['image_path'];

// Attempt to delete the image file from the server
if (file_exists($imagePath)) {
  unlink($imagePath);
}

// Delete the image record from the database
$deleteStmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
$deleteStmt->bind_param("i", $id);
$deleteStmt->execute();

// Redirect to dashboard with a success flag
header("Location: gallery.php?deleted=1");
exit;
?>
