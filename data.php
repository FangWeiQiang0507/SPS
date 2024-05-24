<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 20%; /* Adjust the width as needed */
            margin-top: 20px; /* Add some margin at the top for spacing */
        }

        .button-container form {
            flex: 1;
        }

        table {
            margin-top: 20px; /* Add margin at the top of the table for spacing */
        }
    </style>
</head>
<body>

    <h1>Payment Page</h1>

    <?php
    session_start();
    include("functions.php"); // include calculateParkingFee function from functions.php
    
    // Set the timezone to UTC+8 (Asia/Kuala_Lumpur)
    date_default_timezone_set('Asia/Kuala_Lumpur');

    // Check if the numberplate is set in the session
    if (isset($_SESSION['numberplate'])) {
        $numberplate = $_SESSION['numberplate'];

        // Database connection parameters
        // include("connectionA.php");
        // Database connection parameters
        $servername = "localhost";
        $username = "admin";
        $password = "168168";
        $dbname = "numplate";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to retrieve data based on the entered numberplate
        $sql = "SELECT date, time FROM intime WHERE numberplate = '$numberplate'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display the results
            echo "<h3>Search Results:</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Numberplate</th><th>Date</th><th>Time</th><th>Payment</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $indate = $row['date'];
                $intime = $row['time'];

                // Get the current date and time
                $outdate = date('Y-m-d');
                $outtime = date('H:i:s');

                $totalFee = calculateParkingFee($indate, $intime, $outdate, $outtime);

                echo "<tr>";
                echo "<td>" . $numberplate . "</td>"; // Use $numberplate here
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>" . $totalFee . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            // Add JavaScript confirmation prompt here
            echo "<script>
                    function makePayment() {
                        var confirmed = confirm('You are directed to make payment. Do you want to proceed?');
                        if (confirmed) {
                            window.location.href = 'update_payment.php'; // Redirect to update_payment.php
                        }
                    }
                  </script>";
        } 
        else{
            echo "<p>No matching records found.</p>";
        }

        // Close connection
        $conn->close();
    } else {
        // Handle the case when the numberplate is not set in the session
        echo "Numberplate not found in session.";
        exit(); // Optionally exit the script or redirect to an error page
    }
    ?>


    <div>
        <h3>Parking Rates:</h3>
        <p>First hour or part thereof: RM2.00</p>
        <p>Every subsequent hour or part thereof: RM1.00</p>
        <p>Overnight and Maximum per day: RM 10.00</p>
    </div>

    <div class="button-container">
        <form action="index.php">
            <button type="submit">Back to Home</button>
        </form>

        <!-- Call makePayment function when the button is clicked -->
        <button onclick='makePayment()'>Make Payment</button>
    </div>

</body>
</html>