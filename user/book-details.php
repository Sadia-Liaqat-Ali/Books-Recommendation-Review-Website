<?php
session_start();
include '../dbconnection.php';

// Validate book ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid book ID";
    exit;
}
$book_id = (int)$_GET['id'];

// Handle like or abuse action — only one allowed per user/review
if (isset($_POST['feedback_action'], $_POST['review_id'])) {
    $review_id = (int)$_POST['review_id'];
    $action = $_POST['feedback_action'] === 'abuse' ? 'abuse' : 'like';
    $ip = $_SERVER['REMOTE_ADDR'];

    $existing = mysqli_query($conn, "SELECT id FROM tblreview_feedback WHERE review_id=$review_id AND ip_address='$ip'");
    if (mysqli_num_rows($existing) > 0) {
        // Update previous feedback
        $row = mysqli_fetch_assoc($existing);
        mysqli_query($conn, "UPDATE tblreview_feedback SET action='$action', created_at=NOW() WHERE id={$row['id']}");
    } else {
        // Insert new feedback
        mysqli_query($conn, "INSERT INTO tblreview_feedback (review_id, action, ip_address) VALUES ($review_id, '$action', '$ip')");
    }

    header("Location: book-details.php?id=$book_id");
    exit;
}

// Fetch book info
$book_q = mysqli_query($conn, "SELECT * FROM tblbooks WHERE id=$book_id");
$book = mysqli_fetch_assoc($book_q);
if (!$book) {
    echo "Book not found";
    exit;
}

// Submit or update review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && isset($_POST['rating'], $_POST['comment'])) {
    $uid = $_SESSION['user_id'];
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $check = mysqli_query($conn, "SELECT id FROM tblreviews WHERE user_id=$uid AND book_id=$book_id");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE tblreviews SET rating=$rating, comment='$comment', updated_at=NOW() WHERE user_id=$uid AND book_id=$book_id");
    } else {
        mysqli_query($conn, "INSERT INTO tblreviews (user_id, book_id, rating, comment) VALUES ($uid, $book_id, $rating, '$comment')");
    }
    header("Location: book-details.php?id=$book_id");
    exit;
}

// Delete review
if (isset($_GET['delete_review']) && isset($_SESSION['user_id'])) {
    $rid = (int)$_GET['delete_review'];
    $uid = $_SESSION['user_id'];
    mysqli_query($conn, "DELETE FROM tblreviews WHERE id=$rid AND user_id=$uid");
    header("Location: book-details.php?id=$book_id");
    exit;
}

// Fetch reviews
$reviews = mysqli_query($conn, "
    SELECT r.*, u.name 
    FROM tblreviews r 
    JOIN tblusers u ON u.id = r.user_id 
    WHERE r.book_id = $book_id 
    ORDER BY r.created_at DESC
");

// Fetch current user's review
$user_review = null;
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $res = mysqli_query($conn, "SELECT * FROM tblreviews WHERE book_id=$book_id AND user_id=$uid");
    $user_review = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($book['title']); ?> | Book Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .book-img { width: 100%; max-height: 400px; object-fit: contain; border: 1px solid #ccc; background: #fff; }
    .star { color: gold; }
    .review-box { border: 1px solid #ddd; padding: 15px; background: #fff; border-radius: 6px; margin-bottom: 10px; }
  </style>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
  <?php include 'user-header.php'; ?>
<?php endif; ?>

<div class="container my-4">
  <div class="row">
    <!-- Cover Image -->
    <div class="col-md-4">
      <?php if (!empty($book['cover_image']) && file_exists("../admin/uploads/{$book['cover_image']}")): ?>
        <img src="../admin/uploads/<?php echo $book['cover_image']; ?>" class="book-img" alt="Cover">
      <?php else: ?>
        <img src="default-cover.png" class="book-img" alt="No Cover">
      <?php endif; ?>
    </div>

    <!-- Book Details -->
    <div class="col-md-8">
      <h2 class="text-primary"><?php echo htmlspecialchars($book['title']); ?></h2>
      <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
      <p><strong>Genre:</strong> <?php echo htmlspecialchars($book['genre']); ?></p>
      <p><strong>Published:</strong> <?php echo $book['publication_year']; ?></p>
      <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
      <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
    </div>
  </div>

  <div class="row mt-4">
    <!-- Review Form -->
    <div class="col-md-6">
      <h5><?php echo $user_review ? 'Update Your Review' : 'Write a Review'; ?></h5>
      <?php if (isset($_SESSION['user_id'])): ?>
      <form method="post">
        <div class="mb-2">
          <label>Rating (1–5):</label>
          <select name="rating" class="form-select" required>
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <option value="<?php echo $i; ?>" <?php echo ($user_review && $user_review['rating'] == $i) ? 'selected' : ''; ?>>
                <?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?>
              </option>
            <?php endfor; ?>
          </select>
        </div>
        <div class="mb-2">
          <label>Comment:</label>
          <textarea name="comment" class="form-control" required><?php echo $user_review ? htmlspecialchars($user_review['comment']) : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Save Review</button>
      </form>
      <?php else: ?>
        <p class="text-muted">Please login first to leave a review.</p><a class="btn btn-outline-danger w-50" href="../user-login.php">Login</a>
      <?php endif; ?>
    </div>

    <!-- All Reviews -->
    <div class="col-md-6">
      <h5>All Reviews</h5>
      <?php if (mysqli_num_rows($reviews) > 0): ?>
        <?php while ($r = mysqli_fetch_assoc($reviews)): ?>
          <div class="review-box">
            <strong><?php echo htmlspecialchars($r['name']); ?></strong>
            <div>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="fas fa-star <?php echo $i <= $r['rating'] ? 'star' : ''; ?>"></i>
              <?php endfor; ?>
            </div>
            <p class="mb-1"><?php echo nl2br(htmlspecialchars($r['comment'])); ?></p>
            <small class="text-muted"><?php echo date("d M Y", strtotime($r['created_at'])); ?></small>

            <?php
              $rid = $r['id'];
              $likes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM tblreview_feedback WHERE review_id=$rid AND action='like'"))['c'];
              $abuses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM tblreview_feedback WHERE review_id=$rid AND action='abuse'"))['c'];
            ?>

            <small class="text-muted d-block mt-1">
              👍 Likes: <?php echo $likes; ?> | ⚠️ Abuses: <?php echo $abuses; ?>
            </small>

            <form method="post" class="d-flex gap-2 mt-2">
              <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
              <button type="submit" name="feedback_action" value="like" class="btn btn-sm btn-success">👍 Like</button>
              <button type="submit" name="feedback_action" value="abuse" class="btn btn-sm btn-danger">⚠️ Abuse</button>
            </form>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $r['user_id']): ?>
              <div class="mt-2">
                <a href="?id=<?php echo $book_id; ?>&delete_review=<?php echo $r['id']; ?>" class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Delete your review?')">Delete</a>
              </div>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-muted">No reviews yet.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
