<?php 
session_start();
$pageTitle = "Edit Student"; 
include '../partials/header.php';  // This includes the header and sidebar 
?>

<!-- Main Content Section -->
<div class="container-fluid">
    <div class="row">
        <!-- Include the sidebar -->
        <?php include '../partials/side-bar.php'; ?>
        
        <!-- Main Form Column -->
        <div class="col-md-9 col-lg-10 mt-5">
            <h2>Edit Student</h2>
            <br>

            <!-- Error Messages -->
            <div class="alert alert-danger" style="display: none;" id="errorMessages">
                <strong>System Errors</strong>
                <ul id="errorList"></ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Edit Student Form -->
            <form id="editStudentForm">
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" readonly>
                </div>

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Update Student</button>
            </form>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; // Footer remains the same ?>