<?php
// Include the database configuration
require_once '../includes/db.php';

// Start the session for flash messages
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected date from the form
    $selected_date = $_POST['selected_date'];

    // Prepare a statement to check if the date already exists
    $check_stmt = $conn->prepare("SELECT * FROM dates WHERE selected_date = ?");
    $check_stmt->bind_param("s", $selected_date);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    // Check if the date exists
    if ($check_result->num_rows > 0) {
        $_SESSION['error'] = "Data already exists for this date: " . $selected_date;
    } else {
        // Prepare the SQL statement to insert the date
        $stmt = $conn->prepare("INSERT INTO dates (selected_date) VALUES (?)");

        // Bind the parameter and execute
        $stmt->bind_param("s", $selected_date);
        
        try {
            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['success'] = "Date stored successfully!";
            } else {
                $_SESSION['error'] = "An error occurred while storing the date.";
            }
        } catch (mysqli_sql_exception $e) {
            // Handle the SQL exception for duplicate entry
            if ($e->getCode() == 1062) { // Duplicate entry error code
                $_SESSION['error'] = "Data already exists for this date: " . $selected_date;
            } else {
                $_SESSION['error'] = "An error occurred: " . $e->getMessage();
            }
        }

        // Close the insert statement
        $stmt->close();
    }

    // Close the check statement and connection
    $check_stmt->close();
    $conn->close();

    // Redirect back to the form
    header("Location: ../public/index.php");
    exit();
}
?>
