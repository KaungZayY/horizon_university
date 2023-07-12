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
   <title>Depatments</title>
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
            <li><a class="active" href="admindep.php">Departments</a></li>
            <li><a href="adminidea.php">Ideas</a></li>
            <li><a href="admintopic.php">Topic</a></li>
            <li><a href="admincate.php">Categories</a></li>
            <li><a href="adminprofile.php">Profile</a></li>
         </ul>
         <div class="btncate">
            <button class="btnidea" onclick="location.href='AddDepartment.php'"
               style="color: white; background-color: #4354A5; box-shadow: 3px 5px #000; border: 2px solid #000; float: right;">+Add
               Department
            </button>
         </div>
         <?php
         $select = "SELECT * FROM departments";
         $result = mysqli_query($connection, $select);
         $count = mysqli_num_rows($result);
         if ($count < 1) {
            echo "<p>No Department Entry Found.</p>";
         } else {
            ?>
            <div class="catecontainer">
               <table>
                  <tr>
                     <th hidden>#</th>
                     <th>Department_ID</th>
                     <th>Department_Name</th>
                     <th>Action</th>
                  </tr>
                  <?php
                  for ($i = 0; $i < $count; $i++) {
                     $arr = mysqli_fetch_array($result);
                     $Department_ID = $arr['Department_ID'];

                     echo "<tr>";
                     echo "<td hidden>" . ($i + 1) . "</td>";
                     echo "<td>" . $arr['Department_ID'] . "</td>";
                     echo "<td>" . $arr['Department_Name'] . "</td>";
                     echo "<td>
           <a href='departmentupdate.php?Department_ID=$Department_ID'>Edit</a> |
           <a href='departmentdelete.php?Department_ID=$Department_ID'>Delete</a> 
           </td>";
                     echo "</tr>";
                  }
                  ?>
               </table>
               <?php
         }
         ?>
            </table>
         </div>
         </form>
      </div>
</body>

</html>