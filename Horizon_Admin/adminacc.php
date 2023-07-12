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
   <title>User Accounts</title>
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
            <li><a class="active" href="adminacc.php">Accounts</a></li>
            <li><a href="admindep.php">Departments</a></li>
            <li><a href="adminidea.php">Ideas</a></li>
            <li><a href="admintopic.php">Topic</a></li>
            <li><a href="admincate.php">Categories</a></li>
            <li><a href="adminprofile.php">Profile</a></li>
         </ul>
         <div class="btncate">
            <button class="btnidea" onclick="location.href='userRegister.php'"
               style="color: white; background-color: #4354A5; box-shadow: 3px 5px #000; border: 2px solid #000; float: right;">+Add
               Account</button>
         </div>

         <?php
         $select = "SELECT  u.*, d.Department_ID, d.Department_Name, r.Role_ID, r.Role
   FROM users u, departments d, roles r 
   WHERE u.Role_ID=r.Role_ID
   AND u.Department_ID=d.Department_ID";
         $result = mysqli_query($connection, $select);
         $count = mysqli_num_rows($result);
         if ($count < 1) {
            echo "<p>No User Entry Found.</p>";
         } else {
            ?>
            <div class="catecontainer" style="overflow-x:auto;">
               <table>
                  <tr>
                     <th hidden>#</th>
                     <th>User_ID</th>
                     <th>User_Name</th>
                     <th>User_Email</th>
                     <th>DOB</th>
                     <th>Phone Number</th>
                     <th>Address</th>
                     <th>Photo</th>
                     <th>RoleName</th>
                     <th>DepartmentName</th>
                     <th>Action</th>
                  </tr>
                  <?php
                  for ($i = 0; $i < $count; $i++) {
                     $arr = mysqli_fetch_array($result);
                     $User_ID = $arr['User_ID'];

                     echo "<tr>";
                     echo "<td hidden>" . ($i + 1) . "</td>";
                     echo "<td>" . $arr['User_ID'] . "</td>";
                     echo "<td>" . $arr['User_Name'] . "</td>";
                     echo "<td>" . $arr['User_Email'] . "</td>";
                     echo "<td>" . $arr['DOB'] . "</td>";
                     echo "<td>" . $arr['PhoneNumber'] . "</td>";
                     echo "<td>" . $arr['Address'] . "</td>";
                     echo "<td>" . $arr['Photo'] . "</td>";
                     echo "<td>" . $arr['Role'] . "</td>";
                     echo "<td>" . $arr['Department_Name'] . "</td>";
                     echo "<td>

           <a href='userupdate.php?User_ID=$User_ID'>Edit</a> |
           <a href='userdelete.php?User_ID=$User_ID'>Delete</a> 
           </td>";
                     echo "</tr>";
                  }
                  ?>
               </table>
               <?php
         }
         ?>
         </div>
         </form>
      </div>
</body>

</html>