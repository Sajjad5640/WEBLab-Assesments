<?php
include("server.php"); // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Matrimonial Biodata Records</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    .top-bar {
      display: flex;
      justify-content: flex-start;
      margin-bottom: 20px;
    }
    .add-btn {
      background-color: #4CAF50;
      color: white;
      padding: 10px 18px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 14px;
      transition: background-color 0.3s;
    }
    .add-btn:hover {
      background-color: #45a049;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      background-color: #fff;
      margin-top: 20px;
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }
    th {
      background-color: #f2f2f2;
      color: #333;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .no-data {
      text-align: center;
      color: #888;
      padding: 30px;
      font-size: 16px;
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .action-links a {
      margin-right: 10px;
      color: #007BFF;
      text-decoration: none;
      transition: color 0.3s;
    }
    .action-links a:hover {
      color: #0056b3;
      text-decoration: underline;
    }
    .profile-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ddd;
      display: block;
      margin: 0 auto;
    }
    .pdf-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #d32f2f;
      text-decoration: none;
      font-weight: 500;
      padding: 5px 10px;
      border-radius: 4px;
      transition: all 0.3s;
    }
    .pdf-link:hover {
      background-color: #f5f5f5;
      text-decoration: underline;
    }
    .pdf-icon {
      width: 24px;
      height: 24px;
    }
    .file-missing {
      color: #888;
      font-style: italic;
    }
  </style>
</head>
<body>

<h2>All Matrimonial Biodata Records</h2>

<div class="top-bar">
  <a href="Biodata.php" class="add-btn">+ Add New User</a>
</div>

<?php
$sql = "SELECT * FROM biodata";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<thead>
            <tr>
              <th>ID</th>
              <th>Profile Image</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>DOB</th>
              <th>Gender</th>
              <th>Marital Status</th>
              <th>Blood Group</th>
              <th>Height</th>
              <th>Weight</th>
              <th>Body Color</th>
              <th>Family Members</th>
              <th>Education</th>
              <th>Profession</th>
              <th>Languages</th>
              <th>Hobbies</th>
              <th>Nationality</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Biodata PDF</th>
              <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row["id"]}</td>";
        // Display profile image
        echo '<td style="text-align: center;">';
        if (!empty($row["profile_image"])) {
            $imagePath = $row["profile_image"];
            // Check if file exists
            if (file_exists($imagePath)) {
                echo '<img src="' . htmlspecialchars($imagePath) . '" class="profile-img" alt="Profile Image">';
            } else {
                echo '<span class="file-missing">Image not found</span>';
            }
        } else {
            echo '<span class="file-missing">No image</span>';
        }
        echo '</td>';

        echo "<td>" . htmlspecialchars($row["fullName"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>{$row["dob"]}</td>";
        echo "<td>{$row["gender"]}</td>";
        echo "<td>{$row["marital"]}</td>";
        echo "<td>{$row["blood"]}</td>";
        echo "<td>{$row["height"]} cm</td>";
        echo "<td>{$row["weight"]} kg</td>";
        echo "<td>{$row["color"]}</td>";
        echo "<td>{$row["family"]}</td>";
        echo "<td>" . htmlspecialchars($row["education"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["profession"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["languages"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["hobbies"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nationality"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
         // Display PDF link
        echo '<td>';
        if (!empty($row["pdf"])) {
            $pdfPath = $row["pdf"];
            // Check if file exists
            if (file_exists($pdfPath)) {
                echo '<a href="' . htmlspecialchars($pdfPath) . '" class="pdf-link" target="_blank">';
                echo '<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" class="pdf-icon" alt="PDF">';
                echo 'View PDF</a>';
            } else {
                echo '<span class="file-missing">PDF not found</span>';
            }
        } else {
            echo '<span class="file-missing">No PDF</span>';
        }
        echo '</td>';

        echo '<td class="action-links">
                <a href="update.php?id=' . $row["id"] . '">Edit</a>
                <a href="delete.php?id=' . $row["id"] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>
              </td>';
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<div class='no-data'>No biodata found in the database.</div>";
}
$conn->close();
?>

</body>
</html>
