<?php
session_start();
$conn = new mysqli("localhost", "root", "", "auctiondb", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the admin is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to access this page.");
}

// Fetch all users who have sent messages to the admin
$sql = "SELECT DISTINCT sender FROM message WHERE receiver = 'admin'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Chat List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-list {
            margin: 20px;
        }
        .chat-item {
            padding: 10px;
            background-color: #f9f9f9;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-item:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>List of Users' Chats</h2>
        <div class="chat-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="chat-item">';
                    echo '<a href="admin_chat.php?id=' . urlencode($row['sender']) . '">' . htmlspecialchars($row['sender']) . '</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No users have sent messages yet.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
