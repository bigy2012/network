<?php
    session_start();
    include('../conn.php');
    include('include/check_login.php');

    $_SESSION['user'] = "active";
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
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col">อีเมล</th>
                    <th scope="col">รหัสผ่าน</th>
                    <th scope="col">ปีเกิด</th>
                    <th scope="col">เพศ</th>
                    <th scope="col">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `user` where u_id > 0 ORDER By u_id DESC";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $btn = null;
                            if($row['u_status'] == "1"){
                                $btn = '<button class="btn btn-outline-danger" onclick="disable('.$row['u_id'].')">ปิดการใช้งาน</button>';
                            }elseif($row['u_status'] == "2"){
                                $btn = '<button class="btn btn-outline-primary" onclick="enable('.$row['u_id'].')">เปิดการใช้งาน</button>';
                            }
                            echo '
                            <tr>
                                <th scope="row">'.$row['u_id'].'</th>
                                <td>'.$row['u_fname'].' '.$row['u_lname'].'</td>
                                <td>'.$row['u_email'].'</td>
                                <td>'.$row['u_pass'].'</td>
                                <td>'.$row['u_dob'].'</td>
                                <td>'.$row['u_sex'].'</td>
                                <td>'.$btn.'</td>
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