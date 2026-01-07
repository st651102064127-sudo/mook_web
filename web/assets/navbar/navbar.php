<!-- As a link -->
<div class="p-0 m-0">
  <div class="container-fluid">
    <div class="text-end">
      <!-- <span><a href="frminsert.php" class="text-dark btn fs-7 p-2">สร้างบัญชีผู้ใช้</a></span> -->
      |
      <span><a href="frmlogin.php" class="text-dark btn fs-7 p-2">ลงชื่อเข้าใช้</a></span>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-md navbar-light bg-green-1 sticky-top">
  <div class="container-fluid pt-2">
    <a href="index.php" class="navbar-brand">

      <img src="assets/images/icon/logonav.png" alt="Lomsak Hospital Logo" style="height: 50px;" class="me-2">

    </a>
    <button class="navbar-toggler" data-bs-target="#navbar" data-bs-toggle="collapse">เมนู</button>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav me-auto">

        <li><a href="index.php" class="nav-link ">หน้าหลัก</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ประกาศ/คำสั่ง สำนักงานฯ
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="frmBoard.php">กฎ/ระเบียบ/มติ ครม. และหนังสือเวียน</a></li>
            <li><a class="dropdown-item" href="frmPronotice.php">ประกาศพัสดุ</a></li>
            <li><a class="dropdown-item" href="frmProContract.php">สัญญาพัสดุ</a></li>
            <li><a class="dropdown-item" href="frmPhotoAlbum.php">กิจกรรม</a></li>
          </ul>
        </li>
      </ul>


      <!-- <form class="d-flex m-0 position-relative">
        <input class="form-control w-100 rounded-pill" type="search" placeholder="ค้นหา" aria-label="Search" style="border-radius: 0;">
        <button class="btn rounded-pill position-absolute end-0" type="submit" style="border-radius: 0;">🔎</button>
      </form> -->

    </div>
  </div>
</nav>


<style>
  .bg-green-1 {
    background-color: #72ce87ff !important;
    /* เลือกโค้ดสีที่ต้องการ */
  }

  /* เพิ่มเงาและขอบโค้ง */
  .modern-navbar {
    border-radius: 0 0 20px 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
  }

  /* เมื่อ scroll จะเพิ่มความเข้มของเงา */
  .modern-navbar.scrolled {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    background-color: #66c87a !important;
  }

  /* Logo */
  .navbar-logo {
    height: 45px;
    transition: transform 0.3s ease;
  }

  .navbar-logo:hover {
    transform: scale(1.05);
  }

  /* ลิงก์เมนู */
  .navbar-nav .nav-link {
    color: #000 !important;
    font-weight: 500;
    margin: 0 6px;
    transition: all 0.3s ease;
    border-radius: 10px;
    padding: 6px 12px;
  }

  .navbar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.4);
    color: #000;
    transform: translateY(-2px);
  }

  /* ปุ่มผู้ใช้ด้านบน */
  .user-btn {
    color: #000 !important;
    font-weight: 500;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 10px;
    transition: all 0.3s ease;
  }

  .user-btn:hover {
    background-color: rgba(255, 255, 255, 0.8);
    transform: scale(1.05);
  }

  /* กล่องค้นหา */
  .search-box input {
    border: none;
    outline: none;
    transition: box-shadow 0.3s ease;
  }

  .search-box input:focus {
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
  }

  /* Topbar */
  .topbar {
    background: #f8f9fa;
    border-bottom: 1px solid #ddd;
  }
</style>