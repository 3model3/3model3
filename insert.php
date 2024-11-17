<?php
// Ensure POST data is available
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$date = isset($_POST['date']) ? trim($_POST['date']) : ''; // Capture the date
$amount = isset($_POST['amount']) ? trim($_POST['amount']) : '0.00'; // Default to a valid decimal
$type = isset($_POST['type']) ? trim($_POST['type']) : ''; // Capture the type of transaction

// Combine description and date
if (!empty($date)) {
    $description .= ' ' . $date; // Append the date to the description
}

// Validate that amount is a valid decimal number
if (!empty($description) && !empty($amount) && preg_match('/^\d+(\.\d+)?$/', $amount)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "transactions";

    // Creating a connection to the named database
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    
    // Check for connection error
    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
    } else {
        $SELECT = "SELECT description FROM transactions WHERE description = ? LIMIT 1";
        $INSERT = "INSERT INTO transactions (description, amount) VALUES (?, ?)";

        // Prepare a statement for the SELECT query
        if ($stmt = $conn->prepare($SELECT)) {
            $stmt->bind_param("s", $description); // Bind the parameter correctly
            $stmt->execute();
            $stmt->bind_result($existingDescription);
            $stmt->store_result();
            $rnum = $stmt->num_rows;
            
            if ($rnum == 0) {
                $stmt->close(); // Close the SELECT statement
                
                // Prepare and execute the INSERT statement
                if ($stmt = $conn->prepare($INSERT)) {
                    // Bind description as string, amount as double (decimal)
                    $stmt->bind_param("sd", $description, $amount); 
                    $stmt->execute();
                    echo "Transaction inserted successfully!";
                } else {
                    echo "Error preparing the insert statement: " . $conn->error;
                }
            } else {
                echo "Transaction already exists in the system!";
            }
            $stmt->close(); // Close the SELECT statement
        } else {
            echo "Error preparing the select statement: " . $conn->error;
        }
        
        $conn->close(); // Close the database connection
    }
} else {
    echo "Field required or invalid amount format.";
    die();
}
?>
