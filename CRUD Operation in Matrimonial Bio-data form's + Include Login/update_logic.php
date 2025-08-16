<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "test");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Update Request
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    // Sanitize inputs
    $id = intval($_POST['id']);
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $marital = $conn->real_escape_string($_POST['marital']);
    $blood = $conn->real_escape_string($_POST['blood']);
    $height = intval($_POST['height']);
    $weight = intval($_POST['weight']);
    $color = $conn->real_escape_string($_POST['color']);
    $family = intval($_POST['family']);
    $education = $conn->real_escape_string($_POST['education']);
    $profession = $conn->real_escape_string($_POST['profession']);
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    // Handle checkbox arrays
    $languages = isset($_POST['languages']) ? implode(",", $_POST['languages']) : '';
    $hobbies = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';

    // Prepare update statement - COUNT THE PLACEHOLDERS (17) + 1 for WHERE = 18 total
    $stmt = $conn->prepare("UPDATE biodata SET 
        fullName = ?, email = ?, dob = ?, gender = ?, marital = ?, blood = ?,
        height = ?, weight = ?, color = ?, family = ?, education = ?, profession = ?,
        languages = ?, hobbies = ?, nationality = ?, phone = ?, address = ?
        WHERE id = ?");

    // Count the type specifiers - should be 18 (17 fields + id)
    // s = string, i = integer
    $stmt->bind_param("ssssssiiissssssssi", 
        $fullName, $email, $dob, $gender, $marital, $blood,
        $height, $weight, $color, $family, $education, $profession,
        $languages, $hobbies, $nationality, $phone, $address, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Biodata updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating biodata: " . $stmt->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    header("Location: read.php");
    exit();
}
?>