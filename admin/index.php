<?php
    session_start();
    include('../conn.php');
    include('include/check_login.php');

    $_SESSION['index'] = "active";

    if(isset($_GET['logout'])){
        if(isset($_SESSION['admin_id'])){
            unset($_SESSION['admin_id']);
        }
        if(isset($_SESSION['admin_name'])){
            unset($_SESSION['admin_name']);
        }
        echo "
        <script>
            location.href='login.php';
        </script>
        ";
    }
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
                    $sql = "SELECT * FROM `user` WHERE `u_status`=0 ORDER By u_id DESC";
                    $result = mysqli_query($con,$sql);
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '
                            <tr>
                                <th scope="row">'.$row['u_id'].'</th>
                                <td>'.$row['u_fname'].' '.$row['u_lname'].'</td>
                                <td>'.$row['u_email'].'</td>
                                <td>'.$row['u_pass'].'</td>
                                <td>'.$row['u_dob'].'</td>
                                <td>'.$row['u_sex'].'</td>
                                <td>
                                    <button class="btn btn-outline-primary" onclick="allow('.$row['u_id'].')">อนุญาติ</button>
                                    <button class="btn btn-outline-danger" onclick="not_allow('.$row['u_id'].')">ไม่อนุญาติ</button>
                                </td>
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