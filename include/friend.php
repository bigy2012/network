<?php
    session_start();
    include("../conn.php");
    if(isset($_POST['cancel_add']) || isset($_POST['delete_add']) || isset($_POST['cancel_friend'])){
        $friend_id =$_POST['friend_id'];
        $sql = "DELETE FROM `friend` WHERE `f_id`=".$friend_id;
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
    if(isset($_POST['confirm_add'])){
        $friend_id =$_POST['friend_id'];
        $sql = "UPDATE `friend` SET `f_status`='1' WHERE `f_id`=".$friend_id;
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
    if(isset($_POST['add_friend'])){
        $user = $_SESSION['user_id'];
        $user_id =$_POST['user_id'];
        $sql = "INSERT INTO `friend`(`f_id`, `f_user_add`, `f_user`, `f_status`) VALUES (null,'$user','$user_id','0')";
        if(mysqli_query($con,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
?>