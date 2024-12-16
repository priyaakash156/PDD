<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";

// Start session
session_start();

// Check if user is logged in (assuming seller login session is active)
if (!isset($_SESSION['user_id'])) {  
    die("Please log in to view your bid history.");
}

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve seller ID (assuming seller is logged in)
$userid = $_SESSION['user_id'];  

// Fetch products listed by the seller with availability status
$product_sql = "SELECT id, Product_name, is_sold FROM productdescription WHERE userid = ?";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("i", $userid);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

// Handle product selection
$product_name = '';
$is_sold = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (isset($_POST['sell_bid_id'])) {
        // Handle the Sell button
        $sell_bid_id = $_POST['sell_bid_id'];
        $mark_sold_sql = "UPDATE productdescription SET is_sold = 1, sold_to_bid_id = ? WHERE id = ?";
        $mark_sold_stmt = $conn->prepare($mark_sold_sql);
        $mark_sold_stmt->bind_param("ii", $sell_bid_id, $product_id);
        if ($mark_sold_stmt->execute()) {
            echo "<script>alert('Product marked as sold successfully!');</script>";
        } else {
            echo "<script>alert('Error marking product as sold.');</script>";
        }
    }

    // Fetch the selected product's name and status
    $product_name_sql = "SELECT Product_name, is_sold FROM productdescription WHERE id = ?";
    $product_name_stmt = $conn->prepare($product_name_sql);
    $product_name_stmt->bind_param("i", $product_id);
    $product_name_stmt->execute();
    $product_name_result = $product_name_stmt->get_result();
    
    if ($product_name_result->num_rows > 0) {
        $product_name_row = $product_name_result->fetch_assoc();
        $product_name = $product_name_row['Product_name'];
        $is_sold = $product_name_row['is_sold'];
    }
    
    // Fetch bid history for the selected product, ordered by bid_amount descending
    $history_sql = "SELECT id AS bid_id, userid, name, phone, bid_amount, created_at FROM bids WHERE product_id = ? ORDER BY bid_amount DESC, created_at DESC";
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
    <style>
       /* Include your CSS styles from earlier */
       /* ... */
       <style>
       /* General Reset and Styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
    color: #333;
    line-height: 1.6;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Header Styling */
header {
    background-color: #6a0dad;
    color: white;
    padding: 20px 0;
    text-align: center;
    font-size: 1.8rem;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    border-radius: 0 0 12px 12px;
}

/* Sidebar Styles */
.sidebar {
    width: 250px;
    background: linear-gradient(135deg, #483d8b, #e512e2);
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    padding-top: 50px;
    border-radius: 0 12px 12px 0;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
}

.sidebar a {
    display: block;
    padding: 15px 20px;
    color: #d1d5db;
    font-size: 1.1em;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 10px;
    border-left: 3px solid transparent;
    transition: all 0.3s ease-in-out;
}

.sidebar a:hover,
.sidebar a.active {
    background-color: #483d8b;
    border-left: 3px solid #6a0dad;
    border-radius: 5px;
    font-weight: bold;
}

/* Main Content Area */
.container {
    margin-left: 270px;
    padding: 20px;
    flex: 1;
}

.dashboard-title {
    text-align: center;
    font-size: 2rem;
    color: #6a0dad;
    margin-bottom: 40px;
}

/* Dashboard Cards */
.card-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 280px;
    background: white;
    color: #333;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card i {
    font-size: 2rem;
    color: #6a0dad;
}

.card h3 {
    font-size: 1.5rem;
    color: #6a0dad;
    margin: 20px 0;
}

.card p {
    font-size: 1rem;
    color: #666;
    margin-bottom: 20px;
}

.card button {
    background: linear-gradient(135deg, #483d8b, #e512e2);
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.card button:hover {
    background: #6a0dad;
}

/* Footer Styles */
footer {
    background-color: #6a0dad;
    color: white;
    text-align: center;
    padding: 15px 0;
    margin-top: 30px;
    border-radius: 12px;
}

footer p {
    margin: 0;
    font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        border-radius: 0;
    }

    .container {
        margin-left: 0;
    }

    .card-container {
        flex-direction: column;
    }
}
 /* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

th, td {
    padding: 15px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #1565c0;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Form and Button Styling */
select, button {
    padding: 10px 20px;
    font-size: 1rem;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
}

button {
    background: linear-gradient(135deg, #1565c0, #4caf50);
    color: white;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #6a0dad;
}

/* Action Buttons */
.action-btn {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.action-btn:hover {
    background-color: #388e3c;
}


    </style><style>
       /* General Reset and Styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
    color: #333;
    line-height: 1.6;
    overflow-x: hidden;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Header Styling */
header {
    background-color: #6a0dad;
    color: white;
    padding: 20px 0;
    text-align: center;
    font-size: 1.8rem;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    border-radius: 0 0 12px 12px;
}

/* Sidebar Styles */
.sidebar {
    width: 250px;
    background: linear-gradient(135deg, #483d8b, #e512e2);
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    padding-top: 50px;
    border-radius: 0 12px 12px 0;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
}

.sidebar a {
    display: block;
    padding: 15px 20px;
    color: #d1d5db;
    font-size: 1.1em;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 10px;
    border-left: 3px solid transparent;
    transition: all 0.3s ease-in-out;
}

.sidebar a:hover,
.sidebar a.active {
    background-color: #483d8b;
    border-left: 3px solid #6a0dad;
    border-radius: 5px;
    font-weight: bold;
}

/* Main Content Area */
.container {
    margin-left: 270px;
    padding: 20px;
    flex: 1;
}

.dashboard-title {
    text-align: center;
    font-size: 2rem;
    color: #6a0dad;
    margin-bottom: 40px;
}

/* Dashboard Cards */
.card-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 280px;
    background: white;
    color: #333;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card i {
    font-size: 2rem;
    color: #6a0dad;
}

.card h3 {
    font-size: 1.5rem;
    color: #6a0dad;
    margin: 20px 0;
}

.card p {
    font-size: 1rem;
    color: #666;
    margin-bottom: 20px;
}

.card button {
    background: linear-gradient(135deg, #483d8b, #e512e2);
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.card button:hover {
    background: #6a0dad;
}

/* Footer Styles */
footer {
    background-color: #6a0dad;
    color: white;
    text-align: center;
    padding: 15px 0;
    margin-top: 30px;
    border-radius: 12px;
}

footer p {
    margin: 0;
    font-size: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        border-radius: 0;
    }

    .container {
        margin-left: 0;
    }

    .card-container {
        flex-direction: column;
    }
}
 /* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

th, td {
    padding: 15px;
    text-align: left;
    border: 1px solid #ddd;
}

th {
    background-color: #1565c0;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Form and Button Styling */
select, button {
    padding: 10px 20px;
    font-size: 1rem;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
}

button {
    background: linear-gradient(135deg, #1565c0, #4caf50);
    color: white;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: #6a0dad;
}

/* Action Buttons */
.action-btn {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.action-btn:hover {
    background-color: #388e3c;
}


    </style>
    </style>
</head>
<body>
    <header>
        Seller Dashboard - Bid History
    </header>

    <div class="sidebar">
        <a href="sellerhome.php">Dashboard</a>
        <a href="sellerproducts.php">Manage Products</a>
        <a href="sellerorder.php">Manage Orders</a>
        <a href="sellerprofile.php">Profile Settings</a>
        <a href="login.php">Logout</a>
    </div>

    <div class="container">
        <h2 class="dashboard-title">View Bid History for Your Products</h2>

        <form method="POST" action="">
            <select name="product_id" required>
                <option value="">Select a Product</option>
                <?php while ($product = $product_result->fetch_assoc()): ?>
                    <option value="<?php echo $product['id']; ?>">
                        <?php echo htmlspecialchars($product['Product_name']) . ($product['is_sold'] ? " (Sold)" : " (Available)"); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button class="action-btn" type="submit">View Bid History</button>
        </form>

        <?php if (isset($history_result)): ?>
            <h2>Bid History for <?php echo htmlspecialchars($product_name); ?> 
                <?php echo $is_sold ? "(Sold)" : "(Available)"; ?>
            </h2>
            <?php if ($history_result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Bidder ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Bid Amount (₹)</th>
                            <th>Bid Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $is_highest = true;
                        while ($row = $history_result->fetch_assoc()): 
                        ?>
                            <tr style="background-color: <?php echo $is_highest ? '#e8f5e9' : '#ffffff'; ?>;">
                                <td><?php echo htmlspecialchars($row['userid']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td>₹<?php echo htmlspecialchars($row['bid_amount']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <?php if ($is_highest && !$is_sold): ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <input type="hidden" name="sell_bid_id" value="<?php echo $row['bid_id']; ?>">
                                            <button class="action-btn" type="submit">Sell</button>
                                        </form>
                                    <?php elseif ($is_sold): ?>
                                        <span style="color: gray;">Already Sold</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $is_highest = false; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bids placed yet for this product.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 Auction Platform</p>
    </footer>
</body>
</html>
