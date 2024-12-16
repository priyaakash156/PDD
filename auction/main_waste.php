<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb"; // Change DB name if necessary

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch specific columns from product_description table
$sql = "SELECT id, Product_name, Bidding_starting_price, Date, Time, image_1 FROM product_description";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2Z Auction</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        /* Header styles */
        header {
            background-color: #db44d1;
            color: rgb(27, 26, 26);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        header .search-bar {
            display: flex;
            width: 50%;
            border-radius: 2px;
            padding: 5px;
            margin: 0 15px;
        }
        header .search-bar input {
            width: 85%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        header .search-bar button {
            width: 15%;
            background-color: #ff9800;
            border: none;
            border-radius: 4px;
            padding: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        header .search-bar button:hover {
            background-color: #88778638;
        }
        header .nav-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        header .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        header .nav-menu a:hover {
            text-decoration: underline;
        }

        /* Category Section */
        .category-section {
            padding: 20px;
        }
        .category-title {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        .product-list {
            display: grid;
            grid-template-columns: repeat(6, 1fr); /* 6 items per row */
            gap: 20px;
            margin-bottom: 40px;
        }
        .product-item {
            background-color: #d13fcf0f;
            padding: 15px;
            text-align: center;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product-item img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .product-item h4 {
            margin: 5px 0;
        }
        .product-item p {
            font-size: 15px;
            color:#121111;
            margin: 10px 0;
        }

        /* Footer */
        footer {
            background-color: #121111;
            color: white;
            padding: 20px;
            text-align: center;
        }
        footer a {
            color: white;
            margin: 10px;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<header>
    <div class="logo">A2Z Auction</div>
    <div class="nav-menu">
        <a href="#">Home & Appliances</a>
        <a href="#">Mobiles & Laptop</a>
        <a href="#">Electronics</a>
        <a href="#">Automobiles</a>
        <a href="#">Other</a>
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Search for products, brands and more">
        <button>Search</button>
    </div>
    <div class="nav-menu">
       <a href="#">Profile</a>
        <a href="login.html">Login</a>
    </div>
</header>

<!-- Category Sections -->
<div class="category-section">
    <div class="product-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item">
                <img src="<?php echo htmlspecialchars($row['image_1']); ?>" alt="Product Image" width="150">
                <h4><?php echo htmlspecialchars($row['Product_name']); ?></h4>
                    <p>Bidding start: ₹<?php echo htmlspecialchars($row['Bidding_starting_price']); ?><br>
                    Start date: <?php echo htmlspecialchars($row['Date']); ?><br>
                    Time: <?php echo htmlspecialchars($row['Time']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Close database connection -->
<?php $conn->close(); ?>
   <hr><br>

<!-- Footer Section -->
<footer>
    <p>© 2024 A2Z Auction</p>
    <a href="#">About Us</a>
    <a href="#">Privacy Policy</a>
    <a href="#">Terms & Conditions</a> 
</footer>

</body>
</html>