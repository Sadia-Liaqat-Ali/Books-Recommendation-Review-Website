<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

// Count total users
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tblusers"))['total'];

// Count total books
$total_books = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tblbooks"))['total'];

// Count total reviews
$total_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tblreviews"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
      transition: all 0.2s;
    }
    .total-count {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 5px;
    }
  </style>
</head>
<body>

<?php include 'admin-header.php'; ?>

<div class="container mt-4">
  <h2 class="heading">Wellcome To Admin Dashboard!</h2>
  <!-- Add Book Button -->
  <div class="d-flex justify-content-end mb-3">
    <a href="add-book.php" class="btn btn-success">
      <i class="fas fa-plus me-1"></i> Add New Book
    </a>
  </div>

  <!-- Dashboard Cards -->
  <div class="row g-4">
    <!-- Users Card -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body text-center">
          <i class="fas fa-users fa-3x text-primary mb-3"></i>
          <div class="total-count text-primary"><?php echo $total_users; ?> Users</div>
          <h5 class="card-title">Manage Users</h5>
          <p class="card-text">View, edit or delete registered users.</p>
          <a href="manage-users.php" class="btn btn-outline-primary btn-lg ">Go to Users</a>
        </div>
      </div>
    </div>

    <!-- Books Card -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body text-center">
          <i class="fas fa-book fa-3x text-warning mb-3"></i>
          <div class="total-count text-warning"><?php echo $total_books; ?> Books</div>
          <h5 class="card-title">Manage Books</h5>
          <p class="card-text">Add, update or remove books from catalog.</p>
          <a href="manage-books.php" class="btn btn-outline-warning btn-lg">Go to Books</a>
        </div>
      </div>
    </div>

    <!-- Reviews Card -->
    <div class="col-md-4">
      <div class="card card-hover h-100">
        <div class="card-body text-center">
          <i class="fas fa-comments fa-3x text-success mb-3"></i>
          <div class="total-count text-success"><?php echo $total_reviews; ?> Reviews</div>
          <h5 class="card-title">Manage Reviews</h5>
          <p class="card-text">Approve, edit or delete book reviews.</p>
          <a href="manage_reviews.php" class="btn btn-outline-success btn-lg">Go to Reviews</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
