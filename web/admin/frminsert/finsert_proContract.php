<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มประกาศสัญญาพัสดุ - ระบบจัดการ</title>

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

        /* Form Elements */
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

        /* File Upload */
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            background-color: #f8f9fa;
            text-align: center;
            padding: 2rem;
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
                                    <h2 class="fw-bold text-dark mb-1">เพิ่มประกาศสัญญาพัสดุ</h2>
                                    <small class="text-muted">บันทึกข้อมูลสัญญาซื้อขาย/จ้างใหม่</small>
                                </div>
                                <button type="button" class="btn btn-light border text-muted rounded-pill px-3" onclick="history.back()">
                                    <i class="fas fa-times me-1"></i> ยกเลิก
                                </button>
                            </div>

                            <form action="../../admin/process/insert_proContract.php" method="post" enctype="multipart/form-data">
                                
                                <div class="row g-5">
                                    
                                    <div class="col-lg-8">
                                        <div class="mb-4">
                                            <label for="ContractName" class="form-label">ชื่อสัญญา / เรื่อง <span class="text-danger">*</span></label>
                                            <input type="text" name="ContractName" id="ContractName" required 
                                                   class="form-control form-control-lg fs-6" 
                                                   placeholder="ระบุชื่อสัญญา...">
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label for="ContractDate" class="form-label">วันที่เริ่มสัญญา</label>
                                                <input type="date" name="ContractDate" id="ContractDate" 
                                                       value="<?= date('Y-m-d'); ?>" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <label for="ContractEndDate" class="form-label">วันที่สิ้นสุดสัญญา</label>
                                                <input type="date" name="ContractEndDate" id="ContractEndDate" 
                                                       value="<?= date('Y-m-d'); ?>" class="form-control" required>
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
                                            <label class="form-label fw-bold mb-3">เอกสารสัญญา <span class="text-danger">*</span></label>
                                            
                                            <div class="upload-area flex-grow-1 d-flex flex-column justify-content-center align-items-center bg-white">
                                                <i class="fas fa-file-contract fa-3x text-primary mb-3 opacity-50"></i>
                                                <h6 class="fw-bold text-dark">คลิกเพื่ออัปโหลดไฟล์</h6>
                                                <p class="text-muted small mb-0">รองรับ PDF เท่านั้น</p>
                                                <input type="file" name="ContractFile" id="ContractFile" required 
                                                       onchange="document.getElementById('fileNameDisplay').innerHTML = '<i class=\'fas fa-check-circle text-success me-1\'></i> ' + this.files[0].name;">
                                            </div>
                                            
                                            <div class="text-center mt-3" style="min-height: 20px;">
                                                <small id="fileNameDisplay" class="text-dark fw-medium"></small>
                                            </div>

                                            <button type="submit" name="upload" class="btn btn-success w-100 mt-3 py-2 fw-medium shadow-sm">
                                                <i class="fas fa-save me-2"></i>บันทึกสัญญา
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