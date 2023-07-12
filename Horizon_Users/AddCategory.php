<?php 
    include('connection.php');
    include('AutoIDFunction.php');
    session_start();

    if(!isset($_SESSION['User_ID'])){
    echo "<script>window.alert('Login as QA Manager to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
    }

    if(isset($_POST['btnSave'])){
        $CategoryID = $_POST['txtCategoryID'];
        $Category = $_POST['txtCategory'];


        $check = "SELECT * FROM categories WHERE Category_Name=?";
        $stmt = mysqli_prepare($connect, $check);
        mysqli_stmt_bind_param($stmt, "s", $Category);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $count = mysqli_num_rows($res);

        if($count > 0){
            echo "<script>window.alert('This Category Already Exist!')</script>";
            echo "<script>window.location='addCategory.php'</script>";
        }
        else{
            $Insert = "INSERT INTO categories(Category_ID,Category_Name)
            VALUES (?,?)";
            $stmt1 = mysqli_prepare($connect, $Insert);
            mysqli_stmt_bind_param($stmt1, "ss", $CategoryID, $Category);
            $res1=mysqli_stmt_execute($stmt1);
        }
        if(!$res1){
        echo "<p>Something went wrong" . mysqli_error($connect) . "</p>";
    }
        else{
            echo "<script>window.alert('Success!')</script>";
            echo "<script>window.location='categories.php'</script>";
    }
    }
 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <title> Add Category </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
    <form action="AddCategory.php" method="POST">
    <div class="container">
        <h1>Add Category</h1>
        <div class="inputContainer">
            <p>Category Name</p>
            <input type="text" placeholder="Please enter Category name" name="txtCategory" required>
            <input type="hidden" name = "txtCategoryID" readonly value="<?php echo AutoID('categories','Category_ID','C-',6) ?>">
        </div>
        <div class="buttonContainer">
            <button class="button" type="submit" name="btnSave">Add</button>
            <button type="button" onclick="window.location.href='categories.php'">Cancel</button>

        </div>
    </div>
    </form>
</body>
</html>