<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "admin@pluggedsa.com" && $password === "admin123") {
        $_SESSION['user_id']   = "admin";
        $_SESSION['user_type'] = "admin";
        $_SESSION['name']      = "Admin";
        $_SESSION['email']     = $email;
        header("Location: admin_dashboard.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['name']      = $user['name'];
        $_SESSION['email']     = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - PluggedSA</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #F4F4F4;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
    }
    .login-card input {
      border-radius: 8px;
    }
    .btn-login {
      background-color: #007BFF;
      color: white;
      border-radius: 8px;
    }
    .btn-login:hover {
      background-color: #0056b3;
    }
    .error-message {
      color: red;
      font-size: 14px;
    }
    .register-link a {
      color: #007BFF;
      text-decoration: none;
    }
    .register-link a:hover {
      text-decoration: underline;
    }
    .promo-image {
      max-width: 100%;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="row justify-content-center align-items-center g-4">

    <!-- Login Form -->
    <div class="col-lg-6 col-md-10">
      <div class="login-card">
        <div class="text-center mb-3">
          <img src="logo.png" alt="PluggedSA Logo" style="width: 180px;">
          <h4 class="mt-2">Login to PluggedSA</h4>
        </div>

        <?php if (isset($error)): ?>
          <div class="error-message text-center mb-2"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-login">Login</button>
          </div>
        </form>

        <p class="register-link text-center mt-3">
          Don't have an account? <a href="register.php">Register here</a>
        </p>
      </div>
    </div>

    <!-- Promo Image -->
    <div class="col-lg-6 d-none d-lg-block text-center">
      <img src="phone.png" alt="Promo Image" class="promo-image">
    </div>

  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

