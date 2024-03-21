<?php
    session_start();
    include('conn.php');
    include('include/check_login.php');
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $fname = substr($search, 0 ,strpos($search, " "));
        $lname = substr($search,strpos($search, " "));
        $sql = "SELECT
            `user`.u_id,
            `user`.u_fname,
            `user`.u_lname,
            `user`.u_img
            FROM
            `user`
            WHERE
            `user`.u_fname LIKE '%".$fname."%' OR
            `user`.u_lname LIKE '%".$lname."%'";
        if($fname != ""){
            $sql = "SELECT
            `user`.u_id,
            `user`.u_fname,
            `user`.u_lname,
            `user`.u_img
            FROM
            `user`
            WHERE
            `user`.u_fname LIKE '%".$fname."%' OR
            `user`.u_lname LIKE '%".$fname."%'";
        }elseif($lname != ""){
            $sql = "SELECT
            `user`.u_id,
            `user`.u_fname,
            `user`.u_lname,
            `user`.u_img
            FROM
            `user`
            WHERE
            `user`.u_fname LIKE '%".$lname."%' OR
            `user`.u_lname LIKE '%".$lname."%'";
        }
        
        $result = mysqli_query($con,$sql);
        $output = array();
        if(mysqli_num_rows($result) > 0 ){
            while($row = mysqli_fetch_assoc($result)){
                $output[] = $row;
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
    <div class=" container" style="margin-top:160px">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-2">ค้นหา</h2>
                <?php
                    foreach($output as $key => $value){
                        echo '
                        <div class="card mb-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="img/profile/'.$value['u_img'].'" width="100%">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><a class=" text-decoration-none" href="profile.php?user_id='.$value['u_id'].'">'.$value['u_fname'].' '.$value['u_lname'].'</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                    if($output == null){
                        echo '
                        <div class="row justify-content-center mb-5">
                            <div class="col-auto">
                                <div class="card">
                                    <div class="card-body">ไม่พบชื่อ-นามสกุล</div>
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