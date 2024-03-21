<?php
    session_start();
    include('conn.php');
    include('include/check_login.php');
    $post_id = null;
    if(isset($_GET['post_id'])){
        $post_id = $_GET['post_id'];
        $sql = "SELECT * FROM `post` WHERE `p_id`=".$post_id;
        $result = mysqli_query($con,$sql);
        $row = null;
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if($row['p_user'] != $_SESSION['user_id']){
                echo "
                <script>
                    alert('ผู้ใช้ไม่สามารถแก้ไขโพสนี้ได้')
                    location.href='.'
                </script>
                ";
            }
        }
    }else{
        echo "
        <script>
            alert('ไม่พบโพส')
            location.href='.'
        </script>
        ";
    }
    
    if(isset($_POST['edit_post'])){
        $text = $_POST['text'];
        $sql = null;
        if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
            $filename = rand().date("dmY_his").strrchr($_FILES['img']['name'],".");
            $sql = "UPDATE `post` SET `p_text`='$text',`p_img`='$filename' WHERE `p_id`=".$post_id;
        }else{
            $sql = "UPDATE `post` SET `p_text`='$text' WHERE `p_id`=".$post_id;
        }
        if($sql != null){
            if(mysqli_query($con,$sql)){
                if(isset($_FILES['img']) && $_FILES['img']['name'] != ""){
                    move_uploaded_file($_FILES['img']['tmp_name'],"img/post/".$filename);
                }
                echo "
                    <script>
                        alert('แก้ไขโพสสำเร็จ');
                        location.href='.'
                    </script>
                ";
            }else{
                echo "
                    <script>
                        alert('แก้ไขโพสไม่สำเร็จ');
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
    <div class="container text-center" style="margin-top:160px">
        <h3 class="mb-2">แก้ไขโพส</h3>
        <form action="edit_post.php?post_id=<?php echo $post_id; ?>" method="post" enctype="multipart/form-data">
            <div class="row mb-2">
                <div class="col-4">
                    <label for="text">ข้อความโพส</label>
                </div>
                <div class="col-6">
                    <textarea class="form-control" name="text" id="text" style="resize:none" required placeholder="โพสข้อความหรือรูปภาพ"><?php echo $row['p_text'] ?></textarea>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <label>รูปภาพ</label>
                </div>
                <div class="col-6">
                    <?php 
                        if($row['p_img'] != null){
                            echo '<img src="img/post/'.$row['p_img'].'" width="100%">';
                        }
                    ?>
                    <input type="file" class="form-control" name="img" accept="image/*">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <button class="btn btn-outline-primary" name="edit_post" type="submit">บันทึก</button>
                </div>
            </div>
        </form>
    </div>
    <?php include("include/footer.php") ?>
    <?php include("include/script.php") ?>
</body>
</html>