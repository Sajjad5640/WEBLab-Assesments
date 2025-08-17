<?php
session_start();
include('server.php');

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    
    // Initialize variables
    $uploadDir = 'uploads/';
    $profileImagePath = null;
    $pdfPath = null;
    
    // Create upload directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Get and sanitize form data
    $id = intval($_POST['id']);
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $marital = mysqli_real_escape_string($conn, $_POST['marital']);
    $blood = mysqli_real_escape_string($conn, $_POST['blood']);
    $height = intval($_POST['height']);
    $weight = intval($_POST['weight']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $family = intval($_POST['family']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Handle checkbox arrays
    $languages = isset($_POST['languages']) ? implode(",", array_map(function($lang) use ($conn) {
        return mysqli_real_escape_string($conn, $lang);
    }, $_POST['languages'])) : '';
    
    $hobbies = isset($_POST['hobbies']) ? implode(",", array_map(function($hobby) use ($conn) {
        return mysqli_real_escape_string($conn, $hobby);
    }, $_POST['hobbies'])) : '';

    // Process profile image upload if provided
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $allowedImageTypes = ['jpg', 'jpeg', 'png'];
        $fileExt = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
        
        if (in_array($fileExt, $allowedImageTypes)) {
            $newFilename = uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetPath)) {
                $profileImagePath = $targetPath;
                // Delete old image if exists
                if (!empty($_POST['old_profile_image']) && file_exists($_POST['old_profile_image'])) {
                    unlink($_POST['old_profile_image']);
                }
            } else {
                $_SESSION['message'] = "Failed to move uploaded image";
                $_SESSION['message_type'] = "error";
                header("Location: update.php?id=" . $id);
                exit();
            }
        } else {
            $_SESSION['message'] = "Invalid image file type. Only JPG, JPEG, PNG allowed.";
            $_SESSION['message_type'] = "error";
            header("Location: update.php?id=" . $id);
            exit();
        }
    }

    // Process PDF upload if provided
    if (isset($_FILES['biodataPdf']) && $_FILES['biodataPdf']['error'] == UPLOAD_ERR_OK) {
        $fileExt = strtolower(pathinfo($_FILES['biodataPdf']['name'], PATHINFO_EXTENSION));
        
        if ($fileExt === 'pdf') {
            $newFilename = uniqid() . '.pdf';
            $targetPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['biodataPdf']['tmp_name'], $targetPath)) {
                $pdfPath = $targetPath;
                // Delete old PDF if exists
                if (!empty($_POST['old_pdf']) && file_exists($_POST['old_pdf'])) {
                    unlink($_POST['old_pdf']);
                }
            } else {
                $_SESSION['message'] = "Failed to move uploaded PDF";
                $_SESSION['message_type'] = "error";
                header("Location: update.php?id=" . $id);
                exit();
            }
        } else {
            $_SESSION['message'] = "Only PDF files are allowed";
            $_SESSION['message_type'] = "error";
            header("Location: update.php?id=" . $id);
            exit();
        }
    }

    // Build the SQL update query
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
            address = '$address'";
    
    // Add file paths to query if they were updated
    if ($profileImagePath !== null) {
        $sql .= ", profile_image = '$profileImagePath'";
    }
    if ($pdfPath !== null) {
        $sql .= ", pdf = '$pdfPath'";
    }
    
    $sql .= " WHERE id = $id";

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