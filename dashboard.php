<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$selectedLang = isset($_GET['lang']) ? $_GET['lang'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Quiz Dashboard</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background: #f5f6fa; }
.option { font-size: 14px; word-wrap: break-word; }
.answer { color: red; font-weight: bold; }
.card-body { display: flex; flex-direction: column; justify-content: space-between; }
h6 { font-size: 16px; word-wrap: break-word; }
@media (max-width: 576px) {
    h6 { font-size: 14px; }
    .option { font-size: 13px; }
    .navbar-brand { font-size: 16px; }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Quiz App</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#quizNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="quizNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                $langQuery = "SELECT DISTINCT sub FROM questions";
                $langResult = mysqli_query($conn, $langQuery);
                while ($langRow = mysqli_fetch_assoc($langResult)) {
                    $lang = $langRow['sub'];
                    $active = ($selectedLang == $lang) ? 'active' : '';
                    echo "<li class='nav-item'>
                            <a class='nav-link $active' href='dashboard.php?lang=$lang'>$lang</a>
                          </li>";
                }
                ?>
            </ul>

            <div class="d-flex align-items-center">
                <?php if ($_SESSION['role'] === 'Admin') { ?>
                    <a href="add_question.php" class="btn btn-warning btn-sm me-3">+ Add Question</a>
                <?php } ?>
                <span class="navbar-text text-white small">
                    👤 <?php echo $_SESSION['user']; ?> |
                    <a href="logout.php" class="text-white text-decoration-none">Logout</a>
                </span>
            </div>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container my-4">
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="fw-bold text-center text-md-start">
                <?php echo $selectedLang ? "$selectedLang Questions" : "All Questions"; ?>
            </h4>
        </div>
    </div>

    <div class="row g-4">
        <?php
        $query = $selectedLang
            ? "SELECT * FROM questions WHERE sub='$selectedLang'"
            : "SELECT * FROM questions";

        $result = mysqli_query($conn, $query);
        $qno = 1;

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold mb-2">
                        Q<?php echo $qno++; ?>. <?php echo $row['question_text']; ?>
                    </h6>
                    <ul class="list-group list-group-flush small flex-grow-1">
                        <li class="list-group-item option">1) <?php echo $row['option1']; ?></li>
                        <li class="list-group-item option">2) <?php echo $row['option2']; ?></li>
                        <li class="list-group-item option">3) <?php echo $row['option3']; ?></li>
                        <li class="list-group-item option">4) <?php echo $row['option4']; ?></li>
                        <div class="answer mt-3">✔ Ans: <?php echo $row['correct_answer']; ?></div>
                    </ul>
                 
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
