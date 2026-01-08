<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

$id = $_GET['id'];
$sql = "SELECT * FROM internalnews WHERE IntNewsID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข่าวประชาสัมพันธ์ภายใน</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <?php include("../../admin/include/header.php"); ?>

    <style>
        /* Theme: Minimal Clean Sheet (ชุดเดียวกับหน้า Insert) */
        body { 
            font-family: 'Kanit', sans-serif; 
            background-color: #f8f9fa; 
            color: #495057; 
        }

        .card-minimal {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border-top: 5px solid #ffc107; /* เปลี่ยนสีแถบเป็นสีเหลือง (Warning) สื่อถึงการแก้ไข */
            background-color: white;
        }

        /* Floating Form Style */
        .form-floating > .form-control,
        .form-floating > .form-control-plaintext {
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .form-floating > .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.15); /* เงาสีเหลืองจางๆ */
        }
        .form-floating > label { color: #adb5bd; }

        /* Current File Box Styling */
        .current-file-box {
            background-color: #fffbf0; /* พื้นหลังเหลืองอ่อนจางๆ */
            border: 1px solid #ffeeba;
            border-radius: 8px;
            padding: 1rem;
        }

        .btn-action {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: transform 0.2s;
        }
        .btn-action:hover { transform: translateY(-2px); }
    </style>
</head>

<body class="sb-nav-fixed">

    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">

        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    
                    <div class="card card-minimal mb-4">
                        <div class="card-body p-4 p-md-5">
                            
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                <div>
                                    <h3 class="fw-bold text-dark mb-1">แก้ไขข่าวประชาสัมพันธ์</h3>
                                    <p class="text-muted small mb-0">ปรับปรุงข้อมูลข่าวสาร รหัสข่าว: <strong>#<?= $row['IntNewsID'] ?></strong></p>
                                </div>
                                <div class="text-warning fs-4 bg-light rounded-circle p-3">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </div>

                            <form action="../../admin/process/update_innews.php" method="post" enctype="multipart/form-data">
                                
                                <input type="hidden" name="IntNewsID" value="<?= $row['IntNewsID'] ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['IntNewsFile'] ?>">

                                <div class="row g-4">
                                    
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="IntNewsName" id="IntNewsName" 
                                                   value="<?= htmlspecialchars($row['IntNewsName']) ?>" placeholder="ชื่อเรื่อง" required>
                                            <label for="IntNewsName"><i class="fas fa-heading me-2"></i>หัวข้อข่าว / ชื่อเรื่อง</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="IntNewsDetail" id="IntNewsDetail" 
                                                      placeholder="รายละเอียด" style="height: 150px" required><?= htmlspecialchars($row['IntNewsDetail']) ?></textarea>
                                            <label for="IntNewsDetail"><i class="fas fa-align-left me-2"></i>รายละเอียดเนื้อหาข่าว</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-2">ไฟล์แนบเอกสาร</label>
                                        
                                        <?php if (!empty($row['IntNewsFile'])): ?>
                                            <div class="current-file-box mb-3">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                    <div class="d-flex align-items-center text-dark">
                                                        <i class="fas fa-file-alt text-warning fs-3 me-3"></i>
                                                        <div>
                                                            <div class="small text-muted">ไฟล์ปัจจุบัน:</div>
                                                            <a href="../../assets/images/inNews/<?= $row['IntNewsFile'] ?>" target="_blank" class="fw-bold text-decoration-none text-dark">
                                                                <?= $row['IntNewsFile'] ?> <i class="fas fa-external-link-alt small ms-1 text-muted"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="DeleteOldFile" name="DeleteOldFile" value="1">
                                                        <label class="form-check-label text-danger fw-bold small" for="DeleteOldFile">ลบไฟล์นี้</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="input-group">
                                            <label class="input-group-text bg-white text-muted" for="IntNewsFile"><i class="fas fa-upload"></i></label>
                                            <input type="file" class="form-control" id="IntNewsFile" name="IntNewsFile">
                                        </div>
                                        <div class="form-text mt-1 text-muted small">
                                            <i class="fas fa-info-circle me-1"></i> หากต้องการเปลี่ยนไฟล์ ให้เลือกไฟล์ใหม่ทับไฟล์เดิม (ไม่ต้องติ๊กลบ)
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex gap-3 justify-content-end">
                                            <button type="button" class="btn btn-light btn-action text-muted border" onclick="history.back()">
                                                ยกเลิก
                                            </button>
                                            <button type="submit" name="upload" class="btn btn-warning btn-action shadow-sm text-dark">
                                                <i class="fas fa-save me-2"></i>บันทึกการแก้ไข
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                    
                </div>
            </main>
            <?php include("../../admin/include/footer.php"); ?>
        </div>
    </div>

    <?php include("../include/script.php"); ?>
</body>

</html>