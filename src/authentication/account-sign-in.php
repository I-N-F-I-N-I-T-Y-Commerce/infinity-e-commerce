<?php
include("C:/Users/Vince/Github-Haimonmon/infinity-e-commerce/src/database/INFINITY/connection.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['email'];
    $pass = $_POST["password"];

    $sql = $conn->prepare("SELECT username, user_password, account_id FROM account WHERE username = ?");
    $sql->bind_param("s", $name);
    $sql->execute();
    $result = $sql->get_result();
    

    if ($result->num_rows > 0) {
    
        $row = $result->fetch_assoc();
        $userName = $row['username'];
        $user_pass = $row['user_password'];
        $account_id = $row['account_id'];

        if (password_verify($pass, $user_pass)) {
        
            $_SESSION['username'] = $userName;
            $_SESSION['account_id'] = $account_id;

            header("Location: ../home/index.php");
            exit(); 
        } else {
            echo "<h1 style='color:white'>Incorrect Password</h1>";
        }
    } 
    
    $sql->close();
    $conn->close();
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFINITY 👟 Sign in 👑</title>
    <link rel="stylesheet" href="../global.css">
    <link rel="stylesheet" href="./authentication.css">
</head>
<body>
    <div class="sign-in-form-container">
        <div class="form-container sign-in">
            <label for="notify-message" id="notify-email"></label><br>
            <label for="notify-message" id="notify-password"></label><br>

            <h1>Step in to your Account</h1>
            <h3>Welcome to <span class="highlight1">INFINITY</span></h3>
    
            <!-- * Put the php file here in ` action ` attribute -->
            <form action="" method="POST">
                <label for="email">Email</label><br>
                <input type="text"  class="correct" autocomplete="email" name="email"><br>
                
                <label for="password" id="password">Password</label><br>
                <input type="password" class="correct" name="password" autocomplete="current-password" id="password-input"><br>
                <img src="../public/ICON-HIDE-VIEW-0004.png" id="hide-password" alt="">
                <div class="checkbox-container">
                    <div class="checkbox"></div>
                    <p>Remember Me</p>
                </div>

                <input type="submit" value="Log In">
            </form>

            <div class="sign-up-container">
                <hr>
                <div class="other-accounts-container">
                    <div class="google-acc-btn">
                        <img src="../public/ICON-GOOGLE-0002.png" alt="">
                        <p>Google</p>
                    </div>
                    <p>or</p>
                    <div class="facebook-acc-btn">
                        <img src="../public/ICON-FACEBOOK-0001.png" alt="">
                        <p>Facebook</p>
                    </div>
                </div>
                <p>Dont have an account yet? <a href="./account-sign-up.php"> Create Account</a></p>
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

    <script>
        const hideButton = document.getElementById('hide-password')
        const passwordInput = document.getElementById('password-input')

        hideButton.addEventListener('click', () => {
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text'
                hideButton.src = '../public/ICON-SHOW-VIEW-0003.png'
                passwordInput.classList.remove('correct')
                passwordInput.classList.add('wrong')
            } else {
                passwordInput.type = 'password'
                hideButton.src = '../public/ICON-HIDE-VIEW-0004.png'
                passwordInput.classList.remove('wrong')
                passwordInput.classList.add('correct')
            }
        })
    </script>
</body>
</html>