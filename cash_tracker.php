<?php
session_start(); // Start the session
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit; // Stop further execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Tracker (Incomes and Expenses)</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset and Basic Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: #444;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            max-width: 700px;
            width: 100%;
            overflow: hidden;
        }
        .header {
            background-color: #2575fc;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        h1 {
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        h1 i {
            font-size: 1.2em;
        }

        /* Form Styling */
        .form-container {
            background: #e1f5fe;
            padding: 20px;
            border-bottom: 2px solid #6a11cb;
        }
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        form label {
            font-size: 14px;
            color: #444;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        form input[type="text"],
        form input[type="date"],
        form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
            transition: 0.3s ease;
        }
        input:focus, select:focus {
            border-color: #6a11cb;
        }
        .button-group {
            grid-column: span 2;
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .button-group button, .button-group a {
            flex: 1;
            background: #6a11cb;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .button-group button:hover, .button-group a:hover {
            background: #2575fc;
        }

        /* Tracker Info Sections */
        #show-values {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background: #fff;
        }
        .box {
            flex: 1;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 0 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .box h2 {
            font-size: 20px;
            color: #6a11cb;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .box-expense ul, .box-income ul {
            list-style: none;
            padding: 0;
            max-height: 200px;
            overflow-y: auto;
        }
        .box-calculate {
            border: 2px solid #6a11cb;
        }
        #total {
            font-size: 26px;
            font-weight: bold;
            color: #2575fc;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="fas fa-chart-line"></i> Cash Tracker</h1>
        <p>Manage your expenses and income with ease</p>
        <form action="logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    <div class="form-container">
        <form action="insert.php" method="POST" id="expense-form">
            <label>
                <i class="fas fa-file-alt"></i> Description:
                <input type="text" name="description" id="description" placeholder="Enter Description" required>
            </label>
            <label>
                <i class="fas fa-calendar-alt"></i> Date:
                <input type="date" name="date" id="date" required>
            </label>
            <label>
                <i class="fas fa-dollar-sign"></i> Amount:
                <input type="number" name="amount" id="amount" placeholder="Enter Amount" required step="0.01" min="0" title="Please enter a valid decimal amount (e.g., 78.12)">
            </label>            
            <label>
                <i class="fas fa-tags"></i> Type:
                <select name="type" id="type">
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
            </label>
            <div class="button-group">
                <button type="button" id="btn-add"><i class="fas fa-plus-circle"></i> Add</button>
                <button type="submit"><i class="fas fa-database"></i> Save to Database</button>
                <a href="fetch.php"><i class="fas fa-eye"></i> View Transactions</a>
            </div>
        </form>
    </div>

    <div id="show-values">
        <div class="box box-expense">
            <h2><i class="fas fa-arrow-circle-down"></i>Expense</h2>
            <button class="btn" id="btn-clear-expense" style="display: none;">
                <i class="fas fa-trash"></i> Clear All
            </button>
            <ul id="expense-list"></ul>
        </div>

        <div class="box box-income">
            <h2><i class="fas fa-arrow-circle-up"></i>Income</h2>
            <button class="btn" id="btn-clear-income" style="display: none;">
                <i class="fas fa-trash"></i> Clear All
            </button>
            <ul id="income-list"></ul>
        </div>

        <div class="box box-calculate">
            <h2><i class="fas fa-calculator"></i>Total Net</h2>
            <span id="total">0.00</span>
        </div>
    </div>
</div>

<script>
    document.getElementById('expense-form').addEventListener('submit', function() {
        const type = document.getElementById('type').value;
        const descriptionInput = document.getElementById('description');
        descriptionInput.value += ' ' + type; // Append the type to the description
    });
</script>
<script src="script1.js"></script>
</body>
</html>
