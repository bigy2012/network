<?php
    include("../conn.php");
    if(isset($_POST['post_id'])){
        $post_id = $_POST['post_id'];
        $sql = "DELETE FROM `post` WHERE `p_id`=".$post_id;
        if(mysqli_query($con,$sql)){
            echo "susses";
        }else{
            echo "error";
        }
    }
?>