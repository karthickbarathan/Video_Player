<?php
include("db/config.php");

session_start();
if(isset($_POST['name']) && isset($_POST['password'])){
    $username = $_POST['name'];
    $password = $_POST['password'];

    $stmt = $mysqli-> prepare("Select * from users where name=?");
    $stmt->bind_param("s", $username);
    $stmt-> execute();
    $result = $stmt-> get_result();

    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        if($row['password']== $password){
            $_SESSION['$username'] = $username;
            header("Location: VideoUpload.html");
        }
        else{
            echo "Invalid Passsword!";
        }
    }
}

?>

