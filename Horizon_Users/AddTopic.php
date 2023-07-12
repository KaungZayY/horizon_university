<?php
include('connection.php');
include('AutoIDFunction.php');
session_start();
if (!isset($_SESSION['User_ID']) || $_SESSION['Role_ID'] != "R-000001") {
    echo "<script>window.alert('Login as QA Manager to Access this Page')</script>";
    echo "<script>window.history.go(-1);</script>";
}

if (isset($_POST['btnSave'])) {
    $TopicID = $_POST['txtTopicID'];
    $TopicName = $_POST['txtTopicName'];
    $StartDate = $_POST['txtStartDate'];
    $ClosureDate = $_POST['txtEndDate'];
    $FinalClosureDate = $_POST['txtClosureDate'];

    $check = "SELECT * FROM topics WHERE Topic_Name=?";
    $stmt = mysqli_prepare($connect, $check);
    mysqli_stmt_bind_param($stmt, "s", $TopicName);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        echo "<script>window.alert('This Topic Already Exist!')</script>";
        echo "<script>window.location='addTopic.php'</script>";
    } else {
        $Insert = "INSERT INTO topics(Topic_ID,Topic_Name, StartDate, ClosureDate, FinalClosureDate)
            VALUES (?,?,?,?,?)";
        $stmt1 = mysqli_prepare($connect, $Insert);
        mysqli_stmt_bind_param($stmt1, "sssss", $TopicID, $TopicName, $StartDate, $ClosureDate, $FinalClosureDate);
        $res1 = mysqli_stmt_execute($stmt1);
    }
    if (!$res1) {
        echo "<p>Something went wrong" . mysqli_error($connect) . "</p>";
    } else {
        echo "<script>window.alert('Topic Successfully Added!')</script>";
        echo "<script>window.location='addTopic.php'</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title> Add Topic </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/css/datepicker.min.css'>
    <link rel="stylesheet" href="css/style.css">
    <link href="images/favicon.ico" rel="icon" type="image/x-icon" />

</head>

<body>
    <form action="AddTopic.php" method="POST">
        <div class="container">
            <h1>Add Topics</h1>
            <div class="inputbox">
                <div class="inputContainer">
                    <p>Topic Name</p>
                    <input type="text" placeholder="Please enter Topics name" name="txtTopicName">
                    <input type="hidden" name="txtTopicID" readonly
                        value="<?php echo AutoID('topics', 'Topic_ID', 'T-', 6) ?>">
                </div>
                <div class="inputContainer">
                    <p>Start Date</p>
                    <div class="inputGroup">
                        <div class="svgContainer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-calendar-date" viewBox="0 0 16 16">
                                <path
                                    d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z" />
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                        </div>
                        <input type="date" class="datepicker_input" placeholder="Choose a Start Date" required
                            aria-label="Choose a Start Date" name="txtStartDate">
                    </div>
                </div>
                <div class="inputContainer">
                    <p>End Date</p>
                    <div class="inputGroup">
                        <div class="svgContainer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-calendar-date" viewBox="0 0 16 16">
                                <path
                                    d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z" />
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                        </div>
                        <input type="date" class="datepicker_input" placeholder="Choose a End Date" required
                            aria-label="Choose a End Date" name="txtEndDate">
                    </div>
                </div>
                <div class="inputContainer">
                    <p>Find Closure Date</p>
                    <div class="inputGroup">
                        <div class="svgContainer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-calendar-date" viewBox="0 0 16 16">
                                <path
                                    d="M6.445 11.688V6.354h-.633A12.6 12.6 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61h.675zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82h-.684zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23z" />
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                        </div>
                        <input type="date" class="datepicker_input" placeholder="Choose a Final Closure Date" required
                            aria-label="Choose a Final Closure Date" name="txtClosureDate">
                    </div>
                </div>
            </div>
            <div class="buttonContainer">
                <button class="button" type="submit" name="btnSave">Add</button>
                <button type="button" onclick="window.location.href='topics.php'">Cancel</button>
            </div>
        </div>
    </form>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/js/bootstrap.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.1.4/dist/js/datepicker-full.min.js'></script>
    <script src="./dateTimepicker.js"></script>
</body>

</html>