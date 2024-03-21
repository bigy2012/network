<?php
    session_start();
    include('conn.php');
    include('include/check_login.php');

    $_SESSION['friend'] = "active";
    $user_id = $_SESSION['user_id'];
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
        <h3 class="text-center">คำขอเป็นเพื่อน</h3>
        <div class="row justify-content-center">
            <div class="col-auto">
            <?php 
                    $sql = "SELECT
                    friend.f_id, 
                    friend.f_status, 
                    `user`.u_id, 
                    `user`.u_fname, 
                    `user`.u_lname, 
                    `user`.u_img
                FROM
                    friend
                    INNER JOIN
                    `user`
                    ON 
                        friend.f_user_add = `user`.u_id
                WHERE
                    friend.f_user = '$user_id' AND
                    friend.f_status = 0";
                $result = mysqli_query($con,$sql);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $friend_id = $row['f_id'];
                        echo '
                            <div class="card mb-2">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="img/profile/'.$row['u_img'].'" width="100%">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><a class=" text-decoration-none" href="profile.php?user_id='.$row['u_id'].'">'.$row['u_fname'].' '.$row['u_lname'].'</a></h5>
                            ';
                            echo '<button class="btn btn-outline-primary mb-2" onclick="confirm_add('.$friend_id.')">ยืนยันคำขอเป็นเพื่อน</button>';
                                    echo '<button class="btn btn-outline-danger mb-2" onclick="delete_add('.$friend_id.')">ลบคำขอเป็นเพื่อน</button>';
                            echo '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }else{
                    echo '<div class="row justify-content-center mb-5">
                <div class="col-auto">
                    
                <div class="card">
                    <div class="card-body">ไม่มีคำขอเป็นเพื่อน</div>
                </div>
    
                </div>
            </div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php include("include/footer.php") ?>
    <?php include("include/script.php") ?>
</body>
</html>