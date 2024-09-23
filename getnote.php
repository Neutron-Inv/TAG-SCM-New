<?php

// db settings
$hostname = '127.0.0.1';
$username = 'enabstgd_developer';
$password = 'developer@2020';
$database = 'enabstgd_tag_scm';

// db connection
$con = mysqli_connect($hostname, $username, $password, $database) or die("Error " . mysqli_error($con));
 
 
$rfq_id = $_POST['rfq_id'];

$sql = "SELECT note from client_rfqs WHERE rfq_id='$rfq_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

echo $row['note'];
            
?>