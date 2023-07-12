<?php
include("connect.php");
include("AutoIDFunction.php");

if (!isset($_SESSION['Admin_ID'])) {
    echo "<script>window.alert('Please Login First to Continue.')</script>";
    echo "<script>window.location='Login.php'</script>";
}

if (isset($_POST['btnSave'])) {
    $txtUserID = $_POST['txtUserID'];
    $txtUserName = $_POST['txtUserName'];
    $txtUserEmail = $_POST['txtUserEmail'];
    $txtUserPassword = $_POST['txtUserPassword'];
    $txtUserDate = $_POST['txtUserDate'];
    $txtUserPhoneNumber = $_POST['txtUserPhoneNumber'];
    $txtUserAddress = $_POST['txtUserAddress'];
    $cboRoleID = $_POST['cboRoleID'];
    $cboDepartmentID = $_POST['cboDepartmentID'];

    if (isset($_FILES['fileImage']['name']) && $_FILES['fileImage']['name'] != "") {
        // Image was uploaded, process it
        $fileImage = $_FILES['fileImage']['name'];
        $Destination = "userPhoto/";
        $fileName = $Destination . $txtUserName . "_" . $fileImage;
        $copied = copy($_FILES['fileImage']['tmp_name'], $fileName);
        if (!$copied) {
            echo "<p>Error Uploading Photo</p>";
            exit();
        }
    } else {
        // Image was not uploaded, set fileImage to empty string
        $fileImage = "";
    }


    // Check if the department ID and role ID exist in their respective tables
    $selectQuery = "SELECT * FROM departments WHERE Department_ID = ?";
    $selectStmt = mysqli_prepare($connection, $selectQuery);
    mysqli_stmt_bind_param($selectStmt, 's', $cboDepartmentID);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);
    if (mysqli_num_rows($result) == 0) {
        echo "Department ID does not exist";
    } else {
        $selectQuery = "SELECT * FROM roles WHERE Role_ID = ?";
        $selectStmt = mysqli_prepare($connection, $selectQuery);
        mysqli_stmt_bind_param($selectStmt, 's', $cboRoleID);
        mysqli_stmt_execute($selectStmt);
        $result = mysqli_stmt_get_result($selectStmt);
        if (mysqli_num_rows($result) == 0) {
            echo "Role ID does not exist";
        } else {
            // Check if the email already exists in the users table
            $selectQuery = "SELECT * FROM users WHERE User_Email = ?";
            $selectStmt = mysqli_prepare($connection, $selectQuery);
            mysqli_stmt_bind_param($selectStmt, 's', $txtUserEmail);
            mysqli_stmt_execute($selectStmt);
            $result = mysqli_stmt_get_result($selectStmt);
            if (mysqli_num_rows($result) > 0) {
                echo "<script>window.alert('Email Already Exists')</script>";
                echo "<script>window.location='userRegister.php'</script>";
            } else {
                $hashedPassword = password_hash($txtUserPassword, PASSWORD_DEFAULT); //hash password
                // Insert the data into the users table
                $insertQuery = "INSERT INTO users (User_ID, User_Name, Photo, User_Email, User_Password, DOB, PhoneNumber, Address, Role_ID, Department_ID)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($connection, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, 'ssssssssss', $txtUserID, $txtUserName, $fileName, $txtUserEmail, $hashedPassword, $txtUserDate, $txtUserPhoneNumber, $txtUserAddress, $cboRoleID, $cboDepartmentID);
                if (mysqli_stmt_execute($insertStmt)) {
                    echo "<script>window.alert('New User Successfully Added')</script>";
                    echo "<script>window.location='adminacc.php'</script>";

                } else {
                    echo "Error adding user: " . mysqli_error($connect);
                }
            }
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }



        section {
            padding: 3rem 2rem;
        }



        form {
            border: 3px solid #f1f1f1;
        }

        header {

            display: flex;
            justify-content: center;
        }

        header .img-logo {
            margin-top: 30px;
            width: 200px;
            height: 200px;
            margin-bottom: 25px;
        }


        .form-container {

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;

        }

        .form-container form {
            padding-top: 2rem;
            padding-bottom: 3rem;
            padding-right: 5rem;
            padding-left: 5rem;
            width: 50rem;
            background: rgba(255, 255, 255, 1);
            opacity: 95%;
            border-radius: 0.5rem;
            text-align: center;
        }

        .form-container form h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            text-decoration: underline;
            background-color: white;
        }


        .form-container form .box {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: .5rem;
            padding: 1.2rem 1.4rem;

        }

        .form-container form label {
            font-size: 1rem;
        }



        .button {
            background-color: #4354A5;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background-color: #7984B6;
        }

        .button {
            background-color: #2541bc;
        }
    </style>

</head>

<body background="images/bg.jpg">
    <header>

        <img class="img-logo" src="images/logo.png" alt="My Logo">

    </header>
    <div class="form-container">
        <form action="userRegister.php" method="POST" enctype="multipart/form-data">
            <h3>Enter Your Information!</h3>
            <label><b>Enter Your Name</b></label>
            <input type="hidden" name="txtUserID" readonly value="<?php echo AutoID('users', 'User_ID', 'U-', 6) ?>">
            <input type="text" name="txtUserName" required class="box" placeholder="Your Name">
            <label><b>Upload Image</b></label>
            <input type="file" name="fileImage" class="box">
            <label><b>User Email</b></label>
            <input type="email" name="txtUserEmail" class="box" required placeholder="youremail@yahoo.com">
            <label><b>New Password</b></label>
            <input type="password" name="txtUserPassword" class="box" required placeholder="123">
            <label><b>Date of Birth</b></label>
            <input type="date" name="txtUserDate" class="box" required>
            <label><b>Phone Number</b></label>
            <input type="text" name="txtUserPhoneNumber" class="box" required placeholder="01-220-330-440">
            <label><b>Address</b></label>
            <input type="text" name="txtUserAddress" required class="box" placeholder="No-2 Baho Street Yangon">
            <label><b>Role</b></label>
            <select name="cboRoleID" class="box">
                <?php
                $select = "SELECT * FROM roles";
                $query = mysqli_query($connection, $select);
                $count = mysqli_num_rows($query);
                for ($i = 0; $i < $count; $i++) {
                    $data = mysqli_fetch_array($query);
                    $Role_ID = $data['Role_ID'];
                    $Role = $data['Role'];
                    echo "<option value='$Role_ID'>
							$Role
						</option>";
                }
                ?>
            </select>
            <label><b>Department</b></label>
            <select name="cboDepartmentID" class="box">
                <?php
                $select = "SELECT * FROM departments";
                $query = mysqli_query($connection, $select);
                $count = mysqli_num_rows($query);
                for ($i = 0; $i < $count; $i++) {
                    $data = mysqli_fetch_array($query);
                    $Department_ID = $data['Department_ID'];
                    $Department_Name = $data['Department_Name'];
                    echo "<option value='$Department_ID'>
							$Department_Name
						</option>";
                }
                ?>
            </select>

            <input type="submit" name="btnSave" class="button" value="Save" />
            <input type="reset" value="Cancel" class="button" />
            <section>
                <a href="adminacc.php" class="button">Back To Admin Page</a>
            </section>
        </form>
</body>

</html>