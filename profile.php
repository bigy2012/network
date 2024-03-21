<?php
    session_start();
    include('conn.php');
    include('include/check_login.php');
    $user_id = null;
    $user = $_SESSION['user_id'];
    if(isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $sql = "SELECT * FROM `user` WHERE `u_id`=".$user_id;
        $result = mysqli_query($con,$sql);
        $name = null;
        $img_img = null;
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $name = $row['u_fname']." ".$row['u_lname'];
            $img_img = $row['u_img'];
        }else{
            echo "
                <script>
                    alert('ไม่พบผู้ใช้งาน')
                    location.href='.'
                </script>
        ";
        }
    }else{
        echo "
        <script>
            alert('ไม่พบผู้ใช้งาน')
            location.href='.'
        </script>
        ";
    }

    if(isset($_POST['post'])){
        $text = $_POST['text'];
        $date = date("Y-m-d");
        $time = date("H:i");
        $sql = null;
        if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
            $filename = rand().date("dmY_his").strrchr($_FILES['img']['name'],".");
            $sql = "INSERT INTO `post`(`p_id`, `p_user`, `p_text`, `p_img`, `p_date`, `p_time`) 
            VALUES (null,'$user','$text','$filename','$date','$time')";
        }else{
            $sql = "INSERT INTO `post`(`p_id`, `p_user`, `p_text`, `p_img`, `p_date`, `p_time`) 
            VALUES (null,'$user','$text',null,'$date','$time')";
        }
        if($sql != null){
            if(mysqli_query($con,$sql)){
                if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
                    move_uploaded_file($_FILES['img']['tmp_name'],"img/post/".$filename);
                }
            }else{
                echo "
                    <script>
                        alert('โพสไม่สำเร็จ');
                    </script>
                ";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบเครือข่ายสังคมออนไลน์</title>
    <?php include("include/link.php") ?>
</head>
<body>
    <?php include("include/navbar.php") ?>
    <div class="container" style="margin-top:160px">
        <div class="row mb-4">
            <div class="col-4 text-center">
                <img src="img/profile/<?php echo $img_img; ?>" class="rounded-circle" width="100%">
                <?php 
                    if($_GET['user_id'] == $_SESSION['user_id']){
                        echo '
                        <input class="d-none" type="file" id="img_profile" accept="image/*">
                        <button class="btn btn-outline-primary mt-2" id="btn_profile" >เปลี่ยนรูป</button>
                        ';
                    }
                ?>
            </div>
            <div class="col-auto">
                <h3><?php echo $name; ?></h3>
                <label>เพื่อน <?php 
                $sql = "SELECT
                friend.f_id
            FROM
                friend
                INNER JOIN
                `user`
                ON 
                    friend.f_user_add = `user`.u_id OR
                    friend.f_user = `user`.u_id
            WHERE
                (
                    (
                        friend.f_user_add = '$user_id'
                    ) OR
                    (
                        friend.f_user = '$user_id'
                    )
                    
                ) AND
                friend.f_status = 1 AND
                `user`.u_id <> '$user_id'
            GROUP BY
                `user`.u_id";
                $result = mysqli_query($con,$sql);
                echo mysqli_num_rows($result);
                ?> คน </label>
                <button class="btn btn-primary mb-2" onclick="location.href='?user_id=<?php echo $user_id ?>&friend'">ดู</button>
                <br>
                <?php
                    if($user_id != $user){
                        $sql = "SELECT * FROM `friend` WHERE `f_user_add`='$user_id' AND `f_user`='$user' OR `f_user_add`='$user' AND `f_user`='$user_id'";
                        $result = mysqli_query($con,$sql);
                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                            $friend_id = $row['f_id'];
                            if($row['f_status'] == "0"){
                                if($row['f_user_add'] == $user){
                                    echo '<button class="btn btn-outline-primary" onclick="cancel_add('.$friend_id.')">ยกเลิกคำขอเป็นเพื่อน</button>';
                                }elseif($row['f_user'] == $user){
                                    echo '<button class="btn btn-outline-primary mb-2" onclick="confirm_add('.$friend_id.')">ยืนยันคำขอเป็นเพื่อน</button>';
                                    echo '<button class="btn btn-outline-danger mb-2" onclick="delete_add('.$friend_id.')">ลบคำขอเป็นเพื่อน</button>';
                                }
                            }elseif($row['f_status'] == "1"){
                                echo '<button class="btn btn-outline-primary" onclick="cancel_friend('.$friend_id.')">เลิกเป็นเพื่อน</button>';
                            }
                        }else{
                            echo '<button class="btn btn-outline-primary" onclick="add_friend('.$user_id.')">เพิ่มเพื่อน</button>';
                        }
                    }
                    
                ?>
                
            </div>
        </div>
        <?php 
        if(!isset($_GET['friend'])){
            if($user_id == $_SESSION['user_id']){ 
        ?>
            <div class="row justify-content-center mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">โพส</div>
                        <div class="card-body">
                            <h4 class="card-title"><img class="rounded-circle" src="img/profile/<?php if(isset($_SESSION['user_img'])) echo $_SESSION['user_img'] ?>" width="10%"><br><?php if(isset($_SESSION['user_name'])) echo $_SESSION['user_name'] ?></h4>
                            <form class="card-text" action="profile.php?user_id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">
                                <textarea class="form-control" name="text" style="resize:none" required placeholder="โพสข้อความหรือรูปภาพ"></textarea>
                                <input class="form-control mb-2" name="img" type="file" accept="image/*">
                                <button class="btn btn-primary" type="submit" name="post" value="1">โพส</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } 
        
        $sql = "SELECT
        post.p_id, 
        post.p_user, 
        `user`.u_fname, 
        `user`.u_lname, 
        `user`.u_img, 
        post.p_text, 
        post.p_img, 
        post.p_date, 
        post.p_time
    FROM
        post
        INNER JOIN
        `user`
        ON 
            post.p_user = `user`.u_id
        INNER JOIN
        friend
        ON 
            post.p_user = friend.f_user_add OR
            post.p_user = friend.f_user
    WHERE
        post.p_user = '$user_id'
    GROUP BY
	    post.p_id
    ORDER BY
        post.p_id DESC";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $date = strtotime(date("Y-m-dH:i"))-strtotime($row['p_date'].$row['p_time']);
                $day = round($date/86400);
                $post_time = $day." วันที่แล้ว";
                if($day == 0){
                    $hour = round($date/4260);
                    $post_time = $hour." ชั่วโมงที่แล้ว";
                    if($hour == 0){
                        $minute = round($date/60);
                        $post_time = $minute." นาทีที่แล้ว";
                    }
                }

                $post_img = null;
                if($row['p_img'] != null){
                    $post_img = '<img src="img/post/'.$row['p_img'].'" width="100%">';
                }

                $sql_like = "SELECT `pl_id` FROM `post_like` WHERE `pl_post`='".$row['p_id']."' AND `pl_status`='1'";
                $result_like = mysqli_query($con,$sql_like);
                $like_num = mysqli_num_rows($result_like);

                $sql_like = "SELECT `pl_id` FROM `post_like` WHERE `pl_post`='".$row['p_id']."' AND `pl_user`='".$user."' AND `pl_status`='1'";
                $result_like = mysqli_query($con,$sql_like);
                $like = "ถูกใจ";
                if(mysqli_num_rows($result_like) > 0){
                    $like = "ยกเลิกถูกใจ";
                }

                $btn_post = null;
                if($row['p_user'] == $_SESSION['user_id']){
                    $btn_post = '
                        <div class="float-end m-2">
                            <a class="btn btn-outline-danger" id="btn_delete_post'.$row['p_id'].'" onclick="delete_post('.$row['p_id'].')">ลบ</a>
                        </div>
                        <div class="float-end m-2">
                            <a href="edit_post.php?post_id='.$row['p_id'].'" class="btn btn-outline-primary">แก้ไข</a>
                        </div>
                    ';
                }

                $sql_comment = "SELECT
                `user`.u_fname, 
                `user`.u_lname, 
                post_comment.pc_user,
                post_comment.pc_id, 
                post_comment.pc_post, 
                post_comment.pc_text
            FROM
                post_comment
                INNER JOIN
                `user`
                ON 
                    post_comment.pc_user = `user`.u_id
            WHERE
                post_comment.pc_post = ".$row['p_id'];
                $result_comment = mysqli_query($con,$sql_comment);
                $comment = null;
                if(mysqli_num_rows($result_comment)){
                    while($row_comment = mysqli_fetch_assoc($result_comment)){
                        $comment .= '
                        <div class="row">
                            <div class="col-auto">
                                <div class="card bg-transparent border border-0">
                                    <div class="card-body">
                                        <h5 class="card-title"><a class="text-decoration-none" href="profile.php?user_id='.$row_comment['pc_user'].'">'.$row_comment['u_fname'].' '.$row_comment['u_lname'].'</a></h5>
                                        <p class="card-text">'.$row_comment['pc_text'].'</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                    }
                }

                echo '<div class="row justify-content-center mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            '.$btn_post.'
                            <a class="card-title text-decoration-none text-dark" href="profile.php?user_id='.$row['p_user'].'" style="font-size:20px">
                                <img class="rounded-circle" src="img/profile/'.$row['u_img'].'" width="20%">
                            </a>
                            <div class="row">
                                <div class="col-auto">
                                    <a class="card-title text-decoration-none text-dark" href="profile.php?user_id='.$row['p_user'].'" style="font-size:20px">'.$row['u_fname'].' '.$row['u_lname'].'</a>
                                </div>
                            </div>
                            <p class="card-title"><small class="text-muted">โพสเมื่อ '.$post_time.'</small></p>
                            <p class="card-text">'.$row['p_text'].'</p>
                            '.$post_img.'
                        </div>
                        <div class="card-footer">
                            <div class="container">
                                <small class="text-muted mr-2">ถูกใจ <label id="like_'.$row['p_id'].'">'.$like_num.'</label> คน</small>
                                <div class="row justify-content-center mb-2">
                                    <div class="col-auto mb-2">
                                        <button class="btn" id="btn_like'.$row['p_id'].'" onclick="like('.$row['p_id'].')">'.$like.'</button>
                                    </div>
                                    <div class="col-auto mb-2">
                                        <button class="btn" onclick="focusMethod('.$row['p_id'].')">แสดงความคิดเห็น</button>
                                    </div>
                                </div>
                                <div id="comment_'.$row['p_id'].'">
                                    '.$comment.'
                                </div>
                    ';
                    if($user_id == $user){
                        echo '
                        <form class="input-group mb-2" action="include/comment.php" method="post" id="comment'.$row['p_id'].'" onsubmit="return comment(event,'.$row['p_id'].')">
                            <input class=" d-none" type="text" name="post_id" value="'.$row['p_id'].'" required>
                            <input class="form-control border border-0" type="text" name="text_comment" id="input_comment'.$row['p_id'].'" required placeholder="แสดงความคิดเห็น">    
                            <button class="btn btn-outline-primary border border-0" type="submit" >แสดงความคิดเห็น</button>
                        </form>
                        ';
                    }else{
                        $sql_comment = "SELECT
                            friend.f_id
                        FROM
                            friend
                            INNER JOIN
                            `user`
                            ON 
                                friend.f_user_add = `user`.u_id OR
                                friend.f_user = `user`.u_id
                        WHERE
                            (
                                (
                                    friend.f_user_add = '$user_id' AND
                                    friend.f_user = '$user'
                                ) OR
                                (
                                    friend.f_user = '$user_id' AND
                                    friend.f_user_add = '$user'
                                )
                            ) AND
                            friend.f_status = 1
                        GROUP BY
                            friend.f_id";
                        $result_comment = mysqli_query($con,$sql_comment);
                        if(mysqli_num_rows($result_comment) > 0){
                            echo '
                            <form class="input-group mb-2" action="include/comment.php" method="post" id="comment'.$row['p_id'].'" onsubmit="return comment(event,'.$row['p_id'].')">
                                <input class=" d-none" type="text" name="post_id" value="'.$row['p_id'].'" required>
                                <input class="form-control border border-0" type="text" name="text_comment" id="input_comment'.$row['p_id'].'" required placeholder="แสดงความคิดเห็น">    
                                <button class="btn btn-outline-primary border border-0" type="submit" >แสดงความคิดเห็น</button>
                            </form>
                            ';
                        }
                    }
                    
                    echo '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
        }else{
            echo '
            <div class="row justify-content-center mb-5">
                <div class="col-auto">
                    <div class="card">
                        <div class="card-body">ไม่มีการโพส</div>
                    </div>
                </div>
            </div>';
        }

        }else{
            ?>
        <div class="row justify-content-center mb-2">
            <div class="col-auto">
                <h3>เพื่อน</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-2">
            <div class="col-auto">
                <?php 
                    $sql = "SELECT
                    `user`.u_id, 
                    `user`.u_fname, 
                    `user`.u_lname, 
                    `user`.u_img
                FROM
                    friend
                    INNER JOIN
                    `user`
                    ON 
                        friend.f_user_add = `user`.u_id OR
                        friend.f_user = `user`.u_id
                WHERE
                    (
                        (
                            friend.f_user_add = '$user_id'
                        ) OR
                        (
                            friend.f_user = '$user_id'
                        )
                        
                    ) AND
                    friend.f_status = 1 AND
                    `user`.u_id <> '$user_id'
                GROUP BY
                    `user`.u_id";
                $result = mysqli_query($con,$sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '
                            <div class="card mb-2">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="img/profile/'.$row['u_img'].'" width="100%">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><a class=" text-decoration-none" href="?user_id='.$row['u_id'].'">'.$row['u_fname'].' '.$row['u_lname'].'</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php include("include/footer.php") ?>
    <?php include("include/script.php") ?>
</body>
</html>