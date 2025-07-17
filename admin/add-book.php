<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = $_POST['title'];
    $author      = $_POST['author'];
    $genre       = $_POST['genre'];
    $year        = $_POST['year'];
    $isbn        = $_POST['isbn'];
    $description = $_POST['description'];

    // cover upload
    $cover_name = '';
    if (!empty($_FILES['cover']['name']) && $_FILES['cover']['error'] === 0) {
        $tmp  = $_FILES['cover']['tmp_name'];
        $orig = basename($_FILES['cover']['name']);
        $cover_name = time() . '_' . $orig;
        move_uploaded_file($tmp, 'uploads/' . $cover_name);
    }

    $sql = "INSERT INTO tblbooks (title, author, genre, publication_year, isbn, description, cover_image)
            VALUES ('$title', '$author', '$genre', '$year', '$isbn', '$description', '$cover_name')";

    if (mysqli_query($conn, $sql)) {
        $book_id = mysqli_insert_id($conn);

        // Define genre list in same order as IDs 1-10
        $genre_list = [
            'Fiction','Non-Fiction','Mystery','Science Fiction','Fantasy',
            'Romance','Biography','Self-Help','History','Thriller'
        ];

        // Find genre_id based on index
        $genre_id = array_search($genre, $genre_list);
        if ($genre_id !== false) {
            $genre_id += 1; // because array index starts at 0

            // Prepare professional message
            $message = "📚 A new $genre book \"<strong>$title</strong>\" by $author has been added! 
                        If you're into $genre stories, don't miss it.";

            // Insert into tblnotification
            mysqli_query($conn, "
                INSERT INTO tblnotification (genre_id, book_id, message) 
                VALUES ($genre_id, $book_id, '" . mysqli_real_escape_string($conn, $message) . "')
            ");
        }

        echo "<script>alert('Book added successfully!'); window.location='manage-books.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error adding book, please try again.');</script>";
    }
}
?>

     
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Book | Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .form-container {
      max-width: 700px;
      margin: 40px auto;
      padding: 20px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
  </style>
</head>
<body>
    <?php include 'admin-header.php'; ?>

  <div class="form-container">
    <h4 class="mb-4 text-center">Add New Book</h4>
    <form method="post" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Author</label>
          <input type="text" name="author" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Genre</label>
          <select name="genre" class="form-select" required>
            <option value="">-- Select Genre --</option>
            <?php
              $opts = ['Fiction','Non-Fiction','Mystery','Science Fiction','Fantasy','Romance','Biography','Self-Help','History','Thriller'];
              foreach ($opts as $o) echo "<option>$o</option>";
            ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Publication Year</label>
          <input type="number" name="year" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">ISBN</label>
          <input type="text" name="isbn" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Cover Image</label>
          <input type="file" name="cover" class="form-control">
        </div>
        <div class="col-12">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="mt-4 text-center">
        <button type="submit" class="btn btn-success me-2">Save Book</button>
        <a href="manage_books.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
```
