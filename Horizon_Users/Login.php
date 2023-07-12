<?php
session_start(); 
include('connection.php');

if (isset($_POST['btnLogin'])) {
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPassword'];
    
    // Create a prepared statement
    $select = "SELECT * FROM users WHERE User_Email=?";
    $stmt = mysqli_prepare($connect, $select);
    
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $email);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    
    // Store the result
    $res = mysqli_stmt_get_result($stmt);
    
    // Count the number of rows returned
    $count = mysqli_num_rows($res);
    
    if($count == 1) {
        // Fetch the data row
        $data_row = mysqli_fetch_array($res);
        
        // Verify password
        if (password_verify($password, $data_row['User_Password'])) {
            $_SESSION['User_ID']=$data_row['User_ID'];
            $_SESSION['Role_ID']=$data_row['Role_ID'];
            $_SESSION['Department_ID']=$data_row['Department_ID'];
            echo "<script>window.alert('Login Successful')</script>";
            echo "<script>window.location='home.php'</script>";
        } else {
            echo "<script>window.alert('Invalid Password')</script>";
            echo "<script>window.location='Login.php'</script>";
        }
    } else {
        echo "<script>window.alert('Invalid Email')</script>";
        echo "<script>window.location='Login.php'</script>";
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
    form {border: 3px solid #f1f1f1;}
body{
   background-attachment: fixed;
   background-repeat: no-repeat;
   background-size: cover;
}

header{
   
   display: flex;
   justify-content: center;  
}

header .img-logo{
   margin-top: 30px;
   width: 180px;
   height: 180px;
   margin-bottom: 25px;
}


input[type=email], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
   border-radius: .5rem;
   padding:1.2rem 1.4rem;
   
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

h3{
    text-align: center;

}

h4{
    text-align: center;
}



span.forgetpsww {
  float: right;
color: rgba(28, 0, 200, 0.91);
  font-size: 15px;

}

.toggleeye{
    margin-left: -30px;
}




</style>
 

</head>


<body background="Images/bg.jpg">
<header>
    
    
        
        <img class="img-logo"src="images/logo.png" alt="My Logo">
       
   </header>
   <div class="form-container">

        <form action="login.php" method="POST">
            <h3>Hello! Welcome Back.</h3>
            <h4>Log in with your data that you entered during Your Registration.</h4>


            <div class=container>
                <label for="txtuname"><b>UserEmail</b></label>
                
                <input type="email" name="txtEmail" placeholder="example@email.com" required>

                <label for="txtpassword"><b>Password</b></label>
                    <span class="forgetpsww"><a href="forgotPassword.php">Forget Password?</a></span>
                <input type="password" name="txtPassword"  placeholder="Enter Your Password!" required id="id_password">
                <span class="toggleeye"><i class="fa fa-eye" id="togglePassword"></i></span></div>
                    
            <td></td>
      <td><input type="submit" name="btnLogin" value="Start Now" class="button"></td>
      
                
    </form></div></body>


</html>


