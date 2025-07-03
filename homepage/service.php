<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PURRFECT PAWS | SERVICES</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Navbar Header -->
  <header>
    <nav class="navbar section-content">
      <a href="#" class="navbar-logo">
        <img src="Logo.jpg" alt="Logo" class="icon" />
      </a>
      <ul class="nav-menu">
        <li class="nav-item"><a href="main.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="main.php" class="nav-link">About</a></li>
        <li class="nav-item"><a href="main.php" class="nav-link active">Services</a></li>
        <li class="nav-item"><a href="main.php" class="nav-link">Gallery</a></li>
        <li class="nav-item"><a href="main.php" class="nav-link">Contact</a></li>
      </ul>
    </nav>
  </header>

  <h1>Our Grooming Packages</h1>

  <?php
  // Database connection
  $host = "localhost";
  $user = "root";
  $password = ""; // your password if any
  $dbname = "purrfect_paw";

  $conn = new mysqli($host, $user, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query to fetch packages and their features
  $sql = "SELECT 
              p.id, 
              p.name AS package_name, 
              p.price, 
              p.description,
              pf.feature_name
          FROM packages p
          LEFT JOIN package_feature_map pfm ON p.id = pfm.package_id
          LEFT JOIN package_features pf ON pfm.feature_id = pf.id
          WHERE p.is_active = 1
          ORDER BY p.id, pf.feature_name";

  $result = $conn->query($sql);

  // Organize results
  $packages = [];

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $pkg_id = $row['id'];
      if (!isset($packages[$pkg_id])) {
        $packages[$pkg_id] = [
          'name' => $row['package_name'],
          'price' => $row['price'],
          'description' => $row['description'],
          'features' => []
        ];
      }
      if ($row['feature_name']) {
        $packages[$pkg_id]['features'][] = $row['feature_name'];
      }
    }
  }
  ?>

  <!-- Grooming Packages Section -->
  <section class="page-content">
    <div class="page-header">
      <h2 class="page-title">Our Grooming Packages</h2>
      <p class="page-subtitle">Choose from a range of pampering packages for your furry friend</p>
    </div>

    <div class="packages-grid">
      <?php foreach ($packages as $pkg): ?>
        <div class="package-card">
          <div class="package-header">
            <h3 class="package-name"><?= htmlspecialchars($pkg['name']) ?></h3>
            <div class="package-price">₱<?= number_format($pkg['price'], 2) ?></div>
          </div>
          <ul class="package-features">
            <?php if (!empty($pkg['features'])): ?>
              <?php foreach ($pkg['features'] as $feat): ?>
                <li>✔ <?= htmlspecialchars($feat) ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>No features listed.</li>
            <?php endif; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Ala Carte Section -->
  <?php
  // Fetch ala carte services from package_features
  $ala_sql = "SELECT feature_name FROM package_features ORDER BY feature_name ASC";
  $ala_result = $conn->query($ala_sql);
  ?>

  <section class="page-content">
    <div class="page-header">
      <h2 class="page-title">Ala Carte Services</h2>
      <p class="page-subtitle">Choose individual services for customized care</p>
    </div>

    <div class="packages-grid">
      <?php if ($ala_result && $ala_result->num_rows > 0): ?>
        <?php while($row = $ala_result->fetch_assoc()): ?>
          <div class="package-card">
            <h3 class="package-name"><?= htmlspecialchars($row['feature_name']) ?></h3>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No ala carte services found.</p>
      <?php endif; ?>
    </div>
  </section>

  <?php $conn->close(); ?>

</body>
</html>
