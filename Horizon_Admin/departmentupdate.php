<?php
include("connect.php");
include("AutoIDFunction.php");

if (isset($_POST['btnUpdate'])) {
  $txtDepartmentID = $_POST['txtDepartmentID'];
  $txtDepartmentName = $_POST['txtDepartmentName'];


  $Update = "UPDATE departments SET
                    Department_Name='$txtDepartmentName'
                    WHERE Department_ID='$txtDepartmentID' ";
  $ret = mysqli_query($connection, $Update);
  if ($ret) {
    echo "<script>window.alert('Department Details Updated')</script>";
    echo "<script>window.location='admindep.php'</script>";

  } else {
    echo "Error adding user: " . mysqli_error($connection);
  }
}


$Department_ID = $_REQUEST['Department_ID'];
$query = "SELECT  *
   FROM departments 
   WHERE  Department_ID='$Department_ID' ";
$ret = mysqli_query($connection, $query);
$row = mysqli_fetch_array($ret);
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
      <form action="departmentupdate.php" method="post" enctype="multipart/form-data">
        <p>Department Name</p>
        <input type="text" name="txtDepartmentName" class="box" value="<?php echo $row['Department_Name'] ?>">
    </div>
    <section>
      <input type="hidden" name="txtDepartmentID" value="<?php echo $row['Department_ID'] ?>" />
      <input type="submit" name="btnUpdate" class="button-59" role="button" value="Save" />
      <input type="reset" value="Cancel" class="button-59" role="button" />
    </section>
    <a href="admindep.php" class="buttonb">Back To Departments Page</a>
    </form>

  </div>
</body>

</html>