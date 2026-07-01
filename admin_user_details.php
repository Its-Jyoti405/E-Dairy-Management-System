<?php
// admin_user_details.php

// Include header and config files
include 'admin_header.php';
include 'config.php';

// Check if username is provided in the URL
if (isset($_GET['username'])) {
    // Get username from the URL
    $username = $_GET['username'];

    // Fetch user details based on the username
    $select_user_query = "SELECT u.*, 
                                  o.address AS address,
                                  o.number AS mobile_number,
                                  o.placed_on AS joining_date,
                                  IFNULL(SUM(CASE WHEN o.payment_status = 'pending' THEN o.total_price ELSE 0 END), 0) AS pending_payments, 
                                  IFNULL(SUM(CASE WHEN o.payment_status = 'completed' THEN o.total_price ELSE 0 END), 0) AS completed_payments,
                                  IFNULL(SUM(CASE WHEN o.payment_status IN ('pending', 'completed') THEN o.total_price ELSE 0 END), 0) AS total_payments
                          FROM users u
                          LEFT JOIN orders o ON u.id = o.user_id
                          WHERE u.name = '$username'";
    $result = mysqli_query($conn, $select_user_query);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Include necessary stylesheets -->
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        /* CSS for user details box */
		
		 .user-details {
            text-align: center; /* Center-align the section content */
        }
		
        .details-container {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px auto; /* Center-align the box */
            max-width: 600px; /* Adjust width as needed */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .details-container p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <section class="user-details">
        <h1>User Details</h1>
        <div class="details-container">
            <p>User ID: <?php echo $user['id']; ?></p>
            <p>Username: <?php echo $user['name']; ?></p>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>User Type: <?php echo $user['user_type']; ?></p>
            <p>Joining Date: <?php echo $user['joining_date']; ?></p>
            <p>Address: <?php echo $user['address']; ?></p>
            <p>Mobile Number: <?php echo $user['mobile_number']; ?></p>
            <p>Completed Payments: <?php echo $user['completed_payments']; ?></p>
            <p>Pending Payments: <?php echo $user['pending_payments']; ?></p>
            <p>Total Payments: <?php echo $user['total_payments']; ?></p>
        </div>
    </section>
    <!-- Include necessary scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
<?php
    } else {
        // User not found, display error message or handle accordingly
        echo "User not found.";
    }
} else {
    // Username not provided in the URL, redirect back to the search page
    header("Location: admin_users_search.php");
    exit();
}
?>
