<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand">ระบบเครือข่ายสังคมออนไลน์</a>
    <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar" style="font-size:20px">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll">
        <li class="nav-item">
          <a class="nav-link <?php if (isset($_SESSION['index'])) echo $_SESSION['index']; ?>" href=".">คำขอใช้งาน</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (isset($_SESSION['user'])) echo $_SESSION['user']; ?>" href="user.php">จัดการผู้ใช้</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if (isset($_SESSION['post'])) echo $_SESSION['post']; ?>" href="post.php">จัดการโพส</a>
        </li>
      </ul>
      <div class="d-flex">
        <label><?php if(isset($_SESSION['admin_name'])) echo $_SESSION['admin_name'] ?></label>
        <button class="btn btn-outline-danger" onclick="location.href='index.php?logout=1'">ออกจากระบบ</button>
      </div>
    </div>
  </div>
</nav>

<?php
if (isset($_SESSION['index'])) {
  unset($_SESSION['index']);
}
if (isset($_SESSION['user'])) {
  unset($_SESSION['user']);
}
if (isset($_SESSION['post'])) {
  unset($_SESSION['post']);
}

?>