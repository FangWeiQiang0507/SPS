<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            flex-direction: column;
        }

        .message {
            margin-bottom: 10px;
        }

        .button-container {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <?php
    session_start();
    include("connectionA.php");
    include("functions.php");

    // Set the timezone to UTC+8 (Asia/Kuala_Lumpur)
    date_default_timezone_set('Asia/Kuala_Lumpur');

    if (isset($_SESSION['numberplate'])) {
        $numberplate = $_SESSION['numberplate'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the current date and time
        $outdate = date('Y-m-d');
        $outtime = date('H:i:s');

        // Calculate total fee
        $sql = "SELECT date, time FROM intime WHERE numberplate = '$numberplate'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $indate = $row['date'];
            $intime = $row['time'];

            $totalFee = calculateParkingFee($indate, $intime, $outdate, $outtime);

            // Update payment in database
            $update_sql = "UPDATE intime SET fee = $totalFee WHERE numberplate = '$numberplate'";
            if ($conn->query($update_sql) === TRUE) {
                echo "<div class='message'>Payment updated successfully.</div>";
            } else {
                echo "Error updating payment: " . $conn->error;
            }
        }
    } else {
        echo "Numberplate not found in session.";
    }
    $conn->close();
    ?>
    <br>
    <div class="button-container">
        <button onclick="window.location.href = 'index.php';">Back to Home</button>
    </div>
</body>
</html>