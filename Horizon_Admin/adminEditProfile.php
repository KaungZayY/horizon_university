<?php
session_start();
include('connect.php');
if (!isset($_SESSION['Admin_ID'])) {
  echo "<script>window.alert('Please Login First to Continue.')</script>";
  echo "<script>window.location='Login.php'</script>";
}

if (isset($_GET['Admin_ID'])) {
  $AdminID = $_GET['Admin_ID'];

  $query = "SELECT * FROM admin WHERE Admin_ID='$AdminID' ";
  $result = mysqli_query($connection, $query);
  $arr = mysqli_fetch_array($result);
} else {
  $AdminID = "";
}

if (isset($_POST['btnUpdate'])) {
  $txtAdminID = $_POST['txtAdminID'];
  $txtAdminName = $_POST['txtAdminName'];
  $txtEmail = $_POST['txtEmail'];
  $txtPassword = $_POST['txtPassword'];

  $Update = "UPDATE admin
            SET
            A_UserName='$txtAdminName',
            A_Email='$$txtEmail',
            A_Password='$txtPassword'
            WHERE Admin_ID='A-00001'";

  $result = mysqli_query($connection, $Update);

  if ($result) {
    echo "<script>window.alert('Admin Account is Updated Successfully')</script>";
    echo "<script>window.location='adminacc.php'</script>";
  } else {
    echo "<p>Something went wrong in Admin update :" . mysqli_error($connection) . "</p>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
  <style>
    .button-59 {
      align-items: left;
      background-color: #fff;
      border: 2px solid #000;
      box-sizing: border-box;
      color: #000;
      cursor: pointer;
      display: inline-flex;
      fill: #000;
      font-family: Inter, sans-serif;
      font-size: 16px;
      font-weight: 600;
      height: 48px;
      justify-content: center;
      letter-spacing: -.8px;
      line-height: 24px;
      min-width: 140px;
      outline: 0;
      padding: 0 17px;
      text-align: center;
      text-decoration: none;
      transition: all .3s;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
    }

    .button-59:focus {
      color: #171e29;
    }

    .button-59:hover {
      border-color: #06f;
      color: #06f;
      fill: #06f;
    }

    .button-59:active {
      border-color: #06f;
      color: #06f;
      fill: #06f;
    }

    @media (min-width: 768px) {
      .button-59 {
        min-width: 170px;
      }
    }

    .buttonb {
      background-color: #4354A5;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      text-align: center;
      text-decoration: none;
    }

    .buttonb:hover {
      background-color: #7984B6;
    }

    .buttonb {
      background-color: #2541bc;
    }
  </style>

</head>

<body>
  <form action="adminEditProfile.php" method="post" enctype="multipart/form-data">
    <div class="container">

      <h1>Edit Admin Profile</h1>
      <div class="inputbox">
        <div class="inputContainer">
          <p>New Name</p>
          <input type="text" name="txtAdminName" placeholder="Please enter your new name" required />
        </div>
        <div class="inputContainer">
          <p>New Email</p>
          <input type="email" name="txtEmail" placeholder="Please enter your new email" required />
        </div>
        <div class="inputContainer">
          <p>New Password</p>
          <input type="password" name="txtPassword" placeholder="Please enter your new password" required />
        </div>
      </div>
      <section>
        <input type="hidden" name="txtAdminID" value="<?php echo $arr['Admin_ID'] ?>" />
        <br>
        <input type="submit" name="btnUpdate" class="button-59" role="button" value="Update" />
        <input type="reset" name="btnClear" class="button-59" role="button" value="Clear" />
      </section>
      <a href="adminprofile.php" class="buttonb">Back To Admin Home Page</a>
    </div>
    </div>
  </form>
</body>

</html>