<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "auctiondb"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the 'signup' table
$sql = "SELECT id, username, EmailID, status FROM signup WHERE usertype='user'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User Management</title>
    <style>
        /* Styles go here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .reactivate {
            background: #4caf50;
        }
        .delete {
            background: #d32f2f;
        }
    </style>
    <?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "auctiondb"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users from the 'signup' table
$sql = "SELECT id, username, EmailID, status FROM signup WHERE usertype='user'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User Management</title>
    <style>
        /* Styles go here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .reactivate {
            background: #4caf50;
        }
        .delete {
            background: #d32f2f;
        }
    </style>
    <style>
        /* Styles go here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
        .reactivate {
            background: #4caf50;
        }
    </style>
    <style>
        /* Add your styles here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
        }
        .navbar {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 1.5rem;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
    </style>
        <style>
        /* Add your styles here */
        /* Basic Reset and Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
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
    </style>    <style>
        /* Add your styles here */
        /* Basic Reset and Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
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
    </style><style>
        /* Styles go here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
        .reactivate {
            background: #4caf50;
        }
    </style>
    <style>
        /* Add your styles here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
            color: #333;
        }
        .navbar {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            padding: 15px;
            color: white;
            text-align: center;
            font-size: 1.5rem;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
    </style>
        <style>
        /* Add your styles here */
        /* Basic Reset and Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
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
    </style>    <style>
        /* Add your styles here */
        /* Basic Reset and Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e4e7ea, #e5e7ea);
        }
        .navbar, .footer {
            background: linear-gradient(135deg, #6a0dad, #e40bd9);
            color: white;
            text-align: center;
            padding: 15px;
        }
        .sidebar {
            width: 250px;
            float: left;
            background: linear-gradient(135deg, #483d8b, #e512e2);
            color: white;
            padding: 15px;
            height: 100vh;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #6a0dad;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .deactivate {
            background: #fbc02d;
        }
        .delete {
            background: #d32f2f;
        }
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
    <div class="navbar">Admin Dashboard</div>

    <div class="sidebar">
        <a href="adminhome.php">Dashboard</a><br>
        <a href="adminproduct.php">Product Management</a><br>
        <a href="adminuser.php">User Management</a><br>
        <a href="adminseller.php">Seller Management</a><br>
        <a href="login.php">Log Out</a><br>
    </div>

    <div class="main-content">
        <h1>User Management</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email ID</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['EmailID']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>";
                        // Toggle link
                        echo "<a href='toggle-status.php?id={$row['id']}' class='action-btn " . ($row['status'] === 'active' ? 'deactivate' : 'reactivate') . "'>" . 
                             ($row['status'] === 'active' ? 'Deactivate' : 'Reactivate') . 
                             "</a>";
                        // Delete link
                        echo " <a href='delete-user.php?id={$row['id']}' class='action-btn delete'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>&copy; 2024 Admin Dashboard. All rights reserved.</p>
    </div>
</body>
</html>

<?php
$conn->close();
?>

