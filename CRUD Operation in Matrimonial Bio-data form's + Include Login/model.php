<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "test");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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
        languages, hobbies, nationality, phone, address
    ) VALUES (
        '$fullName', '$email', '$dob', '$gender', '$marital', '$blood',
        $height, $weight, '$color', $family, '$education', '$profession',
        '$languages', '$hobbies', '$nationality', '$phone', '$address'
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