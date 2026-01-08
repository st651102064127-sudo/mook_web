<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

$id = $_GET['id'];
$sql = "SELECT * FROM announcementboard WHERE BoardID = ?";
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
    <title>แก้ไขกฎ/ระเบียบ - ระบบจัดการ</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <?php include("../../admin/include/header.php"); ?>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f8f9fa; /* สีพื้นหลังสว่างสะอาดตา */
            color: #212529;
        }

        /* Minimal Card */
        .card-minimal {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.03);
            background-color: #ffffff;
        }

        /* Form Styling */
        .form-label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #dee2e6;
            background-color: #fdfdfd;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
        }

        /* File Display */
        .file-display-box {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 8px;
            padding: 1rem;
        }
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="fw-bold text-dark mb-0">แก้ไขกฎ/ระเบียบ</h2>
                            <small class="text-muted">แก้ไขข้อมูลรายการ: <?= htmlspecialchars($row['BoardName']) ?></small>
                        </div>
                        <button type="button" class="btn btn-light border text-muted" onclick="history.back()">
                            <i class="fas fa-times me-1"></i> ยกเลิก
                        </button>
                    </div>

                    <div class="card card-minimal mb-4">
                        <div class="card-body p-4 p-md-5">
                            
                            <form action="../../admin/process/update_board.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="BoardID" value="<?= $row['BoardID'] ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['BoardImg'] ?>">

                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="mb-4">
                                            <label for="BoardName" class="form-label">หัวข้อเรื่อง</label>
                                            <input type="text" class="form-control form-control-lg fs-6" 
                                                   name="BoardName" id="BoardName" 
                                                   value="<?= htmlspecialchars($row['BoardName']) ?>" required>
                                        </div>

                                        <div class="mb-0">
                                            <label for="BoardDetail" class="form-label">รายละเอียด</label>
                                            <textarea name="BoardDetail" class="form-control" id="BoardDetail" 
                                                      rows="8" style="resize: none;"><?= htmlspecialchars($row['BoardDetail']) ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="sticky-top" style="top: 2rem; z-index: 1;">
                                            <div class="p-3 bg-light rounded-3 border">
                                                <h6 class="fw-bold mb-3"><i class="fas fa-paperclip me-2"></i>เอกสารแนบ</h6>
                                                
                                                <div class="file-display-box mb-3">
                                                    <?php if (!empty($row['BoardImg'])): ?>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                                                            <div class="overflow-hidden">
                                                                <a href="../../assets/images/board/<?= $row['BoardImg'] ?>" target="_blank" class="d-block text-truncate fw-medium text-dark text-decoration-none">
                                                                    <?= $row['BoardImg'] ?>
                                                                </a>
                                                                <small class="text-muted">คลิกเพื่อเปิดไฟล์</small>
                                                            </div>
                                                        </div>
                                                        <hr class="my-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="DeleteOldFile" id="DeleteOldFile" value="1">
                                                            <label class="form-check-label text-danger small" for="DeleteOldFile">
                                                                ต้องการลบไฟล์นี้
                                                            </label>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="text-center text-muted py-3">
                                                            <i class="fas fa-file-excel fa-2x mb-2 d-block opacity-25"></i>
                                                            <small>ไม่มีไฟล์แนบในปัจจุบัน</small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="BoardImg" class="form-label small">อัปโหลดไฟล์ใหม่ (ทับไฟล์เดิม)</label>
                                                    <input type="file" class="form-control form-control-sm" id="BoardImg" name="BoardImg">
                                                </div>
                                            </div>

                                            <button type="submit" name="upload" class="btn btn-success w-100 mt-3 py-2 fw-medium shadow-sm">
                                                <i class="fas fa-save me-2"></i>บันทึกการเปลี่ยนแปลง
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