<?php 
require_once '../conn.php'; 

// Pagination settings
$images_per_page = 6; // Number of images per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $images_per_page;

// Get total number of images
$total_result = $conn->query("SELECT COUNT(*) as total FROM gallery");
$total_row = $total_result->fetch_assoc();
$total_images = $total_row['total'];
$total_pages = ceil($total_images / $images_per_page);

// Get images for current page
$result = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC LIMIT $images_per_page OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Purrfect Paws</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
  <!-- Navbar Header -->
  <header>
    <nav class="navbar section-content">
      <a href="#" class="navbar-logo">
        <img src="Logo.jpg" alt="Logo" class="icon" />
      </a>
      <ul class="nav-menu">
        <li class="nav-item"><a href="#home" class="nav-link active">Home</a></li>
        <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
        <li class="nav-item"><a href="#service" class="nav-link">Services</a></li>
        <li class="nav-item"><a href="#gallery" class="nav-link">Gallery</a></li>
        <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <main>
    <section class="hero-section" id="home">
      <div class="section-content">
        <div class="hero-details">
          <h2 class="title">PURRFECT PAWS</h2>
          <h3 class="subtitle">Best Grooming in the Town of Caniogan</h3>
          <p class="description">From Paw-scheduling to Tail-wagging — We’ve Got It Covered.</p>
          <div class="buttons">
            <a href="loginform.php" class="button book-now">Book Now</a>
            <a href="#contact" class="button contact-us">Contact Us</a>
          </div>
        </div>
        <div class="hero-image-wrapper">
          <img src="pawpatrol-removebg-preview.png" alt="Hero" class="image-hero" />
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="about">
      <div class="section-content">
        <div class="about-image-wrapper">
          <img src="about.jpg" alt="About" class="about-image" />
        </div>
        <div class="about-details">
          <h2 class="section-title">About Us</h2>
          <p class="text">
            Purrfect Paws is a pet grooming shop committed to providing quality, gentle, and professional grooming services for pets of all shapes and sizes. We believe that every pet deserves to feel clean, happy, and loved — and every pet owner deserves a hassle-free booking experience.
          </p>
          <div class="social-link-list">
            <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
<section class="service-section" id="service">
  <h2 class="section-title">Our Services</h2>
  <div class="section-content">
    <ul class="service-list">

      <li class="service-item">
        <a href="loginform.html" class="service-link">
          <img src="fullgroom.png" alt="Full Grooming" class="service-image" />
          <h3 class="name">FULL GROOMING</h3>
          <p class="text">
            Our Full Grooming package includes a warm bath, blow dry, nail trim, tooth brushing, ear cleaning, and a stylish haircut — everything your pet needs to look and feel their best.
          </p>
        </a>
      </li>

      <li class="service-item">
        <a href="loginform.html" class="service-link">
          <img src="bathdry.png" alt="Spa Bath" class="service-image" />
          <h3 class="name">SPA BATH</h3>
          <p class="text">
            Pamper your pet with our luxurious Spa Bath, which features a nano bubble bath, gentle massage, blow dry, nail trim, tooth brushing, and ear cleaning. This package also includes a stylish haircut, odor eliminator, and paw moisturizer for a complete spa experience.
          </p>
        </a>
      </li>

      <li class="service-item">
        <a href="loginform.html" class="service-link">
          <img src="bnd.png" alt="Bath and Dry" class="service-image" />
          <h3 class="name">BATH AND DRY</h3>
          <p class="text">
            A quick and refreshing service that includes a full bath and gentle blow dry — ideal for keeping your pet clean between full grooming sessions.
          </p>
        </a>
      </li>

    </ul>
  </div>
</section>


    <!-- Gallery Section with Pagination -->
<section class="gallery-section" id="gallery">
  <h2 class="section-title">Gallery</h2>
  <div class="section-content">
    
    <!-- Gallery Container with Pagination Controls -->
    <div class="gallery-container">
      <!-- Gallery Grid -->
      <div class="gallery-grid">
        <ul class="gallery-list" id="gallery-list">
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <li class="gallery-item">
                <div class="gallery-image-container">
                  <img src="gallery_images/<?php echo htmlspecialchars($row['image_path']); ?>" 
                       alt="Gallery Image" 
                       class="gallery-image" />
                </div>
              </li>
            <?php endwhile; ?>
          <?php else: ?>
            <li class="gallery-item no-images">
              <p>No images found in the gallery.</p>
            </li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Numbered Pagination -->
      <div class="gallery-pagination">
        <?php if ($current_page > 1): ?>
          <a href="javascript:void(0)" onclick="loadGalleryPage(<?php echo $current_page - 1; ?>)" class="pagination-btn">&laquo;</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="javascript:void(0)"
             onclick="loadGalleryPage(<?php echo $i; ?>)"
             class="pagination-btn <?php echo $i == $current_page ? 'active' : ''; ?>">
             <?php echo $i; ?>
          </a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
          <a href="javascript:void(0)" onclick="loadGalleryPage(<?php echo $current_page + 1; ?>)" class="pagination-btn">&raquo;</a>
        <?php endif; ?>
      </div>

    </div>


  </div>
</section>


    <!-- Contact Us Section -->
    <section class="contact-section" id="contact">
      <h2 class="section-title">Contact Us</h2>
      <div class="section-content">
        <ul class="contact-info-list">
          <li class="contact-info"><i class="fa-solid fa-location-crosshairs"></i><p>324 DR. SIXTO ANTONIO AVENUE., CANIOGAN, PASIG CITY</p></li>
          <li class="contact-info"><i class="fa-regular fa-envelope"></i><p>purrfectpaws@gmail.com</p></li>
          <li class="contact-info"><i class="fa-solid fa-phone"></i><p>CP num</p></li>
          <li class="contact-info"><i class="fa-solid fa-clock"></i><p>9AM - 8PM ONLY</p></li>
          <li class="contact-info"><i class="fa-solid fa-calendar-check"></i><p>MONDAY TO SUNDAY</p></li>
          <li class="contact-info"><i class="fa-solid fa-globe"></i><p>Purrfect Paws</p></li>
        </ul>
        <form action="loginform.php" class="contact-form">
          <input type="text" placeholder="Your Name" class="form-input" required />
          <input type="email" placeholder="Email" class="form-input" required />
          <textarea placeholder="Your Message" class="form-input" required></textarea>
          <button type="submit" class="submit-button">Submit</button>
        </form>
      </div>
    </section>
  </main>

  <script>
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".nav-link");

  // Highlight nav link based on scroll
  window.addEventListener("scroll", () => {
    let scrollY = window.pageYOffset + 130;

    sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.offsetHeight;
      const sectionId = section.getAttribute("id");

      if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
        navLinks.forEach((link) => {
          link.classList.remove("active");
          if (link.getAttribute("href") === `#${sectionId}`) {
            link.classList.add("active");
          }
        });
      }
    });
  });

  // Load gallery page with smooth fade transition
  function loadGalleryPage(page) {
    const galleryList = document.getElementById('gallery-list');
    galleryList.classList.add('fade-out');

    setTimeout(() => {
      fetch(`gallery_load.php?page=${page}`)
        .then(response => response.json())
        .then(data => {
          // Update gallery content
          galleryList.innerHTML = data.html;

          // Update pagination controls
          document.querySelector('.gallery-pagination').innerHTML = data.pagination;

          // Update page info if exists
          const pageInfo = document.querySelector('.gallery-page-info');
          if (pageInfo) {
            pageInfo.innerHTML = `
              <span>Page ${data.current_page} of ${data.total_pages}</span>
              <span>(${data.total_images} total images)</span>
            `;
          }

          galleryList.classList.remove('fade-out');
        })
        .catch(error => {
          console.error('Error loading gallery page:', error);
        });
    }, 300); // Match this with CSS transition duration
  }

  // (Optional) Update next/prev arrows if you're using them
  function updateArrows(currentPage, totalPages) {
    const leftArrow = document.querySelector('.gallery-arrow-left');
    const rightArrow = document.querySelector('.gallery-arrow-right');

    if (leftArrow) {
      if (currentPage > 1) {
        leftArrow.onclick = () => loadGalleryPage(currentPage - 1);
        leftArrow.classList.remove('disabled');
      } else {
        leftArrow.onclick = null;
        leftArrow.classList.add('disabled');
      }
    }

    if (rightArrow) {
      if (currentPage < totalPages) {
        rightArrow.onclick = () => loadGalleryPage(currentPage + 1);
        rightArrow.classList.remove('disabled');
      } else {
        rightArrow.onclick = null;
        rightArrow.classList.add('disabled');
      }
    }
  }
</script>
</body>
</html>
