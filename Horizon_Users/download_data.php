<?php
// Establish database connection
include('connection.php');

// Retrieve column names using SHOW COLUMNS SQL statement
$columns_query = mysqli_query($connect, "SHOW COLUMNS FROM posts");

// Extract column names into an array
$column_names = array();
while ($column_row = mysqli_fetch_assoc($columns_query)) {
    $column_names[] = $column_row['Field'];
}

// Retrieve data from posts table
$data_query = mysqli_query($connect, "SELECT * FROM posts");

// Create CSV file
$file = fopen('posts_data.csv', 'w');

// Write column names to the first row of the CSV file
fputcsv($file, $column_names);

// Write data rows to the CSV file
while ($data_row = mysqli_fetch_assoc($data_query)) {
    // Format the date/time value
    $formatted_date = date('Y-m-d H:i:s', strtotime($data_row['Upload_Time']));
    $data_row['Upload_Time'] = $formatted_date;
    
    // Write the row to the CSV file
    fputcsv($file, $data_row);
}

// Close the CSV file and database connections
fclose($file);
mysqli_close($connect);

// Create a zip archive of the attachments folder and the CSV file
$zip = new ZipArchive();
$zip_name = 'data.zip';

if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
    exit("Cannot create zip archive");
}

// Add the attachments folder to the zip archive
$attachments_path = 'attachments/';
$attachments_folder = scandir($attachments_path);
foreach ($attachments_folder as $file) {
    if (is_file($attachments_path . $file)) {
        $zip->addFile($attachments_path . $file);
    }
}

// Add the CSV file to the zip archive
$zip->addFile('posts_data.csv', 'posts_data.csv');

// Close the zip archive
$zip->close();

// Download the zip archive
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename=data.zip');
header('Content-Length: ' . filesize($zip_name));
readfile($zip_name);

// Remove the temporary CSV file and zip archive
unlink('posts_data.csv');
unlink('data.zip');
?>
