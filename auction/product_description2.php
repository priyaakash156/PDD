<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";

// Start session
session_start();

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must log in to place a bid.");
}

// Retrieve logged-in user's ID
$userid = $_SESSION['user_id'];

// Retrieve product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT id, Product_name, Bidding_starting_price, Date, Time, Product_description, Important_features, Benefits, image_1, image_2, image_3, image_4, is_sold, sold_to_bid_id 
        FROM productdescription WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1):
    $product = $result->fetch_assoc();
    $is_sold = $product['is_sold'];

    // Get auction date and time
    $auction_end = $product['Date'] . ' ' . $product['Time'];
    $current_time = date('Y-m-d H:i:s');

    // Check if the auction has ended
    $auction_ended = strtotime($current_time) > strtotime($auction_end);

    // Get the current highest bid from the database
    $bid_sql = "SELECT MAX(bid_amount) as highest_bid FROM bids WHERE product_id = ?";
    $bid_stmt = $conn->prepare($bid_sql);
    $bid_stmt->bind_param("i", $product_id);
    $bid_stmt->execute();
    $bid_result = $bid_stmt->get_result();
    $highest_bid = 0;
    if ($bid_result->num_rows > 0) {
        $bid_data = $bid_result->fetch_assoc();
        $highest_bid = $bid_data['highest_bid'];
    }

    // Handle the bid submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$auction_ended && !$is_sold) {
        $name = htmlspecialchars($_POST['name']);
        $phone = htmlspecialchars($_POST['phone']);
        $bid = floatval($_POST['bid']);

        // Validate the bid
        if ($bid <= $product['Bidding_starting_price']) {
            echo "<div class='confirmation-message'>Bid must be greater than the starting price of ₹" . $product['Bidding_starting_price'] . ".</div>";
        } elseif ($bid <= $highest_bid) {
            echo "<div class='confirmation-message'>Bid must be greater than the previous highest bid of ₹$highest_bid.</div>";
        } else {
            // Process the bid - store it in the database
            $bid_sql = "INSERT INTO bids (product_id, product_title, name, phone, bid_amount, userid) VALUES (?, ?, ?, ?, ?, ?)";
            $bid_stmt = $conn->prepare($bid_sql);
            $bid_stmt->bind_param("isssdi", $product_id, $product['Product_name'], $name, $phone, $bid, $userid);
            $bid_stmt->execute();

            echo "<div class='confirmation-message'>Thank you, $name! Your bid of ₹$bid has been placed successfully.</div>";

            // Update the highest bid and check if auction has ended
            $highest_bid = $bid;

            if (strtotime($current_time) > strtotime($auction_end)) {
                // Update the product description table to mark it as sold
                $update_sql = "UPDATE productdescription SET is_sold = 1, sold_to_bid_id = ?, sold_to_user_id = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("iii", $bid_stmt->insert_id, $userid, $product_id);
                $update_stmt->execute();

                echo "<div class='confirmation-message'>Auction ended. The product has been sold to you for ₹$bid!</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['Product_name']); ?> - Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f0ff; /* Light purple background */
            margin: 0;
            padding: 0;
        }
        header {
            background: linear-gradient(135deg, #6a0dad, #e40bd9); /* Purple header background */
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        .back-button {
            background-color: #4b47b6; /* Darker purple for the button */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #3a3691;
        }
        .product-details {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff; /* White for contrast */
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .image-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .image-row img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 4px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }
        h2 {
            color: #6c63ff; /* Purple headings */
        }
        p {
            line-height: 1.6;
            color: #333;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .submit-button {
            padding: 10px 20px;
            background-color: #6c63ff; /* Purple button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .submit-button:hover {
            background-color: #574fbb; /* Darker purple on hover */
        }
        .confirmation-message {
            margin-top: 20px;
            padding: 10px;
            background-color: #e6e0ff; /* Light purple success background */
            border-radius: 4px;
            color: #6c63ff; /* Purple text */
        }
        .bid-history {
            margin-top: 30px;
            padding: 15px;
            background-color: #f3f0ff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .bid-history table {
            width: 100%;
            border-collapse: collapse;
        }
        .bid-history table, .bid-history th, .bid-history td {
            border: 1px solid #ddd;
        }
        .bid-history th {
            background-color: #6c63ff;
            color: white;
            text-align: left;
            padding: 10px;
        }
        .bid-history td {
            padding: 10px;
            text-align: left;
        }
        .winning-bid {
            color: #4caf50; /* Green for winning bid */
        }
        .heading{
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<header>
    <h1>A2Zauction</h1>
    <button class="back-button" onclick="window.history.back();">Back</button>
</header>
<div class="product-details">
    <div class="heading">
        <h3>Images</h3>
        <button class="message-button" onclick="window.location.href='user_chat.php?id=<?php echo urlencode($_SESSION['user_id']); ?>';">
            Message Admin
        </button>
    </div>
    <div class="image-row">
        <img src="<?php echo htmlspecialchars($product['image_1']); ?>" alt="Product Image 1">
        <?php if (!empty($product['image_2'])): ?>
            <img src="<?php echo htmlspecialchars($product['image_2']); ?>" alt="Product Image 2">
        <?php endif; ?>
        <?php if (!empty($product['image_3'])): ?>
            <img src="<?php echo htmlspecialchars($product['image_3']); ?>" alt="Product Image 3">
        <?php endif; ?>
        <?php if (!empty($product['image_4'])): ?>
            <img src="<?php echo htmlspecialchars($product['image_4']); ?>" alt="Product Image 4">
        <?php endif; ?>
        <div class="product-details">
    <!-- Existing product details code -->
    
    <!-- Add the "Message" button -->
   <!-- Add the "Message Admin" button -->



    <!-- Add some styles for the button -->
    <style>
        .message-button {
            padding: 10px 20px;
            background-color: #ff7f50; /* Coral color for distinction */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .message-button:hover {
            background-color: #e5673d; /* Slightly darker coral on hover */
        }
    </style>
</div>

    </div>

    <h2><?php echo htmlspecialchars($product['Product_name']); ?></h2>
    <p><strong>Bidding Starting Price:</strong> ₹<?php echo htmlspecialchars($product['Bidding_starting_price']); ?></p>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($product['Date']); ?></p>
    <p><strong>Time:</strong> <?php echo htmlspecialchars($product['Time']); ?></p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['Product_description']); ?></p>
    <p><strong>Important Features:</strong> <?php echo htmlspecialchars($product['Important_features']); ?></p>
    <p><strong>Benefits:</strong> <?php echo htmlspecialchars($product['Benefits']); ?></p>

    <?php if ($is_sold): ?>
        <p class="confirmation-message">This product has been sold. Bidding is now closed.</p>
    <?php elseif ($auction_ended): ?>
        <p class="confirmation-message">This auction has ended. Bidding is closed.</p>
    <?php else: ?>
        <h3>Place Your Bid</h3>
        <form method="POST" action="">
            <input type="text" name="name" class="input-field" placeholder="Your Name" required>
            <input type="text" name="phone" class="input-field" placeholder="Your Phone" required>
            <input type="number" name="bid" class="input-field" placeholder="Your Bid (₹)" step="0.01" required>
            <button type="submit" class="submit-button">Place Bid</button>
        </form>
    <?php endif; ?>

    <div class="bid-history">
        <h3>Bid History</h3>
        <?php
        $history_sql = "SELECT b.name, b.phone, b.bid_amount, b.id AS bid_id, b.userid
                        FROM bids b
                        WHERE b.product_id = ?
                        ORDER BY b.bid_amount DESC";
        $history_stmt = $conn->prepare($history_sql);
        $history_stmt->bind_param("i", $product_id);
        $history_stmt->execute();
        $history_result = $history_stmt->get_result();

        if ($history_result->num_rows > 0):
        ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Bid Amount (₹)</th>
                    <th>Bidder ID</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = $history_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['bid_amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['userid']); ?></td>
                        <td>
                            <?php echo ($row['bid_id'] == $product['sold_to_bid_id']) ? "<span class='winning-bid'>Winning Bid</span>" : "Not Sold"; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No bids placed yet for this product.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<?php
else:
    echo "Product not found.";
endif;
$conn->close();
?>
