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

// Fetch sellers from the database
$sql = "SELECT id, username, EmailID, phonenumber, status FROM signup WHERE usertype = 'seller'";
$result = $conn->query($sql);

// Initialize sellers array
$sellers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sellers[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Management</title>
    <style>
        /* Body and general styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
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
            border-radius: 0 12px 12px 0;
            color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
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
            margin-top: 30px;
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

        /* Button styles */
        .btn {
            display: inline-block;
            padding: 5px 10px;
            font-size: 1em;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-deactivate {
            background-color: #fbc02d;
        }

        .btn-activate {
            background-color: #4caf50;
        }

        .btn-delete {
            background-color: #d32f2f;
        }

        .btn:hover {
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
    </style>
</head>
<body>
<div class="navbar">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a>
        <a href="adminproduct.php">Product Management</a>
        <a href="adminuser.php">User Management</a>
        <a href="adminseller.php">Seller Management</a>
        <a href="login.php">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Seller Management</h1>

        <!-- Display success or error messages -->
        <?php if (isset($_GET['message'])): ?>
            <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>

        <!-- Sellers Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Seller Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sellers as $seller): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seller['id']); ?></td>
                        <td><?php echo htmlspecialchars($seller['username']); ?></td>
                        <td><?php echo htmlspecialchars($seller['EmailID']); ?></td>
                        <td><?php echo htmlspecialchars($seller['phonenumber']); ?></td>
                        <td><?php echo htmlspecialchars($seller['status']); ?></td>
                        <td>
                            <?php if ($seller['status'] === 'active'): ?>
                                <a href="deactivate-seller.php?id=<?php echo $seller['id']; ?>" class="btn btn-deactivate">Deactivate</a>
                            <?php else: ?>
                                <a href="reactivate-seller.php?id=<?php echo $seller['id']; ?>" class="btn btn-activate">Reactivate</a>
                            <?php endif; ?>
                            <a href="delete-seller.php?id=<?php echo $seller['id']; ?>" class="btn btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; 2024 Seller Management Dashboard
    </div>

</body>
</html>
