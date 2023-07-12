<?php
include('connection.php');
session_start();
if (!isset($_SESSION['User_ID'])) {
   echo "<script>window.alert('Login in to Access this Page')</script>";
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
   <title>My Wall</title>
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
            <li><a href="home.php">Home</a></li>
            <li><a class="active" href="mywall.php">My Wall</a></li>
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
         <div class="column2">
            <a href="create_ideas.php"><button class="btridea">Create an Idea</button></a><br>
         </div>
         <?php
         if (isset($_POST['btnSort'])) {
            $sort_by = $_POST['cboSort'];
            $User_ID = $_SESSION['User_ID'];
            $select = "SELECT * FROM posts WHERE User_ID='$User_ID' ORDER BY $sort_by";
         } else {
            $select = "SELECT * FROM posts WHERE User_ID='$User_ID'";
         }
         $query = mysqli_query($connect, $select);
         $i = 1;
         while ($row = mysqli_fetch_assoc($query)) {
            // Generate HTML code for each row
            echo '<div class="row">';
            echo '<div class="columnevents1">';
            echo '<div class="eventbox1" style="background-color: white;">';
            echo '<div class="topsection">';
            echo "<a href=\"deletePost.php?pid={$row['Post_ID']}\" style=\"all: unset; cursor: pointer;\"><i style=\"font-size:24px; float: right; margin-top: 10px; margin-right: 10px;\" class=\"fa\">&#xf014;</i></a>";
            echo '<p><b>' . $row['Post'] . '</b></p>';
            echo '</div>';
            echo '<div class="bottomsection">';
            echo '<p style="color: #000;margin-left: 10px;"><strong>' . $row['Title'] . '</strong></p>
                     <span class="time" style="margin-right: 10px;margin-top: 15px;"><b>' . $row['Upload_Time'] . '</b></span>';
            echo '</div>';
            echo '</div>';

         }
         ?>


      </div>
   </div>
</body>

</html>