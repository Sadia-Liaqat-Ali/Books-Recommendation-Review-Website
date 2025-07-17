<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit;
}

// DELETE review
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM tblreviews WHERE id=$delete_id");
    echo "<script>alert('Review deleted.'); window.location='manage_reviews.php';</script>";
    exit;
}

// Fetch all reviews with user, book and feedback counts
$sql = "
    SELECT r.id, r.rating, r.comment, r.created_at,
           u.name AS user_name, b.title AS book_title,
           (SELECT COUNT(*) FROM tblreview_feedback WHERE review_id = r.id AND action = 'like') AS likes,
           (SELECT COUNT(*) FROM tblreview_feedback WHERE review_id = r.id AND action = 'abuse') AS abuses
    FROM tblreviews r
    JOIN tblusers u ON r.user_id = u.id
    JOIN tblbooks b ON r.book_id = b.id
    ORDER BY r.created_at DESC
";

$reviews = mysqli_query($conn, $sql);
if (!$reviews) {
    die("Error fetching reviews: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Reviews | BookRecSys Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .table th, .table td { vertical-align: middle; }
  </style>
</head>
<body>

<?php include 'admin-header.php'; ?>
<br><br>
<div class="container">
  <h4 class="mb-4">Manage User Reviews</h4>

  <?php if (mysqli_num_rows($reviews) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Book</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Likes</th>
            <th>Abuses</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($reviews)): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo htmlspecialchars($row['user_name']); ?></td>
              <td><?php echo htmlspecialchars($row['book_title']); ?></td>
              <td class="text-danger"><?php echo $row['rating']; ?> ★</td>
              <td><?php echo nl2br(htmlspecialchars($row['comment'])); ?></td>
              <td class="text-success"><?php echo $row['likes']; ?> 👍</td>
              <td class="text-danger"><?php echo $row['abuses']; ?> ⚠️</td>
              <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
              <td>
                <a href="?delete_id=<?php echo $row['id']; ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Delete this review?');">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No reviews found.</div>
  <?php endif; ?>
</div>

</body>
</html>
