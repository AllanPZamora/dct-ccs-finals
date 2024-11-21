<?php
session_start();
$pageTitle = "Delete Student";
include '../partials/header.php';
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
                    <!-- Student Deletion Confirmation -->
                    <h5>Are you sure you want to delete the following student record?</h5>
                    <ul>
                        <li><strong>Student ID:</strong>  </li>
                        <li><strong>First Name:</strong></li>
                        <li><strong>Last Name:</strong></li>
                    </ul>
                    <form method="POST">
                        <input type="hidden" name="student_id" value="">
                        <button type="button" class="btn btn-secondary" onclick="">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Student Record</button>
                    </form>
                    <!-- If student not found -->
                    <p class="text-danger">Student not found.</p>
                    <a href="register.php" class="btn btn-primary">Back to Student List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include '../partials/footer.php';
?>