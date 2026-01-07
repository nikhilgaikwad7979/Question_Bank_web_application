<?php
session_start();
include 'db.php';

// If already logged in
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $role     = $_POST['role']; // Student / Admin

    // Fetch user from DB
    $query = "SELECT * FROM login WHERE userName='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {

        $user = mysqli_fetch_assoc($result);

        $dbPassword = $user['password'];
        $dbRole     = trim($user['designation']); // Remove extra spaces

        // ✅ Check password and role (case-insensitive)
        if (password_verify($password, $dbPassword)) {
            
            if (strtolower($role) === strtolower($dbRole)) {
                $_SESSION['user'] = $user['userName'];
                $_SESSION['role'] = $dbRole;

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Invalid role selected for this user.";
            }

        } else {
            $error = "Incorrect password.";
        }

    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        .login-card {
            border-radius: 14px;
        }
    </style>
</head>
<body>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">
            <div class="card login-card shadow-lg border-0">
                <div class="card-body p-4">

                    <h3 class="text-center fw-bold mb-4">User Login</h3>

                    <!-- Error Message -->
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                        </div>

                        <div class="mb-3">
                            <select name="role" class="form-select form-select-lg" required>
                                <option value="">Select Role</option>
                                <option value="Student">Student</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>

                        <button name="login" class="btn btn-success btn-lg w-100">Login</button>
                    </form>

                    <p class="text-center mt-3 small text-dark">
                        Don’t have an account? <a href="signup.php" class="fw-semibold text-primary">Signup</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
