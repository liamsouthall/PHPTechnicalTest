<!DOCTYPE html>
<html>
<head>
    <title>Business Comparison Technical Test</title>
    <script type="text/javascript" src="src/js/app.js"></script>
    <link rel="stylesheet" type="text/css" href="src/scss/style.css">
</head>
    <div>Your details have been succesfully added</div>

    <button onclick="window.location.href = 'index.php';">Return to form page</button>
<body>
    <?php
    
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'formData');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $sql = "SELECT firstName, lastName, email FROM Registration";
    $result = $conn->query($sql);

    // Display form data in HTML table
    if ($result->num_rows > 0) {
        echo "<table><tr><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["firstName"] . "</td><td>" . $row["lastName"] . "</td><td>" . $row["email"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No form data found.";
    }

    $conn->close();

    
    ?>
    
</body>
</html>