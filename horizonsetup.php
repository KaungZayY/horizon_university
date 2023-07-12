<?php 
	$connect = mysqli_connect('localhost', 'root', '', 'horizon_university');

	//delete Reacts table
	$delete = "DROP TABLE Reacts";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Reacts Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Comments table
	$delete = "DROP TABLE Comments";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Comments Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Action table
	$delete = "DROP TABLE tbl_action";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Action Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}
	
	//delete Posts table
	$delete = "DROP TABLE Posts";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Posts Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Users table
	$delete = "DROP TABLE Users";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Users Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Departments table
	$delete = "DROP TABLE Departments";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Departments Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Topics table
	$delete = "DROP TABLE Topics";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Topics Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Categories table
	$delete = "DROP TABLE Categories";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Categories Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Roles table
	$delete = "DROP TABLE Roles";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Roles Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Admin table
	$delete = "DROP TABLE Admin";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Admin Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//delete Password_reset table
	$delete = "DROP TABLE Password_reset";
	$query = mysqli_query($connect, $delete);
	if ($query) 
	{
		echo "<script>alert('Password_reset Table Deleted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}
	
	// -----------------------------------------------------------------------------------------

	//create Admin table
	$create = "CREATE TABLE Admin
				(Admin_ID varchar(40) NOT NULL PRIMARY KEY,
				A_UserName varchar(50),
				A_Password varchar(30))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Admin Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	$insert = "INSERT INTO Admin VALUES ('A-00001', 'admin', 'admin')";
	$query = mysqli_query($connect, $insert);

	if ($query) 
	{
		echo "<script>alert('Admin Data Inserted')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//create Password_reset table
	$create = "CREATE TABLE Password_reset
				(id int(11) NOT NULL PRIMARY KEY,
				email varchar(255),
				token varchar(255),
				expire_time datetime)";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Password_reset Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Roles table
	$create = "CREATE TABLE Roles
				(Role_ID varchar(40) NOT NULL PRIMARY KEY,
				Role varchar(50))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Roles Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	$insert = "INSERT INTO Roles
				VALUES
				    ('R-000001', 'QA Manager'),
				    ('R-000002', 'QA Coordinator'),
				    ('R-000003', 'Normal Staff');";
	$query = mysqli_query($connect, $insert);

	if ($query) {
		echo "<script>alert('Roles Data Inserted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Categories table
	$create = "CREATE TABLE Categories
				(Category_ID varchar(40) NOT NULL PRIMARY KEY,
				Category_Name varchar(50))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Categories Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Topics table
	$create = "CREATE TABLE Topics
				(Topic_ID varchar(40) NOT NULL PRIMARY KEY,
				Topic_Name varchar(50),
				StartDate date,
				ClosureDate date,
				FinalClosureDate date)";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Topics Table Created')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}

	//create Departments table
	$create = "CREATE TABLE Departments
				(Department_ID varchar(40) NOT NULL PRIMARY KEY,
				Department_Name varchar(50))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Departments Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	$insert = "INSERT INTO Departments
				VALUES
				    ('D-000001', 'Academic'),
				    ('D-000002', 'Student Affairs'),
				    ('D-000003', 'Finance'),
				    ('D-000004', 'Sales and Marketing');";
	$query = mysqli_query($connect, $insert);

	if ($query) {
		echo "<script>alert('Roles Data Inserted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Users table
	$create = "CREATE TABLE Users
				(User_ID varchar(40) NOT NULL PRIMARY KEY,
				User_Name varchar(50),
				User_Email varchar(255),
				User_Password varchar(255),
				DOB date,
				PhoneNumber varchar(30),
				Address varchar(255),
				Photo text,
				Role_ID varchar(40),
				Department_ID varchar(40),
				FOREIGN KEY (Role_ID) REFERENCES Roles (Role_ID),
				FOREIGN KEY (Department_ID) REFERENCES Departments (Department_ID))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Users Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Posts table
	$create = "CREATE TABLE Posts
				(Post_ID varchar(40) NOT NULL PRIMARY KEY,
				Post text,
				Anonymous boolean,
				Upload_Time datetime,
				View_Count int,
				Like_Count int,
				Dislike_Count int,
				Document text,
				Title varchar(128),
				Category_ID varchar(40),
				User_ID varchar(40),
				Topic_ID varchar(40),
				FOREIGN KEY (Category_ID) REFERENCES Categories (Category_ID),
				FOREIGN KEY (User_ID) REFERENCES Users (User_ID),
				FOREIGN KEY (Topic_ID) REFERENCES Topics (Topic_ID))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Posts Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Action table
	$create = "CREATE TABLE tbl_action
				(Action_ID int NOT NULL PRIMARY KEY,
				Action varchar(7),
				View varchar(1),
				User_ID varchar(40),
				Post_ID varchar(40),
				FOREIGN KEY (User_ID) REFERENCES Users (User_ID),
				FOREIGN KEY (Post_ID) REFERENCES Posts (Post_ID))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Action Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Comments table
	$create = "CREATE TABLE Comments
				(Comment_ID varchar(40) NOT NULL PRIMARY KEY,
				Comment text,
				Anonymous boolean,
				Upload_Date date,
				Upload_Time time,
				Post_ID varchar(40),
				User_ID varchar(40),
				FOREIGN KEY (Post_ID) REFERENCES Posts (Post_ID),
				FOREIGN KEY (User_ID) REFERENCES Users (User_ID))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Comments Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Reacts table
	$create = "CREATE TABLE Reacts
				(React_ID varchar(40) NOT NULL PRIMARY KEY,
				React varchar(50),
				Post_ID varchar(40),
				User_ID varchar(40),
				FOREIGN KEY (Post_ID) REFERENCES Posts (Post_ID),
				FOREIGN KEY (User_ID) REFERENCES Users (User_ID))";
	$query = mysqli_query($connect, $create);
	if ($query) 
	{
		echo "<script>alert('Reacts Table Created')</script>";
	}
	else 
	{
		echo mysqli_error($connect);
	}
?>