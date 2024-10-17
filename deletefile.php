<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the file and directory from the POST request
    $file = $_POST['file'];
    $directory = $_POST['directory'];

    // Construct the full path of the file to be deleted
    $filePath = $directory . '/' . $file;

    // Initialize response
    $response = array('success' => false);

    // Check if the file exists
    if (file_exists($filePath)) {
        // Try to delete the file
        if (unlink($filePath)) {
            // If successful, return success response
            $response['success'] = true;
        } else {
            // If the file couldn't be deleted, return an error
            $response['message'] = 'Failed to delete the file.';
        }
    } else {
        // If the file does not exist, return an error
        $response['message'] = 'File not found.';
    }

    // Return the JSON response
    echo json_encode($response);
} else {
    // If the request method is not POST, return an error
    echo json_encode(array('success' => false, 'message' => 'Invalid request.'));
}
?>