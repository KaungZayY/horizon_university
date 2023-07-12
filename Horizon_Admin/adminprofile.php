<?php
session_start();
include('connect.php');
if (!isset($_SESSION['Admin_ID'])) {
    echo "<script>window.alert('Please Login First to Continue.')</script>";
    echo "<script>window.location='Login.php'</script>";
 }

$query = "SELECT * FROM admin ";
$ret = mysqli_query($connection, $query);
$row = mysqli_fetch_array($ret);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account</title>
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

        table,
        tr,
        td,
        th {

            padding: 10px;

            margin: auto;

            border: none;

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
                <li><a href="admintopic.php">Topic</a></li>
                <li><a href="admincate.php">Categories</a></li>
                <li><a class="active" href="adminprofile.php">Profile</a></li>
            </ul>

            <div class="acc" style="margin-top: 40px;">
                <a href="adminEditProfile.php" style="all: unset; cursor: pointer;"><i
                        style="font-size:24px; float: right; margin-top: 10px; margin-right: 10px;"
                        class="fa">&#xf013;</i></a>
                <div class="container1">

                    <div class="profile-pic">
                        <img src="images/profile.jpg" alt="Profile Picture" class="profile">
                        <div class="username"><b>
                                <?php echo $row['A_UserName'] ?>
                            </b></div>
                    </div>
                    <div>
                        <table>
                            <tr>
                                <td>Admin User Name :</td>
                                <td>
                                    <b>
                                        <?php echo $row['A_UserName'] ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Password :</td>
                                <td>
                                    <b>
                                        <?php echo $row['A_Password'] ?>
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>