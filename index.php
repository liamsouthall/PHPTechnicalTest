<?php

?>

<!DOCTYPE html>
<html>
<head>
    <title>Business Comparison Technical Test</title>
    <script type="text/javascript" src="src/js/app.js"></script>
    <link rel="stylesheet" type="text/css" href="src/scss/style.css">
</head>

<body>
    <h1>Registration Form</h1>
        <form id="registrationForm" action="processform.php" method="POST" enctype="multipart/form-data">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="firstName">

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email">

            <label for="emailConfirmation">Confirm Email:</label>
            <input type="email" name="emailConfirmation" id="emailConfirmation">

            <label for="profilePicture">Profile Picture:</label>
            <input type="file" name="profilePicture" id="profilePicture">

            <label for="acceptTerms">Accept Terms and Conditions:</label>
            <input type="checkbox" name="acceptTerms" id="acceptTerms">

            <button type="submit" name="btnSubmit">Submit</button>
        </form>
  </body>
</html>