<?php
include("db/config.php");

// Fetch videos from database
$query = "SELECT video_name, video_data, upload_time FROM Videos";
$result = $mysqli->query($query);

$videos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Base64 encode video data for embedding
        $row['video_data'] = base64_encode($row['video_data']);
        $videos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($videos);

$mysqli->close();
?>