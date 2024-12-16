<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auctiondb";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_SESSION['user_id'];


// Fetch all products
$sql = "SELECT * FROM productdescription WHERE userid = '$id' ";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Existing PHP code...

// Check if Sell button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sell_bid_id'])) {
    $product_id = $_POST['product_id'];
    $sell_bid_id = $_POST['sell_bid_id'];

    // Update the product as sold
    $mark_sold_sql = "UPDATE productdescription SET is_sold = 1, sold_to_bid_id = ? WHERE id = ?";
    $mark_sold_stmt = $conn->prepare($mark_sold_sql);
    $mark_sold_stmt->bind_param("ii", $sell_bid_id, $product_id);
    
    if ($mark_sold_stmt->execute()) {
        // Redirect to order summary page with the product details
        header("Location: order_summary.php?product_id=" . $product_id . "&bid_id=" . $sell_bid_id);
        exit;
    } else {
        echo "<script>alert('Error marking product as sold.');</script>";
    }
}
?>


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Seller Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

/* Product Table */
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
    background-color: #6a0dad;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

.action-btn {
    background-color: #6a0dad;
    color: white;
    border: none;
    padding: 8px 16px;
    font-size: 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}

.action-btn:hover {
    background-color: #483d8b;
}

.action-btn.delete {
    background-color: #f44336;
}

.action-btn.delete:hover {
    background-color: #d32f2f;
}

/* Add Product Button */
.add-product-btn {
    background-color: #6a0dad;
    color: white;
    padding: 12px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 30px;
    display: block;
    width: 200px;
    margin-left: auto;
    margin-right: auto;
}

.add-product-btn:hover {
    background-color: #483d8b;
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

    table th, table td {
        padding: 12px;
        font-size: 1.1rem;
    }

    .action-btn, .add-product-btn {
        width: 100%;
        font-size: 1.2rem;
        padding: 12px;
    }
}

    </style>
</head>
<body>
    <header>
        Seller Dashboard - Manage Products
    </header>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <a href="sellerhome.php">Dashboard</a>
        <a href="sellerproducts.php" class="active">Manage Products</a>
        <a href="sellerorder.php">Manage Orders</a>
        <a href="sellerprofile.php">Profile Settings</a>
        <a href="#">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2 class="dashboard-title">Manage Your Products</h2>

        <!-- Add Product Button -->
        <button class="add-product-btn" onclick="window.location.href='description-page.php'">Add New Product</button>

        <!-- Products Table -->
        <table id="productsTable">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Date</th> <!-- Date column -->
                    <th>Time</th> <!-- New Time column -->
                    <!-- <th>View</th> New View column -->
                </tr>
            </thead>
            <tbody>
                <!-- Product rows will be dynamically populated here -->
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>#<?php echo $product['id']; ?></td>
                        <td><?php echo $product['Product_name']; ?></td>
                        <td>$<?php echo $product['Bidding_starting_price']; ?></td>
                        <td><?php echo $product['Date']; ?></td>
                        <td><?php echo $product['Time']; ?></td>
                        <!-- <td><button class="action-btn view-btn" onclick="openModal(<?php echo $product['id']; ?>)">View</button></td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Your E-Commerce Platform. All rights reserved.</p>
    </footer>

    <script>
        // Modal logic (if needed)
        function openModal(productId) {
            // Implement logic to open modal and show product details
            console.log('Product ID:', productId);
        }
    </script>

</body>
</html>
