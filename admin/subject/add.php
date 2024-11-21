<?php
session_start();
$pageTitle = "Add Subject";
include '../partials/header.php';
include '../../functions.php';


// Handle form submission
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize input
    $subject_code = htmlspecialchars($_POST['subject_code']);
    $subject_name = htmlspecialchars($_POST['subject_name']);

    // Validate input
    if (empty($subject_code) || empty($subject_name)) {
        $errors[] = "Both Subject Code and Subject Name are required.";
    } elseif (isSubjectExists($subject_code, $subject_name)) {
        $errors[] = "Subject code or name already exists.";
    } else {
        // Add subject to the database
        if (addSubject($subject_code, $subject_name)) {
            header("Location: add.php");
            exit;
        } else {
            $errors[] = "Failed to add subject. Please try again.";
        }
    }
}

// Fetch all subjects from the database
$subjects = getSubjects();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include '../partials/side-bar.php'; ?>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container mt-5">
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
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>System Errors</strong>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Subject Entry Form -->
                <div class="card shadow-sm p-4">
                    <form method="post">
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
                            <?php if (!empty($subjects)): ?>
                                <?php foreach ($subjects as $subject): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                                        <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                        <td>
                                            <a href="edit.php?subject_code=<?php echo urlencode($subject['subject_code']); ?>" class="btn btn-info btn-sm">Edit</a>
                                            <a href="delete.php?subject_code=<?php echo urlencode($subject['subject_code']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No subjects found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>


<?php
include '../partials/footer.php';
?>