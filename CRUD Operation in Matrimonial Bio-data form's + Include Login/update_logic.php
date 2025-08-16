<?php
session_start();
include('server.php');

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    
    // Get form data
    $id = $_POST['id'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $marital = $_POST['marital'];
    $blood = $_POST['blood'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $color = $_POST['color'];
    $family = $_POST['family'];
    $education = $_POST['education'];
    $profession = $_POST['profession'];
    $nationality = $_POST['nationality'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    // Handle checkbox arrays
    $languages = isset($_POST['languages']) ? implode(",", $_POST['languages']) : '';
    $hobbies = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';
    
    // Basic SQL update query
    $sql = "UPDATE biodata SET 
            fullName = '$fullName', 
            email = '$email', 
            dob = '$dob', 
            gender = '$gender', 
            marital = '$marital', 
            blood = '$blood',
            height = $height, 
            weight = $weight, 
            color = '$color', 
            family = $family, 
            education = '$education', 
            profession = '$profession',
            languages = '$languages', 
            hobbies = '$hobbies', 
            nationality = '$nationality', 
            phone = '$phone', 
            address = '$address'
            WHERE id = $id";
    
    // Execute query
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Biodata updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating record: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }
    
    // Close connection
    mysqli_close($conn);
    
    // Redirect back to read page
    header("Location: read.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid request.";
    $_SESSION['message_type'] = "error";
    header("Location: read.php");
    exit();
}
?>