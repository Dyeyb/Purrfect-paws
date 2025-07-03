<?php
require_once '../conn.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
  $folder = "gallery_images/";
  $filename = basename($_FILES["image"]["name"]);
  $targetPath = $folder . $filename;

  $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
  $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

  if (!in_array($fileType, $allowedTypes)) {
    $error = "❌ Only JPG, JPEG, PNG, or GIF files are allowed.";
  } elseif (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
    $stmt = $conn->prepare("INSERT INTO gallery (image_path) VALUES (?)");
    $stmt->bind_param("s", $filename);
    $stmt->execute();
    header("Location: gallery.php");
    exit;
  } else {
    $error = "❌ Failed to upload the image.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add New Image</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }

    body {
      background-color: #faf4f5;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .form-wrapper {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .form-wrapper h2 {
      margin-bottom: 20px;
      color: #252525;
      font-weight: 700;
    }

    .upload-box {
      display: block;
      background-color: #A8E6CF;
      border: 2px dashed #ccc;
      color: #252525;
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .upload-box:hover {
      background-color: #91d7bd;
    }

    .upload-box input {
      display: none;
    }

    #preview-container {
      margin-bottom: 20px;
    }

    #imagePreview {
      max-width: 100%;
      max-height: 250px;
      border-radius: 12px;
      border: 2px solid #A8E6CF;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      display: none;
    }

    button {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      background-color: #FFE29D;
      color: #252525;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #fbd876;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #777;
      text-decoration: none;
      font-size: 14px;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      font-weight: 500;
    }

    @media (max-width: 480px) {
      .form-wrapper {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="form-wrapper">
    <h2>📷 Add New Image</h2>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="post" enctype="multipart/form-data">
      <label class="upload-box">
        Click to select image file
        <input type="file" name="image" id="imageInput" accept="image/*" required />
      </label>

      <div id="preview-container">
        <img id="imagePreview" src="" alt="Image Preview" />
      </div>

      <button type="submit">Upload Image</button>
    </form>

    <a href="gallery.php" class="back-link">← Back to Dashboard</a>
  </div>

  <script>
    const imageInput = document.getElementById("imageInput");
    const imagePreview = document.getElementById("imagePreview");

    imageInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function () {
          imagePreview.src = reader.result;
          imagePreview.style.display = "block";
        };
        reader.readAsDataURL(file);
      } else {
        imagePreview.src = "";
        imagePreview.style.display = "none";
      }
    });
  </script>
</body>
</html>
