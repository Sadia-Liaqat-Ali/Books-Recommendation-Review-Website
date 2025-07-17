<?php
include 'dbconnection.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $bio      = mysqli_real_escape_string($conn, $_POST['bio']);

    // ✅ Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Upload profile pic
    $profile_pic = '';
    if (!empty($_FILES['profile']['name'])) {
        $tmp  = $_FILES['profile']['tmp_name'];
        $namefile = time().'_'.basename($_FILES['profile']['name']);
        move_uploaded_file($tmp, 'uploads/'.$namefile);
        $profile_pic = $namefile;
    }

    // Insert into DB
    $sql = "INSERT INTO tblusers (name, email, password, profile_pic, bio)
            VALUES ('$name', '$email', '$hashedPassword', '$profile_pic', '$bio')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Registered successfully!";
        header('Location: user-login.php');
        exit;
    } else {
        $msg = "Error or Email already exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Register | BookRecSys</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: #ffffff;
      padding: 2rem;
      border-radius: .75rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 420px;
    }
    .login-card .logo {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2575fc;
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .login-card .form-control:focus {
      box-shadow: none;
      border-color: #6a11cb;
    }
    .login-btn {
      background: #6a11cb;
      border: none;
    }
    .login-btn:hover {
      background: #2575fc;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="logo">
      <i class="fas fa-user-plus"></i> BookRecSys Register
    </div>

    <?php if ($msg): ?>
      <div class="alert alert-info py-2"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" novalidate>
      <div class="mb-2">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Profile Picture</label>
        <input type="file" name="profile" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Short Bio</label>
        <textarea name="bio" class="form-control" rows="2"></textarea>
      </div>
      <button type="submit" class="btn login-btn text-white w-100 mb-2">
        <i class="fas fa-user-check me-1"></i> Register
      </button>
      <div class="text-center">
        Already a user? <a href="user-login.php">Login here</a>
      </div>
    </form>
  </div>
</body>
</html>
