<?php
session_start();
include "includes/db.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
  $user = mysqli_fetch_assoc($query);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <form method="post" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <?php if(isset($error)): ?>
      <div class="bg-red-100 text-red-700 p-2 mb-4 rounded"><?= $error ?></div>
    <?php endif; ?>

    <div class="mb-4">
      <label class="block text-sm font-medium">Username</label>
      <input type="text" name="username" value="admin" class="border w-full p-2 rounded" required>
    </div>

    <div class="mb-6">
      <label class="block text-sm font-medium">Password</label>
      <input type="password" name="password" value="admin123" class="border w-full p-2 rounded" required>
    </div>

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
  </form>

</body>
</html>
