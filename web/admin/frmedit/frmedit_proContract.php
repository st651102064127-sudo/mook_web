<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

$id = $_GET['id'] ?? 0;
$id = (int)$id;

// ดึงข้อมูลสัญญา
$sql = "SELECT * FROM procurementcontract WHERE ContractID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('ไม่พบข้อมูลสัญญา'); window.history.back();</script>";
    exit;
}

// ฟังก์ชันแปลงวันที่สำหรับแสดงผล
function formatDateThai($strDate) {
    if (empty($strDate) || $strDate == "0000-00-00") return "-";
    $months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $timestamp = strtotime($strDate);
    if ($timestamp === false) return "-";
    $day = (int)date("d", $timestamp);
    $month = (int)date("m", $timestamp);
    $year = (int)date("Y", $timestamp) + 543;
    return "{$day} {$months[$month]} {$year}";
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขประกาศสัญญาพัสดุ - ระบบจัดการ</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <?php include("../../admin/include/header.php"); ?>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        /* Minimal Card */
        .card-minimal {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            background-color: #ffffff;
        }

        /* Form Styling */
        .form-label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e9ecef;
            background-color: #fcfcfc;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: transparent;
        }

        /* File Display & Upload */
        .file-display-box {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            background-color: #f8f9fa;
            text-align: center;
            padding: 1.5rem;
            transition: all 0.3s;
            position: relative;
            cursor: pointer;
        }
        
        .upload-area:hover {
            border-color: #198754;
            background-color: #f0fff4;
        }

        .upload-area input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
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

                    <div class="card card-minimal mb-4">
                        <div class="card-body p-4 p-md-5">

                            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                <div>
                                    <h2 class="fw-bold text-dark mb-1">แก้ไขประกาศสัญญาพัสดุ</h2>
                                    <small class="text-muted">แก้ไขข้อมูลสัญญา: <?= htmlspecialchars($row['ContractName']) ?></small>
                                </div>
                                <button type="button" class="btn btn-light border text-muted rounded-pill px-3" onclick="history.back()">
                                    <i class="fas fa-times me-1"></i> ยกเลิก
                                </button>
                            </div>

                            <form action="../../admin/process/update_proContract.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="ContractID" value="<?= $row['ContractID']; ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['ContractFile']; ?>">

                                <div class="row g-5">
                                    
                                    <div class="col-lg-8">
                                        <div class="mb-4">
                                            <label for="ContractName" class="form-label">ชื่อสัญญา / เรื่อง <span class="text-danger">*</span></label>
                                            <input type="text" name="ContractName" id="ContractName" 
                                                   class="form-control form-control-lg fs-6" 
                                                   value="<?= htmlspecialchars($row['ContractName']); ?>" required>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="ContractDate" class="form-label">วันที่เริ่มสัญญา</label>
                                                <input type="date" name="ContractDate" id="ContractDate" class="form-control"
                                                       value="<?= date('Y-m-d', strtotime($row['ContractDate'])); ?>" required>
                                                <small class="text-muted ps-1"><i class="far fa-clock me-1"></i> เดิม: <?= formatDateThai($row['ContractDate']) ?></small>
                                            </div>
                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <label for="ContractEndDate" class="form-label">วันที่สิ้นสุดสัญญา</label>
                                                <input type="date" name="ContractEndDate" id="ContractEndDate" class="form-control"
                                                       value="<?= date('Y-m-d', strtotime($row['ContractEndDate'])); ?>" required>
                                                <small class="text-muted ps-1"><i class="far fa-clock me-1"></i> เดิม: <?= formatDateThai($row['ContractEndDate']) ?></small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">หน่วยงาน</label>
                                                <input type="text" name="ContractDepartment" value="กลุ่มงานพัสดุ" 
                                                       class="form-control" readonly>
                                            </div>
                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <label class="form-label">สังกัด</label>
                                                <input type="text" name="ContractAgency" value="โรงพยาบาลหล่มสัก" 
                                                       class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 d-flex flex-column">
                                        <div class="p-4 bg-light rounded-3 h-100 d-flex flex-column">
                                            <label class="form-label fw-bold mb-3"><i class="fas fa-paperclip me-2"></i>เอกสารสัญญา</label>
                                            
                                            <div class="file-display-box">
                                                <?php if (!empty($row['ContractFile'])): ?>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-file-contract text-primary fa-2x me-3"></i>
                                                        <div class="overflow-hidden">
                                                            <a href="../../assets/images/proContract/<?= $row['ContractFile']; ?>" target="_blank" class="d-block text-truncate fw-medium text-dark text-decoration-none">
                                                                <?= $row['ContractFile']; ?>
                                                            </a>
                                                            <small class="text-success">เปิดดูไฟล์ปัจจุบัน</small>
                                                        </div>
                                                    </div>
                                                    <hr class="my-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="del_file" id="del_file" value="1">
                                                        <label class="form-check-label text-danger small" for="del_file">
                                                            ต้องการลบไฟล์นี้
                                                        </label>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-center text-muted py-2">
                                                        <small>ไม่มีไฟล์สัญญาเดิม</small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="upload-area flex-grow-1 d-flex flex-column justify-content-center align-items-center bg-white">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-secondary mb-2 opacity-50"></i>
                                                <h6 class="fw-bold text-dark mb-0">อัปโหลดไฟล์ใหม่</h6>
                                                <small class="text-muted">(ทับไฟล์เดิม)</small>
                                                <input type="file" name="ContractFile" id="ContractFile" 
                                                       onchange="document.getElementById('fileNameDisplay').innerHTML = '<i class=\'fas fa-check-circle text-success me-1\'></i> ' + this.files[0].name;">
                                            </div>
                                            
                                            <div class="text-center mt-2" style="min-height: 20px;">
                                                <small id="fileNameDisplay" class="text-dark fw-medium"></small>
                                            </div>

                                            <button type="submit" name="upload" class="btn btn-success w-100 mt-3 py-2 fw-medium shadow-sm">
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