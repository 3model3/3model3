<?php
session_start(); // Start the session

// Include the database connection
require_once('db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to fetch the user
    $query = "SELECT * FROM users WHERE username = '$username'"; // Note: Removed password from query
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result); // Fetch user data
        // Verify the password using password_verify
        if (password_verify($password, $row['password'])) { // Check hashed password
            $_SESSION['loggedin'] = true; // Set session variable
            header("Location: cash_tracker.php"); // Redirect to cash tracker
            exit;
        } else {
            $error = "Invalid username or password."; // Display error for invalid login
        }
    } else {
        $error = "Invalid username or password."; // Display error for invalid login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Basic styles for login page */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #f4f6f8;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Set a fixed width for the login container */
        }
        h2 {
            text-align: center;
        }
        p {
            color: red;
            text-align: center;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #357ab8;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo '<p>' . $error . '</p>'; } ?>
        <form action="" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
    <div class="button-group">
    <a href="register.php" class="register-button">Create Account</a>
</div>
        </form>
    </div>
</body>
</html>
