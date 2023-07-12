<?php 
include('connection.php');
session_start();

if(!isset($_SESSION['User_ID'])){
  echo "<script>window.alert('Login to Access this Page')</script>";
  echo "<script>window.history.go(-1);</script>";
}
else{
  $User_ID = $_SESSION['User_ID'];
  $select = "SELECT * FROM users WHERE User_ID = ?";
    $stmt = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($stmt, "s", $User_ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_array($result);
    
    $Photo = $data['Photo'];
    if (empty($Photo)) {
    $Photo="userPhoto/default_profile.png";
    }
}

 ?>


<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Statistics</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="css/style2.css">
   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
               <img src="<?php echo $Photo?>" alt="smallimage" class="smallimage" id="dropdown_img"
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
              <li><a class="active" href="statistics.php">Statistics</a></li>
            <?php endif; ?>
            <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
              <li><a href="categories.php">Categories</a></li>
            <?php endif; ?>
            <li><a href="topics.php">Topics</a></li>
         </ul>
         <h2 style="text-align:center;">Ideas Made By Departments</h2>

         <div class="statsimg" style="all:unset; width: 50%; margin:auto; display: flex; justify-content: center;">
            <canvas id="myChart"></canvas>
         </div>
          


         <div class="catecontainer">
            <h2 style="text-align:center;">Number of Ideas made by Each Departments</h2>
  <table id=dataTable>
    <tr>
        <th>Department</th>
        <th>Number of Ideas</th>
        <th>Percentage of Ideas</th>
        <th>Number of Contributors</th>
    </tr>
<?php
    // Initialize percentage_ideas array
    $percentage_ideas = array();

    // Perform query to get all departments
    $departments_query = mysqli_query($connect, "SELECT Department_Name FROM departments");

    // Loop through each department
    while($department_row = mysqli_fetch_assoc($departments_query)) {
        $department_name = $department_row['Department_Name'];
        $department_id_query = mysqli_query($connect, "SELECT Department_ID FROM departments WHERE Department_Name='$department_name'");
        if (!$department_id_query) {
            echo "Error: " . mysqli_error($connect);
        }
        else {
            $department_id_row = mysqli_fetch_assoc($department_id_query);
            $department_id = $department_id_row['Department_ID'];

            // Query to get number of contributors
            $contributors_query = mysqli_query($connect, "SELECT COUNT(DISTINCT User_ID) AS NumContributors FROM posts WHERE User_ID IN (SELECT User_ID FROM users WHERE Department_ID='$department_id')");


            if (!$contributors_query) {
                echo "Error: " . mysqli_error($connect);
            }
            else {
                // Query to get number of ideas
                $ideas_query = mysqli_query($connect, "SELECT COUNT(*) AS NumIdeas FROM posts INNER JOIN users ON posts.User_ID=users.User_ID INNER JOIN departments ON users.Department_ID=departments.Department_ID WHERE departments.Department_Name='$department_name'");
                if (!$ideas_query) {
                    echo "Error: " . mysqli_error($connect);
                }
                else {
                    // Query to get total number of ideas
                    $total_ideas_query = mysqli_query($connect, "SELECT COUNT(*) AS TotalIdeas FROM posts");
                    if (!$total_ideas_query) {
                        echo "Error: " . mysqli_error($connect);
                    }
                    else {
                        // Get the data from each query
                        $contributors_row = mysqli_fetch_assoc($contributors_query);
                        $num_contributors = $contributors_row['NumContributors'];

                        $ideas_row = mysqli_fetch_assoc($ideas_query);
                        $num_ideas = $ideas_row['NumIdeas'];

                        $total_ideas_row = mysqli_fetch_assoc($total_ideas_query);
                        $total_ideas = $total_ideas_row['TotalIdeas'];

                        // Calculate percentage of ideas
                        if ($num_ideas > 0) {
                            $percentage_ideas[] = round(($num_ideas / $total_ideas) * 100, 2);
                        } else {
                            $percentage_ideas[] = 0;
                        }

                        // Display data in table row
                        echo "<tr>
                                  <td>$department_name</td>
                                  <td>$num_ideas</td>
                                  <td>{$percentage_ideas[count($percentage_ideas) - 1]}%</td>
                                  <td>$num_contributors</td>
                              </tr>";


                    }
                }
            }
        }
    }
?>


</table>

<script>
// Get the canvas element
var ctx = document.getElementById("myChart").getContext("2d");

// Define the chart data
var chartData = {
  labels: [
<?php
    // Print department names as chart labels
    $departments_query = mysqli_query($connect, "SELECT Department_Name FROM departments");
    while($department_row = mysqli_fetch_assoc($departments_query)) {
        $department_name = $department_row['Department_Name'];
        echo "'$department_name', ";
    }
?>
  ],
  datasets: [{
    data: [
<?php
    // Print number of ideas for each department as chart data
    $departments_query = mysqli_query($connect, "SELECT Department_Name FROM departments");
    while($department_row = mysqli_fetch_assoc($departments_query)) {
        $department_name = $department_row['Department_Name'];
        $ideas_query = mysqli_query($connect, "SELECT COUNT(*) AS NumIdeas FROM posts INNER JOIN users ON posts.User_ID=users.User_ID INNER JOIN departments ON users.Department_ID=departments.Department_ID WHERE departments.Department_Name='$department_name'");
        $ideas_row = mysqli_fetch_assoc($ideas_query);
        $num_ideas = $ideas_row['NumIdeas'];
        echo "$num_ideas, ";
    }
?>
    ],
    backgroundColor: [
      "#FF6384",
      "#36A2EB",
      "#FFCE56",
      "#29BB89",
      "#7C53C3",
      "#F97B72"
    ]
  }]
};

// Create the chart
var myPieChart = new Chart(ctx,{
    type: 'pie',
    data: chartData,
    options: {}
});
</script>


         </div>
      </div>
   </div>
</body>

</html>