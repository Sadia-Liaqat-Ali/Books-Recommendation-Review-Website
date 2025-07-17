<?php
session_start();
include '../dbconnection.php';

$search = '';
if (isset($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']);
    $sql = "SELECT * FROM tblbooks 
            WHERE title LIKE '%$search%' 
               OR author LIKE '%$search%' 
               OR genre LIKE '%$search%' 
            ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM tblbooks ORDER BY created_at DESC";
}
$books = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Catalog | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .search-bar { max-width: 1200px;  margin: 30px auto; }
    .book-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.08);
      overflow: hidden;
      transition: 0.2s;
      background: #fff;
      position: relative;
    }
    .book-card:hover { transform: translateY(-4px); }

    .book-cover {
      height: 250px;
      width: 100%;
      object-fit: contain;
      background-color: #f0f0f0;
      padding: 10px;
    }

    .share-text {
      position: absolute;
      top: 8px;
      right: 12px;
      font-size: 0.9rem;
      padding: 4px 8px;
      border-radius: 12px;
      color: red;
      font-weight: 600;
    }

    .card-body { padding: 1rem; }
    .book-title { font-size: 1.25rem; font-weight: 600; margin-bottom: .25rem; }
    .book-meta span {
      display: block;
      font-size: 0.9rem;
      margin-bottom: 4px;
      color: #555;
    }
    .book-description {
      font-size: 0.9rem;
      color: #444;
      margin-top: .5rem;
      height: 60px;
      overflow: hidden;
    }
  </style>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
  <?php include 'user-header.php'; ?>
<?php endif; ?>

<div class="container">
  <!-- Search Bar -->
  <form class="search-bar" method="get">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search by title, author, or genre..." 
             value="<?php echo htmlspecialchars($search); ?>">
      <button class="btn btn-primary" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </form>

  <!-- Book Cards -->
  <div class="row g-4">
    <?php if (mysqli_num_rows($books) > 0): ?>
      <?php while ($book = mysqli_fetch_assoc($books)): ?>
        <div class="col-md-4">
          <div class="book-card">
            <!-- Share Text -->
            <a href="share.php?book_id=<?php echo $book['id']; ?>" class="share-text">
              <i class="fas fa-share-alt me-1"></i> Share
            </a>

            <!-- Book Cover -->
            <?php if (!empty($book['cover_image']) && file_exists("../admin/uploads/{$book['cover_image']}")): ?>
              <img src="../admin/uploads/<?php echo $book['cover_image']; ?>" class="book-cover" alt="Cover">
            <?php else: ?>
              <img src="default-cover.png" class="book-cover" alt="No Cover">
            <?php endif; ?>

            <!-- Book Info -->
            <div class="card-body">
              <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
              <div class="book-meta">
                <span><i class="fas fa-user me-1"></i>Author: <?php echo htmlspecialchars($book['author']); ?></span>
                <span><i class="fas fa-tag me-1"></i>Genre: <?php echo htmlspecialchars($book['genre']); ?></span>
                <span><i class="fas fa-calendar me-1"></i>Year: <?php echo htmlspecialchars($book['publication_year']); ?></span>
                <span><i class="fas fa-barcode me-1"></i>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></span>
              </div>
              <div class="book-description">
                <?php echo nl2br(htmlspecialchars(substr($book['description'], 0, 120))) . '...'; ?>
              </div>

              <!-- Buttons -->
              <div class="d-flex gap-2 mt-2">
                <a href="book-details.php?id=<?php echo $book['id']; ?>" class="btn btn-outline-primary w-50">
                  View Details
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="my-wishlist.php?book_id=<?php echo $book['id']; ?>" class="btn btn-outline-success w-50">
                  <i class="fas fa-heart me-1"></i> Add to Wishlist
                </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="text-center text-muted">No books found.</div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
