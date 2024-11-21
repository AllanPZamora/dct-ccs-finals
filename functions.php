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

?>