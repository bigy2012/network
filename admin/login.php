<?php
    session_start();
    include('../conn.php');

    $_SESSION['index'] = "active";

    if(isset($_POST['login_admin'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT `a_id`,`a_name` FROM `admin` WHERE `a_email`='$email' AND `a_pass`='$password'";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['admin_id'] = $row['a_id'];
            $_SESSION['admin_name'] = $row['a_name'];
            echo "
            <script>
                location.href='index.php'
            </script>
            ";
        }else{
            echo "
            <script>
                alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง')
            </script>
            ";
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

    <link rel="stylesheet" href="../include/css/bootstrap.min.css">
    <link rel="stylesheet" href="../include/css/style.css">
    
</head>
<body>
    <div class="container" style="margin-top:160px">
        
        <div class="row justify-content-center">
            <div class="col-auto">
                <form class="mb-2" action="login.php" method="post">
                    <h2 class="text-center">ลงชื่อเข้าใช้ผู้ดูแลระบบ</h2>
                    <div class="row mb-2">
                        <div class="col-auto mb-2">
                            <label for="email">อีเมล</label>
                        </div>
                        <div class="col-auto mb-2">
                            <input class="form-control" type="email" name="email" id="email" placeholder="อีเมล" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-auto mb-2">
                            <label for="password">รหัสผ่าน</label>
                        </div>
                        <div class="col-auto mb-2">
                            <input class="form-control" type="password" name="password" id="password" placeholder="รหัสผ่าน" required>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary" type="submit" name="login_admin" value="1">เข้าสู่ระบบ</button>
                </form>
                <button class="btn btn-outline-danger" onclick="location.href='../.'">กลับหน้าแรก</button>
            </div>
            
        </div>
    </div>
    <?php include("include/script.php") ?>
</body>
</html>