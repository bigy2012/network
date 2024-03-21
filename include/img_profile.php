<?php
    session_start();
    include("../conn.php");
    if(isset($_FILES['edit_profile'])){
        $user_id =$_SESSION['user_id'];
        $filename = rand().date("dmY_his").strrchr($_FILES['edit_profile']['name'],".");
        $sql = "UPDATE `user` SET `u_img`='$filename' WHERE `u_id`=".$user_id;
        if(mysqli_query($con,$sql)){
            move_uploaded_file($_FILES['edit_profile']['tmp_name'],"../img/profile/".$filename);
            $_SESSION['user_img'] = $filename;
            echo "success";
        }else{
            echo "error";
        }
    }
?>