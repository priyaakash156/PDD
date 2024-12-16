<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";

// Start session
session_start();

// Check if user is logged in (assuming seller login session is active)
if (!isset($_SESSION['seller_id'])) {
    die("Please log in to view your bid history.");
}

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve seller ID (assuming seller is logged in)
$seller_id = $_SESSION['seller_id'];  // Seller ID should be stored in session after login

// Fetch products listed by the seller
$product_sql = "SELECT id, Product_name FROM productdescription WHERE seller_id = ?";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("i", $seller_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

// Handle product selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Fetch bid history for the selected product
    $history_sql = "SELECT name, phone, bid_amount, created_at FROM bids WHERE product_id = ? ORDER BY created_at DESC";
    $history_stmt = $conn->prepare($history_sql);
    $history_stmt->bind_param("i", $product_id);
    $history_stmt->execute();
    $history_result = $history_stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller - Bid History</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #1565c0;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #1565c0;
            margin-bottom: 20px;
        }
        select, button {
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #1565c0;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<header>
    Seller Dashboard - Bid History
</header>

<div class="container">
    <h2>Select a Product to View Bid History</h2>

    <!-- Product Selection Form -->
    <form method="POST" action="">
        <select name="product_id" required>
            <option value="">Select a Product</option>
            <?php while ($product = $product_result->fetch_assoc()): ?>
                <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['Product_name']); ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">View Bid History</button>
    </form>

    <!-- Display Bid History -->
    <?php if (isset($history_result)): ?>
        <h2>Bid History for <?php echo htmlspecialchars($product_name); ?></h2>
        <?php if ($history_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Bid Amount (₹)</th>
                    <th>Bid Time</th>
                </tr>
                <?php while ($row = $history_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['bid_amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No bids placed yet for this product.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
