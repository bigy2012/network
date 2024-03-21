<?php
    include('../../conn.php');
    if(isset($_POST['allow'])){
        $user_id = $_POST['user_id'];
        $sql = "UPDATE `user` SET `u_status`='1' WHERE `u_id`=".$user_id;
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
    if(isset($_POST['not_allow'])){
        $user_id = $_POST['user_id'];
        $sql = "DELETE FROM `user` WHERE `u_id`=".$user_id;
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
    if(isset($_POST['enable'])){
        $user_id = $_POST['user_id'];
        $sql = "UPDATE `user` SET `u_status`='1' WHERE `u_id`=".$user_id;
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
    if(isset($_POST['disable'])){
        $user_id = $_POST['user_id'];
        $sql = "UPDATE `user` SET `u_status`='2' WHERE `u_id`=".$user_id;
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
?>