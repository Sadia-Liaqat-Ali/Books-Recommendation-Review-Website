<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// DELETE book
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM tblbooks WHERE id=$id");
    echo "<script>alert('Book deleted successfully!'); window.location='manage-books.php';</script>";
    exit;
}

// UPDATE book
if (isset($_POST['update'])) {
    $id          = (int)$_POST['id'];
    $title       = $_POST['title'];
    $author      = $_POST['author'];
    $genre       = $_POST['genre'];
    $year        = $_POST['year'];
    $isbn        = $_POST['isbn'];
    $description = $_POST['description'];

    // upload cover image
    if (!empty($_FILES['cover']['name']) && $_FILES['cover']['error'] === 0) {
        $tmp = $_FILES['cover']['tmp_name'];
        $name = time() . '_' . basename($_FILES['cover']['name']);
        move_uploaded_file($tmp, 'uploads/' . $name);
        mysqli_query($conn, "UPDATE tblbooks SET cover_image='$name' WHERE id=$id");
    }

    $sql = "UPDATE tblbooks SET title='$title', author='$author', genre='$genre', publication_year='$year', isbn='$isbn', description='$description' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo "<script>alert('Book updated.'); window.location='manage-books.php';</script>";
    exit;
}

// FETCH for edit
$editing = false;
if (isset($_GET['id'])) {
    $editing = true;
    $id = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM tblbooks WHERE id=$id");
    $book = mysqli_fetch_assoc($res);
}

$all = mysqli_query($conn, "SELECT * FROM tblbooks ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Books | Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .form-box, .table-box {
      background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 6px;
    }
    .action-icon { margin-right: 8px; }
  </style>
</head>
<body>

<?php include 'admin-header.php'; ?>
<br><br>

<div class="container">
  <h4 class="mb-4">Manage Books</h4>

  <?php if ($editing): ?>
  <div class="form-box mb-4">
    <h5>Edit Book #<?php echo $book['id']; ?></h5>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $book['id']; ?>">

      <div class="mb-2">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($book['title']); ?>" required>
      </div>

      <div class="mb-2">
        <label>Author</label>
        <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($book['author']); ?>" required>
      </div>

      <div class="mb-2">
        <label>Genre</label>
        <select name="genre" class="form-select" required>
          <?php
          $opts = ['Fiction','Non-Fiction','Mystery','Science Fiction','Fantasy','Romance','Biography','Self-Help','History','Thriller'];
          foreach($opts as $o) {
              $sel = $book['genre'] == $o ? 'selected' : '';
              echo "<option $sel>$o</option>";
          }
          ?>
        </select>
      </div>

      <div class="mb-2">
        <label>Publication Year</label>
        <input type="number" name="year" class="form-control" value="<?php echo $book['publication_year']; ?>">
      </div>

      <div class="mb-2">
        <label>ISBN</label>
        <input type="text" name="isbn" class="form-control" value="<?php echo htmlspecialchars($book['isbn']); ?>">
      </div>

      <div class="mb-2">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($book['description']); ?></textarea>
      </div>

      <div class="mb-2">
        <label>Cover Image (Leave blank to keep current)</label>
        <input type="file" name="cover" class="form-control">
      </div>

      <button type="submit" name="update" class="btn btn-warning">Update Book</button>
      <a href="manage-books.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
  <?php endif; ?>

  <div class="table-box mb-5">
    <h5>All Books</h5>
    <table class="table table-bordered align-middle table-striped">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Author</th>
          <th>Genre</th>
          <th>Year</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; while ($b = mysqli_fetch_assoc($all)): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo htmlspecialchars($b['title']); ?></td>
          <td><?php echo htmlspecialchars($b['author']); ?></td>
          <td><?php echo htmlspecialchars($b['genre']); ?></td>
          <td><?php echo $b['publication_year']; ?></td>
          <td>
            <a href="?id=<?php echo $b['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
            <a href="?delete_id=<?php echo $b['id']; ?>" onclick="return confirm('Delete this book?')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
