<!-- admin-header.php -->
<?php
// Call this at top of every admin page (after session_start & auth-check)
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
    <a class="navbar-brand" href="admin-dashboard.php">
      <i class="fas fa-book-reader me-2"></i>BookRecSystem Admin
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse w-100" id="adminNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="admin-dashboard.php"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage-users.php"><i class="fas fa-users me-1"></i>Manage Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add-book.php"><i class="fas fa-plus me-1"></i>Add Book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage-books.php"><i class="fas fa-book me-1"></i>Manage Books</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="manage_reviews.php"><i class="fas fa-comments me-1"></i>Manage Reviews</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item text-white me-3">
          <i class="fas fa-user-circle me-1"></i>
          <?php echo htmlspecialchars($_SESSION['admin_email']); ?>
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
