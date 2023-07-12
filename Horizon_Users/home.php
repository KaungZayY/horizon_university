<?php
include('connection.php');
session_start();
if (!isset($_SESSION['User_ID'])) {
  echo "<script>window.alert('Login in to Access this Page')</script>";
  echo "<script>window.location='Login.php'</script>";
} else {

  $User_ID = $_SESSION['User_ID'];
  $select = "SELECT * FROM users WHERE User_ID = ?";
  $stmt = mysqli_prepare($connect, $select);
  mysqli_stmt_bind_param($stmt, "s", $User_ID);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $data = mysqli_fetch_array($result);

  $User_Name = $data['User_Name'];
  $Photo = $data['Photo'];
  if (empty($Photo)) {
    $Photo = "userPhoto/default_profile.png";
  }

}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style2.css" />
  <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet" />
  <script type="dropdown.js"></script>

  <style>
    .form-container .form {
      width: 100%;
    }

    @media screen and (max-width: 415px) {
      .search {
        float: none;
      }

      .form-container {
        padding: 2rem;
      }
    }

    .button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 8px;
    }

    .button:hover {
      background-color: #3e8e41;
    }
  </style>
</head>

<body>
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
        <li><a class="active" href="home.php">Home</a></li>
        <li><a href="mywall.php">My Wall</a></li>
        <li><a href="account.php">My Account</a></li>
        <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
          <li><a href="statistics.php">Statistics</a></li>
        <?php endif; ?>
        <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
          <li><a href="categories.php">Categories</a></li>
        <?php endif; ?>
        <li><a href="topics.php">Topics</a></li>
      </ul>
      <div class="border">
        <div align="right">
          <p>Sort</p>
          <select id="sort-by" name="cboSort">
            <option value="Upload_Time">By Time</option>
            <option value="Title">By Name</option>
          </select>
          <input type="submit" name="btnSort" value="Sort">
        </div>
      </div>
      <a href="#" class="button">Previous</a>
      <a href="#" class="button">Next</a>

      <form action="home.php" method="POST">

        <!-- <div class="column2">
          <a href="create_ideas.php"><button class="btridea">Create an Idea</button></a><br>
        </div> -->
        <div class="btnnew">
          <a href="create_ideas.php" style="color: black; text-decoration: none;"><button class="btnidea">
              +New Idea
              <?php if ($_SESSION['Role_ID'] == 'R-000001') { ?>
                <a href="download_data.php">
                  <button class="btnidea" id="btnDownload"
                    style="color: white; background-color: #4354A5; box-shadow: 3px 5px #000; border: 2px solid #000; float: right;">
                    <i style="font-size:24px" class="fa">&#xf019;</i> Download Data
                  </button>
                </a>
              <?php } ?>

        </div>
        <?php
        if (isset($_POST['btnSort'])) {
          $sort_by = $_POST['cboSort'];
          $select = "SELECT * FROM posts ORDER BY $sort_by DESC";
        } else {
          $select = "SELECT * FROM posts ORDER BY Upload_Time DESC";
        }
        $query = mysqli_query($connect, $select);
        while ($row = mysqli_fetch_assoc($query)) {
          $Post_ID = $row['Post_ID'];
          $anon = $row['Anonymous'];
          if ($anon === '1') {
            $author = "Anonymous";
          } else {

            $User_ID = $row['User_ID'];
            $auth = "SELECT User_Name FROM users WHERE User_ID='$User_ID'";
            $authResult = mysqli_query($connect, $auth);
            $authRow = mysqli_fetch_assoc($authResult);
            $author = $authRow['User_Name'];
          }
          echo '<div class="main-container" style="background-color: white">';
          if ($_SESSION['Role_ID'] == 'R-000001') {
            echo "<a href=\"deletePost.php?pid={$row['Post_ID']}\" style=\"all: unset; cursor: pointer;\"><i style=\"font-size:24px; float: right; margin-top: 10px; margin-right: 10px;\" class=\"fa\">&#xf014;</i></a>";
          } else {
            echo "<a></a>";
          }
          echo '<div class="row2">';
          echo '<div class="topsection2">';
          echo '<div class="column3">';
          echo '<p style="padding-left: 20px; padding-right: 10%">';
          echo '<b> ' . $row['Post'] . '</b>';
          echo '</p>';
          echo '</div>';
          echo '<div class="column4">';
          echo '<p style="float: right; padding-right: 10%; margin-bottom: auto">
                By ' . $author . '
              </p><br>';
          echo '</p><br>';
          echo "<a href='details_idea.php?pid=$Post_ID'>See More</a>";
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '<div class="bottomsection2">';
          echo '<div class="name">';
          echo '<p style="color: #000; margin-left: 10px; margin-top: 10px">';
          echo '<strong>' . $row['Title'] . '</strong>';
          echo '</p>';
          echo '</div>';

          $now = time();
          $Upload_Time = strtotime($row['Upload_Time']);
          $secondsSinceUpload = $now - $Upload_Time;

          if ($secondsSinceUpload < 60) {
            $timeAgo = "just now";
          } else if ($secondsSinceUpload < 3600) {
            $minutesAgo = floor($secondsSinceUpload / 60);
            $timeAgo = $minutesAgo . " minute" . ($minutesAgo == 1 ? "" : "s") . " ago";
          } else if ($secondsSinceUpload < 86400) {
            $hoursAgo = floor($secondsSinceUpload / 3600);
            $timeAgo = $hoursAgo . " hour" . ($hoursAgo == 1 ? "" : "s") . " ago";
          } else {
            $daysAgo = floor($secondsSinceUpload / 86400);
            $timeAgo = $daysAgo . " day" . ($daysAgo == 1 ? "" : "s") . " ago";
          }

          echo '<span class="time1" style="float: right"><b>' . $timeAgo . '.</b></span>';
          echo '</div>';
          echo '</div>';



        }

        ?>
    </div>
  </div>
  </form>
</body>

</html>