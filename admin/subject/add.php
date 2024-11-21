<?php
session_start();
$pageTitle = "Add Subject";
include '../partials/header.php';
include '../../functions.php';


?>

   <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Section -->
            <?php include '../partials/side-bar.php'; ?>

            <!-- Main Content Section -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="mt-5">
                    <h2>Add a New Subject</h2>
                    <br>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
                        </ol>
                    </nav>
                    <hr>
                    <br>

                    <!-- Error Message Display -->
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>System Errors</strong>
                        <ul>
                            <li>Error message placeholder.</li>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Subject Entry Form -->
                    <div class="card shadow-sm p-4">
                        <form method="post" action="add.php">
                            <div class="form-group mb-3">
                                <label for="subject_code" class="form-label">Subject Code</label>
                                <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="Enter Subject Code" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="subject_name" class="form-label">Subject Name</label>
                                <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter Subject Name" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-50">Add Subject</button>
                            </div>
                        </form>
                    </div>
                    <hr>

                    <!-- Subject List Table -->
                    <h3 class="mt-5 text-center">Subject List</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Sample Code</td>
                                    <td>Sample Name</td>
                                    <td>
                                        <a href="edit.php?subject_code=sample" class="btn btn-info btn-sm">Edit</a>
                                        <a href="delete.php?subject_code=sample" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">No subjects found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

<?php
include '../partials/footer.php'; // Footer will remain the same
?>