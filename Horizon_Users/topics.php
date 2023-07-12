<?php
include('connection.php');
session_start();
if (!isset($_SESSION['User_ID'])) {
   echo "<script>window.alert('Login to Access this Page')</script>";
   echo "<script>window.history.go(-1);</script>";
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
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Topics</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="css/style2.css">
   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">


   <style>
      p {
         color: #595F6C;
         display: inline-block;
      }

      .form {
         width: 100%;
      }

      select {
         border-radius: 0.5rem;
         border: 2px solid #000;
         text-align: center;
         margin-left: 5px;
         font-size: 12px;
      }

      .sort-container {
         float: right;
         color: #595F6C;
         align-items: center;
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
            <li><a href="account.php">My Account</a></li>
            <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
               <li><a href="statistics.php">Statistics</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
               <li><a href="categories.php">Categories</a></li>
            <?php endif; ?>
            <li><a class="active" href="topics.php">Topics</a></li>
         </ul>

         <?php
            if(isset($_SESSION['Role_ID']) && $_SESSION['Role_ID'] == 'R-000001') {
            ?>
            <div class="btnnew" style="display:flex; justify-content:center;">
               <a href="AddTopic.php"><button class="btridea">Create a Topic</button></a>
            </div>
            <br><br>
            <?php
            }
            ?>


         <form action="topics.php" method="GET">
            <div class="border">
               <div align="right">
                  <p>Sort</p>
                  <select id="sort-by" name="cboSort">
                     <option value="StartDate">By Time</option>
                     <option value="Topic_Name">By Name</option>
                  </select>
                  <input type="submit" name="btnSort" value="Sort">
               </div>
            </div>

            <div class="row">
               <?php
               if (isset($_POST['btnSort'])) {
                  $sort_by = $_POST['cboSort'];
                  $select = "SELECT * FROM topics ORDER BY $sort_by";
               } else {
                  $select = "SELECT * FROM topics";
               }
               $query = mysqli_query($connect, $select);
               $i = 1;
               while ($row = mysqli_fetch_assoc($query)) {
                  // Generate HTML code for each row
                  $class = "columnevents" . $i;
                  $event = "eventbox" . $i;
                  $i = $i + 1;
                  echo "<div class=\"$class\">";
                  echo '<div class="eventbox1">';
                  echo '<div class="topsection">';
                  if ($_SESSION['Role_ID'] == 'R-000001') {
                     echo "<a href=\"deleteTopic.php?tid={$row['Topic_ID']}\" style=\"all: unset; cursor: pointer;\"><i style=\"font-size:24px; float: right; margin-top: 10px; margin-right: 10px;\" class=\"fa\">&#xf014;</i></a>";
                  } else {
                     echo "<a></a>";
                  }
                  echo '<p style="padding-left: 15px; color: black;"><b>Start : ' . $row['StartDate'] . '<br><br><br>End: ' . $row['ClosureDate'] . '<br><br><br>Closure: ' . $row['FinalClosureDate'] . '</b></p>';
                  echo '</div>';
                  echo '<div class="bottomsection">';
                  echo '<p style="color: #000;margin-left: 10px;padding-bottom: 9px;"><strong>' . $row['Topic_Name'] . '</strong></p>';
                  echo '</div><br>';
                  echo '</div><br>';
               }
               ?>
            </div>
      </div>
   </div>
   </form>
</body>

</html>