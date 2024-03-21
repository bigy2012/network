<?php
    if(!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_name'])){
        echo "
        <script>
        location.href='login.php';
        </script>
        ";
    }
?>