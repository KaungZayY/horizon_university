<?php
include("connection.php");
include("AutoIDFunction.php");
session_start();

if (!isset($_SESSION['User_ID'])) {
   echo "<script>window.alert('Login First')</script>";
   echo "<script>window.location='login.php'</script>";
}


if (isset($_POST['btnPublish'])) {

   $content = $_POST['txtContent'];
   $User_ID = $_SESSION['User_ID'];
   $txtPostID = $_POST['txtPostID'];
   $txtTitle = $_POST['txtTitle'];
   $Upload_Time = date('Y-m-d H:i:s');
   $cboCategories = $_POST['cboCategories'];
   $cboTopics = $_POST['cboTopics'];
   $View_Count = 0;
   $Like_Count = 0;
   $Dislike_Count = 0;

   if (isset($_FILES['attachFile']['name']) && $_FILES['attachFile']['name'] != "") {
      // Image was uploaded, process it
      $CurrentTime = date('Y-m-d-H-i-s');
      $attachFile = $_FILES['attachFile']['name'];
      $Destination = "attachments/";
      $fileName = $Destination . $txtPostID . "_" . $CurrentTime . "_" . $attachFile;
      $copied = copy($_FILES['attachFile']['tmp_name'], $fileName);
      if (!$copied) {
         echo "<p>Error Uploading Photo</p>";
         exit();
      }
   } else {
      // Image was not uploaded, set attachFile to empty string
      $attachFile = "";
   }

   if (isset($_POST['anon'])) {
      $anon = "1";
   } else {
      $anon = "0";
   }

   $end_date_query = mysqli_query($connect, "SELECT ClosureDate FROM topics WHERE Topic_ID = '$cboTopics'");
   $end_date_row = mysqli_fetch_assoc($end_date_query);
   $end_date = $end_date_row['ClosureDate'];

   // Check if end date has not yet arrived
   if (date('Y-m-d') <= $end_date) {
      $insertQuery = "INSERT INTO posts (Post_ID, Title, Post, Upload_Time, View_Count, Like_Count, Dislike_Count, Category_ID, User_ID, Topic_ID, Document, Anonymous) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $insertStmt = mysqli_prepare($connect, $insertQuery);
      mysqli_stmt_bind_param($insertStmt, 'ssssiiisssss', $txtPostID, $txtTitle, $content, $Upload_Time, $View_Count, $Like_Count, $Dislike_Count, $cboCategories, $User_ID, $cboTopics, $fileName, $anon);
      if (mysqli_stmt_execute($insertStmt)) {
         echo "<script>window.alert('Your Post was Published')</script>";
         echo "<script>window.location='create_ideas.php'</script>";
         // Retrieve the User_Emails of Role_ID = "R-000001"
      $sql = "SELECT User_Email,User_Name FROM users WHERE Role_ID = 'R-000001'";
      $result = mysqli_query($connect, $sql);

      // Loop through the result set and send email to each User_Email
      while ($row = mysqli_fetch_assoc($result)) {
        $to = $row['User_Email'];
        $subject = 'New Idea has Uploaded';
        $message = "Dear ".$row['User_Name'].",\n\nI wanted to bring to your attention that a new idea has been uploaded to our website by one of our members.\n\nPlease take a moment to review the idea at your earliest convenience, as it may be of interest to you and your team.\n\nThank you for your time and attention.\n\nBest regards";

        // Set additional headers
        $headers = 'From: horizionuniversity@example.com' . "\r\n" .
               'Reply-To: webmaster@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
         ini_set('smtp_port', 1025);
         ini_set('smtp_host', 'localhost');

        // Send the email
        mail($to, $subject, $message, $headers);
      }

      } else {
         echo "Error adding user: " . mysqli_error($connect);
      }
   } else {
      echo "<script>window.alert('Posting for this topic is currently Disabled')</script>";
      echo "<script>window.location='create_ideas.php'</script>";
   }

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <title>Create Ideas</title>
   <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
   <link rel="stylesheet" type="text/css" href="css/style3.css">
   <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">

   <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: 'Poppins', sans-serif;
      }

      body {
         background-color: #F4F2EC;
         font-family: 'SF Pro Display', sans-serif;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         margin: 10px;
      }

      li {
         margin-left: 16px;
      }

      a {
         cursor: pointer;
      }


      .container {
         max-width: 991px;
         width: 100%;
         background: #fff;
         border-radius: 8px;
         overflow: hidden;
      }

      .toolbar {
         padding: 16px;
         background: #eee;
      }

      .toolbar .head {
         display: flex;
         grid-gap: 10px;
         margin-bottom: 16px;
         flex-wrap: wrap;
      }

      .toolbar .head>input {
         max-width: 100px;
         padding: 6px 10px;
         border-radius: 6px;
         border: 2px solid #ddd;
         outline: none;
      }

      .toolbar .head select {
         background: #fff;
         border: 2px solid #ddd;
         border-radius: 6px;
         outline: none;
         cursor: pointer;
      }

      .toolbar .head .color {
         background: #fff;
         border: 2px solid #ddd;
         border-radius: 6px;
         outline: none;
         cursor: pointer;
         display: flex;
         align-items: center;
         grid-gap: 6px;
         padding: 0 10px;
      }

      .toolbar .head .color span {
         font-size: 14px;
      }

      .toolbar .head .color input {
         border: none;
         padding: 0;
         width: 26px;
         height: 26px;
         background: #fff;
         cursor: pointer;
      }

      .toolbar .head .color input::-moz-color-swatch {
         width: 20px;
         height: 20px;
         border: none;
         border-radius: 50%;
      }

      .toolbar .btn-toolbar {
         display: flex;
         flex-wrap: wrap;
         align-items: center;
         grid-gap: 10px;
      }

      .toolbar .btn-toolbar button {
         background: #fff;
         border: 2px solid #ddd;
         border-radius: 6px;
         cursor: pointer;
         width: 40px;
         height: 40px;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 18px;
      }

      .toolbar .btn-toolbar button:hover {
         background: #f3f3f3;
      }

      #content {
         padding: 16px;
         outline: none;
         max-height: 50vh;
         overflow: auto;
      }

      #show-code[data-active="true"] {
         background: #eee;
      }

      .form-container {
         box-sizing: border-box;
         width: 100%;
         height: 100%;
         padding: 2rem;
         border: 2px solid #000000;
         border-radius: 10px;
         margin: auto;
         justify-content: center;
         align-items: center;
      }

      .form-container form {
         width: 100%;
      }

      .box {
         width: 350px;
         padding: 8px;
         border-radius: 5px;
         margin-bottom: 20px;
         font-size: 18px;
         margin-top: 10px;
         box-sizing: border-box;
         border: 1px solid #000;

      }

      label {
         font-size: 18px;
         font-weight: bold;
      }

      .box1 {
         width: 100%;
         box-sizing: border-box;
         border: 1px solid #000;
      }

      .categories_div {
         margin-top: 10px;
      }

      .events_div {
         margin-top: 10px;
      }

      input.checkbox {
         width: 18px;
         height: 18px;
      }

      .button {
         display: inline-block;
         margin: 10px;
         background-color: white;
         color: #7E7E7E;
         padding: 12px 20px;
         border: 1px solid #000;
         border-radius: 5px;
         cursor: pointer;
         font-size: 16px;

         justify-content: center;
         font-weight: bold;

      }

      .button:hover {
         background-color: #4354A5;
         color: white;
         font-weight: bold;
      }

      .btn {
         display: flex;
         justify-content: center;
         padding: 10px;
         text-align: center;
      }

      .file {
         margin-top: 15px;
         font-size: 18px;
         margin-bottom: 20px;
      }
   </style>
</head>

<body>
   <div class="form-container">
      <h1 style="text-align: center;">Create Idea</h1>
      <form action="create_ideas.php" method="POST" enctype="multipart/form-data">
         <label for="title">Title</label><br>
         <input type="hidden" name="txtPostID" readonly value="<?php echo AutoID('posts', 'Post_ID', 'P-', 6) ?>">
         <input type="text" id="title" name="txtTitle" placeholder="Please Enter Title(required)" required
            class="box"><br>
         <label for="contents">Content</label><br>
         <input type="text" id="content" name="txtContent" placeholder="Please Enter Text" required class="box"><br>
         <label for="myfile">Select a file:</label><br>
         <input type="file" id="file-input" name="attachFile" value="file" class="file">
         <div class="categories_div">
            <label for="categories">Select Categories</label><br>
            <select class="box" required name="cboCategories">
               <option disabled selected>Select Categories</option>
               <?php
               $select = "SELECT * FROM categories";
               $query = mysqli_query($connect, $select);
               $count = mysqli_num_rows($query);
               for ($i = 0; $i < $count; $i++) {
                  $data = mysqli_fetch_array($query);
                  $Category_ID = $data['Category_ID'];
                  $Category_Name = $data['Category_Name'];
                  echo "<option value='$Category_ID'>
                     $Category_Name
                  </option>";
               }
               ?>
            </select>
         </div>

         <div class="events_div">
            <label for="events">Select Topic</label><br>
            <select class="box" required name="cboTopics">
               <option disabled selected>Select Topics</option>
               <?php
               $select = "SELECT * FROM topics";
               $query = mysqli_query($connect, $select);
               $count = mysqli_num_rows($query);
               for ($i = 0; $i < $count; $i++) {
                  $data = mysqli_fetch_array($query);
                  $Topic_ID = $data['Topic_ID'];
                  $Topic_Name = $data['Topic_Name'];
                  echo "<option value='$Topic_ID'>
                     $Topic_Name
                  </option>";
               }
               ?>
            </select>
         </div>
         <input type="checkbox" id="terms" name="terms" value="terms" class="checkbox" required>
         <label for="terms"> I agree to <a href="userAgreement.php" style="color: blue; text-decoration: none;">terms
               and conditions</a>.</label><br>
         <label>
            <input type="checkbox" id="check" name="anon" class="checkbox" value="Y"> Post Annonymously
         </label>

         <div class="btn">
            <input type="submit" name="btnPublish" class="button" value="Publish">
            <a href="javascript:history.back()" class="button">Cancel</a>
         </div>
      </form>
   </div>
</body>

</html>