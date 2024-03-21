<?php
    session_start();
    include("../conn.php");
    if($_POST['post_id']){
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $post_id = $_POST['post_id'];
        $text_comment = $_POST['text_comment'];
        
        $sql = "INSERT INTO `post_comment`(`pc_id`, `pc_post`, `pc_user`, `pc_text`) 
        VALUES (null,'$post_id','$user_id','$text_comment')";
        if(mysqli_query($con,$sql)){
            echo '
            <div class="row">
                <div class="col-auto">
                    <div class="card bg-transparent border border-0">
                        <div class="card-body">
                            <h5 class="card-title"><a class="text-decoration-none" href="profile.php?user_id='.$user_id.'">'.$user_name.'</a></h5>
                            <p class="card-text">'.$text_comment.'</p>
                        </div>
                    </div>
                </div>
            </div>
        ';
        }
        
    }
?>