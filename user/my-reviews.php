<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT r.*, b.title FROM tblreviews r 
        JOIN tblbooks b ON r.book_id = b.id 
        WHERE r.user_id = $user_id ORDER BY r.created_at DESC";

$reviews = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Reviews | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif;  }
    .review-card {
      background: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.05);
    }
    .rating {
      color: #f39c12;
    }
  </style>
</head>
<body>

<?php include 'user-header.php'; ?>
<br><br>
<div class="container">
  <h4 class="mb-4">My Reviews</h4>

  <?php if (mysqli_num_rows($reviews) > 0): ?>
    <?php while ($r = mysqli_fetch_assoc($reviews)): ?>
      <div class="review-card">
        <h5><?php echo htmlspecialchars($r['title']); ?> (Rated: <span class="rating"><?php echo str_repeat('★', $r['rating']); ?></span>)</h5>
        <p class="mb-1"><?php echo nl2br(htmlspecialchars($r['comment'])); ?></p>
        <div class="text-end">
          <a href="share.php?review_id=<?php echo $r['id']; ?>" class="btn btn-sm btn-outline-danger me-2">
            <i class="fas fa-share-alt me-1"></i> Share
          </a>
          <a href="?delete_id=<?php echo $r['id']; ?>" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Delete this review?');">
            <i class="fas fa-trash"></i> Delete
          </a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-info">You have not posted any reviews yet.</div>
  <?php endif; ?>
</div>

<?php
// DELETE review if requested
if (isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM tblreviews WHERE id = $del_id AND user_id = $user_id");
    echo "<script>alert('Review deleted.'); window.location='my-reviews.php';</script>";
    exit;
}
?>

</body>
</html>
