<?php
include('connection.php');
session_start();
if (isset($_SESSION['User_ID'])) {
    $User_ID = $_SESSION['User_ID'];

    $select = "SELECT * FROM users WHERE User_ID = ?";
    $stmt = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($stmt, "s", $User_ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_array($result);

    $User_Name = $data['User_Name'];
    $User_Email = $data['User_Email'];
    $PhoneNumber = $data['PhoneNumber'];
    $Department_ID = $data['Department_ID'];

    $selDep = "SELECT Department_Name FROM departments WHERE Department_ID=?";
    $stmtPre = mysqli_prepare($connect, $selDep);
    mysqli_stmt_bind_param($stmtPre, "s", $Department_ID);
    mysqli_stmt_execute($stmtPre);
    $res = mysqli_stmt_get_result($stmtPre);
    $data1 = mysqli_fetch_array($res);
    $Department_Name = $data1['Department_Name'];

    $Address = $data['Address'];
    $Photo = $data['Photo'];
    if (empty($Photo)) {
        $Photo = "userPhoto/default_profile.png";
    }
} else {
    echo "<script>window.alert('Login First to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style2.css">
    <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">

    <style>
        p {
            color: #595F6C;
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

        @media (max-width: 944px) {
            .container>div {
                flex-basis: 100%;
            }
        }
    </style>

</head>

<body>
    <form action="account.php" method="GET">
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
                    <li><a class="active" href="account.php">My Account</a></li>
                    <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
                        <li><a href="statistics.php">Statistics</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION['Role_ID'] != 'R-000003'): ?>
                        <li><a href="categories.php">Categories</a></li>
                    <?php endif; ?>
                    <li><a href="topics.php">Topics</a></li>
                </ul>
                <div class="header" style="padding-bottom: 30px;">
                    <h3>Account & Profile</h3>
                </div>
                <div class="acc">
                    <a href="update.php" style="all: unset; cursor: pointer;"><i
                            style="font-size:24px; float: right; margin-top: 10px; margin-right: 10px;"
                            class="fa">&#xf013;</i></a>
                    <div class="container1">

                        <div class="profile-pic">
                            <img src="<?php echo $Photo ?>" alt="Profile Picture" class="profile">
                            <div class="username">
                                <?php echo $User_Name; ?>
                            </div>
                        </div>
                        <div>
                            <label for="first-name">Department:
                                <?php echo $Department_Name; ?>
                            </label><br><br>
                            <label for="email">Email:
                                <?php echo $User_Email; ?>
                            </label><br><br>
                            <label for="phonenumber">Phone Number:
                                <?php echo $PhoneNumber; ?>
                            </label><br><br>
                            <label for="address">Address:
                                <?php echo $Address; ?>
                            </label><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>