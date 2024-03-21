<?php
    session_start();
    include('conn.php');
    include('include/check_login.php');

    $user_id = $_SESSION['user_id'];
    if(isset($_POST['save_profile'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $password = $_POST['password'];
        $password_confrim = $_POST['password_confrim'];
        $date = $_POST['date'];
        $sex = $_POST['sex'];
        $sql = null;
        if($password != null && $password_confrim != null){
            if($password == $password_confrim){
                $sql = "UPDATE `user` SET `u_fname`='$fname',`u_lname`='$lname',`u_pass`='$password',`u_dob`='$date',`u_sex`='$sex' WHERE `u_id`=".$user_id;
            }else{
                echo "
                <script>
                    alert('รหัสผ่านไม่ตรงกัน');
                </script>
                ";
            }
        }else{
            $sql = "UPDATE `user` SET `u_fname`='$fname',`u_lname`='$lname',`u_dob`='$date',`u_sex`='$sex' WHERE `u_id`=".$user_id;
        }
        if($sql  != null){
            if(mysqli_query($con,$sql)){
                $_SESSION['user_name'] = $fname." ".$lname;
                echo "
                <script>
                    alert('บันทึกสำเร็จ');
                </script>
                ";
            }else{
                echo "
                <script>
                    alert('บันทึกไม่สำเร็จ');
                </script>
                ";
            }
        }
    }

    $sql = "SELECT * FROM `user` WHERE `u_id`=".$user_id;
    $result = mysqli_query($con,$sql);
    $row = null;
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

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
    <div class=" container" style="margin-top:160px">

        <h2 class="text-center mb-5">แก้ไขข้อมูลส่วนตัว</h2>

        <form class="row justify-content-center" action="edit_profile.php" method="post" enctype="multipart/form-data">
            <div class="col-auto">
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="fname">ชื่อจริง</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="text" name="fname" id="fname" value="<?php echo $row['u_fname'] ?>" required>
                    </div>
                    <div class="col-auto mb-2">
                        <label for="lname">นามสกุล</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="text" name="lname" id="lname" value="<?php echo $row['u_lname'] ?>" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label>อีเมล</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" tyle="email" disabled value="<?php echo $row['u_email'] ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="password">รหัสผ่าน</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="col-auto mb-2">
                        <label for="password_confrim">ยืนยันรหัสผ่าน</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="password" name="password_confrim" id="password_confrim">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="date">วัน/เดือน/ปีเกิด</label>
                    </div>
                    <div class="col-auto mb-2">
                        <input class="form-control" type="date" name="date" id="date" value="<?php echo $row['u_dob'] ?>" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-auto mb-2">
                        <label for="">เพศ</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-check" type="radio" name="sex" id="sex1" value="M" <?php if($row['u_sex'] == "M") echo "checked" ?> required>
                        <label class="form-check-label" for="sex1">ชาย</label>
                    </div>
                    <div class="col-auto">
                        <input class="form-check" type="radio" name="sex" id="sex2" value="F" <?php if($row['u_sex'] == "F") echo "checked" ?> required>
                        <label class="form-check-label" for="sex2">หญิง</label>
                    </div>
                </div>
                <button class="btn btn-outline-primary" type="submit" name="save_profile">บันทึก</button>
            </div>
        </form>
    </div>
    <?php include("include/footer.php") ?>
    <?php include("include/script.php") ?>
</body>
</html>