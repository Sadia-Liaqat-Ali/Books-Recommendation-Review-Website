<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user-login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle add to wishlist
if (isset($_GET['book_id'])) {
    $book_id = (int)$_GET['book_id'];

    $check = mysqli_query($conn, "SELECT * FROM tblwishlist WHERE user_id=$user_id AND book_id=$book_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO tblwishlist (user_id, book_id) VALUES ($user_id, $book_id)");
    }
    header("Location: my-wishlist.php");
    exit;
}

// Handle remove from wishlist
if (isset($_GET['remove_id'])) {
    $remove_id = (int)$_GET['remove_id'];
    mysqli_query($conn, "DELETE FROM tblwishlist WHERE id=$remove_id AND user_id=$user_id");
    header("Location: my-wishlist.php");
    exit;
}

// Fetch wishlist items
$sql = "SELECT w.id AS wishlist_id, b.*
        FROM tblwishlist w
        JOIN tblbooks b ON w.book_id = b.id
        WHERE w.user_id = $user_id
        ORDER BY w.created_at DESC";
$wishlist = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Wishlist | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .book-img { width: 80px; height: 100px; object-fit: contain; background: #eee; padding: 5px; }
  </style>
</head>
<body>

<?php include 'user-header.php'; ?>

<div class="container mt-4">
  <h4 class="mb-4">📚 My Wishlist</h4>

  <?php if (mysqli_num_rows($wishlist) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Year</th>
            <th>ISBN</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($book = mysqli_fetch_assoc($wishlist)): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td>
                <?php if (!empty($book['cover_image']) && file_exists("../admin/uploads/{$book['cover_image']}")): ?>
                  <img src="../admin/uploads/<?php echo $book['cover_image']; ?>" class="book-img" alt="Cover">
                <?php else: ?>
                  <img src="default-cover.png" class="book-img" alt="No Cover">
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($book['title']); ?></td>
              <td><?php echo htmlspecialchars($book['author']); ?></td>
              <td><?php echo htmlspecialchars($book['genre']); ?></td>
              <td><?php echo htmlspecialchars($book['publication_year']); ?></td>
              <td><?php echo htmlspecialchars($book['isbn']); ?></td>
              <td>
                <a href="book-details.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-outline-primary">
                  View
                </a>
                <a href="my-wishlist.php?remove_id=<?php echo $book['wishlist_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this book from your wishlist?');">
                  <i class="fas fa-trash"></i> Remove
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">You have no books in your wishlist.</div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="book-catalog.php" class="btn btn-secondary">
      <i class="fas fa-arrow-left me-1"></i> Browse More Books
    </a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
