<?php
include("db/config.php");

// Check if videoName is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["videoName"])) {
    $videoName = $_POST["videoName"];

    // Delete video from database
    $query = "DELETE FROM Videos WHERE video_name = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $videoName);
    if ($stmt->execute()) {
        // Respond with success message
        http_response_code(204);
    } else {
        // Respond with error message
        http_response_code(500);
        echo "Error: Failed to delete video.";
        error_log("Error deleting video: " . $stmt->error);
    }
    $stmt->close();
} else {
    // Respond with error if videoName is not provided
    http_response_code(400);
    echo "Error: Video name not provided.";
}

$mysqli->close();
?>
