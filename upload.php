<?php
include("db/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["videoFile"])) {
    $videoName = $_FILES["videoFile"]["name"];
    $videoTmpName = $_FILES["videoFile"]["tmp_name"];
    $videoType = $_FILES["videoFile"]["type"];
    $videoSize = $_FILES["videoFile"]["size"];
    $uploadTime = date("Y-m-d H:i:s"); // Get current date and time

    // Validate file type
    $allowedTypes = array("video/mp4", "video/mpeg", "video/quicktime", "video/x-msvideo");
    if (!in_array($videoType, $allowedTypes)) {
        die("Invalid file type. Only MP4, MPEG, QuickTime, and AVI files are allowed.");
    }

    // Insert video into database
    $query = "INSERT INTO Videos (video_name, video_data, upload_time) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $videoName, $videoData, $uploadTime);
    $videoData = file_get_contents($videoTmpName);
    $stmt->send_long_data(1, $videoData);
    $stmt->execute();
    // $stmt->close();
    if ($stmt->errno) {
        echo "Failed to insert video: " . $stmt->error;
    } else {
        echo "Video uploaded successfully.";
        header("Location: dashboard.html");
    }

    // echo "Video uploaded successfully.";
} else {
    echo "No file uploaded.";
}

$mysqli->close();
?>
