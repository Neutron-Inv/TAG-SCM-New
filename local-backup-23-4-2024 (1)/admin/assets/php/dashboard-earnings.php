<?php
$mysqli = new mysqli("localhost", "root", "", "enabstgd_scm_portal");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$year = date('Y');

$currentMonth = date("n"); // n returns the month without leading zeros

// Create an array with months from 1 to the current month
$allMonths = range(1, $currentMonth);

$query = "SELECT MONTH(rfq_date) AS month, SUM(total_quote) AS value FROM client_rfqs WHERE YEAR(rfq_date)='$year' GROUP BY MONTH(rfq_date)";
$result = $mysqli->query($query);


if (!$result) {
    die("Error in query: " . mysqli_error($mysqli));
}

$data = array();

// Initialize an associative array with 0 values for all months
$monthlyData = array_fill_keys($allMonths, 0);

while ($row = $result->fetch_assoc()) {
    // Update the value for the corresponding month
    $monthlyData[$row['month']] = $row['value'];
}

// Convert the associative array to a simple array
foreach ($allMonths as $month) {
    $data[] = array(
        'month' => $month,
        'value' => $monthlyData[$month]
    );
}

echo json_encode($data);

$mysqli->close();
?>