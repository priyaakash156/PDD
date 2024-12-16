<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "auctiondb";

$message = "Product information submitted successfully";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in first.");
}
$user_id = $_SESSION['user_id'];

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $conn->real_escape_string($_POST['product-name']);
    $bidding_starting_price = (float)$_POST['bidding-start'];
    $date = $conn->real_escape_string($_POST['bidding-date']);
    $time = $conn->real_escape_string($_POST['bidding-time']);
    $product_description = $conn->real_escape_string($_POST['product-description']);
    $important_features = $conn->real_escape_string($_POST['important-features']);
    $benefits = $conn->real_escape_string($_POST['benefits']);
    $formatted_time = date("h:i A", strtotime($time));

    $imagePaths = [];
    $uploadDirectory = "uploads/";

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    foreach ($_FILES['product-image']['name'] as $index => $filename) {
        $error = $_FILES['product-image']['error'][$index];
        if ($error === UPLOAD_ERR_OK) {
            $tempName = $_FILES['product-image']['tmp_name'][$index];
            $filePath = $uploadDirectory . uniqid() . "_" . basename($filename);
            if (move_uploaded_file($tempName, $filePath)) {
                $imagePaths[] = $conn->real_escape_string($filePath);
            }
        }
    }

    $image1 = $imagePaths[0] ?? NULL;
    $image2 = $imagePaths[1] ?? NULL;
    $image3 = $imagePaths[2] ?? NULL;
    $image4 = $imagePaths[3] ?? NULL;

    $sql = "INSERT INTO productdescription 
    (Product_name, userid, Bidding_starting_price, Date, Time, Product_description, Important_features, Benefits, image_1, image_2, image_3, image_4) 
    VALUES ('$product_name', '$user_id', '$bidding_starting_price', '$date', '$formatted_time', '$product_description', '$important_features', '$benefits', '$image1', '$image2', '$image3', '$image4')";
    

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('$message'); window.location.href='sellerproducts.php';</script>";
    } else {
        echo "Error inserting data into the database: " . $conn->error;
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Description Page</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0c3fc, #8e44ad); /* Light to deep purple gradient */
            color: #4a004e;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5em;
            text-align: center;
            color: #4b0082;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 5px;
            color: #5e239d;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #dcd6f7;
            border-radius: 5px;
            font-size: 1em;
            color: #4a004e;
            background: #f9f7ff;
        }

        input:focus, textarea:focus {
            border-color: #8e44ad;
            outline: none;
            background: #f2e8ff;
        }

        textarea {
            resize: vertical;
            height: 120px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .details-section {
            flex: 1;
            min-width: 300px;
        }

        .image-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .image-row input[type="file"] {
            flex: 1;
            min-width: 120px;
            padding: 10px;
            border: 2px dashed #8e44ad;
            background: #f9f7ff;
            cursor: pointer;
        }

        .image-row input[type="file"]:hover {
            background: #f2e8ff;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            font-size: 1.2em;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #6a0dad, #9a32cd); /* Vibrant purple gradient */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #4b0082, #8e44ad);
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product Description</h1>
        <form action="description-page.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="details-section">
                    <label for="product-name">Product Name</label>
                    <input type="text" id="product-name" name="product-name" placeholder="Enter product name here..." required>
                </div>
                <div class="details-section">
                    <label for="bidding-start">Bidding Start Price</label>
                    <input type="number" id="bidding-start" name="bidding-start" placeholder="Enter bidding start price..." required>
                </div>
            </div>

            <div class="form-row">
                <div class="details-section">
                    <label for="bidding-date">Date</label>
                    <input type="date" id="bidding-date" name="bidding-date" required>
                </div>
                <div class="details-section">
                    <label for="bidding-time">Time</label>
                    <input type="time" id="bidding-time" name="bidding-time" required>
                </div>
            </div>

            <div class="form-row">
                <div class="details-section">
                    <label for="product-description">Product Description</label>
                    <textarea id="product-description" name="product-description" placeholder="Enter product description here..." required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="details-section">
                    <label for="important-features">Important Features</label>
                    <textarea id="important-features" name="important-features" placeholder="List the important features..." required></textarea>
                </div>
                <div class="details-section">
                    <label for="benefits">Benefits</label>
                    <textarea id="benefits" name="benefits" placeholder="Describe the benefits here..." required></textarea>
                </div>
            </div>

            <div class="image-row">
                <input type="file" name="product-image[]" accept="image/*" required>
                <input type="file" name="product-image[]" accept="image/*">
                <input type="file" name="product-image[]" accept="image/*">
                <input type="file" name="product-image[]" accept="image/*">
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>
</html>
