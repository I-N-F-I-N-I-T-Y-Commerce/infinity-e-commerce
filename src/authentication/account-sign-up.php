<?php

include("../database/INFINITY/connection.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        // Decode the JSON data
        $formData = json_decode($_POST['formData'], true);
        
        // Now you can access the form data
        $firstName = $formData['firstName'];
        $lastName = $formData['lastName'];
        $contactNum = $formData['contactNum'];
        $locationAddress = $formData['locationAddress'];
        $userName = $formData['userName'];
        $email = $formData['email'];
        $password = password_hash($formData['password'], PASSWORD_DEFAULT);

        // Use the data as needed, e.g., insert into database, etc.
        // echo "<h1 style='color:white'>Hello $firstName $lastName $password</h1>";
    }

    $sql = "INSERT INTO account (username, user_password, user_email) VALUES ('$userName', '$password', '$email')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ./account-sign-in.php");
        exit(); // Make sure to stop further script execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFINITY 👟 Sign Up 👑</title>
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="./authentication.css">

    <script src="./script.js" defer></script>
</head>
<body>
    <div class="sign-up-form-container">
        <div class="form-container sign-up" id="sign-up-form">

            <h1>Sign Up for your Account.</h1>
            <h3>Already have an account??? <a href="./account-sign-in.php" class="highlight1">Sign In</a></h3>
    
            <!-- * Put the php file here in ` action ` attribute -->
            <form action="./account-sign-up.php" method="POST">
                <div class="terms-image-container">
                    <img src="../src/public/IMG-TERMS-0001.png" alt="">
                    <div class="circle-shoe-highlight1"></div>
                    <div class="circle-shoe-highlight2"></div>
                </div>  
                <label for="submit" id="terms-conditions">
                    To Proceed, please accept our <span class="highlight-terms"> Terms and Conditions. </span><br>

                    <br>
                    Its Important that you read and understand then before continuing to buy our Products
                </label>

                <!-- <p id="notify-confirm-password">OwO</p> -->
                <input type="submit" value="Submit" name="submit">
            </form>

            <hr>

            <div class="progress-bar">
                <div class="checkpoint1 done"></div>
                <hr class="done-progress">
                <p id="personal" class="done-on-step">Personal</p>

                <div class="checkpoint2 done"></div>
                <hr class="done-progress">
                <p id="account" class="done-on-step">Account</p>

                <div class="checkpoint3 on-progress"></div>
                <p id="submit" class="on-progress-step">Submit</p>
            </div>
           
        </div>
        <div class="image-banner">
            <img src="../public/IMG-BANNER-SIGNIN-0001.jpg" alt="">
            <div class="logo-name-container">
                <h1>INFINITY</h1>
                <div class="third-circle"></div>
            </div>
            <h1 class="tagline">DREAM</h1>
            <h3>IN STEPS</h3>
        </div>

        
    </div>
</body>
</html>