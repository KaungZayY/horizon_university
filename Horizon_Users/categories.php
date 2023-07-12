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
   <title>Categories</title>
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
               <li><a href="categories.php" class="active">Categories</a></li>
            <?php endif; ?>
            <li><a href="topics.php">Topics</a></li>
         </ul>

         <div class="btncate">
            <?php
            if ($_SESSION['Role_ID'] == "R-000001") {
               ?>

               <a href="addCategory.php">
                  <button class="btnidea"
                     style="color: white; background-color: #4354A5; box-shadow: 3px 5px #000; border: 2px solid #000; float: right;">+Add
                     Categories</button>
               </a>

               <?php
            }
            ?>
         </div>

         <form action="categories.php" method="POST">
            <div class="catecontainer">
               <table>
                  <tr>
                     <th>ID</th>
                     <th>Categories</th>
                     <th>Post Count</th>
                     <th></th>
                  </tr>
                  <tbody>
                     <?php
                     $select = "SELECT * FROM categories";
                     $query = mysqli_query($connect, $select);
                     $count = mysqli_num_rows($query);
                     for ($i = 0; $i < $count; $i++) {
                        $data = mysqli_fetch_array($query);
                        $Category_ID = $data['Category_ID'];
                        $Category_Name = $data['Category_Name'];

                        //count how many users are assigned to the current department
                        $countQuery = "SELECT COUNT(*) FROM posts WHERE Category_ID = '$Category_ID'";
                        $result = $connect->query($countQuery);
                        // Get count value
                        if ($result) {
                           $countRow = mysqli_fetch_array($result);
                           $uCount = $countRow[0];
                        }

                        echo "<tr>
                            <td>$Category_ID</td>
                            <td>$Category_Name</td>
                            <td>$uCount</td>";
                        if ($_SESSION['Role_ID'] == 'R-000001') {
                           echo "<td><a href='deleteCategory.php?cid=$Category_ID'>Remove</a></td>";
                        }
                        echo "</tr>";

                     }
                     ?>
                  </tbody>
               </table>
            </div>
         </form>
      </div>
</body>

</html>