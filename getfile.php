<?php
if (!isset($_GET['source'])){
$rfqId = isset($_POST['rfq_id']) ? $_POST['rfq_id'] : null;

if (!$rfqId) {
    // Handle the case where rfq_id is not provided
    echo json_encode(['error' => 'rfq_id not provided']);
    exit();
}

$dir = 'document/rfq/' . $rfqId . '/';
$files = [];

if (file_exists($dir)) {
    $dirFiles = scandir($dir);
    foreach ($dirFiles as $file) {
        if ($file != '.' && $file != '..') {
            $files[] = $file;
        }
    }
}

$response = [
    'directory' => $dir,
    'files' => $files,
];

echo json_encode($response);
exit();
}elseif(isset($_GET['source']) && $_GET['source'] == 'project'){
    
    $pid = isset($_POST['p_id']) ? $_POST['p_id'] : null;
    $cid = isset($_POST['c_id']) ? $_POST['c_id'] : null;
    if (!$pid || !$cid) {
        // Handle the case where rfq_id is not provided
        echo json_encode(['error' => 'p_id not provided']);
        exit();
    }
    
    $dir = 'document/client/' . $cid . '/'. $pid . '/';
    $files = [];
    
    if (file_exists($dir)) {
        $dirFiles = scandir($dir);
        foreach ($dirFiles as $file) {
            if ($file != '.' && $file != '..') {
                $files[] = $file;
            }
        }
    }
    
    $response = [
        'directory' => $dir,
        'files' => $files,
    ];
    
    echo json_encode($response);
    exit();
    
}
?>