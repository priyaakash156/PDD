<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve user input
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Database connection
    $servername = "localhost";
    $db_email = "root";
    $db_password = "";
    $dbname = "auctiondb";  // Change DB name if necessary

    // Create connection
    $conn = new mysqli($servername, $db_email, $db_password, $dbname, 3307);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check user credentials and status
    $sql = "SELECT * FROM signup WHERE EmailID = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $userInfo = $result->fetch_assoc();

        // Check user status
        if ($userInfo['status'] === 'active') {
            // User is authenticated and active, set session variables
            $_SESSION["logged_in"] = true;
            $_SESSION['user_id'] = $userInfo['id'];
            $_SESSION['usertype'] = $userInfo['usertype'];

            // Redirect based on usertype
            if ($userInfo['usertype'] === 'user') {
                header("Location:main.php");
            } elseif ($userInfo['usertype'] === 'admin') {
                header("Location:adminproduct.php");
            } elseif ($userInfo['usertype'] === 'seller') {
                header("Location:sellerproducts.php");
            }
            exit();
        } else {
            // User is deactivated
            echo "<script>alert('Your account is deactivated. Please contact support for assistance.');</script>";
        }
    } else {
        // Invalid credentials, show an error message
        echo "<script>alert('Invalid username or password.');</script>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2Z Auction - Login</title>
    <style>
        /* (Keep the original styles as provided earlier) */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(145deg,  #E8D7F1, #FDF3FF,#D489F9);
            display: flex;
            justify-content: flex-start; /* Align to the left */
            align-items: center;
            height: 100vh;
            margin: 0;
            padding-left: 20px; /* Space from the edge */
        }
        .message-box {
            background-color: #D489F9; /* Purple color */
            padding: 20px;
            border-radius: 100px; /* Curved corners */
            color: #ffffff;
            width: 400px; /* Set width for better alignment */
            margin-right: 300px; /* Space to the right of the box */
            text-align: center;
        }
        .message-box h1, .message-box h2, .message-box p, .message-box h3 {
            margin: 140px 0;
        }
        .login-container {
            width: 350px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h3 {
            font-size: 12px; /* Adjust size as needed */
        }
        .message-box h1 {
            color: #ff5733;
            font-size: 50px; /* Replace #ff5733 with your desired color */
        }
        .message-box h3 {
            color: #100f0f;
            font-size: 25px; /* Replace #ff5733 with your desired color */
        }
        .message-box p {
            color: #151313;
            font-size: 15px; /* Replace #ff5733 with your desired color */
        }
        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #191616;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 94%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #d07bfa;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #db44d1;
        }
        .login-container .forgot-password {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .login-container .forgot-password:hover {
            text-decoration: underline;
        }
        .login-container .create-account {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .login-container .create-account:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="message-box">
    <h1>A2Z Auction</h1>
    <p>In the bidding of life, true worth is often revealed in the moments we share</p>
    <h3>WELCOME BACK!!!</h3>
</div>

<div class="login-container">
    <h2>Warm wishes</h2>
    <h3>Login in to your account to get started</h3>
    <form action="login.php" method="POST">
        <label for="email">Email ID</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required> 

        <button type="submit">LOGIN</button>
        <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
        <a href="register.php" class="create-account">Create Account</a>
    </form>
</div>

</body>
</html>
