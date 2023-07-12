<?php
session_start();
include('connect.php');

if (isset($_POST['btnLogin'])) {
  $txtEmail = $_POST['txtEmail'];
  $txtPassword = $_POST['txtPassword'];

  $checkAccount = "SELECT *
                   FROM admin a
                   WHERE a.A_UserName='$txtEmail' AND a.A_Password='$txtPassword'
                   AND a.Admin_ID= a.Admin_ID
                   ";

  $result = mysqli_query($connection, $checkAccount);
  $count = mysqli_num_rows($result);
  $arr = mysqli_fetch_array($result);

  if ($count < 1) {
    echo "<script>window.alert('Wrong Admin Email or Password')</script>";
    echo "<script>window.location='adminlogin.php'</script>";
  } else {
    $_SESSION['Admin_ID'] = $arr['Admin_ID'];
    $_SESSION['A_UserName'] = $arr['A_UserName'];
    $_SESSION['A_Password'] = $arr['A_Password'];

    echo "<script>window.alert('Admin Login Success.')</script>";
    echo "<script>window.location='adminacc.php'</script>";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    form {
      border: 3px solid #f1f1f1;
    }

    body {
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }

    header {

      display: flex;
      justify-content: center;
    }

    header .img-logo {
      margin-top: 30px;
      width: 180px;
      height: 180px;
      margin-bottom: 25px;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
      border-radius: .5rem;
      padding: 1.2rem 1.4rem;

    }

    .button {
      background-color: #4354A5;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }

    .button:hover {
      background-color: #7984B6;
    }

    .form-container {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;

    }

    .form-container form {
      padding-top: 2rem;
      padding-bottom: 3rem;
      padding-right: 5rem;
      padding-left: 5rem;
      width: 50rem;
      background: rgba(255, 255, 255, 1);
      opacity: 95%;
      border-radius: 0.5rem;
    }

    h3 {
      text-align: center;

    }

    h4 {
      text-align: center;
    }

    span.forgetpsww {
      float: right;
      color: rgba(28, 0, 200, 0.91);
      font-size: 15px;

    }

    .toggleeye {
      margin-left: -30px;
    }
  </style>
</head>

<body background="Images/bg.jpg">
  <header>
    <img class="img-logo" src="images/logo.png" alt="My Logo">
  </header>
  <div class="form-container">
    <form action="Login.php" method="POST">
      <h3>Hello! Welcome Back Admin.</h3>
      <div class=container>
        <label><b>Admin Username</b></label>
        <input type="text" name="txtEmail" placeholder="Username" required />
        <label for="txtpassword"><b>Password</b></label>
        <input type="password" name="txtPassword" placeholder="Password" required id="id_password">
        <span class="toggleeye"><i class="fa fa-eye" id="togglePassword"></i></span>
      </div>
      <td></td>
      <td><input type="submit" name="btnLogin" value="Login" class="button"></td>
    </form>
  </div>
</body>


</html>