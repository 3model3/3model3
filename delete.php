<?php
require_once('db.php');

// Check if the form was submitted and 'description' is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['description'])) {
    $description = $_POST['description'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM transactions WHERE description = ?");
    $stmt->bind_param("s", $description);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the fetch.php page with a success message
        header("Location: fetch.php?message=Record+deleted+successfully");
    } else {
        // Redirect back with an error message
        header("Location: fetch.php?message=Error+deleting+record: " . $stmt->error);
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect back if no description was provided
    header("Location: fetch.php?message=No+description+provided");
}

// Close the database connection
$conn->close();
?>
