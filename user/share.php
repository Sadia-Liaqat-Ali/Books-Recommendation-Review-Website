<?php
session_start();
include '../dbconnection.php';

$share_url = '';
$share_text = '';

// Handle review sharing
if (isset($_GET['review_id'])) {
    $review_id = (int)$_GET['review_id'];
    $res = mysqli_query($conn, "SELECT * FROM tblreviews WHERE id = $review_id");
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        $share_url = "http://localhost/Booksystem/review-view.php?id=" . $review_id;
        $share_text = "Review: " . substr($r['comment'], 0, 50) . "...";
    } else {
        echo "Review not found.";
        exit;
    }
}

// Handle book sharing if review_id is not set
else if (isset($_GET['book_id'])) {
    $book_id = (int)$_GET['book_id'];
    $res = mysqli_query($conn, "SELECT * FROM tblbooks WHERE id = $book_id");
    if ($res && mysqli_num_rows($res) > 0) {
        $book = mysqli_fetch_assoc($res);
        $share_url = "http://localhost/Booksystem/book-details.php?id=" . $book_id;
        $share_text = "Book: " . htmlspecialchars($book['title']);
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Share</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; padding-top: 50px; font-family: 'Segoe UI', sans-serif; }
    .share-box {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .social-icons a {
      margin: 0 10px;
      font-size: 50px;
      color: blue;
      transition: 0.2s;
    }
    .social-icons a:hover {
      color: red;
    }
  </style>
</head>
<body>

<div class="share-box">
  <h4>Share "<?php echo $share_text; ?>"</h4>
  <p class="text-muted mb-2">Use this link to share:</p>
  <div class="input-group mb-3">
    <input type="text" id="shareLink" class="form-control" value="<?php echo $share_url; ?>" readonly>
    <button class="btn btn-outline-secondary" onclick="copyLink()">Copy</button>
  </div>

  <p class="text-muted mb-2">Or share directly:</p>
  <div class="social-icons">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" title="Facebook">
      <i class="fab fa-facebook"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($share_url); ?>&text=<?php echo urlencode($share_text); ?>" target="_blank" title="Twitter">
      <i class="fab fa-twitter"></i>
    </a>
    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($share_text . ' ' . $share_url); ?>" target="_blank" title="WhatsApp">
      <i class="fab fa-whatsapp"></i>
    </a>
  </div>
</div>

<script>
function copyLink() {
  var copyText = document.getElementById("shareLink");
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile
  document.execCommand("copy");
  alert("Link copied to clipboard!");
}
</script>

</body>
</html>
