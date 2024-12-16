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

// Check if the user ID is passed as a query parameter
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Delete the user from the database
    $sql = "DELETE FROM signup WHERE id=? and usertype='user'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Redirect back to the admin user management page with a success message
        header("Location: adminuser.php?message=User+deleted+successfully");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
