<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";

// Start session
session_start();

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT id, Product_name, Bidding_starting_price, Current_price, Date, Time, image_1, image_2, image_3 
        FROM product_description WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1):
    $product = $result->fetch_assoc();
else:
    echo "Product not found.";
    exit();
endif;

$stmt->close();
$conn->close();
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['Product_name']); ?> - Live Auction</title>
    <style>
          /* General Styles */
          body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f500;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

     
        .product-image img {
            width: 100%;
            border-radius: 8px;
        }

        .auction-details {
            background-color: #e0e0e0;
            padding: 10px;
            border-radius: 25px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-info-container {
            display: flex;
            align-items: center;
        }

        .price-info {
            text-align: left;
            margin-right: 20px;
        }

        .price-info p {
            margin: 0;
            color: #888;
        }

        .price-info h3 {
            margin: 5px 0;
        }

        .separator {
            height: 50px;
            width: 1px;
            background-color: #ccc;
        }

        .live-users {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .live-users img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 3px;
        }

        .live-users span {
            font-size: 14px;
            color: #666;
        }

        .current-price {
            text-align: left;
            margin-left: 20px;
        }

        .auction-status {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .live-indicator {
            color: #ffcc00;
            font-weight: bold;
            display: inline-block;
        }

        .bidders {
            display: flex;
            flex-direction: column;
            align-items: start;
            margin-top: 20px;
        }

        .bidder {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .bidder img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .bid-amount {
            font-weight: bold;
            margin-left: auto;
        }

        .bid-options {
            display: flex;
            gap: 10px;
            margin: 10px 0;
        }

        .bid-options input[type="button"],
        .bid-options input[type="text"] {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }

        .place-bid {
            background-color: #ffcc00;
            color: #000;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        .timer {
            display: flex;
            align-items: center;
            background-color: #e0e0e0;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 18px;
            margin-top: 10px; /* Added margin-top to move the clock downward */
        }

        .timer span:first-child {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="auction-container">
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($product['image_1']); ?>" alt="<?php echo htmlspecialchars($product['Product_name']); ?>" />
        </div>
        <div class="auction-details">
            <div class="price-info-container">
                <div class="price-info">
                    <p>Start price</p>
                    <h3>&#8377;<?php echo htmlspecialchars($product['Bidding_starting_price']); ?></h3>
                </div>
                <div class="separator"></div>
                <div class="current-price">
                    <p>Current price</p>
                    <h3>&#8377;<?php echo htmlspecialchars($product['Current_price']); ?></h3>
                </div>
            </div>
        </div>
        <div class="auction-status">
            <span class="live-indicator">● Live auction</span>
            <div class="timer">
                <span>⏰</span>
                <span>00:20</span>
            </div>
        </div>
        <div class="bidders">
            <!-- Add bidders dynamically using JavaScript or PHP -->
            <div class="bidder">
                <img src="path/to/user-image.jpg" alt="Bidder Name">
                <span>Bidder Name</span>
                <span class="bid-amount">&#8377;50,000</span>
            </div>
        </div>
        <div class="bid-options">
            <input type="button" value="&#8377;2,000">
            <input type="button" value="&#8377;3,000">
            <input type="button" value="&#8377;5,000">
            <input type="text" placeholder="custom bid">
        </div>
        <button class="place-bid">Place Bid for &#8377;50,000</button>
    </div>
</body>
</html>
