<?php
    session_start();
    include('conn.php');

    if(isset($_SESSION['user_id']) && isset($_SESSION['user_name']) && isset($_SESSION['user_img'])){
        echo "
        <script>
        location.href='.';
        </script>
        ";
    }

    if(isset($_POST['register'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $date = $_POST['date'];
        $sex = $_POST['sex'];
        if($password == $password_confirm){
            $sql = "SELECT `u_id` FROM `user` WHERE `u_email`='$email'";
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result) == 0){
                $img = null;
                if($sex == "M"){
                    $img = "M.png";
                }elseif($sex == "F"){
                    $img = "F.png";
                }
                $sql = "INSERT INTO `user`(`u_id`, `u_fname`, `u_lname`, `u_email`, `u_pass`, `u_dob`, `u_sex`, `u_img`, `u_status`) 
                VALUES (null,'$fname','$lname','$email','$password','$date','$sex','$img','0')";
                if(mysqli_query($con,$sql)){
                    echo "
                        <script>
                            alert('สมัครสมาชิกสำเร็จ');
                            location.href='index.php';
                        </script>
                    ";
                }else{
                    echo "
                        <script>
                            alert('สมัครสมาชิกไม่สำเร็จ');
                        </script>
                    ";
                }
            }else{
                echo "
                        <script>
                            alert('มีอีเมลนี่ในระบบแล้ว');
                        </script>
                    ";
            }
        }else{
            echo "
            <script>
                alert('รหัสผ่านไม่ตรงกัน');
            </script>
            ";
        }
    }
    if(isset($_POST['login'])){
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];

        $sql = "SELECT * FROM `user` WHERE `u_email`='$email' AND `u_pass`='$password'";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if($row['u_status'] == "0"){
                echo "
                    <script>
                        alert('ยังไม่อนุญาตให้ใช้งาน');
                    </script>
                ";
            }elseif($row['u_status'] == "1"){
                $_SESSION['user_id'] = $row['u_id'];
                $_SESSION['user_name'] = $row['u_fname']." ".$row['u_lname'];
                $_SESSION['user_img'] = $row['u_img'];
                echo "
                <script>
                    location.href='index.php';
                </script>
                ";
            }elseif($row['u_status'] == "2"){
                echo "
                <script>
                    alert('ไม่สามารถใช้งานได้');
                </script>
                ";
            }
        }else{
            echo "
                <script>
                    alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง');
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
    <?php include("include/link.php") ?>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand">ระบบเครือข่ายสังคมออนไลน์</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar" style="font-size:20px">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item"></li>
      </ul>
      <form class="d-flex" action="login.php" method="POST">
        <div class="row">
            <div class="col-auto">
                <input class="form-control" type="email" name="login_email" placeholder="อีเมล" value="<?php if(isset($_POST['login_email'])) echo $_POST['login_email'] ?>" required>
            </div>
            <div class="col-auto">
                <input class="form-control" type="password" name="login_password" placeholder="รหัสผ่าน" value="<?php if(isset($_POST['login_password'])) echo $_POST['login_password'] ?>" required>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-primary" type="submit" name="login" value="1">เข้าสู่ระบบ</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</nav>
    <div class="container mt-4 text-center">
        <label class="mb-2" style="font-size:20px">สมัครสมาชิก</label>
        <div class="row justify-content-center">
            <form class="col-auto" action="login.php" method="POST">
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="fname">ชื่อ</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="text" name="fname" id="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname'] ?>" required>
                    </div>
                    <div class="col-auto mb-2">
                        <label for="lname">นามสกุล</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="text" name="lname" id="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname'] ?>" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="email">อีเมล</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="email" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="password">รหัสผ่าน</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="password" name="password" id="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" minlength="8" required>
                    </div>
                    <div class="col-auto mb-2">
                        <label for="password_confirm">ยืนยันรหัสผ่าน</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="password" name="password_confirm" id="password_confirm" value="<?php if(isset($_POST['password_confirm'])) echo $_POST['password_confirm'] ?>" minlength="8" required>
                    </div>
                </div>
                <div class="row mb-2 mb-2">
                    <div class="col-auto mb-2">
                        <label for="date">วัน/เดือน/ปีเกิด</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="date" name="date" id="date" value="<?php if(isset($_POST['date'])) echo $_POST['date'] ?>" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="">เพศ</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-check" type="radio" name="sex" id="sex1" value="M" <?php if(isset($_POST['sex']) && $_POST['sex']== "M") echo "checked" ?> required>
                        <label class="form-check-label" for="sex1">ชาย</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-check" type="radio" name="sex" id="sex2" value="F" <?php if(isset($_POST['sex']) && $_POST['sex']== "F") echo "checked" ?> required>
                        <label class="form-check-label" for="sex2">หญิง</label>
                    </div>
                </div>
                <button class="btn btn-outline-primary" type="submit" name="register" value="1">สมัครสมาชิก</button>
            </form>
        </div>
        
        
    </div>
    <?php include("include/footer.php") ?>
    <?php include("include/script.php") ?>
</body>
</html>