<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user-login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Static genres
$all_genres = [
    1 => 'Fiction',
    2 => 'Non-Fiction',
    3 => 'Mystery',
    4 => 'Science Fiction',
    5 => 'Fantasy',
    6 => 'Romance',
    7 => 'Biography',
    8 => 'Self-Help',
    9 => 'History',
    10 => 'Thriller'
];

// Save selected genres
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['genres'])) {
    mysqli_query($conn, "DELETE FROM tblrecommendation WHERE user_id=$user_id AND book_id IS NULL");

    foreach ($_POST['genres'] as $genre_id) {
        $genre_id = (int)$genre_id;
        if (array_key_exists($genre_id, $all_genres)) {
            mysqli_query($conn, "INSERT INTO tblrecommendation (user_id, genre_id) VALUES ($user_id, $genre_id)");
        }
    }

    echo "<script>alert('Genres saved!'); window.location='user-dashboard.php';</script>";
    exit;
}

// Get user's previously selected genres
$user_genres = [];
$res = mysqli_query($conn, "SELECT genre_id FROM tblrecommendation WHERE user_id=$user_id AND book_id IS NULL");
while ($r = mysqli_fetch_assoc($res)) {
    $user_genres[] = $r['genre_id'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Select Genres</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .selected-box {
        background: #fff;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }
  </style>
</head>
<body>
<?php include 'user-header.php'; ?>

<div class="container mt-4">
  <h4 class="mb-3">📚 Select Your Favorite Genres</h4>

  <div class="alert alert-info">
    <strong>Why select genres?</strong><br>
    This helps us recommend books that match your interests. Choose the genres you like to read — such as <em>Fiction</em> for stories, <em>Thriller</em> for suspense, or <em>Biography</em> to learn from real lives.
  </div>

  <form method="post">
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <?php foreach ($all_genres as $id => $name): ?>
            <div class="col-sm-6 col-md-4">
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="genres[]" value="<?php echo $id; ?>"
                  id="genre<?php echo $id; ?>" <?php echo in_array($id, $user_genres) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="genre<?php echo $id; ?>">
                  <?php echo htmlspecialchars($name); ?>
                </label>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary mt-3">💾 Save Preferences</button>
      </div>

      <div class="col-md-4">
        <div class="selected-box">
          <h6 class="mb-2">🎯 Your Selected Genres</h6>
          <ul class="list-group">
            <?php if (count($user_genres) > 0): ?>
              <?php foreach ($user_genres as $gid): ?>
                <li class="list-group-item"><?php echo htmlspecialchars($all_genres[$gid]); ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="list-group-item text-muted">No genres selected yet.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </form>
</div>

</body>
</html>
