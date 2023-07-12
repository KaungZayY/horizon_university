<?php
include("connect.php");
include("AutoIDFunction.php");
if (!isset($_SESSION['Admin_ID'])) {
  echo "<script>window.alert('Please Login First to Continue.')</script>";
  echo "<script>window.location='Login.php'</script>";
}
if (isset($_POST['btnSave'])) {
  $txtDepartmentID = $_POST['txtDepartmentID'];
  $txtDepartmentName = $_POST['txtDepartmentName'];

  $selectQuery = "SELECT * FROM departments WHERE Department_name = ?";
  $selectStmt = mysqli_prepare($connection, $selectQuery);
  mysqli_stmt_bind_param($selectStmt, 's', $txtDepartmentName);
  mysqli_stmt_execute($selectStmt);
  $result = mysqli_stmt_get_result($selectStmt);
  if (mysqli_num_rows($result) > 0) {
    echo "<script>window.alert('Department Already Exists')</script>";
    echo "<script>window.location='AddDepartment.php'</script>";
  } else {
    $Insert = "INSERT INTO `departments`
                (`Department_ID`, `Department_Name`) 
                VALUES 
                ('$txtDepartmentID','$txtDepartmentName')";
    $ret = mysqli_query($connection, $Insert);
  }

  if ($ret) {
    echo "<script>window.alert('Success!')</script>";
    echo "<script>window.location='admindep.php'</script>";
  } else {
    echo "<p>Something went wrong" . mysql_error($connection) . "</p>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title> Add Department </title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* CSS */
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
  <div class="container">
    <h1>Add Department</h1>
    <div class="inputContainer">
      <form action="AddDepartment.php" method="post">
        <p>Department Name</p>
        <input type="hidden" name="txtDepartmentID" readonly
          value="<?php echo AutoID('departments', 'Department_ID', 'D-', 6) ?>">
        <input type="text" name="txtDepartmentName" required class="box" placeholder="Finance">
    </div>
    <section>
      <input type="submit" name="btnSave" class="button-59" role="button" value="Save" />
      <input type="reset" value="Cancel" class="button-59" role="button" />
    </section>
    <a href="admindep.php" class="buttonb">Back To Departments Page</a>
    </form>

  </div>
</body>

</html>