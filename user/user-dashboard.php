<?php
session_start();
include '../dbconnection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: user-login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.2s;
    }
  </style>
</head>
<body>

  <?php include 'user-header.php'; ?>

  <div class="container mt-4">

    <h4 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h4>

    <!-- Dashboard Cards -->
    <div class="row g-4">
      <!-- Book Catalog -->
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body text-center">
            <i class="fas fa-book fa-3x text-primary mb-3"></i>
            <h5 class="card-title">Book Catalog</h5>
            <p class="card-text">Browse all books by genre, author, or title.</p>
            <a href="book-catalog.php" class="btn btn-outline-primary btn-sm">Explore Books</a>
          </div>
        </div>
      </div>

      <!-- My Reviews -->
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body text-center">
            <i class="fas fa-star fa-3x text-warning mb-3"></i>
            <h5 class="card-title">My Reviews</h5>
            <p class="card-text">View, edit or delete your book reviews.</p>
            <a href="my-reviews.php" class="btn btn-outline-warning btn-sm">Manage Reviews</a>
          </div>
        </div>
      </div>

      <!-- Wishlist -->
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body text-center">
            <i class="fas fa-heart fa-3x text-danger mb-3"></i>
            <h5 class="card-title">Wishlist</h5>
            <p class="card-text">Books you've saved for later.</p>
            <a href="wishlist.php" class="btn btn-outline-danger btn-sm">View Wishlist</a>
          </div>
        </div>
      </div>

      <!-- Recommendations -->
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body text-center">
            <i class="fas fa-magic fa-3x text-info mb-3"></i>
            <h5 class="card-title">Recommendations</h5>
            <p class="card-text">Books we think you'll love!</p>
            <a href="recommendations.php" class="btn btn-outline-info btn-sm">See Suggestions</a>
          </div>
        </div>
      </div>

      <!-- Edit Profile -->
      <div class="col-md-4">
        <div class="card card-hover h-100">
          <div class="card-body text-center">
            <i class="fas fa-user-edit fa-3x text-secondary mb-3"></i>
            <h5 class="card-title">Edit Profile</h5>
            <p class="card-text">Update your personal info and bio.</p>
            <a href="edit-profile.php" class="btn btn-outline-secondary btn-sm">Edit Profile</a>
          </div>
        </div>
      </div>

    
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
