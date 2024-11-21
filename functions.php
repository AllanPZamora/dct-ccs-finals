<?php

// Database connection function
function connectDatabase() {
    $host = "localhost"; // Database host
    $user = "root"; // Database username
    $password = ""; // Database password
    $dbname = "dct-ccs-finals"; // Database name

    // Create connection
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Validate user credentials
function validateLogin($email, $password) {
    $conn = connectDatabase();

    // Sanitize input to prevent SQL injection
    $email = $conn->real_escape_string($email);
    $password = md5($password); // Hash password with md5()

    // Query for user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return user details if login is successful
    } else {
        return false; // Return false if login fails
    }
}

// Check for duplicate student IDs
function isStudentIDExists($student_id) {
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    return $result->num_rows > 0;
}

// Register a new student
function registerStudent($student_id, $first_name, $last_name) {
    $conn = connectDatabase();

    // Sanitize inputs
    $student_id = $conn->real_escape_string($student_id);
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO students (student_id, first_name, last_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $student_id, $first_name, $last_name);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

// Fetch all students
function getStudents() {
    $conn = connectDatabase();
    $sql = "SELECT * FROM students";
    $result = $conn->query($sql);

    // Fetch all rows as associative array
    $students = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    $conn->close();
    return $students;
}

function isSubjectExists($subject_code, $subject_name) {
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM subjects WHERE subject_code = ? OR subject_name = ?");
    $stmt->bind_param("ss", $subject_code, $subject_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    return $result->num_rows > 0;
}

function addSubject($subject_code, $subject_name) {
    $conn = connectDatabase();

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO subjects (subject_code, subject_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $subject_code, $subject_name);

    // Execute and check if successful
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

function getSubjects() {
    $conn = connectDatabase();
    $sql = "SELECT * FROM subjects";
    $result = $conn->query($sql);

    // Fetch all rows as associative array
    $subjects = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
    }
    $conn->close();
    return $subjects;
}
    // Function to fetch a subject by its code (for editing)
function getSubjectByCode($subject_code) {
    $conn = connectDatabase();

    // Prepare statement to fetch the subject details
    $stmt = $conn->prepare("SELECT * FROM subjects WHERE subject_code = ?");
    $stmt->bind_param("s", $subject_code);  // Bind subject_code parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    // Return the subject details if found
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Return null if no subject found
    }
}

// Function to update the subject in the database
function updateSubject($subject_code, $subject_name) {
    $conn = connectDatabase();

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE subjects SET subject_name = ? WHERE subject_code = ?");
    $stmt->bind_param("ss", $subject_name, $subject_code); // Bind parameters
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $success;  // Return whether the update was successful or not
}

?>