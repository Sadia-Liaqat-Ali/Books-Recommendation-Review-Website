<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user-login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get genre IDs selected by user (where book_id IS NULL)
$genre_ids = [];
$res = mysqli_query($conn, "SELECT genre_id FROM tblrecommendation WHERE user_id = $user_id AND book_id IS NULL");
while ($row = mysqli_fetch_assoc($res)) {
    $genre_ids[] = $row['genre_id'];
}

// Fetch notifications from tblnotification for selected genres
$notifications = [];
if (!empty($genre_ids)) {
    $genre_str = implode(',', $genre_ids);
    $notifications = mysqli_query($conn, "SELECT message, created_at FROM tblnotification WHERE genre_id IN ($genre_str) ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📢 Your Book Notifications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; }
    .notif-box {
      max-width: 800px;
      margin: auto;
      padding: 20px;
    }
    .notif-item {
      background: #fff;
      border-left: 5px solid #007bff;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .notif-time {
      font-size: 0.8rem;
      color: #888;
    }
  </style>
</head>
<body>

<?php include 'user-header.php'; ?>

<div class="container notif-box mt-4">
  <h4 class="mb-3">🎯 Book Recommendations Just for You</h4>

  <?php if (!empty($notifications) && mysqli_num_rows($notifications) > 0): ?>
    <?php while ($n = mysqli_fetch_assoc($notifications)): ?>
      <div class="notif-item">
        <div><?php echo $n['message']; ?></div>
        <div class="notif-time"><?php echo date('d M Y, h:i A', strtotime($n['created_at'])); ?></div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="alert alert-warning">No new notifications based on your selected genres.</div>
  <?php endif; ?>
</div>

</body>
</html>
