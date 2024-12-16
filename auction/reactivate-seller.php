<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "auctiondb";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the seller ID is passed as a query parameter
if (isset($_GET['id'])) {
    $sellerId = intval($_GET['id']);

    // Update the seller status to 'active' in the database
    $sql = "UPDATE signup SET status='active' WHERE id=? AND usertype='seller'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sellerId);

    if ($stmt->execute()) {
        // Redirect back to the seller management page with a success message
        header("Location: adminseller.php?message=Seller+reactivated+successfully");
        exit();
    } else {
        echo "Error reactivating seller: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
