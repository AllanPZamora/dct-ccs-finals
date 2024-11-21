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

    // Sanitize input
    $email = $conn->real_escape_string($email);
    $password = md5($password); // Hash password to match database

    // Query for user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return user details
    } else {
        return false;
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
 
?>