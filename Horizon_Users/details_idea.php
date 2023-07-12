<?php
include('connection.php');
include("AutoIDFunction.php");
session_start();


if (isset($_REQUEST['pid']) && isset($_SESSION['User_ID'])) {
   $Post_ID = $_REQUEST['pid'];
   $User_ID = $_SESSION['User_ID'];

   $check = "SELECT COUNT(*) FROM tbl_action WHERE Post_ID='$Post_ID' AND User_ID='$User_ID' AND View='Y'";
   $result = mysqli_query($connect, $check);
   $row = mysqli_fetch_array($result);
   $count = $row[0];

   if ($count < 1) {
      $sql = "INSERT INTO tbl_action (Post_ID, User_ID, View) VALUES ('$Post_ID', '$User_ID', 'Y')";
      $result = mysqli_query($connect, $sql);
      //add view count
      $viewCount = "UPDATE Posts SET View_Count = View_Count + 1 WHERE Post_ID = '$Post_ID'";
      $res = mysqli_query($connect, $viewCount);
   }
} else {
   echo "<script>window.alert('Something Went Wrong')</script>";
   echo "<script>window.history.go(-1);</script>";
}

//like button
if (isset($_POST['btnLike'])) {
   $Post_ID = $_POST['pid'];
   $User_ID = $_SESSION['User_ID'];
   //get previous action
   $preCheck = "SELECT Action FROM tbl_action WHERE Post_ID = '$Post_ID' AND User_ID='$User_ID'";
   $preRes = mysqli_query($connect, $preCheck);
   $preAction = mysqli_fetch_assoc($preRes);
   $acti = $preAction['Action'];

   if ($acti == "Like") {
      echo "<script>alert('You Have Already Upvoted this Post!');</script>";
   } else {
      $update = "UPDATE tbl_action SET Action = 'Like' WHERE Post_ID = '$Post_ID' AND User_ID='$User_ID'";
      $run = mysqli_query($connect, $update);
      //add one to total post like count

      $post = "UPDATE Posts SET Like_Count = Like_Count + 1 WHERE Post_ID = '$Post_ID'";
      $run = mysqli_query($connect, $post);
      echo "<script>alert('Post Upvoted!');</script>";
   }


}
//dislike button
if (isset($_POST['btnDislike'])) {
   $Post_ID = $_POST['pid'];
   $User_ID = $_SESSION['User_ID'];

   //get previous action
   $preCheck = "SELECT Action FROM tbl_action WHERE Post_ID = '$Post_ID' AND User_ID='$User_ID'";
   $preRes = mysqli_query($connect, $preCheck);
   $preAction = mysqli_fetch_assoc($preRes);
   $acti = $preAction['Action'];

   if ($acti == "Dislike") {
      echo "<script>alert('You Have Already Dowhvoted this Post!');</script>";
   } else {
      $update = "UPDATE tbl_action SET Action = 'Dislike' WHERE Post_ID = '$Post_ID' AND User_ID='$User_ID'";
      $run = mysqli_query($connect, $update);
      //add one to total post like count
      $post = "UPDATE Posts SET Dislike_Count = Dislike_Count + 1 WHERE Post_ID = '$Post_ID'";
      $run = mysqli_query($connect, $post);
      echo "<script>alert('Post Downvoted!');</script>";
   }

}


if (isset($_POST['btnComment'])) {

   if (isset($_POST['anon'])) {
      $anon = "1";
   } else {
      $anon = "0";
   }

   $txtComment = $_POST['txtComment'];
   $Comment_ID = AutoID('comments', 'Comment_ID', 'CM-', 6);
   $Upload_Date = date('Y-m-d');
   $Upload_Time = date('H:i:s');
   $User_ID = $_SESSION['User_ID'];
   $Post_ID = $_POST['pid'];

   // Get Topic_ID from the posts table using Post_ID
   $query = "SELECT Topic_ID FROM posts WHERE Post_ID = '$Post_ID'";
   $result = mysqli_query($connect, $query);
   if ($result) {
      $row = mysqli_fetch_assoc($result);
      $Topic_ID = $row['Topic_ID'];

      // Check the closure date of the topic
      $query = "SELECT ClosureDate FROM topics WHERE Topic_ID = '$Topic_ID'";
      $result = mysqli_query($connect, $query);
      if ($result) {
         $row = mysqli_fetch_assoc($result);
         $ClosureDate = $row['ClosureDate'];

         if (strtotime($ClosureDate) >= strtotime(date('Y-m-d'))) {
            $insertQuery = "INSERT INTO comments (Comment_ID, Comment, Upload_Date, Upload_Time, User_ID, Post_ID, Anonymous) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = mysqli_prepare($connect, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, 'sssssss', $Comment_ID, $txtComment, $Upload_Date, $Upload_Time, $User_ID, $Post_ID, $anon);
            if (mysqli_stmt_execute($insertStmt)) {
               echo "<script>window.alert('Your Comment was Published')</script>";
               $sqlAuthor = "SELECT User_Email, User_Name FROM users WHERE User_ID = (SELECT User_ID FROM posts WHERE Post_ID = '$Post_ID')";
               $resAuth = mysqli_query($connect, $sqlAuthor);
               $authData = mysqli_fetch_assoc($resAuth);

               $to = $authData['User_Email'];
               $subject = 'New Comment on your post';
               $message = "Dear ".$authData['User_Email'].",\n\nI wanted to bring to your attention that a new comment has been uploaded to your previous idea, by one of our members.\n\nPlease take a moment to review the comment.\n\nThank you for your time and attention.\n\nBest regards";

               // Set additional headers
               $headers = 'From: horizionuniversity@example.com' . "\r\n" .
                     'Reply-To: webmaster@example.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
               ini_set('smtp_port', 1025);
               ini_set('smtp_host', 'localhost');

                 // Send the email
               mail($to, $subject, $message, $headers);

            } else {
               echo "Error adding user: " . mysqli_error($connect);
            }
         }
      } else {
         echo "Error executing query: " . mysqli_error($connect);
      }
   } else {
      echo "Error executing query: " . mysqli_error($connect);
   }

}



?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="css/style2.css">
   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
   <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

   <style>
      #commentForm label {
         display: block;
         font-weight: bold;
         margin-bottom: 5px;
      }

      #commentForm textarea {
         width: 100%;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 5px;
         resize: vertical;
      }

      #commentForm button[type="submit"] {
         display: block;
         margin-top: 10px;
         padding: 10px;
         background-color: #FFD62D;
         color: #fff;
         border: none;
         border-radius: 5px;
         cursor: pointer;
      }


      .form-container .form {
         width: 100%;
      }

      .form {
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
   </style>

</head>

<body>
   <div class="form-container">
      <div class="form">
         <div class="container"><label>Horizon University</label>
            <div class="dropdown" style="float: right; margin-left: 18px; margin-top: 1px; ">
               <img src="images/profile.jpg" alt="smallimage" class="smallimage" id="dropdown_img"
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
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="topics.php">Topics</a></li>
         </ul>
         <form action="details_idea.php" method="POST">
            <?php
            if (isset($_REQUEST['pid'])) {
               $Post_ID = $_REQUEST['pid'];
               $User_ID = $_SESSION['User_ID'];
               echo '<input type="hidden" name="pid" value="' . $Post_ID . '">';
               $select = "SELECT * FROM posts WHERE Post_ID = ?";
               $stmt = mysqli_prepare($connect, $select);
               mysqli_stmt_bind_param($stmt, "s", $Post_ID);
               mysqli_stmt_execute($stmt);
               $result = mysqli_stmt_get_result($stmt);
               $data = mysqli_fetch_array($result);
               $View_Count = $data['View_Count'] + 1;
               echo '<input type="hidden" name="post_id" value="<?php echo $Post_ID; ?>">';
               echo '<div class="ideadetail">';
               echo '<div class="heading">';
               echo '<h2>' . $data['Title'] . '</h2>';
               echo "<span style='float: right; margin-top:-50px;'><i style='font-size:24px'
                     class='fa'>&#xf06e;</i><label>&nbsp;&nbsp;&nbsp;" . $View_Count . " &nbsp;&nbsp;&nbsp;" . $data['Upload_Time'] . " </label></span>";
               echo '</div>';
               echo '<p>' . $data['Post'] . '</p>';

               echo '<h3>Attachments</h3>';
               echo '<p></p>';
               echo $data['Document'];
               echo '</div>';
               //check the person is liked or displike
               $check = "SELECT Action FROM tbl_action WHERE Post_ID='$Post_ID' AND User_ID='$User_ID'";
               $result = mysqli_query($connect, $check);
               $row = mysqli_fetch_assoc($result);
               $action = $row['Action'];

               echo '<div class="derow">';
               if ($action == 'Like') {
                  echo '<button style="width: 30%; background-color: #FFD62D;" name="btnLike"><i class="fa fa-thumbs-up" style="font-size:24px; color:#fff;"></i> Like</button>';
                  echo '<button style="width: 30%;" name="btnDislike"><i class="fa fa-thumbs-down" style="font-size:24px; color:#FFD62D;"></i> Dislike</button>';
               } elseif ($action == 'Dislike') {
                  echo '<button style="width: 30%;" name="btnLike"><i class="fa fa-thumbs-up" style="font-size:24px; color:#FFD62D;"></i> Like</button>';
                  echo '<button style="width: 30%; background-color: #FFD62D;" name="btnDislike"><i class="fa fa-thumbs-down" style="font-size:24px; color:#fff;"></i> Dislike</button>';
               } else {
                  echo '<button style="width: 30%;" name="btnLike"><i class="fa fa-thumbs-up" style="font-size:24px; color:#FFD62D;"></i> Like</button>';
                  echo '<button style="width: 30%;" name="btnDislike"><i class="fa fa-thumbs-down" style="font-size:24px; color:#FFD62D;"></i> Dislike</button>';
               }
               echo '<button style="width: 30%;" onclick="showCommentForm()"><i style="font-size:24px" class="far">&#xf27a;</i> Comment</button>';
               echo '</div>';
               echo '<label>
            <input type="checkbox" id="check" name="anon" class="checkbox" value="Y"> Post Annonymously
         </label>';

               echo '<div id="commentForm" style="display: none;">';
               echo '<form method="post" action="">';
               echo '<label for="comment">Leave a comment:</label>';
               echo '<textarea name="txtComment" id="comment" rows="4"></textarea>';
               echo '<button type="submit" name="btnComment">Post Comment</button>';
               echo '</div>';

               echo '<script>';
               echo 'function showCommentForm() {';
               echo '    document.getElementById("commentForm").style.display = "block";';
               echo '    event.preventDefault();';
               echo '}';
               echo '</script>';
               echo '</form>';
               ?>
            </form>
            <br><br><br>
            <?php
            $cmtQuery = "SELECT * FROM comments WHERE Post_ID = '$Post_ID' ORDER BY Upload_Date DESC, Upload_Time DESC";
            $cmtRun = mysqli_query($connect, $cmtQuery);
            while ($cmts = mysqli_fetch_assoc($cmtRun)) {
               $Post_ID = $cmts['Post_ID'];
               $anon = $cmts['Anonymous'];
               $Comment = $cmts['Comment'];
               $Upload_Date = $cmts['Upload_Date'];
               $Upload_Time = $cmts['Upload_Time'];

               if ($anon === '1') {
                  $author = "Anonymous";
                  $photo = "userPhoto/default_profile.png";
               } else {

                  $User_ID = $cmts['User_ID'];
                  $auth = "SELECT User_Name,Photo FROM users WHERE User_ID='$User_ID'";
                  $authResult = mysqli_query($connect, $auth);
                  $authRow = mysqli_fetch_assoc($authResult);
                  $author = $authRow['User_Name'];
                  $photo = $authRow['Photo'];
                  if (empty($photo)) {
                     $photo = "userPhoto/default_profile.png";
                  }
               }

               // Convert Upload_Date and Upload_Time to Unix timestamp
               $timestamp = strtotime("$Upload_Date $Upload_Time");

               // Calculate the difference in seconds between the current time and the timestamp of the comment
               $secondsSinceUpload = time() - $timestamp;

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
               echo '<div class="cmt">';
               echo '<div class="cmter">';
               echo '<div class="cmtimg">';
               echo '<img src="' . $photo . '" style="width:10%; float: left;">';
               echo '</div>';
               echo '<div class="detail">';
               echo '<h3>' . $author . '</h3>';
               echo '' . $timeAgo . '<br>';
               echo '<p>' . $Comment . '</p>';
               echo '<p><i class="fa fa-thumbs-up"></i>&nbsp;2&nbsp;&nbsp;&nbsp;<a href="#">Like</a>&nbsp;&nbsp;&nbsp;<a
                  href="#">Reply</a></p>';
               echo '</div>';
               echo '</div>';
               echo '</div>';

            }
            } else {
               echo "<p>This post is deleted or Unpublished by the Owner</p>";
            }
            ?>
      </div>
   </div>
</body>

</html>