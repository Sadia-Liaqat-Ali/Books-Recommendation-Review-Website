<?php
session_start();
include '../dbconnection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch current user data
$res = mysqli_query($conn, "SELECT * FROM tblusers WHERE id = $user_id");
$user = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $bio      = mysqli_real_escape_string($conn, $_POST['bio']);
    $password = trim($_POST['password']);

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $tmp = $_FILES['profile_pic']['tmp_name'];
        $img = time() . '_' . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($tmp, '../uploads/' . $img);
        $updatePic = ", profile_pic = '$img'";
    } else {
        $updatePic = '';
    }

    // Handle password update only if provided
    $updatePassword = '';
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $updatePassword = ", password = '$hashed_password'";
    }

    $sql = "UPDATE tblusers 
            SET name='$name', email='$email', bio='$bio' $updatePic $updatePassword
            WHERE id=$user_id";

    if (mysqli_query($conn, $sql)) {
        $success = 'Profile updated successfully!';
        $_SESSION['user_name'] = $name;
    } else {
        $error = 'Something went wrong. Please try again.';
    }

    // Refresh user data
    $res = mysqli_query($conn, "SELECT * FROM tblusers WHERE id = $user_id");
    $user = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
    }
    .profile-box {
      background: #fff;
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .form-control:focus {
      border-color: #6a11cb;
      box-shadow: none;
    }
    .btn-save {
      background: #6a11cb;
      color: white;
    }
    .btn-save:hover {
      background: #2575fc;
    }
    .profile-pic {
      max-height: 100px;
      border-radius: 50%;
    }
  </style>
</head>
<body>

<?php include 'user-header.php'; ?>
<br><br>
<div class="container">
  <div class="profile-box">
    <h4 class="mb-4 text-center">
      <i class="fas fa-user-edit me-2"></i>Edit Profile
    </h4>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php elseif ($success): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3 text-center">
        <?php if (!empty($user['profile_pic'])): ?>
          <img src="../uploads/<?php echo $user['profile_pic']; ?>" class="profile-pic mb-2">
        <?php endif; ?>
        <input type="file" name="profile_pic" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control"
               value="<?php echo htmlspecialchars($user['name']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="<?php echo htmlspecialchars($user['email']); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Bio</label>
        <textarea name="bio" class="form-control" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Reset Password</label>
        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
      </div>
      <button type="submit" class="btn btn-save w-100">
        <i class="fas fa-save me-1"></i> Save Changes
      </button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
