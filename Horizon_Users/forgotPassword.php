<?php 
session_start();
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the email address from the form
  $email = $_POST['email'];

  // Check if the email address exists in the database in the users table
  $stmt = $connect->prepare('SELECT * FROM users WHERE User_Email = ?');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  // If the email address exists in the users table, generate a random token and store it in the database
  if ($user) {
    $token = bin2hex(random_bytes(32));
    $expire_time = date('Y-m-d H:i:s', strtotime('+9 hour')); // Token expires in 1 hour
    $stmt = $connect->prepare('INSERT INTO password_reset (email, token, expire_time) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $email, $token, $expire_time);
    $stmt->execute();

    // Send an email to the user's email address with a link that includes the token as a parameter
    $reset_link = 'http://localhost/horizon_university/Horizon_Users/resetPassword.php?token=' . $token;//*******need to update this*******
    $to = $email;
    $subject = 'Password Reset';
    $message = "To reset your password, please click on this link:\n\n$reset_link";
    $headers = 'From: webmaster@example.com' . "\r\n" .
               'Reply-To: webmaster@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    ini_set('smtp_port', 1025);
    ini_set('smtp_host', 'localhost');

    mail($to, $subject, $message, $headers);

    // Display a success message
    //$_SESSION['message'] = 'An email has been sent to your email address with instructions to reset your password.';
    echo "<script>alert('Email Sent, Rest Your Password')
            window.location='login.php'
            </script>";

    exit;
  } else {
    // If the email address doesn't exist in the users table, display an error message
    echo "<script>alert('Email not Found')
            window.location='forgotPassword.php'
            </script>";
  }
}

 ?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forget Password?</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>

   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
  <style>

 @import url('https://fonts.cdnfonts.com/css/sf-pro-display');
body{
   background-attachment: fixed;
   background-repeat: no-repeat;
   background-size: cover;
}

 font-family: 'SF Pro Display', sans-serif;

section{
   padding:3rem 2rem;
}



form {border: 3px solid #f1f1f1;}

header{
   
   display: flex;
   justify-content: center;  
}

header .img-logo{
   margin-top: 30px;
   width: 200px;
   height: 200px;
   margin-bottom: 25px;
}


.form-container{
  
   display: flex;
   align-items: center;
   justify-content: center;
   padding:2rem;

}

.form-container form{
   padding-top: 2rem;
   padding-bottom: 3rem;
   padding-right: 5rem;
   padding-left: 5rem;
   width: 50rem;
   background: rgba(255,255,255,1);
   opacity: 95%;
   border-radius: 0.5rem;
   text-align: center;
}

.form-container form h3{
   font-size: 1.5rem;
   margin-bottom: 1rem;
   text-transform: uppercase;
   text-decoration: underline;
   background-color: white;
}


.form-container form .box{
    width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   


}

.form-container form label{
    font-size: 1.3rem;
}



.button {
  background-color: #4354A5;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  text-align: center;
}

.button:hover {
  background-color: #7984B6;
}

.button{
   background-color: #2541bc;
}


   </style>

</head>

<body background="images/bg.jpg">
  <header>
        <img class="img-logo"src="images/logo.png" alt="My Logo">
  </header>
   <?php
  // Display error message if there is one
  if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
  }

  // Display success message if there is one
  if (isset($_SESSION['message'])) {
    echo '<p style="color: green;">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
  }
  ?>
  <div class="form-container">
    <form action="forgotPassword.php" method="POST">
    <h3>Enter Your Information!</h3>
        
        <input type="text" name = "email" placeholder="Please Enter Your Email" required class="box">
        <div class="smalllabel">We will send a link to your E-mail to reset your password.</div>
        <input type="submit" name="btnSave" value="Reset" class="button">    
        <input type="reset" value="Cancel" class="button" />
  </form>
</body>
</html>
