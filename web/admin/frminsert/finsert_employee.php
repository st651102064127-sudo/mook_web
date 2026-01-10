<?php include "../../assets/connect_db/connect_db.php"; 
include "../../assets/check_login_admin/check_login_superAdmin.php";

?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มเจ้าหน้าที่ใหม่</title>
    <!-- เรียกใช้ Font Kanit -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./style/employee.css">
    <?php include("../../admin/include/header.php"); ?>

</head>

<body class="sb-nav-fixed">
    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav"><?php include("../../admin/include/sidebar.php"); ?></div>

        <div id="layoutSidenav_content">
            <main class="container-fluid px-4">

                <!-- Header Card -->
                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="card page-header-card p-4">
                            <div
                                class="card-body d-flex justify-content-between align-items-center position-relative z-1">
                                <div>
                                    <h3 class="fw-bold mb-2"><i class="fas fa-user-plus me-2"></i>เพิ่มเจ้าหน้าที่ใหม่
                                    </h3>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="../manage/Employee.php"><i
                                                        class="fas fa-home me-1"></i> หน้าหลัก</a></li>
                                            <li class="breadcrumb-item"><a
                                                    href="../manage/manage_employee.php">รายการเจ้าหน้าที่</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">เพิ่มข้อมูล</li>
                                        </ol>
                                    </nav>
                                </div>
                                <i class="fas fa-users-cog header-icon-bg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form Card (Full Width) -->
                <div class="row pb-5">
                    <div class="col-12">
                        <form action="../../admin/process/insert_employee.php" method="post" class="needs-validation"
                            novalidate>

                            <div class="card main-form-card">
                                <div class="card-header-custom">
                                    <h5 class="m-0 fw-bold text-dark">ลงทะเบียนเจ้าหน้าที่ใหม่</h5>
                                    <small class="text-muted">กรอกข้อมูลรายละเอียดเพื่อเข้าสู่ระบบ</small>
                                </div>

                                <div class="card-body p-5">

                                    <!-- Section 1: Personal Info -->
                                    <div class="section-title">
                                        <i class="fas fa-user"></i> 1. ข้อมูลส่วนตัว
                                    </div>
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="name" id="name" required class="form-control"
                                                    placeholder="ชื่อ-นามสกุล">
                                                <label for="name">ชื่อ - นามสกุล</label>
                                                <i class="fas fa-user input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="email" name="email" id="email" required
                                                    class="form-control" placeholder="name@example.com">
                                                <label for="email">อีเมล</label>
                                                <i class="fas fa-envelope input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="tel" id="tel" required class="form-control"
                                                    maxlength="10" pattern="[0-9]{10}" placeholder="เบอร์โทร">
                                                <label for="tel">เบอร์โทรศัพท์</label>
                                                <i class="fas fa-phone input-icon"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 2: Work Info -->
                                    <div class="section-title">
                                        <i class="fas fa-briefcase"></i> 2. ข้อมูลการทำงาน
                                    </div>
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="EmpCod" id="EmpCod" required
                                                    class="form-control" placeholder="รหัสพนักงาน">
                                                <label for="EmpCod">รหัสพนักงาน</label>
                                                <i class="fas fa-hashtag input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <select name="position" id="position" class="form-select" required>
                                                    <option value="" selected disabled>เลือกตำแหน่ง...</option>
                                                    <option value="เจ้าหน้าที่พัสดุ">เจ้าหน้าที่พัสดุ</option>
                                                    <option value="หัวหน้าเจ้าหน้าที่พัสดุ">หัวหน้าเจ้าหน้าที่พัสดุ
                                                    </option>
                                                    <option value="Admin">ผู้ดูแลระบบ (Admin)</option>
                                                </select>
                                                <label for="position">ตำแหน่ง</label>
                                                <i class="fas fa-id-badge input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="department" id="department" required
                                                    class="form-control" placeholder="ฝ่ายงาน" value="กลุ่มงานพัสดุ">
                                                <label for="department">หน่วยงาน / ฝ่าย</label>
                                                <i class="fas fa-building input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="agency" id="agency" required
                                                    class="form-control" placeholder="หน่วยงาน"
                                                    value="โรงพยาบาลหล่มสัก">
                                                <label for="agency">สังกัด</label>
                                                <i class="fas fa-hospital input-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <select name="role" id="role" class="form-select" required>
                                                    <option value="" selected disabled>เลือกสิทธิ์การใช้งาน...</option>
                                                    <option value="Member">Member (เจ้าหน้าที่ทั่วไป)</option>
                                                    <option value="Admin">Admin (ผู้ดูแลระบบ)</option>
                                                </select>
                                                <label for="role">สิทธิ์การเข้าถึงระบบ (Role)</label>
                                                <i class="fas fa-user-shield input-icon"></i>
                                                <div class="invalid-feedback">กรุณาเลือกสิทธิ์การใช้งาน</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 3: Security -->
                                    <div class="password-section">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                                                style="width: 30px; height: 30px;">
                                                <i class="fas fa-lock small"></i>
                                            </div>
                                            <h6 class="m-0 fw-bold text-success">3. ความปลอดภัยของบัญชี</h6>
                                        </div>
                                        <div class="row g-4">
                                            <div class="col-md-6 col-lg-4 position-relative">
                                                <div class="input-group">
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="password" name="password" id="password" required
                                                            class="form-control border-end-0" placeholder="รหัสผ่าน"
                                                            style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                        <label for="password"
                                                            style="padding-left: 1rem;">กำหนดรหัสผ่าน</label>
                                                        <i class="fas fa-key input-icon"></i>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary bg-light"
                                                        onclick="togglePassword()" style="border-left: 0;">
                                                        <i class="fas fa-eye" id="eye-icon"></i>
                                                    </button>
                                                </div>
                                                <div class="form-text ms-1 text-muted small mt-2"><i
                                                        class="fas fa-info-circle me-1"></i>ควรมีความยาวอย่างน้อย 6
                                                    ตัวอักษร</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Footer Actions -->
                                <div
                                    class="card-footer bg-light border-0 p-4 text-end d-flex justify-content-end gap-2">
                                    <a href="../manage/manage_employee.php" class="btn btn-cancel">
                                        <i class="fas fa-times me-1"></i> ยกเลิก
                                    </a>
                                    <button type="submit" class="btn btnSave">
                                        <i class="fas fa-save me-1"></i> บันทึกข้อมูล
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </main>
            <?php include("../../admin/include/footer.php"); ?>
        </div>
    </div>

    <?php include("../include/script.php"); ?>

    <script>
        function togglePassword() {
            const pwd = document.getElementById("password");
            const icon = document.getElementById("eye-icon");
            if (pwd.type === "password") {
                pwd.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                pwd.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>

</html>