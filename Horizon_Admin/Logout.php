<?php
session_start();
include('connect.php');
if (!isset($_SESSION['Admin_ID'])) {
  echo "<script>window.alert('Please Login First to Continue.')</script>";
  echo "<script>window.location='adminlogin.php'</script>";
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
    .button:focus {
      color: #171e29;
    }

    .button:hover {
      border-color: #06f;
      color: #06f;
      fill: #06f;
    }

    .button:active {
      border-color: #06f;
      color: #06f;
      fill: #06f;
    }

    @media screen and (max-width: 415px) {
      .search {
        float: none;
      }

      .form-container {
        padding: 2rem;
      }

      .border {
        border-width: 0 0 1px;
        border-bottom: 1px solid #595F6C;

      }
    }
  </style>
</head>

<body>
  <div class="flexMid">
    <div>
      <h1>Do you sure want to Log out?</h1>
      <div class="logoutButtonContainer">
        <section>
          <a href="adminlogout.php" class="button">
            <button class="button">Logout</button>
          </a>
        </section>
        <section>
          <a href="adminacc.php" class="button">
            <button class="button">Cancel</button>
          </a>
        </section>
      </div>
    </div>
  </div>
</body>

</html>