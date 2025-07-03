<?php
require_once '../conn.php';

// Set content type to JSON
header('Content-Type: application/json');

// Pagination settings
$images_per_page = 6;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $images_per_page;

// Get total number of images
$total_result = $conn->query("SELECT COUNT(*) as total FROM gallery");
$total_row = $total_result->fetch_assoc();
$total_images = $total_row['total'];
$total_pages = ceil($total_images / $images_per_page);

// Get images for current page
$result = $conn->query("SELECT * FROM gallery ORDER BY uploaded_at DESC LIMIT $images_per_page OFFSET $offset");

// Build HTML for gallery items
$html = '';
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $html .= '<li class="gallery-item">';
        $html .= '<div class="gallery-image-container">';
        $html .= '<img src="gallery_images/' . htmlspecialchars($row['image_path']) . '" alt="Gallery Image" class="gallery-image" />';
        $html .= '</div>';
        $html .= '</li>';
    }
} else {
    $html = '<li class="gallery-item no-images"><p>No images found in the gallery.</p></li>';
}

// Build pagination HTML
$pagination_html = '';
if ($total_pages > 1) {
    if ($current_page > 1) {
        $pagination_html .= '<a href="javascript:void(0)" onclick="loadGalleryPage(' . ($current_page - 1) . ')" class="pagination-btn">&laquo;</a>';
    }

    for ($i = 1; $i <= $total_pages; $i++) {
        $active_class = ($i == $current_page) ? 'active' : '';
        $pagination_html .= '<a href="javascript:void(0)" onclick="loadGalleryPage(' . $i . ')" class="pagination-btn ' . $active_class . '">' . $i . '</a>';
    }

    if ($current_page < $total_pages) {
        $pagination_html .= '<a href="javascript:void(0)" onclick="loadGalleryPage(' . ($current_page + 1) . ')" class="pagination-btn">&raquo;</a>';
    }
}

// Return JSON
echo json_encode([
    'html' => $html,
    'pagination' => $pagination_html,
    'current_page' => $current_page,
    'total_pages' => $total_pages,
    'total_images' => $total_images
]);
