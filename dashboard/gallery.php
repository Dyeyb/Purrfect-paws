<?php
require_once '../conn.php';
$result = $conn->query("SELECT * FROM gallery ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Gallery Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    :root {
      --white-color: #fff;
      --dark-color: #252525;
      --primary-color: #A8E6CF;
      --secondary-color: #FFE29D;
      --light-pink-color: #faf4f5;
      --medium-gray-color: #ccc;
      --font-size-s: 0.9rem;
      --font-size-n: 1rem;
      --font-size-l: 1.5rem;
      --font-size-xl: 2rem;
      --font-weight-semi-bold: 600;
      --font-weight-bold: 700;
      --border-radius-s: 8px;
      --border-radius-circle: 50%;
      --site-max-width: 1300px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Montserrat", sans-serif;
    }

    body {
      background: var(--light-pink-color);
      display: flex;
    }

    /* Sidebar Styles */
    .sidebar {
      width: 260px;
      height: 100vh;
      background-color: var(--primary-color);
      padding: 30px 20px;
      position: fixed;
      left: 0;
      top: 0;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .sidebar .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar .logo img {
      width: 80px;
      height: 80px;
      border-radius: var(--border-radius-circle);
    }

    .menu {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .menu a {
      display: flex;
      align-items: center;
      padding: 10px 12px;
      text-decoration: none;
      color: var(--dark-color);
      border-radius: var(--border-radius-s);
      transition: background 0.3s, color 0.3s;
      font-weight: var(--font-weight-semi-bold);
    }

    .menu a i {
      margin-right: 10px;
      font-size: 20px;
    }

    .menu a:hover {
      background-color: var(--secondary-color);
      color: var(--dark-color);
    }

    .menu a.active {
      background-color: var(--secondary-color);
      color: var(--dark-color);
    }

    .menu a.active:hover {
      background-color: #fdd56c;
    }


    .menu hr {
      border: none;
      border-top: 1px solid var(--medium-gray-color);
      margin: 8px 0;
    }

    .submenu {
      margin-left: 30px;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .submenu a {
      font-size: var(--font-size-s);
    }

    /* Content Area */
    .content {
      margin-left: 260px;
      padding: 40px;
      flex-grow: 1;
      width: calc(100% - 260px);
    }

    h2 {
      font-size: var(--font-size-xl);
      color: var(--dark-color);
      margin-bottom: 25px;
    }

    .add-btn {
      background: var(--primary-color);
      padding: 10px 20px;
      border-radius: var(--border-radius-s);
      text-decoration: none;
      color: var(--dark-color);
      font-weight: var(--font-weight-semi-bold);
      display: inline-block;
      margin-bottom: 20px;
    }

    .add-btn:hover {
      background: var(--secondary-color);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: var(--white-color);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    th, td {
      padding: 14px 10px;
      border: 1px solid var(--medium-gray-color);
      text-align: center;
    }

    th {
      background: var(--primary-color);
      font-weight: var(--font-weight-bold);
      color: var(--dark-color);
    }

    img {
      width: 100px;
      height: auto;
      border-radius: var(--border-radius-s);
    }

    .actions a {
      padding: 6px 14px;
      font-size: var(--font-size-s);
      font-weight: var(--font-weight-semi-bold);
      text-decoration: none;
      margin: 0 5px;
      border-radius: var(--border-radius-s);
      display: inline-block;
    }

    .edit-btn {
      background-color: var(--secondary-color);
      color: var(--dark-color);
    }

    .edit-btn:hover {
      background-color: #fdd56c;
    }

    .delete-btn {
      background-color: #ff6b6b;
      color: var(--white-color);
    }

    .delete-btn:hover {
      background-color: #ff4949;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <img src="Logo.jpg" alt="Logo" />
    </div>
    <nav class="menu">
      <a href="#"><i class='bx bx-home'></i>Dashboard / Home</a>
      <hr>
      <a href="#"><i class='bx bx-folder'></i>Client History</a>
      <hr>
      <a href="#"><i class='bx bx-note'></i>Session Notes</a>
      <div class="submenu">
        <a href="#"><i class='bx bx-right-arrow-alt'></i> Add Notes (Logger)</a>
        <a href="#"><i class='bx bx-show-alt'></i> View Notes (Groomer)</a>
      </div>
      <hr>
      <a href="#"><i class='bx bx-wrench'></i>Assignment Tool</a>
      <hr>
      <a href="gallery.php" class="active"><i class='bx bx-camera'></i>Pet Gallery</a>
      <hr>
      <a href="#"><i class='bx bx-log-out'></i>Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="content">
    <h2>Gallery Dashboard</h2>
    <a href="gallery_add.php" class="add-btn">+ Add New Image</a>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Preview</th>
          <th>Filename</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><img src="gallery_images/<?php echo htmlspecialchars($row['image_path']); ?>" alt="Gallery Image"></td>
              <td><?php echo htmlspecialchars($row['image_path']); ?></td>
              <td class="actions">
                <a href="gallery_edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                <a href="gallery_delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this image?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="4">No images found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('deleted') === '1') {
      alert('🗑️ Image has been successfully deleted.');
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>

</body>
</html>
