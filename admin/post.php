<?php
    session_start();
    include('../conn.php');
    include('include/check_login.php');

    $_SESSION['post'] = "active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบเครือข่ายสังคมออนไลน์</title>

    <link rel="stylesheet" href="../include/css/bootstrap.min.css">
    <link rel="stylesheet" href="../include/css/style.css">
    
</head>
<body>
    <?php include("include/navbar.php") ?>
    <div class="container" style="margin-top:160px">
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ไอดี</th>
                    <th scope="col">อีเมล</th>
                    <th scope="col">ข้อความ</th>
                    <th scope="col">รูป</th>
                    <th scope="col">วันที่</th>
                    <th scope="col">เวลา</th>
                    <th scope="col">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT
                    `user`.u_email, 
                    post.p_id,
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
                ORDER BY
                    post.p_id DESC";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $img = null;
                            if($row['p_img'] != null){
                                $img = '<img src="../img/post/'.$row['p_img'].'" width="100%">';
                            }
                            echo '
                            <tr>
                                <th scope="row">'.$row['p_id'].'</th>
                                <td>'.$row['u_email'].'</td>
                                <td>'.$row['p_text'].'</td>
                                <td>'.$img.'</td>
                                <td>'.$row['p_date'].'</td>
                                <td>'.$row['p_time'].'</td>
                                <td><button class="btn btn-outline-danger" onclick="delete_post('.$row['p_id'].')">ลบโพส</button></td>
                            </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    <?php include("include/script.php") ?>
</body>
</html>