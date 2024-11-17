<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include database connection
require_once('db.php');

// Query to fetch transactions
$query = "SELECT * FROM transactions";
$result = mysqli_query($conn, $query);

$netIncome = 0; // Initialize net income
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data as Recorded in the Database</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Basic and Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #0f2027, #203a43, #2c5364);
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            background: #f4f6f8;
            max-width: 90%;
            width: 800px;
            border-radius: 15px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            padding: 20px;
            color: #333;
        }
        .card-header h2 {
            text-align: center;
            color: #4a90e2;
            font-size: 24px;
            margin-bottom: 20px;
            position: relative;
        }
        .card-header h2::before {
            content: "\f15c";
            font-family: "Font Awesome 5 Free";
            position: absolute;
            font-size: 24px;
            left: -40px;
            color: #4a90e2;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            font-size: 16px;
        }
        th {
            background: #4a90e2;
            color: #fff;
            font-weight: 600;
        }
        tr:nth-child(even) {
            background: #f2f5fa;
        }
        .income {
            color: #28a745;
            font-weight: bold;
        }
        .expense {
            color: #dc3545;
            font-weight: bold;
        }
        .net-income {
            color: #6f42c1;
            font-weight: bold;
            font-size: 18px;
        }

        /* Button and Link Styling */
        .delete-button {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-button:hover {
            background-color: #ff1a1a;
        }
        .redirect-button {
            display: inline-block;
            background: #4a90e2;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            margin-top: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
        .redirect-button:hover {
            background: #357ab8;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Data from the Database</h2>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $description = htmlspecialchars($row['description']);
                        $amount = (float) htmlspecialchars($row['amount']); // Convert amount to float
                        $class = (strpos($description, 'income') !== false) ? 'income' : 'expense'; // Determine class based on description

                        // Calculate net income
                        if ($class === 'income') {
                            $netIncome += round($amount, 10); // Add to net income, rounded to 10 decimal places
                        } else {
                            $netIncome -= round($amount, 10); // Subtract from net income, rounded to 10 decimal places
                        }
                    ?>
                    <tr>
                        <td class="<?php echo $class; ?>"><?php echo $description; ?></td>
                        <td class="<?php echo $class; ?>"><?php echo number_format($amount, 10, '.', ''); ?></td>
                        <td>
                            <form action="delete.php" method="post" style="display:inline;">
                                <input type="hidden" name="description" value="<?php echo $description; ?>">
                                <input type="submit" value="Delete" class="delete-button">
                            </form>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="2" class="net-income">Net Income:</td>
                        <td class="net-income"><?php echo number_format(round($netIncome, 8), 8, '.', ''); ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="cash_tracker.php" class="redirect-button"><i class="fas fa-arrow-left"></i> Cash Tracker</a>
        </div>
    </div>
</div>
</body>
</html>
