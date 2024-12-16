<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";
$port = 3307; // Update if your database uses a different port

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$logged_in_user_id = $_SESSION['user_id'];

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders based on the specified conditions
$sql = "
    SELECT 
        pd.id AS product_id,
        pd.Product_name,
        pd.Product_description,
        pd.Important_features,
        pd.Benefits,
        pd.image_1,
        b.bid_amount,
        CONCAT(s.first_name, ' ', s.last_name) AS bidder_name,
        s.phonenumber AS bidder_phone
    FROM bids b
    JOIN signup s ON b.userid = s.id
    JOIN productdescription pd ON b.product_id = pd.id
    WHERE b.userid = ?
      AND pd.id = b.product_id
    ORDER BY b.bid_amount DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $logged_in_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3e5f5; /* Light purple background */
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #6a1b9a; /* Deep purple */
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .order-list {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .order-item {
            border-bottom: 1px solid #d1c4e9; /* Light purple border */
            padding: 15px 0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            border: 2px solid #6a1b9a; /* Border matches the theme */
        }
        h2 {
            color: #6a1b9a; /* Deep purple */
            text-align: center;
        }
        h3 {
            color: #4a148c; /* Darker purple for headings */
        }
        p {
            margin: 5px 0;
            color: #4a148c; /* Darker purple for text */
        }
        .order-list p strong {
            color: #6a1b9a; /* Highlighted purple */
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="main.php">Home</a>
    </div>
    <div class="order-list">
        <h2>My Orders</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="order-item">
                    <img src="<?php echo htmlspecialchars($row['image_1']); ?>" alt="Product Image" class="order-image">
                    <h3><?php echo htmlspecialchars($row['Product_name']); ?></h3>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['Product_description']); ?></p>
                    <p><strong>Features:</strong> <?php echo htmlspecialchars($row['Important_features']); ?></p>
                    <p><strong>Benefits:</strong> <?php echo htmlspecialchars($row['Benefits']); ?></p>
                    <p><strong>Your Bid Amount:</strong> ₹<?php echo htmlspecialchars($row['bid_amount']); ?></p>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($row['bidder_name']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($row['bidder_phone']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>


<?php
$stmt->close();
$conn->close();
?>
