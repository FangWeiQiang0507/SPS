<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numberplate Search</title>
    <style>
        body {
            text-align: center; /* Center-align the content within the body */
            margin: 0; /* Remove default margin to center the form more effectively */
            padding: 20px; /* Add some padding for better visual appearance */
        }

        form {
            display: inline-block; /* Display the form as an inline block */
            text-align: left; /* Left-align the form elements within the form */
        }

        label {
            display: block; /* Make the labels block-level elements for better spacing */
            margin-bottom: 8px; /* Add margin below labels for spacing */
        }

        input,
        button {
            margin-bottom: 16px; /* Add margin below input fields and button for spacing */
        }
    </style>
    <title>Centered Form</title>
</head>
<body>

    <h2>Please Search Your Number Plate of Vehicle for Making Payment</h2>

    <form method="post" action="">
        <label for="numberplate">Enter Numberplate:</label>
        <input type="text" name="numberplate" id="numberplate" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php
    // Check if the form is submitted
    if (isset($_POST['search'])) {
        // Get the entered numberplate
        $search_numberplate = $_POST['numberplate'];

        // Database connection parameters
        // include("connectionA.php"); or 
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
        $sql = "SELECT * FROM intime WHERE numberplate = '$search_numberplate'";
        $result = $conn->query($sql);

        // Display the results
        if ($result->num_rows > 0) {
            session_start();
            while ($row = $result->fetch_assoc()) {
                // Assuming you want to store the numberplate in a variable
                $numberplate = $row['numberplate'];
            
                // Process the numberplate or store it in a session or database
                // For example, you can store it in a session variable
                $_SESSION['numberplate'] = $numberplate;
            
                // Redirect to another PHP file
                header("Location: data.php");
                exit(); // Ensure that no further code is executed after the redirection
            }
        } else {
            echo "<p>No matching records found.</p>";
        }

        // Close connection
        $conn->close();
    }
    ?>

    <div>
        <br>
        <p style="text-align:center;">For reservations, click <a href="reservation.php">here</a>.</p>
        <h3>Parking Rates:</h3>
        <p>First hour or part thereof: RM2.00</p>
        <p>Every subsequent hour or part thereof: RM1.00</p>
        <p>Maximum per day: RM 10.00</p>
    </div>

    <div class="button-container">
        <form action="index.php">
            <button type="submit">Back to Home</button>
        </form>
    </div>

</body>
</html>