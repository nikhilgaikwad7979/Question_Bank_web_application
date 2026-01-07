<?php
session_start();
include 'db.php';

// Redirect if not logged in or not admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['submit'])) {
    $sub = mysqli_real_escape_string($conn, $_POST['sub']);
    $question_text = mysqli_real_escape_string($conn, $_POST['question_text']);
    $option1 = mysqli_real_escape_string($conn, $_POST['option1']);
    $option2 = mysqli_real_escape_string($conn, $_POST['option2']);
    $option3 = mysqli_real_escape_string($conn, $_POST['option3']);
    $option4 = mysqli_real_escape_string($conn, $_POST['option4']);
    $correct_answer = mysqli_real_escape_string($conn, $_POST['correct_answer']);

    $insertQuery = "INSERT INTO questions (sub, question_text, option1, option2, option3, option4, correct_answer)
                    VALUES ('$sub', '$question_text', '$option1', '$option2', '$option3', '$option4', '$correct_answer')";

    if (mysqli_query($conn, $insertQuery)) {
        $message = "Question added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9 col-sm-12">

            <h3 class="text-center mb-4">Add New Question</h3>

            <?php if ($message): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Language / Subject</label>
                            <input type="text" name="sub" class="form-control" placeholder="e.g., Java, Python" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Question Text</label>
                            <textarea name="question_text" class="form-control" rows="3" placeholder="Enter your question" required></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Option 1</label>
                                <input type="text" name="option1" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Option 2</label>
                                <input type="text" name="option2" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Option 3</label>
                                <input type="text" name="option3" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Option 4</label>
                                <input type="text" name="option4" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="form-label fw-semibold">Correct Answer</label>
                            <input type="text" name="correct_answer" class="form-control" placeholder="Must match one of the options" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary w-100">Add Question</button>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
