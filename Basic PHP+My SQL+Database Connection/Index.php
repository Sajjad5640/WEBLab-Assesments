 <?php
include 'server.php';

$sql = "INSERT INTO client (name, email, phone) VALUES
('Alice Khan', 'alice@example.com', '01711111111'),
('Bob Rahman', 'bob@example.com', '01822222222'),
('Charlie Hossain', 'charlie@example.com', '01933333333'),
('Dipa Sultana', 'dipa@example.com', '01644444444'),
('Emon Islam', 'emon@example.com', '01555555555')";

if ($conn->query($sql) === TRUE) {
    echo "Sample users added successfully.";
} else {
    echo "Error: " . $conn->error;
}
?>
<?php
include 'server.php';

$sql = "UPDATE client 
        SET name = 'Alice Banu', email = 'alice.banu@example.com', phone = '01700000000' 
        WHERE id = 2";

if ($conn->query($sql) === TRUE) {
    echo "User updated successfully.";
} else {
    echo "Error updating user: " . $conn->error;
}
?> 
<?php
include 'server.php';

$id = 2; // Change to the ID you want to delete
$sql = "DELETE FROM client WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "User deleted successfully.";
} else {
    echo "Error deleting user: " . $conn->error;
}
?>
