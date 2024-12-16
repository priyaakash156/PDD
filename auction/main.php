<?php
// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "auctiondb";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch specific columns from product_description table
$sql = "SELECT id, Product_name, Bidding_starting_price, Date, Time, image_1 
        FROM productdescription 
        WHERE (is_sold = '0' OR is_sold = '1') AND Status = 'approved'";
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
            background-color: #f3e5f5;
        }

        header {
            background: linear-gradient(90deg, #6a1b9a, #8e24aa, #ab47bc);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        header .logo {
            font-size: 28px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        header .search-bar {
            display: flex;
            width: 50%;
            border-radius: 4px;
            background-color: #f3e5f5;
            padding: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        header .search-bar input {
            width: 85%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            outline: none;
        }

        header .search-bar button {
            width: 15%;
            background-color: #8e24aa;
            border: none;
            border-radius: 4px;
            padding: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        header .search-bar button:hover {
            background-color: #6a1b9a;
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
            font-size: 16px;
            transition: color 0.3s ease;
        }

        header .nav-menu a:hover {
            text-decoration: underline;
            color: #f3e5f5;
        }

        .category-section {
            padding: 30px;
            background-color: #f8e3fc;
        }

        .category-title {
            font-size: 28px;
            margin-bottom: 15px;
            color: #6a1b9a;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .product-item {
            background-color: #ffffff;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-item img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product-item h4 {
            margin: 10px 0;
            color: #8e24aa;
            font-size: 18px;
            font-weight: bold;
        }

        .product-item p {
            font-size: 15px;
            color: #6a1b9a;
            margin: 10px 0;
        }

        footer {
            background: linear-gradient(90deg, #6a1b9a, #8e24aa);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 16px;
        }

        footer a {
            color: white;
            margin: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        footer a:hover {
            text-decoration: underline;
            color: #f3e5f5;
        }

        .dropbtn {
            background-color: transparent;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #8e24aa;
            color: white;
        }

        .profile {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #8e24aa    ;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1;
        }

        .dropdown-content a {
            color:  #f3e5f5;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #e1bee7;
        }

        .show {
            display: block;
        }
        a{
            text-decoration: none;
            text-transform: capitalize;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">A2Z Auction</div>

    <div class="search-bar">
        <input type="text" placeholder="Search for products, brands and more">
        <button>Search</button>
    </div>
    <div class="nav-menu">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">Profile</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="yourdetailspage.php">Your details</a>
                <a href="order.php">Orders</a>
            </div>
        </div>
        <a href="login.php">Login</a>
    </div>
</header>

<div class="category-section">
    <div class="product-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item">
                    <a href="product_description2.php?id=<?php echo urlencode($row['id']); ?>">
                        <img src="<?php echo htmlspecialchars($row['image_1']); ?>" alt="Product Image" width="150">
                        <h4><?php echo htmlspecialchars($row['Product_name']); ?></h4>
                        <p>Bidding start: ₹<?php echo htmlspecialchars($row['Bidding_starting_price']); ?><br>
                        Start date: <?php echo htmlspecialchars($row['Date']); ?><br>
                        Time: <?php echo htmlspecialchars($row['Time']); ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php $conn->close(); ?>

<footer>
    <p>© 2024 A2Z Auction</p>
    <a href="register.php">Become a seller</a> 
    <a href="#">Copyright @ 2024</a>
</footer>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

</body>
</html>
