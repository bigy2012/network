<?php
    if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) && !isset($_SESSION['user_img'])){
        echo "
        <script>
        location.href='login.php';
        </script>
        ";
    }
?>