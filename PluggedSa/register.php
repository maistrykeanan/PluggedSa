<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name        = $_POST['name'];
    $surname     = $_POST['surname'];
    $email       = $_POST['email'];
    $cell_number = $_POST['cell_number'];
    $password    = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type   = $_POST['user_type'];

    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "That email is already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, surname, email, cell_number, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $surname, $email, $cell_number, $password, $user_type);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Something went wrong while creating your account.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - PluggedSA</title>

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
    .register-card {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 460px;
    }
    .register-card input,
    .register-card select {
      border-radius: 8px;
    }
    .btn-register {
      background-color: #007BFF;
      color: white;
      border-radius: 8px;
    }
    .btn-register:hover {
      background-color: #0056b3;
    }
    .error-message {
      color: red;
      font-size: 14px;
    }
    .login-link {
      font-size: 14px;
    }
    .login-link a {
      color: #007BFF;
      text-decoration: none;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-6">
      <div class="register-card mx-auto text-center">
        <h3 class="mb-3">Create Your PluggedSA Account</h3>

        <?php if (isset($error)): ?>
          <div class="error-message mb-2"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <input type="text" name="name" class="form-control" placeholder="Name" required>
          </div>
          <div class="mb-3">
            <input type="text" name="surname" class="form-control" placeholder="Surname" required>
          </div>
          <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="mb-3">
            <input type="text" name="cell_number" class="form-control" placeholder="Cell Number" required>
          </div>
          <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>
          <div class="mb-3">
            <select name="user_type" class="form-select">
              <option value="buyer">Buyer</option>
              <option value="seller">Seller</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-register">Register</button>
          </div>
        </form>

        <p class="login-link mt-3">Already have an account? <a href="login.php">Login here</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
