<?php 
include('connection.php');
session_start();
if(isset($_SESSION['User_ID'])){
    $User_ID = $_SESSION['User_ID'];

    $select = "SELECT * FROM users WHERE User_ID = ?";
    $stmt = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($stmt, "s", $User_ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_array($result);
    
    $User_ID = $data['User_ID'];
    $User_Name = $data['User_Name'];
    $User_Email = $data['User_Email'];
    $DOB = $data['DOB'];
    $PhoneNumber = $data['PhoneNumber'];
    $Address = $data['Address'];
    $Photo = $data['Photo'];
    if (empty($Photo)) {
    $Photo="userPhoto/default_profile.png";
    }


    if(isset($_POST['btnUpdate'])){

        // Check if a new image is uploaded

        $User_ID = $_POST['txtUserID'];
        $User_Name = $_POST['txtUserName'];
        $User_Email = $_POST['txtUserEmail'];
        $DOB = $_POST['txtDOB'];
        $PhoneNumber = $_POST['txtPhoneNumber'];
        $Address = $_POST['txtAddress'];

        $update = "UPDATE users SET User_Name=?, User_Email=?, DOB=?, PhoneNumber=?, Address=? WHERE User_ID=?";
        $stmt = mysqli_prepare($connect, $update);
        mysqli_stmt_bind_param($stmt, "sssssi", $User_Name, $User_Email, $DOB, $PhoneNumber, $Address, $User_ID);
        $query1=mysqli_stmt_execute($stmt);
        if (!$query1) {
            echo "<script>alert(' Update UnSuccessful, Try Again')
            window.location='QA_Manager_Update.php'
            </script>";
        }
        else{
            echo "<script>alert(' Update Successful, Login Again')
            window.location='logout.php'
            </script>";
        }
    }
}

else{
    echo "<script>window.alert('Login First')</script>";
    echo "<script>window.location='Login.php'</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Account</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="css/style2.css">
   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">

   <style>
      p {
         color: #595F6C;
      }

      @media screen and (max-width: 415px) {
         .search {
            float: none;
         }

         .form-container {
            padding: 2rem;
         }

      }

      @media (max-width: 944px) {
         .container>div {
            flex-basis: 100%;
         }
      }
   </style>

</head>

<body>
<form action="update.php" method="POST">
   <div class="form-container">
      <div class="form">
         <div class="container"><label>Horizon University</label>
            <div class="dropdown" style="float: right; margin-left: 18px; margin-top: 1px; ">
               <img src="<?php echo $Photo ?>" alt="smallimage" class="smallimage" id="dropdown_img"
                  style="width: 30px;border-radius: 50%; border: 1px solid #ccc;">
               <div class="dropdown-content">
                  <a href="Logout.php">Log out</a>
               </div>
            </div>
         </div>
         <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="mywall.php">My Wall</a></li>
            <li><a class="active" href="account.php">My Account</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="topics.php">Topics</a></li>
         </ul>
         <div class="header">
            <h3>Account & Profile</h3>
            <p>This information will be displayed so be careful what you share!</p>

            <div class="container1">
               <div class="profile-pic">
                  <img src="<?php echo $Photo ?>" alt="Profile Picture" class="profile">
                  <div class="username">Username</div>
               </div>
               <div>
                <input type="hidden" value ="<?php echo $User_ID?>" name="txtUserID"/>
                <label for="first-name">Name</label> <br>
                <input type="text" id="first-name" name="txtUserName" required  class="box" value="<?php echo $User_Name ?>"> <br>
                <label for="email">Email</label> <br>
                <input type="email" id="email" name="txtUserEmail" required  class="box" value="<?php echo $User_Email ?>"> <br>
            </div>
            <div>
                <label for="dob">Birthday</label> <br>
                <input type="date" id="dob" name="txtDOB" required  class="box" value="<?php echo $DOB ?>"> <br>
                <label for="phonenumber">Phone Number</label> <br>
                <input type="text" id="phonenumber" name="txtPhoneNumber" required  class="box" value="<?php echo $PhoneNumber ?>"> <br>
                <label for="address">Address</label> <br>
                <input type="text" id="address" name="txtAddress" required  class="box" value="<?php echo $Address ?>"> <br>
               </div>
            </div>

            <div class="button-container">
                 <button class="update-button" type="submit" name="btnUpdate" value="Update">Update</button>
                 <button class="cancel-button" type="reset">Cancel</button>
               </div>

   </form>

   </div>
</body>
</html>