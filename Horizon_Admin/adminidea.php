<?php
session_start();
include('connect.php');
if (!isset($_SESSION['Admin_ID'])) {
   echo "<script>window.alert('Please Login First to Continue.')</script>";
   echo "<script>window.location='Login.php'</script>";
}
?>
<script type="text/javascript">
   function handleSelect(elm) {
      window.location = elm.value + ".php";
   }
</script>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Ideas</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="css/style2.css">
   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">


   <style>
      .form {
         width: 100%;
      }

      p {
         color: #595F6C;
         display: inline-block;
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
         <form action="adminidea.php" method="GET">
            <table>
               <div class="container"><label>Admin Settings</label>
                  <div class="dropdown" style="float: right; margin-left: 18px; margin-top: 1px; ">
                     <img src="images/profile.jpg" alt="smallimage" class="smallimage" id="dropdown_img"
                        style="width: 30px;border-radius: 50%; border: 1px solid #ccc;">
                     <div class="dropdown-content">
                        <a href="Logout.php">Log out</a>
                     </div>
                  </div>
               </div>
               <ul>
                  <li><a href="adminacc.php">Accounts</a></li>
                  <li><a href="admindep.php">Departments</a></li>
                  <li><a class="active" href="adminidea.php">Ideas</a></li>
                  <li><a href="admintopic.php">Topic</a></li>
                  <li><a href="admincate.php">Categories</a></li>
                  <li><a href="adminprofile.php">Profile</a></li>
               </ul>


               <div class="border">
                  <div align="right">
                     <p>Sort</p>
                     <select name="formal" onchange="javascript:handleSelect(this)" id="sort-by">
                        <option value="adminidea" selected="selected">By Time</option>
                        <option value="adminideabyname">By Name</option>
                     </select>
                  </div>
               </div>

               <?php
               $select = "SELECT * FROM posts ORDER BY Upload_Time DESC";
               $query = mysqli_query($connection, $select);
               while ($row = mysqli_fetch_assoc($query)) {
                  $Post_ID = $row['Post_ID'];
                  $anon = $row['Anonymous'];
                  if ($anon === 'Y') {
                     $author = "Anonymous";
                  } else {
                     $User_ID = $row['User_ID'];
                     $auth = "SELECT User_Name FROM users WHERE User_ID='$User_ID'";
                     $authResult = mysqli_query($connection, $auth);
                     $authRow = mysqli_fetch_assoc($authResult);
                     $author = $authRow['User_Name'];
                  }
                  echo '<div class="row" >';
                  echo '<div class="columnevents1" style="background-color: white"  >';
                  echo '<div class="eventbox1">';
                  echo ' <div class="topsection"> ';
                  echo " <a href='ideadelete.php?Post_ID=$Post_ID' style='cursor:pointer; color: black'><i style='font-size:24px; float: right; margin-top: 10px; margin-right: 10px;' class='fa'>&#xf014;</i></a>";
                  echo ' <p style="padding-left: 15px; color: black">';
                  echo '<b>  
                  ' . $row['Post'] . ' 
                  </b>';
                  echo '</p><br><br>';
                  echo ' <p style="padding-right: 15px; color: black; float:right; margin-bottom:auto">';
                  echo '<b> By:'
                     . $author .
                     '</b></p>';
                  echo '</div>';
                  echo '<div class="bottomsection">';
                  echo '  <p style="color: #000;margin-left: 10px;padding-bottom: 14px">';
                  echo '<strong>
                  ' . $row['Title'] . '
                  </strong>';
                  echo '</p>';



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
                  echo '</div>';
                  echo '</div>';

               }
               ?>
            </table>
         </form>
      </div>
   </div>
</body>

</html>