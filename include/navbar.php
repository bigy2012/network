<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand">ระบบเครือข่ายสังคมออนไลน์</a>
    <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <form action="search.php" method="post">
      <div class="row justify-content-center">
        <div class="col-auto mb-2">
          <input class="form-control" type="text" name="search" value="<?php if(isset($_POST['search'])) echo $_POST['search'] ?>" placeholder="ชื่อ-นามสกุล" required>
        </div>
        <div class="col-auto mb-2">
          <button class="btn btn-outline-primary" type="submit">ค้นหาเพื่อน</button>
        </div>
      </div>
    </form>
    <div class="collapse navbar-collapse" id="navbar" style="font-size:20px">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link <?php if (isset($_SESSION['index'])) echo $_SESSION['index']; ?>" href=".">หน้าแรก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (isset($_SESSION['friend'])) echo $_SESSION['friend']; ?>" href="friend.php">คำขอเป็นเพื่อน</a>
        </li>
      </ul>
      <div class="d-flex dropdown">
        <a class="text-dark text-decoration-none" href="profile.php?user_id=<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; ?>"><?php if (isset($_SESSION['user_name'])) echo $_SESSION['user_name']; ?></a>
        <a class="nav-link dropdown-toggle text-dark" href="#" id="user_menu" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
        <ul class="dropdown-menu" aria-labelledby="user_menu">
          <li><a class="dropdown-item" href="edit_profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href=".?logout=1">ออกจากระบบ</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<?php
if (isset($_SESSION['index'])) {
  unset($_SESSION['index']);
}
if (isset($_SESSION['friend'])) {
  unset($_SESSION['friend']);
}

?>