<?php
session_start();
include('connect.php');
if (!isset($_SESSION['Admin_ID'])) {
   echo "<script>window.alert('Please Login First to Continue.')</script>";
   echo "<script>window.location='Login.php'</script>";
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
            <li><a href="adminidea.php">Ideas</a></li>
            <li><a class="active" href="admintopic.php">Topic</a></li>
            <li><a href="admincate.php">Categories</a></li>
            <li><a href="adminprofile.php">Profile</a></li>
         </ul>
         <br><br>
         <form action="admintopic.php" method="GET">
            <table>
               <?php
               $select = "SELECT * FROM topics";
               $query = mysqli_query($connection, $select);
               while ($row = mysqli_fetch_assoc($query)) {

                  $Topic_ID = $row['Topic_ID'];
                  echo '<div class="row">';
                  echo '<div class="columnevents1"  style="background-color: white;" >';
                  echo '<div class="eventbox1">';
                  echo ' <div class="topsection"> ';
                  echo " <a href='topicdelete.php?Topic_ID=$Topic_ID' style='cursor:pointer; color: black;'><i style='font-size:24px; float: right; margin-top: 10px; margin-right: 10px;' class='fa'>&#xf014;</i></a>";
                  echo ' <p style="padding-left: 15px; color: black;"><b> Start : 
                  ' . $row['StartDate'] . ' </b></p><br><br>';
                  echo ' <p style="padding-left: 15px; color: black;"><b> Closure : 
                  ' . $row['ClosureDate'] . '</b></p><br><br>';
                  echo ' <p style="padding-left: 15px; color: black;"><b> Final Closure : 
                  ' . $row['FinalClosureDate'] . ' </b></p><br><br>';
                  echo '</div>';
                  echo '<div class="bottomsection">';
                  echo '  <p style="color: #000;margin-left: 10px;padding-bottom: 9px;"><strong>'
                     . $row['Topic_Name'] . '
                  </strong></p>';
                  echo '</div>';
                  echo '</div>';
                  echo ' </div>';
                  echo ' </div>';
               }
               ?>
      </div>
   </div>
   </table>
   </form>
</body>

</html>