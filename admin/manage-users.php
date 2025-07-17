<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.php");
    exit;
}

// DELETE user
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM tblusers WHERE id=$id");
    echo "<script>alert('User deleted.'); window.location='manage-users.php';</script>";
    exit;
}

// UPDATE user
if (isset($_POST['update'])) {
    $id   = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    mysqli_query($conn, "UPDATE tblusers SET name='$name', email='$email', bio='$bio' WHERE id=$id");
    echo "<script>alert('User updated.'); window.location='manage-users.php';</script>";
    exit;
}

// FETCH specific user to edit
$editing = false;
if (isset($_GET['id'])) {
    $editing = true;
    $id = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM tblusers WHERE id=$id");
    $user = mysqli_fetch_assoc($res);
}

// FETCH all users
$all = mysqli_query($conn, "SELECT * FROM tblusers ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users | BookRecSys Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
 
    .profile-pic { width: 50px; height: 50px; object-fit: cover; border-radius: 50%; }
  </style>
</head>
<body>

<?php include 'admin-header.php'; ?>
<br><br>
<div class="container">
  <h4 class="mb-4">Manage Users</h4>

  <?php if ($editing): ?>
    <div class="card mb-4">
      <div class="card-body">
        <h5>Edit User</h5>
        <form method="post">
          <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
          <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($user['name']); ?>">
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
          </div>
          <div class="mb-2">
            <label>Bio</label>
            <textarea name="bio" class="form-control"><?php echo htmlspecialchars($user['bio']); ?></textarea>
          </div>
          <button type="submit" name="update" class="btn btn-warning">Update</button>
          <a href="manage-users.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  <?php endif; ?>

  <?php if (mysqli_num_rows($all) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Picture</th>
            <th>Name</th>
            <th>Email</th>
            <th>Bio</th>
            <th>Registered</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($all)): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td>
                <?php if (!empty($row['profile_pic']) && file_exists("../uploads/{$row['profile_pic']}")): ?>
                  <img src="../uploads/<?php echo $row['profile_pic']; ?>" class="profile-pic">
                <?php else: ?>
                  <img src="../default-user.png" class="profile-pic">
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($row['name']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo nl2br(htmlspecialchars($row['bio'])); ?></td>
              <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
              <td>
                <a href="?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?');">
                  <i class="fas fa-trash-alt"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No users found.</div>
  <?php endif; ?>
</div>

</body>
</html>
