<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
    <div class="container">
        
        <a href="index.php" class="navbar-brand d-flex align-items-center">
<img src="assets/images/icon/logo.png" alt="Logo" style="height: 80px; width: auto;" class="me-3">            <div class="d-flex flex-column">
                <span class="fw-bold fs-5 text-white">Lomsak Hospital</span>
                <span class="fs-7 text-white-50" style="font-size: 0.8rem;">ระบบบริหารจัดการพัสดุ</span>
            </div>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="main.php" class="nav-link px-3 active">
                        <i class="fa-solid fa-house me-2"></i>หน้าหลัก
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bullhorn me-2"></i>ประกาศ/คำสั่ง
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3 mt-2" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item py-2" href="frmBoard.php">กฎ/ระเบียบ/มติ ครม.</a></li>
                        <li><a class="dropdown-item py-2" href="frmPronotice.php">ประกาศพัสดุ</a></li>
                        <li><a class="dropdown-item py-2" href="frmProContract.php">สัญญาพัสดุ</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item py-2" href="frmPhotoAlbum.php">ประมวลภาพกิจกรรม</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <a href="frmlogin.php" class="btn btn-login">
                    <i class="fa-solid fa-circle-user me-2"></i>ลงชื่อเข้าใช้
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
    /* ตั้งค่า Font หลัก */
    body {
        font-family: 'Kanit', sans-serif;
    }

    /* 1. Navbar Design: ใช้สีเขียวแบบไล่เฉดให้ดูทันสมัย แต่ไม่ฉูดฉาด */
    .custom-navbar {
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding-top: 0.8rem;
        padding-bottom: 0.8rem;
    }

    /* 2. Menu Links: ตัด Animation ขยับออก เน้นการเปลี่ยนสีที่นุ่มนวล */
    .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 400;
        font-size: 1rem;
        transition: color 0.2s ease-in-out, background-color 0.2s;
        border-radius: 8px;
        margin: 0 4px;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.1); /* พื้นหลังจางๆ เมื่อเอาเมาส์ชี้ */
    }

    /* 3. Dropdown Menu: สะอาดตา ไม่มีเงาฟุ้งเกินไป */
    .dropdown-menu {
        min-width: 220px;
        border: 1px solid rgba(0,0,0,0.05); /* ขอบบางๆ */
    }

    .dropdown-item {
        color: #495057;
        font-size: 0.95rem;
        transition: background-color 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa; /* สีเทาอ่อนมากๆ */
        color: #198754; /* ตัวหนังสือเปลี่ยนเป็นสีเขียว */
        font-weight: 500;
    }

    /* 4. Login Button: เรียบหรู พื้นขาว ตัดขอบมน */
    .btn-login {
        background-color: rgba(255, 255, 255, 0.95);
        color: #198754;
        font-weight: 500;
        border-radius: 50px; /* ทรงแคปซูล */
        padding: 8px 24px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-login:hover {
        background-color: #ffffff;
        color: #146c43;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transform: translateY(-1px); /* ขยับขึ้นนิดเดียวมากๆ เพื่อให้รู้ว่ากดได้ */
    }

    /* Mobile Toggle Adjust */
    .navbar-toggler:focus {
        box-shadow: none;
    }
</style>