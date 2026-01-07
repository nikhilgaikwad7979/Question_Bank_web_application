<?php
include 'db.php';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $designation = $_POST['designation'];

    $query = "INSERT INTO login (userName, password, designation)
              VALUES ('$username', '$password', '$designation')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Signup Successful');</script>";
    } else {
        echo "<script>alert('Signup Failed');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #43cea2, #185a9d);
        }
        .signup-card {
            border-radius: 12px;
        }
    </style>
</head>

<body>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">

    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-4">

            <div class="card signup-card shadow-lg border-0">
                <div class="card-body p-4">

                    <h3 class="text-center fw-bold mb-4">User Signup</h3>

                    <form method="POST">

                        <div class="mb-3">
                            <input type="text"
                                   name="username"
                                   class="form-control form-control-lg"
                                   placeholder="Username"
                                   required>
                        </div>

                        <div class="mb-3">
                            <input type="password"
                                   name="password"
                                   class="form-control form-control-lg"
                                   placeholder="Password"
                                   required>
                        </div>

                        <div class="mb-3">
                            <select name="designation"
                                    class="form-select form-select-lg"
                                    required>
                                <option value="">Select Role</option>
                                <option value="Student">Student</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>

                        <button name="signup" class="btn btn-primary btn-lg w-100">
                            Signup
                        </button>

                    </form>

                    <p class="text-center mt-3 small">
                        Already have an account?
                        <a href="login.php" class="fw-semibold">Login</a>
                    </p>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>
