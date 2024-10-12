<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Select a Date</h2>

        <!-- Flash Messages for Success or Error -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Date Form -->
        <form action="../process/store_date.php" method="post">
            <div class="mb-3">
                <label for="selected_date" class="form-label">Date</label>
                <input type="text" class="form-control" id="selected_date" name="selected_date" readonly>
            </div>

            <!-- Button to Add Current Date -->
            <button type="button" class="btn btn-secondary mb-3" id="add_date_btn">Add Current Date</button>

            <!-- Button to Store Date in Database -->
            <button type="submit" class="btn btn-primary">Store in Database</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // When the "Add Current Date" button is clicked
            $('#add_date_btn').click(function() {
                // Fill the text box with the current date
                $('#selected_date').val(new Date().toISOString().split('T')[0]);
            });
        });
    </script>
</body>
</html>
