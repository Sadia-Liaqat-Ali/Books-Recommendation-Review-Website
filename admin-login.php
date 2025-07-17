
<?php
session_start();
include 'dbconnection.php';  

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT id, email 
            FROM tbladmin 
            WHERE email='$email' 
              AND password='$password' 
            LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) === 1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['admin_id']    = $row['id'];
        $_SESSION['admin_email'] = $row['email'];
        header('Location: admin/admin-dashboard.php');
        exit;
    } else {
        $error = 'Invalid login';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | BookRecSys</title>
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
      max-width: 400px;
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
      <i class="fas fa-book-reader"></i> BookRecSys Admin
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger py-2"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn login-btn text-white w-100 mb-2">
        <i class="fas fa-sign-in-alt me-1"></i> Login
      </button>
    </form>
  </div>
</body>
</html>