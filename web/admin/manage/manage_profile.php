<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

 $empID = $_SESSION['user_id'];

// ดึงข้อมูลปัจจุบันมาแสดง
 $sql = "SELECT * FROM employee WHERE EmpID = ?";
 $stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $empID);
mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <!-- เรียกใช้ Font Kanit -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php include("../include/header.php"); ?>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f0f2f5;
        }

        /* --- Header Section --- */
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

        /* --- Inputs --- */
        .form-floating > .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem 0.75rem 1rem 2.5rem;
            height: auto;
        }
        .form-floating > .form-control:read-only {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
            border-color: #eee;
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

        /* --- Password Section --- */
        .password-section {
            background-color: #fff5f5;
            border: 1px dashed #ffcccc;
            border-radius: 12px;
            padding: 20px;
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
        .btn-cancel:hover {
            background-color: #e2e6ea;
            color: #495057;
        }
        .btn-save {
            background: linear-gradient(90deg, #198754 0%, #146c43 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(25, 135, 84, 0.3);
            color: white;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include("../include/navbar.php"); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include("../include/sidebar.php"); ?>
        </div>

        <div id="layoutSidenav_content">
            <main class="container-fluid px-4">
                
                <!-- Header Card -->
                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="card page-header-card p-4">
                            <div class="card-body d-flex justify-content-between align-items-center position-relative z-1">
                                <div>
                                    <h3 class="fw-bold mb-2"><i class="fas fa-user-circle me-2"></i>แก้ไขข้อมูลส่วนตัว</h3>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="Employee.php"><i class="fas fa-home me-1"></i> หน้าหลัก</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">โปรไฟล์ของฉัน</li>
                                        </ol>
                                    </nav>
                                </div>
                                <i class="fas fa-id-card-clip header-icon-bg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form Card (Full Width) -->
                <div class="row pb-5">
                    <div class="col-12">
                        <form action="edit_profile_db.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            
                            <div class="card main-form-card">
                                <div class="card-header-custom">
                                    <h5 class="m-0 fw-bold text-dark">ปรับปรุงข้อมูลผู้ใช้งาน</h5>
                                    <small class="text-muted">แก้ไขข้อมูลส่วนตัวและตั้งค่าความปลอดภัย</small>
                                </div>
                                
                                <div class="card-body p-5">
                                    
                                    <!-- Section 1: General Info -->
                                    <div class="section-title">
                                        <i class="fas fa-user"></i> 1. ข้อมูลส่วนตัว
                                    </div>
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input class="form-control" id="EmpName" name="EmpName" type="text" value="<?= htmlspecialchars($row['EmpName']) ?>" required />
                                                <label for="EmpName">ชื่อ - นามสกุล</label>
                                                <i class="fas fa-user input-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input class="form-control" id="EmpEmail" name="EmpEmail" type="email" value="<?= htmlspecialchars($row['EmpEmail']) ?>" required />
                                                <label for="EmpEmail">อีเมล</label>
                                                <i class="fas fa-envelope input-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input class="form-control" id="EmpPhone" name="EmpPhone" type="text" value="<?= htmlspecialchars($row['EmpPhone']) ?>" required />
                                                <label for="EmpPhone">เบอร์โทรศัพท์</label>
                                                <i class="fas fa-phone input-icon"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 2: Work Info (Read Only) -->
                                    <div class="section-title">
                                        <i class="fas fa-briefcase"></i> 2. ข้อมูลการทำงาน (อ่านอย่างเดียว)
                                    </div>
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input class="form-control" type="text" value="<?= htmlspecialchars($row['EmpCod']) ?>" readonly />
                                                <label>รหัสพนักงาน</label>
                                                <i class="fas fa-hashtag input-icon text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input class="form-control" type="text" value="<?= htmlspecialchars($row['EmpPosition']) ?>" readonly />
                                                <label>ตำแหน่ง</label>
                                                <i class="fas fa-id-badge input-icon text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <div class="form-floating">
                                                <input class="form-control" type="text" value="<?= htmlspecialchars($row['EmpDepartment']) ?>" readonly />
                                                <label>แผนก/ฝ่าย</label>
                                                <i class="fas fa-building input-icon text-muted"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Section 3: Password -->
                                    <div class="password-section">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                                                <i class="fas fa-key small"></i>
                                            </div>
                                            <h6 class="m-0 fw-bold text-danger">3. เปลี่ยนรหัสผ่าน</h6>
                                        </div>
                                        <p class="text-muted small mb-3">เว้นว่างหากไม่ต้องการเปลี่ยนรหัสผ่าน (หากต้องการเปลี่ยน จำเป็นต้องกรอกรหัสผ่านเดิม)</p>

                                        <div class="row g-3">
                                            <div class="col-md-12 position-relative">
                                                <div class="form-floating">
                                                    <input class="form-control" id="old_password" name="old_password" type="password" placeholder="รหัสผ่านเดิม" />
                                                    <label for="old_password">รหัสผ่านเดิม</label>
                                                    <i class="fas fa-lock input-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <div class="form-floating">
                                                    <input class="form-control" id="new_password" name="new_password" type="password" placeholder="รหัสผ่านใหม่" />
                                                    <label for="new_password">รหัสผ่านใหม่</label>
                                                    <i class="fas fa-key input-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <div class="form-floating">
                                                    <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="ยืนยันรหัสผ่านใหม่" />
                                                    <label for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
                                                    <i class="fas fa-check-double input-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" onclick="togglePasswords()" id="showPass">
                                                    <label class="form-check-label text-muted small" for="showPass">แสดงรหัสผ่าน</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Footer Actions -->
                                <div class="card-footer bg-light border-0 p-4 text-end d-flex justify-content-end gap-2">
                                    <a href="Employee.php" class="btn btn-cancel">
                                        <i class="fas fa-times me-1"></i> ยกเลิก
                                    </a>
                                    <button type="submit" name="save_profile" class="btn btnSave">
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
        function togglePasswords() {
            var oldPass = document.getElementById("old_password");
            var newPass = document.getElementById("new_password");
            var conPass = document.getElementById("confirm_password");
            
            if (oldPass.type === "password") {
                oldPass.type = "text";
                newPass.type = "text";
                conPass.type = "text";
            } else {
                oldPass.type = "password";
                newPass.type = "password";
                conPass.type = "password";
            }
        }
    </script>

    <!-- Alert Handling -->
    <?php if (isset($_SESSION['status']) && $_SESSION['status'] != "") { ?>
        <script>
            // แสดง Alert ตามปกติ (สามารถเปลี่ยนเป็น SweetAlert ได้)
            alert("<?= $_SESSION['msg']; ?>");
            <?php if ($_SESSION['status'] == 'success') { ?>
                // ถ้าสำเร็จ รีเฟรชหน้าเพื่อโหลดข้อมูลใหม่และล้าง session
                window.location.href = 'edit_profile.php'; 
            <?php } ?>
        </script>
        <?php 
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
        ?>
    <?php } ?>

</body>
</html>