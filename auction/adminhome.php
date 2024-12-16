<?php
// session_start();
// Database connection details
$host = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "auctiondb"; // Database name
// $userid=$_SESSION['user_id'];

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname,3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count total users and total sellers in the 'signup' table
$sql = "SELECT COUNT(*) AS total_users FROM signup WHERE usertype = 'user'";
$result = $conn->query($sql);
$totalUsers = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalUsers = $row['total_users'];
}

$sql = "SELECT COUNT(*) AS total_sellers FROM signup WHERE usertype = 'seller'";
$result = $conn->query($sql);
$totalSellers = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalSellers = $row['total_sellers'];
}

// Count total products in the 'productdescription' table
$sql = "SELECT COUNT(*) AS total_products FROM productdescription";
$result = $conn->query($sql);
$totalProducts = 0;
if ($result && $row = $result->fetch_assoc()) {
    $totalProducts = $row['total_products'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Basic reset and styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #d1d5db;
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
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    border-radius: 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

.navbar h1 {
    font-size: 1.8em;
    font-weight: bold;
}

.chat-button {
    background: linear-gradient(135deg, #483d8b, #e512e2);
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 1em;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s;
}

.chat-button:hover {
    background-color: #6a0dad;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
            color: #d1d5db;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #d1d5db;
            font-size: 1.1em;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease-in-out;
            margin-bottom: 10px;
        }

        /* Sidebar links hover effect */
        .sidebar a:hover {
            background-color: #225fd800;
            border-left: 3px solid #6a0dad;
            border-radius: 5px;
            color: #fff;
            font-weight: 600;
        }

        /* Main content styles */
        .main-content {
            margin-left: 270px;
            padding: 20px;
            color: #d1d5db;
        }

        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 280px;
            background: #f609e615;
            color: #6a0dad;
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

        .card h2 {
            font-size: 2.8em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1.2em;
            font-weight: 500;
            color: #010a17e6;
        }

        .card .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: #fff;
            font-size: 1em;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .card .btn:hover {
            background-color: #483d8b;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: #fff;
            margin-top: 30px;
            border-radius: 0;
            width: 100%;
            bottom: 0;
            position: fixed;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-cards {
                flex-direction: column;
            }

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
    <style>
        /* Basic reset and styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #d1d5db;
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
            background: linear-gradient(135deg, #6a0dad,    #e40bd9);
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

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 600;
            padding: 10px 15px;
            border: 2px solid transparent;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .navbar a:hover {
            background-color: #483d8b;
            border-color: #fff;
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
            border-radius:0;
            color: #d1d5db;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #d1d5db;
            font-size: 1.1em;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease-in-out;
            margin-bottom: 10px;
        }

        /* Sidebar links hover effect */
        .sidebar a:hover {
            background-color: #225fd800;
            border-left: 3px solid #6a0dad;
            border-radius: 5px;
            color: #fff; /* Change text color on hover */
            font-weight: 600; /* Make font weight bolder on hover */
        }

        /* Additional individual hover effects for each link (optional) */
        .sidebar a:nth-child(1):hover {
            background-color: #6a0dad;
        }

        .sidebar a:nth-child(2):hover {
            background-color: #483d8b;
        }

        .sidebar a:nth-child(3):hover {
            background-color: #e40bd9;
        }

        .sidebar a:nth-child(4):hover {
            background-color: #d512e2;
        }

        .sidebar a:nth-child(5):hover {
            background-color: #ff4b5c; /* Change hover color for Logout */
        }

        /* Main content styles */
        .main-content {
            margin-left: 270px;
            padding: 20px;
            color: #d1d5db;
        }

        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 280px;
            background: #f609e615;
            color: #6a0dad;
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

        .card h2 {
            font-size: 2.8em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1.2em;
            font-weight: 500;
            color: #010a17e6;
        }

        .card .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #483d8b, #e512e2);          
              color: #fff;
            font-size: 1em;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .card .btn:hover {
            background-color: #483d8b;
        }

        /* Welcome card */
        .dashboard-card {
            background: #e106c096;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            text-align: center;
        }

        .dashboard-card h3 {
            font-size: 1.8em;
            font-weight: bold;
            color: #6a0dad;
            margin-bottom: 15px;
        }

        .dashboard-card p {
            font-size: 1.2em;
            color: #d1d5db;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #6a0dad, #d506f0);
            color: #fff;
            margin-top: 30px;
            border-radius: 12px;
            border-radius: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-cards {
                flex-direction: column;
            }

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
</head>
<body>
<div class="navbar">
    <h1>Admin Dashboard</h1>
     <a href="admin_chat.php">CHAT</a>
    </div>


    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a>
        <a href="adminproduct.php">Product Management</a>
        <a href="adminuser.php">User Management</a>
        <a href="adminseller.php">Seller Management</a>
        <a href="login.php">Log Out</a>
    </div>

    <div class="main-content">
        <div class="dashboard-cards">
            <div class="card">
                <h2><?php echo $totalProducts; ?></h2>
                <p>Total Products</p>
                <a href="adminproduct.php" class="btn">View Products</a>
            </div>

            <div class="card">
                <h2><?php echo $totalSellers; ?></h2>
                <p>Total Sellers</p>
                <a href="adminseller.php" class="btn">View Sellers</a>
            </div>

            <div class="card">
                <h2><?php echo $totalUsers; ?></h2>
                <p>Total Users</p>
                <a href="adminuser.php" class="btn">View Users</a>
            </div>
        </div>

        <div class="dashboard-card">
            <h3>Welcome, Admin!</h3>
            <p>Manage your products, users, and sellers all from this attractive dashboard.</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
    </div>
</body>
</html>
