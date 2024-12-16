<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auctiondb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST actions for approving or rejecting products
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approve_product'])) {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $sql = "UPDATE productdescription SET Status = 'approved' WHERE id = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product approved successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }

    if (isset($_POST['reject_product'])) {
        $product_id = $conn->real_escape_string($_POST['product_id']);
        $sql = "UPDATE productdescription SET Status = 'rejected' WHERE id = '$product_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Product rejected successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Fetch pending products from the database
$sql_pending = "SELECT id, Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Status FROM productdescription WHERE status = 'pending'";
$result_pending = $conn->query($sql_pending);

$pending_products = [];
if ($result_pending->num_rows > 0) {
    while ($row = $result_pending->fetch_assoc()) {
        $pending_products[] = $row;
    }
}

// Fetch approved products from the database
$sql_approved = "SELECT id, Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Status FROM productdescription WHERE status = 'approved'";
$result_approved = $conn->query($sql_approved);

$approved_products = [];
if ($result_approved->num_rows > 0) {
    while ($row = $result_approved->fetch_assoc()) {
        $approved_products[] = $row;
    }
}
// Fetch rejected products from the database
$sql_rejected = "SELECT id, Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Status FROM productdescription WHERE status = 'rejected'";
$result_rejected = $conn->query($sql_rejected);

$rejected_products = [];
if ($result_rejected->num_rows > 0) {
    while ($row = $result_rejected->fetch_assoc()) {
        $rejected_products[] = $row;
    }
}


// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product Management</title>
    <style>
        /* Your existing CSS code */
        /* Simplified for brevity */
        <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            padding: 15px 30px;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            padding: 20px;
            position: fixed;
            height: 100%;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #6a0dad;
            color: #fff;
        }

        .action-btn {
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .action-btn.approve {
            background-color: #4caf50;
        }

        .action-btn.reject {
            background-color: #e53935;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: #fff;
            margin-top: 30px;
        }
    </style>
    <style>
        /* Your existing styles here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            padding: 15px 30px;
            color: #fff;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            padding: 20px;
            position: fixed;
            height: 100%;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            border-left: 3px solid transparent;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #6a0dad;
            border-left: 3px solid #fff;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #6a0dad;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-btn {
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .action-btn.approve {
            background-color: #4caf50;
        }

        .action-btn.reject {
            background-color: #e53935;
        }

        .action-btn.delete {
            background-color: #d32f2f;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: #fff;
            margin-top: 30px;
            border-radius: 12px;
        }
         
        /* Basic reset and styling */
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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navbar styles */
        .navbar {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            padding: 15px 30px;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .navbar h1 {
            font-size: 1.8em;
            font-weight: bold;
        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            padding-top: 20px;
            position: fixed;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 0;
            color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            display: block;
            padding: 15px 15px;
            color: #fff;
            font-size: 1.1em;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease-in-out;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #483d8b;
            border-left: 3px solid #fff;
            border-radius: 5px;
        }

        /* Main content styles */
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #6a0dad;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-transform: capitalize;
        }

        th {
            background-color: #6a0dad;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-btn {
            display: inline-block;
            padding: 5px 10px;
            font-size: 1em;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .action-btn.deactivate {
            background-color: #fbc02d;
        }

        .action-btn.delete {
            background-color: #d32f2f;
        }

        .action-btn:hover {
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: #fff;
            margin-top: 30px;
            border-radius: 12px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-radius: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    
    </style>
    </style>
</head>
<body>
    <div class="navbar">
        <h1 style="color: white; margin-bottom:0;">Admin Dashboard</h1>
    </div>

    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a>
        <a href="adminproduct.php">Product Management</a>
        <a href="adminuser.php">User Management</a>
        <a href="adminseller.php">Seller Management</a>
        <a href="login.php">Log Out</a>
    </div>

    <div class="main-content">
        <h1>Manage Seller Products</h1>

        <!-- Pending Products Table -->
        <h2>Pending Products</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User ID</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pending_products) > 0): ?>
                    <?php foreach ($pending_products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['Product_name']) ?></td>
                            <td><?= htmlspecialchars($product['userid']) ?></td>
                            <td><?= htmlspecialchars($product['Bidding_starting_price']) ?></td>
                            <td><?= htmlspecialchars($product['Date']) ?></td>
                            <td><?= htmlspecialchars($product['Time']) ?></td>
                            <td><?= htmlspecialchars($product['Product_description']) ?></td>
                            <td><?= htmlspecialchars($product['Status']) ?></td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" name="approve_product" class="action-btn approve">Approve</button>
                                </form>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" name="reject_product" class="action-btn reject">Reject</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align:center;">No pending products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Approved Products Table -->
        <h2>Approved Products</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>User ID</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($approved_products) > 0): ?>
                    <?php foreach ($approved_products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= htmlspecialchars($product['Product_name']) ?></td>
                            <td><?= htmlspecialchars($product['userid']) ?></td>
                            <td><?= htmlspecialchars($product['Bidding_starting_price']) ?></td>
                            <td><?= htmlspecialchars($product['Date']) ?></td>
                            <td><?= htmlspecialchars($product['Time']) ?></td>
                            <td><?= htmlspecialchars($product['Product_description']) ?></td>
                            <td><?= htmlspecialchars($product['Status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No approved products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
                <!-- rejected Products Table -->
                <h2>Rejected Products</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>User ID</th>
            <th>Price</th>
            <th>Date</th>
            <th>Time</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($rejected_products) > 0): ?>
            <?php foreach ($rejected_products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['Product_name']) ?></td>
                    <td><?= htmlspecialchars($product['userid']) ?></td>
                    <td><?= htmlspecialchars($product['Bidding_starting_price']) ?></td>
                    <td><?= htmlspecialchars($product['Date']) ?></td>
                    <td><?= htmlspecialchars($product['Time']) ?></td>
                    <td><?= htmlspecialchars($product['Product_description']) ?></td>
                    <td><?= htmlspecialchars($product['Status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">No rejected products found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    </div>

    <div class="footer">
        &copy; 2024 Admin Dashboard
    </div>
</body>
</html>
