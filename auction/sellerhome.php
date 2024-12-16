<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
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

    </style>
</head>
<body>

<header>
    Seller Dashboard
</header>

<!-- Sidebar Navigation -->
<div class="sidebar">
    <a href="sellerhome.php" class="active">Dashboard</a>
    <a href="sellerproducts.php">Manage Products</a>
    <a href="sellerorder.php">Manage Orders</a>
    <a href="sellerprofile.php">Profile Settings</a>
    <a href="login.php">Logout</a>
</div>

<!-- Main Dashboard Content -->
<div class="container" style="margin-left: 280px;">
    <h2 class="dashboard-title">Welcome to your Seller Dashboard</h2>

    <div class="card-container">
        <!-- Dashboard Card 1 -->
        <div class="card">
            <i class="fas fa-box"></i>
            <h3>Manage Products</h3>
            <p>Update, add, or delete your products from the catalog.</p>
            <a href="sellerproducts.php"><button>Go to Products</button></a>
        </div>

        <!-- Dashboard Card 2 -->
        <div class="card">
            <i class="fas fa-truck"></i>
            <h3>Manage Orders</h3>
            <p>View and manage your incoming orders.</p>
           <a href="sellerorder.php" ></ahref><button>View Orders</button></a>
        </div>

        <!-- Dashboard Card 3 -->
        <div class="card">
            <i class="fas fa-users"></i>
            <h3>Profile Settings</h3>
            <p>Update your seller profile and business details.</p>
            <a href="sellerprofile.php"><button>Update Profile</button></a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 Your E-Commerce Platform. All rights reserved.</p>
</footer>

</body>
</html>