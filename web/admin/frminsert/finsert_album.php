<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างอัลบั้มรูปภาพ - ระบบจัดการ</title>

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

        /* File Upload Area */
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
                                    <h2 class="fw-bold text-dark mb-1">สร้างอัลบั้มรูปภาพ</h2>
                                    <small class="text-muted">เพิ่มรูปภาพกิจกรรมและข่าวสารประชาสัมพันธ์</small>
                                </div>
                                <button type="button" class="btn btn-light border text-muted rounded-pill px-3" onclick="history.back()">
                                    <i class="fas fa-times me-1"></i> ยกเลิก
                                </button>
                            </div>

                            <form action="../../admin/process/insert_album.php" method="post" enctype="multipart/form-data">
                                
                                <div class="row g-5">
                                    
                                    <div class="col-lg-8">
                                        <div class="mb-4">
                                            <label for="AlbumName" class="form-label">ชื่ออัลบั้ม <span class="text-danger">*</span></label>
                                            <input type="text" name="AlbumName" id="AlbumName" required 
                                                   class="form-control form-control-lg fs-6" 
                                                   placeholder="ระบุชื่อกิจกรรม หรือชื่ออัลบั้ม...">
                                        </div>

                                        <div class="mb-4">
                                            <label for="AlbumDetail" class="form-label">รายละเอียดเพิ่มเติม</label>
                                            <textarea name="AlbumDetail" id="AlbumDetail" rows="8" required 
                                                      class="form-control" placeholder="รายละเอียดของกิจกรรม..."></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 d-flex flex-column">
                                        <div class="p-4 bg-light rounded-3 h-100 d-flex flex-column">
                                            <label class="form-label fw-bold mb-3">รูปภาพในอัลบั้ม <span class="text-danger">*</span></label>
                                            
                                            <div class="upload-area flex-grow-1 d-flex flex-column justify-content-center align-items-center bg-white">
                                                <i class="fas fa-images fa-3x text-success mb-3 opacity-50"></i>
                                                <h6 class="fw-bold text-dark">คลิกเพื่ออัปโหลดรูปภาพ</h6>
                                                <p class="text-muted small mb-0">เลือกได้หลายรูปพร้อมกัน</p>
                                                <input type="file" name="AlbumImg[]" id="AlbumImg" multiple required 
                                                       onchange="updateFileList(this)">
                                            </div>
                                            
                                            <div class="text-center mt-3" style="min-height: 20px;">
                                                <small id="fileNameDisplay" class="text-dark fw-medium"></small>
                                            </div>

                                            <button type="submit" name="upload" class="btn btn-success w-100 mt-3 py-2 fw-medium shadow-sm">
                                                <i class="fas fa-save me-2"></i>บันทึกอัลบั้ม
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

    <script>
        // ฟังก์ชันแสดงจำนวนไฟล์ที่เลือก
        function updateFileList(input) {
            const display = document.getElementById('fileNameDisplay');
            if (input.files.length > 0) {
                display.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> เลือกแล้ว ' + input.files.length + ' รูปภาพ';
            } else {
                display.textContent = '';
            }
        }
    </script>
</body>

</html>