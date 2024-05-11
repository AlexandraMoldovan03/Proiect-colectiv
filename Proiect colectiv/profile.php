<?php
require "functions.php";
//check_login();
$isLogged = isset($_SESSION['email_verified']);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" >

    <title>Booking System</title>
    
   
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 
        </head>

    

    <body>

  


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #2ec1ac;
            padding: 10px;
            color: white;
        }

        .navbar-brand {
            color: black;
        }

        h1 {
            color: #2ec1ac;
            margin: 20px 0;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #2ec1ac;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <title>Profile</title>
</head>
<body>


<h1>Profile</h1>

<?php if(check_login(false)): ?>
    Hi, <?=$_SESSION['USER']->username;?>;

    <br><br>

    <?php if(check_verified()): ?>
        <!-- Display user bookings -->
        <?php
        $connect = mysqli_connect('localhost', 'root', '', 'tennis');
        if (!$connect) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $bookingsQuery = "SELECT name, email, date, timeslot FROM bookings WHERE email = ?";
        $stmtBookings = mysqli_prepare($connect, $bookingsQuery);
        mysqli_stmt_bind_param($stmtBookings, "s", $_SESSION['USER']->email);
        mysqli_stmt_execute($stmtBookings);
        $bookingsResult = mysqli_stmt_get_result($stmtBookings);
        ?>

        <?php if ($bookingsResult && mysqli_num_rows($bookingsResult) > 0): ?>
            <div class="table-container">
                <p>Your bookings:</p>
                <table>
                    <tr><th>Name</th><th>Email</th><th>Date</th><th>Timeslot</th></tr>

                    <?php while ($record = mysqli_fetch_assoc($bookingsResult)): ?>
                        <tr>
                            <td><?= $record['name']; ?></td>
                            <td><?= $record['email']; ?></td>
                            <td><?= $record['date']; ?></td>
                            <td><?= $record['timeslot']; ?></td>
                        </tr>
                    <?php endwhile; ?>

                </table>
            </div>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>

        <?php mysqli_free_result($bookingsResult); ?>

    <?php else: ?>
        <a href="verify.php">
            <button>Verify Profile</button>
        </a>
    <?php endif; ?>

<?php endif; ?>
<br><br><br>
</body>
</html>
