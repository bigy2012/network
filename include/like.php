<?php
    session_start();
    include("../conn.php");
    if($_POST['post_id']){
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];
        $sql = "SELECT `pl_status` FROM `post_like` WHERE `pl_post`='$post_id' AND `pl_user`='$user_id'";
        $result = mysqli_query($con,$sql);

        $like = "like";
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if($row['pl_status'] == "1"){
                $sql_like = "UPDATE `post_like` SET `pl_status`='0' WHERE `pl_post`='".$post_id."' AND `pl_user`='$user_id'";
                $like = "unlike";
            }elseif($row['pl_status'] == "0"){
                $sql_like = "UPDATE `post_like` SET `pl_status`='1' WHERE `pl_post`='".$post_id."' AND `pl_user`='$user_id'";
            }
        }else{
            $sql_like = "INSERT INTO `post_like`(`pl_id`, `pl_post`, `pl_user`,`pl_status`) VALUES (null,'$post_id','$user_id','1')";
        }
        $num = null;
        if(mysqli_query($con,$sql_like)){
            $sql = "SELECT `pl_id` FROM `post_like` WHERE `pl_post`='$post_id' AND `pl_status`='1'";
            $result = mysqli_query($con,$sql);
            $num = mysqli_num_rows($result);
        }
        $output = array("like"=>$like,"num"=>$num);
        echo json_encode($output);
    }
?>