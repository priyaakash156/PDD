<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "auctiondb"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Fetch the current status
    $sql = "SELECT status FROM signup WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $newStatus = ($row['status'] === 'active') ? 'inactive' : 'active';

        // Update the user's status
        $updateSql = "UPDATE signup SET status = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newStatus, $userId);

        if ($updateStmt->execute()) {
            header("Location: adminuser.php"); // Redirect back to User Management page
            exit;
        } else {
            echo "Error updating status.";
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
