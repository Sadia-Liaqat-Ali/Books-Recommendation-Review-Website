<!-- user-header.php -->
<?php
// Call this at top of every user page (after session_start & auth-check)
?>

<style>
  .navbar-dark .navbar-nav .nav-link {
    position: relative;
    color: #ccc;
    transition: background 0.3s, color 0.3s, padding 0.3s;
    border-radius: 30px;
    padding: 8px 16px;
  }

  .navbar-dark .navbar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff;
  }

  .navbar-dark .navbar-nav .nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Brand / Project Name -->
    <a class="navbar-brand" href="user-dashboard.php" style="padding-left: 30px;">
      <i class="fas fa-book-open-reader me-2"></i>BookRecSystem User
    </a>

    <!-- Mobile Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible Content -->
    <div class="collapse navbar-collapse w-100" id="userNav">
      <!-- Centered Nav Links -->
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="user-dashboard.php"><i class="fas fa-home me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="book-catalog.php"><i class="fas fa-book me-1"></i>Book Catalog</a></li>
        <li class="nav-item"><a class="nav-link" href="my-wishlist.php"><i class="fas fa-heart me-1"></i>Wishlist</a></li>
        <li class="nav-item"><a class="nav-link" href="select-genres.php"><i class="fas fa-magic me-1"></i>My Favourite</a></li>
        <li class="nav-item"><a class="nav-link" href="recommendations.php"><i class="fas fa-magic me-1"></i>Recommendations</a></li>
        <li class="nav-item"><a class="nav-link" href="my-reviews.php"><i class="fas fa-comment-dots me-1"></i>My Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="edit-profile.php"><i class="fas fa-user-edit me-1"></i>Edit Profile</a></li>
      </ul>

      <!-- User Info & Logout Far Right -->
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item text-white me-3">
          <i class="fas fa-user-circle me-1"></i>
          <?php echo htmlspecialchars($_SESSION['user_email']); ?>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-light btn-sm" href="../logout.php">
            <i class="fas fa-sign-out-alt me-1"></i>Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
