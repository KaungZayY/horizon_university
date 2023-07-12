<?php 
if(isset($_POST['btnLogout'])){
    session_start();
    session_destroy();
    echo"<script>alert('LogOut Successful')
    window.location='Login.php'</script>";
}

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
    <title>Document</title>
</head>
<body>
    <form action="Logout.php" method="POST">
    <div class="flexMid">
        <div>
            <h1>Do you sure want to Log out?</h1>
            <div class="logoutButtonContainer">
                <button class="button" type="submit" name="btnLogout">Logout</button>
                <button class="button" type="button" onclick="window.history.back();">Cancel</button>

            </div>
        </div>
    </div>
    </form>
</body>
</html>