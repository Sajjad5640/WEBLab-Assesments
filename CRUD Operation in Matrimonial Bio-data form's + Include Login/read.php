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
    }
    .top-bar {
      display: flex;
      justify-content: flex-start;
      margin-bottom: 15px;
    }
    .add-btn {
      background-color: #4CAF50;
      color: white;
      padding: 10px 18px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 14px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      background-color: #fff;
    }
    th, td {
      padding: 10px 15px;
      border: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }
    th {
      background-color: #fff;
      color: black;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    .no-data {
      text-align: center;
      color: #888;
      padding: 20px;
      font-size: 16px;
    }
    .action-links a {
      margin-right: 10px;
      color: #007BFF;
      text-decoration: none;
    }
    .action-links a:hover {
      text-decoration: underline;
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
              <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row["id"]}</td>";
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
