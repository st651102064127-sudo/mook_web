<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_superAdmin.php";

$id = $_GET['id'];
$sql = "SELECT * FROM employee WHERE EmpID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('ไม่พบข้อมูลเจ้าหน้าที่'); window.location='../manage/manage_employee.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลเจ้าหน้าที่ - ระบบจัดการ</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php include("../../admin/include/header.php"); ?>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f0f2f5;
        }

        /* --- Header Section (ทางเดียวกันกับหน้าเพิ่ม) --- */
        .page-header-card {
            background: linear-gradient(135deg, #064020 0%, #0d5e3a 100%);
            color: white;
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 20px rgba(6, 64, 32, 0.2);
            overflow: hidden;
            position: relative;
        }
        .breadcrumb-item a { color: rgba(255,255,255,0.7); text-decoration: none; transition: 0.3s; }
        .breadcrumb-item a:hover { color: #fff; }
        .breadcrumb-item.active { color: #fff; font-weight: 500; }
        .header-icon-bg {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 10rem;
            opacity: 0.1;
            transform: rotate(-15deg);
        }

        /* --- Main Form Card --- */
        .main-form-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            background: #fff;
            overflow: hidden;
            width: 100%; 
        }
        .card-header-custom {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
        }
        .section-title {
            color: #064020;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px dashed #e0e0e0;
            display: flex;
            align-items: center;
        }
        .section-title i {
            background: #e8f5e9;
            color: #2e7d32;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 10px;
            font-size: 0.9rem;
        }

        /* --- Inputs & Icons --- */
        .form-floating > .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem 0.75rem 1rem 2.5rem;
            height: auto;
        }
        .form-floating > .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15);
        }
        .form-floating > label {
            padding-left: 2.5rem;
            color: #6c757d;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #adb5bd;
            z-index: 5;
            transition: 0.3s;
        }
        .form-control:focus ~ .input-icon {
            color: #198754;
        }
        .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding-left: 2.5rem;
        }

        /* --- Buttons --- */
        .btn-cancel {
            background-color: #f8f9fa;
            color: #6c757d;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 500;
        }
        .btn-save {
            background: linear-gradient(90deg, #198754 0%, #146c43 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
            transition: 0.2s;
        }
        .btn-save:hover { transform: translateY(-2px); color: white; }

        .password-section {
            background-color: #f9f9f9;
            border: 1px dashed #ced4da;
            border-radius: 12px;
            padding: 20px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav"><?php include("../../admin/include/sidebar.php"); ?></div>

        <div id="layoutSidenav_content">
            <main class="container-fluid px-4">
                
                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="card page-header-card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center position-relative z-1">
                                <div>
                                    <h3 class="fw-bold mb-2"><i class="fas fa-user-edit me-2"></i>แก้ไขข้อมูลเจ้าหน้าที่</h3>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="../manage/manage_employee.php">รายการเจ้าหน้าที่</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">ID: <?= $row['EmpID'] ?></li>
                                        </ol>
                                    </nav>
                                </div>
                                <i class="fas fa-id-card-clip header-icon-bg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pb-5">
                    <div class="col-12">
                        <form action="../../admin/process/update_employee.php" method="post" class="needs-validation" novalidate>
                            <input type="hidden" name="EmpID" value="<?= $row['EmpID'] ?>">

                            <div class="card main-form-card">
                                <div class="card-header-custom">
                                    <h5 class="m-0 fw-bold text-dark">ปรับปรุงรายละเอียดข้อมูล</h5>
                                    <small class="text-muted">ตรวจสอบและแก้ไขข้อมูลให้เป็นปัจจุบัน</small>
                                </div>
                                
                                <div class="card-body p-5">
                                    
                                    <div class="section-title">
                                        <i class="fas fa-user"></i> 1. ข้อมูลส่วนตัว
                                    </div>
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="name" id="name" required class="form-control" 
                                                    value="<?= htmlspecialchars($row['EmpName']) ?>" placeholder="ชื่อ-นามสกุล">
                                                <label for="name">ชื่อ - นามสกุล</label>
                                                <i class="fas fa-user input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="email" name="email" id="email" required class="form-control" 
                                                    value="<?= htmlspecialchars($row['EmpEmail']) ?>" placeholder="อีเมล">
                                                <label for="email">อีเมล</label>
                                                <i class="fas fa-envelope input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="tel" id="tel" required class="form-control" 
                                                    value="<?= htmlspecialchars($row['EmpPhone']) ?>" maxlength="10" pattern="[0-9]{10}" placeholder="เบอร์โทร">
                                                <label for="tel">เบอร์โทรศัพท์</label>
                                                <i class="fas fa-phone input-icon"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-title">
                                        <i class="fas fa-briefcase"></i> 2. ข้อมูลการทำงาน
                                    </div>
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="EmpCod" id="EmpCod" class="form-control bg-light" 
                                                    value="<?= htmlspecialchars($row['EmpCod']) ?>" readonly style="cursor: not-allowed;">
                                                <label for="EmpCod">รหัสพนักงาน (ไม่อนุญาตให้แก้ไข)</label>
                                                <i class="fas fa-hashtag input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <select name="position" id="position" class="form-select" required>
                                                    <option value="เจ้าหน้าที่พัสดุ" <?= ($row['EmpPosition'] == 'เจ้าหน้าที่พัสดุ') ? 'selected' : '' ?>>เจ้าหน้าที่พัสดุ</option>
                                                    <option value="หัวหน้าเจ้าหน้าที่พัสดุ" <?= ($row['EmpPosition'] == 'หัวหน้าเจ้าหน้าที่พัสดุ') ? 'selected' : '' ?>>หัวหน้าเจ้าหน้าที่พัสดุ</option>
                                                    <option value="Admin" <?= ($row['EmpPosition'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                                                </select>
                                                <label for="position">ตำแหน่ง</label>
                                                <i class="fas fa-id-badge input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 position-relative">
                                            <div class="form-floating">
                                                <select name="role" id="role" class="form-select" required>
                                                    <option value="Member" <?= ($row['EmpRole'] == 'Member') ? 'selected' : '' ?>>Member (เจ้าหน้าที่ทั่วไป)</option>
                                                    <option value="Admin" <?= ($row['EmpRole'] == 'Admin') ? 'selected' : '' ?>>Admin (ผู้ดูแลระบบ)</option>
                                                </select>
                                                <label for="role">สิทธิ์การเข้าถึงระบบ (Role)</label>
                                                <i class="fas fa-user-shield input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="department" id="department" required class="form-control" 
                                                    value="<?= htmlspecialchars($row['EmpDepartment']) ?>" placeholder="ฝ่ายงาน">
                                                <label for="department">หน่วยงาน / ฝ่าย</label>
                                                <i class="fas fa-building input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input type="text" name="agency" id="agency" required class="form-control" 
                                                    value="<?= htmlspecialchars($row['EmpAgency']) ?>" placeholder="สังกัด">
                                                <label for="agency">สังกัด</label>
                                                <i class="fas fa-hospital input-icon"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="password-section">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-key small"></i>
                                            </div>
                                            <h6 class="m-0 fw-bold text-secondary">3. เปลี่ยนรหัสผ่าน</h6>
                                        </div>
                                        <p class="text-muted small mb-3"><i class="fas fa-info-circle me-1"></i>เว้นว่างไว้หากไม่ต้องการเปลี่ยนแปลงรหัสผ่านเดิม</p>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-6 position-relative">
                                                <div class="input-group">
                                                    <div class="form-floating flex-grow-1">
                                                        <input type="password" name="password" id="password" class="form-control border-end-0" placeholder="รหัสผ่านใหม่" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                        <label for="password">รหัสผ่านใหม่</label>
                                                        <i class="fas fa-lock input-icon"></i>
                                                    </div>
                                                    <button type="button" class="btn btn-outline-secondary bg-light" onclick="togglePassword()" style="border-left: 0;">
                                                        <i class="fas fa-eye" id="eye-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="ยืนยันรหัสผ่าน">
                                                    <label for="password_confirm">ยืนยันรหัสผ่านใหม่</label>
                                                    <i class="fas fa-check-double input-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer bg-light border-0 p-4 text-end d-flex justify-content-end gap-2">
                                    <a href="../manage/manage_employee.php" class="btn btn-cancel">
                                        <i class="fas fa-times me-1"></i> ยกเลิก
                                    </a>
                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-save me-1"></i> ยืนยันการแก้ไข
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
            const pwdConf = document.getElementById("password_confirm");
            const icon = document.getElementById("eye-icon");
            
            if (pwd.type === "password") {
                pwd.type = "text";
                pwdConf.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                pwd.type = "password";
                pwdConf.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }

        // ตรวจสอบรหัสผ่านก่อน Submit
        document.querySelector("form").addEventListener("submit", function(e) {
            const pass = document.getElementById("password").value;
            const confirm = document.getElementById("password_confirm").value;

            if (pass && pass !== confirm) {
                alert("❗ รหัสผ่านยืนยันไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>