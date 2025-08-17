<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "test");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

 // File upload handling with better error checking
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir) ){
        if (!mkdir($uploadDir, 0755, true)) {
            die("Failed to create upload directory");
        }
    }

    $profileImagePath = null;
    $pdfPath = null;

    // Process profile image
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == UPLOAD_ERR_OK) {
        $allowedImageTypes = ['jpg', 'jpeg', 'png'];
        $fileExt = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
        
        if (in_array($fileExt, $allowedImageTypes)) {
            $newFilename = uniqid() . '.' . $fileExt;
            $targetPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetPath)) {
                $profileImagePath = $targetPath;
            } else {
                $_SESSION['error'] = "Failed to move uploaded image";
            }
        } else {
            $_SESSION['error'] = "Invalid image file type";
        }
    }

    // Process PDF
    if (isset($_FILES['biodataPdf']) && $_FILES['biodataPdf']['error'] == UPLOAD_ERR_OK) {
        $fileExt = strtolower(pathinfo($_FILES['biodataPdf']['name'], PATHINFO_EXTENSION));
        
        if ($fileExt === 'pdf') {
            $newFilename = uniqid() . '.pdf';
            $targetPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($_FILES['biodataPdf']['tmp_name'], $targetPath)) {
                $pdfPath = $targetPath;
            } else {
                $_SESSION['error'] = "Failed to move uploaded PDF";
            }
        } else {
            $_SESSION['error'] = "Only PDF files are allowed";
        }
    }

    // Sanitize inputs
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $marital = $_POST['marital'];
    $blood = $_POST['blood'];
    $height = intval($_POST['height']);
    $weight = intval($_POST['weight']);
    $color = $_POST['color'];
    $family = intval($_POST['family']);
    $education = $conn->real_escape_string($_POST['education']);
    $profession = $conn->real_escape_string($_POST['profession']);
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    // Convert arrays to comma-separated strings
    $languages = isset($_POST['languages']) ? implode(", ", $_POST['languages']) : '';
    $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : '';

    $sql = "INSERT INTO biodata (
        fullName, email, dob, gender, marital, blood,
        height, weight, color, family, education, profession,
        languages, hobbies, nationality, phone, address, profile_image, pdf
    ) VALUES (
        '$fullName', '$email', '$dob', '$gender', '$marital', '$blood',
        $height, $weight, '$color', $family, '$education', '$profession',
        '$languages', '$hobbies', '$nationality', '$phone', '$address', '$profileImagePath', '$pdfPath'
    )";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Biodata submitted successfully!";
        header("Location: read.php");
        
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
}
?>