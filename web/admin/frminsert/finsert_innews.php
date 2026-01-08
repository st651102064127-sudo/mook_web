<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข่าวประชาสัมพันธ์ภายใน</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <?php include("../../admin/include/header.php"); ?>

    <style>
        body { 
            font-family: 'Kanit', sans-serif; 
            background-color: #f8f9fa; /* พื้นหลังสีขาวควันบุหรี่จางๆ */
            color: #495057; 
        }

        /* Main Card Styling */
        .card-minimal {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); /* เงาฟุ้งๆ นุ่มๆ */
            border-top: 5px solid #198754; /* แถบสีเขียวด้านบนสุด */
            background-color: white;
        }

        /* Floating Form Clean Style */
        .form-floating > .form-control,
        .form-floating > .form-control-plaintext {
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }

        .form-floating > .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1); /* เงาสีเขียวจางๆ เวลาพิมพ์ */
        }

        .form-floating > label {
            color: #adb5bd;
        }

        /* File Input Custom */
        .file-upload-wrapper {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
            position: relative;
        }
        
        .file-upload-wrapper:hover {
            border-color: #198754;
            background-color: #f0fdf4;
        }

        .btn-action {
            padding: 0.6rem 1.5rem;
            border-radius: 50px; /* ปุ่มมนแบบแคปซูล */
            font-weight: 500;
            transition: transform 0.2s;
        }
        .btn-action:hover {
            transform: translateY(-2px);
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
                                    <h3 class="fw-bold text-dark mb-1">เพิ่มข่าวประชาสัมพันธ์ภายใน</h3>
                                    <p class="text-muted small mb-0">กรอกข้อมูลด้านล่างเพื่อประกาศข่าวสารในระบบ</p>
                                </div>
                                <div class="text-success fs-4 bg-light rounded-circle p-3">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                            </div>

                            <form action="../../admin/process/insert_innews.php" method="post" enctype="multipart/form-data">
                                <div class="row g-4">
                                    
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="InNewsName" name="InNewsName" placeholder="ระบุชื่อเรื่อง" required>
                                            <label for="InNewsName"><i class="fas fa-heading me-2"></i>หัวข้อข่าว / ชื่อเรื่อง</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="รายละเอียด" id="InNewsDetail" name="InNewsDetail" style="height: 150px" required></textarea>
                                            <label for="InNewsDetail"><i class="fas fa-align-left me-2"></i>รายละเอียดเนื้อหาข่าว</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-2">ไฟล์แนบเอกสาร</label>
                                        <div class="file-upload-wrapper position-relative">
                                            <input type="file" id="InNewsFile" name="InNewsFile" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" required>
                                            <div class="text-muted pointer-events-none">
                                                <i class="fas fa-cloud-upload-alt fs-2 mb-2 text-success"></i>
                                                <p class="mb-0 fw-medium">คลิกที่นี่เพื่อเลือกไฟล์ หรือ ลากไฟล์มาวาง</p>
                                                <small class="text-secondary opacity-75">(รองรับ PDF, JPG, PNG ขนาดไม่เกิน 10MB)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex gap-3 justify-content-end">
                                            <button type="button" class="btn btn-light btn-action text-muted border" onclick="history.back()">
                                                ยกเลิก
                                            </button>
                                            <button type="submit" name="upload" class="btn btn-success btn-action shadow-sm">
                                                <i class="fas fa-paper-plane me-2"></i>เผยแพร่ข่าว
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