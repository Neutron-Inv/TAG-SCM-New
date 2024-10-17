<?php

// db settings
$hostname = '127.0.0.1';
$username = 'enabstgd_developer';
$password = 'developer@2020';
$database = 'enabstgd_tag_scm';

// db connection
$con = mysqli_connect($hostname, $username, $password, $database) or die("Error " . mysqli_error($con));
 
 
$rfq_id = $_POST['rfq_id'];

$sql = "SELECT contact_id from client_rfqs WHERE rfq_id='$rfq_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$contact = $row['contact_id'];

$sql2 = "SELECT email from client_contacts WHERE contact_id='$contact'";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);

echo $row2['email'];
            
?>