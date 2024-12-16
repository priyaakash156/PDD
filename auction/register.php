<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password if not blank
$database = "auctiondb";

// Establish connection
$conn = new mysqli($servername, $username, $password, $database, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $first_name = $_POST['First_name'];
    $last_name = $_POST['Last_name'];
    $gender = $_POST['Gender'];
    $email_id = $_POST['Email_id'];
    $phone_number = $_POST['Phone_number'];
    $address = $_POST['Address1'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $confirm_password = $_POST['Confirm_password'];
    $user_type = $_POST['UserType'];
    $date_of_birth = $_POST['Date_of_Birth'];
    $status = "active"; // Default status value

    // Validate password and confirm password
    if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
    } else {
        // SQL query to insert data into the signup table
        $sql = "INSERT INTO signup (first_name, last_name, gender, EmailID, phonenumber, Address, username, password, confirmpassword, usertype, date_of_birth, status)
                VALUES ('$first_name', '$last_name', '$gender', '$email_id', '$phone_number', '$address', '$username', '$password', '$confirm_password', '$user_type', '$date_of_birth', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A2Z Auction - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #a4508b, #D489F9);
                        /* background: linear-gradient(145deg,  #E8D7F1, #FDF3FF,#D489F9); */

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
            margin: 0;
            padding: 0;
            color: #ffffff;
        }

        /* Header Styles */
        .header {
            width: 100%;
            background: rgba(0, 0, 0, 0.2);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ffccff;
            text-shadow: 2px 2px 4px #000000;
        }

        .header .nav-link {
            font-size: 16px;
            color: #ffffff;
            text-decoration: none;
            background: linear-gradient(to right, #a4508b, #5f0a87);
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s ease-in-out;
            font-weight: bold;
        }

        .header .nav-link:hover {
            background: linear-gradient(to right, #5f0a87, #a4508b);
        }

        /* Main Container */
     

        .message-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .message-box h1 {
            color: #ffccff;
            font-size: 36px;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px #000000;
        }

        .message-box h3 {
            font-size: 22px;
            margin-top: 10px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 500px;
            color: #333333;
        }

        .login-container h2 {
            color: #5f0a87;
            margin-bottom: 20px;
            text-align: center;
            font-size: 28px;
        }

        .login-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #5f0a87;
        }

        .login-container input[type="text"],
        .login-container input[type="email"],
        .login-container input[type="password"],
        .login-container input[type="tel"],
        .login-container input[type="date"],
        .login-container textarea,
        .login-container select {
            width: 100%;
            padding: 7px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background: #f3e5f5;
            color: #333333;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-container input:focus,
        .login-container textarea:focus,
        .login-container select:focus {
            border-color: #a4508b;
            outline: none;
            box-shadow: 0 0 5px rgba(165, 80, 139, 0.5);
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #a4508b, #5f0a87);
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease-in-out;
        }

        .login-container button:hover {
            background: linear-gradient(to right, #5f0a87, #a4508b);
        }

        textarea {
            resize: none;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            body {
                padding: 10px;
            }
            .message-box h1 {
                font-size: 28px;
            }
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">A2Z Auction</div>
    <a href="login.php" class="nav-link">Sign Up</a>
</div>



    <div class="login-container">
        <h2>Sign Up</h2>
        <form action="register.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <label for="First_name">First Name</label>
                    <input type="text" id="First_name" name="First_name" required>
                </div>
                <div class="col-md-6">
                    <label for="Last_name">Last Name</label>
                    <input type="text" id="Last_name" name="Last_name" required>
                </div>
            </div>
           

        

            <label for="Gender">Gender</label>
            <select id="Gender" name="Gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="Date_of_Birth">Date of Birth</label>
            <input type="date" id="Date_of_Birth" name="Date_of_Birth" required>

            <label for="Email_id">Email ID</label>
            <input type="email" id="Email_id" name="Email_id" required>

            <label for="Phone_number">Phone Number</label>
            <input type="tel" id="Phone_number" name="Phone_number" required>

            <label for="Address1">Address</label>
            <textarea id="Address1" name="Address1" rows="4" required></textarea>

            <label for="Username">Username</label>
            <input type="text" id="Username" name="Username" required>

            <label for="Password">Password</label>
            <input type="password" id="Password" name="Password" required>

            <label for="Confirm_password">Confirm Password</label>
            <input type="password" id="Confirm_password" name="Confirm_password" required>

            <label for="UserType">User Type</label>
            <select id="UserType" name="UserType" required>
                <option value="seller">Seller</option>
                <option value="user">User</option>
            </select>

            <button type="submit">REGISTER</button>
        </form>
    </div>
</div>

</body>
</html>
