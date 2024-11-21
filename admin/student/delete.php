<?php
session_start();
$pageTitle = "Delete Student Record";
include '../partials/header.php';
include '../../functions.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Fetch student data from the database to confirm it exists
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $studentToDelete = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if (!$studentToDelete) {
        // If no student is found, redirect back to register page
        header("Location: register.php");
        exit;
    }
} else {
    // If no student_id is provided, redirect to the register page
    header("Location: register.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Delete student record from the database
    $conn = connectDatabase();
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect to the register page after deletion
    header("Location: register.php");
    exit;
}
?>

<!-- Main Content Section -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../partials/side-bar.php'; ?>

        <!-- Main Content Column -->
        <div class="col-md-9 col-lg-10 mt-5">
            <h2>Delete a Student</h2>
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
                </ol>
            </nav>

            <div class="card mt-3">
                <div class="card-body">
                    <?php if ($studentToDelete): ?>
                        <h5>Are you sure you want to delete the following student record?</h5>
                        <ul>
                            <li><strong>Student ID:</strong> <?= htmlspecialchars($studentToDelete['student_id']) ?></li>
                            <li><strong>First Name:</strong> <?= htmlspecialchars($studentToDelete['first_name']) ?></li>
                            <li><strong>Last Name:</strong> <?= htmlspecialchars($studentToDelete['last_name']) ?></li>
                        </ul>
                        <form method="POST">
                            <input type="hidden" name="student_id" value="<?= htmlspecialchars($studentToDelete['student_id']) ?>">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php';">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Student Record</button>
                        </form>
                    <?php else: ?>
                        <p class="text-danger">Student not found.</p>
                        <a href="register.php" class="btn btn-primary">Back to Student List</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../partials/footer.php'; // Footer will remain the same
?>