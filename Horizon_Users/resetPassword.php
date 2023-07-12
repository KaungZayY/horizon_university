<?php
session_start();
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the new password from the form
  $new_password = $_POST['new_password'];
  
  // Get the token from the password reset link
  $token = $_GET['token'];

  // Check if the token exists in the database
  $stmt = $connect->prepare('SELECT * FROM password_reset WHERE token = ? AND expire_time >= NOW()');
  $stmt->bind_param('s', $token);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($row) {
    // If the token exists and hasn't expired, update the password for the user

    // Update the password for the user
    $stmt = $connect->prepare('UPDATE users SET User_Password = ? WHERE User_Email = ?');
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $email = $row['email'];
    $stmt->bind_param('ss', $password_hash, $email);
    $stmt->execute();

    // Delete the password reset token from the database
    $stmt = $connect->prepare('DELETE FROM password_reset WHERE token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();

    // Display a success message
    //$_SESSION['message'] = 'Your password has been reset.';
    echo "<script>alert(' Your Password has been rest, Login Again')
            window.location='login.php'
            </script>";
    exit;
  } else {
    // If the token doesn't exist or has expired, display an error message
    $_SESSION['error'] = 'Invalid or expired token.';
    header('Location: forgotPassword.php');
    exit;
  }
}
?>


<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Your Password</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon"/>

   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
  <style>

 @import url('https://fonts.cdnfonts.com/css/sf-pro-display');
body{
   background-attachment: fixed;
   background-repeat: no-repeat;
   background-size: cover;
 font-family: 'SF Pro Display', sans-serif;
}


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
}

.form-container form h3{
   font-size: 1.5rem;
   margin-bottom: 1rem;
   text-transform: uppercase;
   text-decoration: underline;
   background-color: white;
   text-align: center;
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
    font-size: 1rem;
    text-align: left;
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
?>
<div class="form-container">
<form action="<?php echo $_SERVER['PHP_SELF'].'?token='.$_GET['token']; ?>" method="POST">
  <h3>Reset Your Password</h3>
        <label for="txtuname"><b>New Password</b></label>
        <input type="password" name="new_password" placeholder="Enter Your New Password" required class="box" required>
        <input type="submit" name="btnSave" value="Reset Password" class="button">
</form>
</body>
</html>
