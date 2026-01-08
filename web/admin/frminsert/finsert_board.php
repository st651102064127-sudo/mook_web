<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มกฎ/ระเบียบ/มติ ครม.</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <?php include("../../admin/include/header.php"); ?>

    <style>
        body { 
            font-family: 'Kanit', sans-serif; 
            background-color: #f8f9fa;
            color: #495057; 
        }

        /* Minimal Card Style */
        .card-minimal {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border-top: 5px solid #198754; /* ธีมสีเขียว */
            background-color: white;
        }

        /* Floating Form */
        .form-floating > .form-control,
        .form-floating > .form-control-plaintext {
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }
        .form-floating > .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
        }
        .form-floating > label { color: #adb5bd; }

        /* File Upload Box (Multiple Support) */
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
                                    <h3 class="fw-bold text-dark mb-1">เพิ่มกฎ/ระเบียบ/มติ ครม.</h3>
                                    <p class="text-muted small mb-0">บันทึกข้อมูลหนังสือเวียนหรือข้อบังคับใหม่ลงในระบบ</p>
                                </div>
                                <div class="text-success fs-4 bg-light rounded-circle p-3">
                                    <i class="fas fa-gavel"></i>
                                </div>
                            </div>

                            <form action="../../admin/process/insert_board.php" method="post" enctype="multipart/form-data">
                                <div class="row g-4">
                                    
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="BoardName" name="BoardName" placeholder="ระบุชื่อเรื่อง" required>
                                            <label for="BoardName"><i class="fas fa-heading me-2"></i>เรื่อง / ชื่อกฎระเบียบ</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="รายละเอียด" id="BoardDetail" name="BoardDetail" style="height: 150px" required></textarea>
                                            <label for="BoardDetail"><i class="fas fa-align-left me-2"></i>รายละเอียดเพิ่มเติม</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-2">ไฟล์เอกสารแนบ (เลือกได้หลายไฟล์)</label>
                                        <div class="file-upload-wrapper position-relative">
                                            <input type="file" id="BoardImg" name="BoardImg[]" multiple 
                                                   class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" required>
                                            
                                            <div class="text-muted pointer-events-none">
                                                <i class="fas fa-copy fs-2 mb-2 text-success"></i>
                                                <p class="mb-0 fw-medium">คลิกเลือกไฟล์ หรือ ลากไฟล์มาวางที่นี่</p>
                                                <small class="text-secondary opacity-75">
                                                    (รองรับ PDF, JPG, PNG | สามารถเลือกพร้อมกันได้หลายไฟล์)
                                                </small>
                                            </div>
                                        </div>
                                        <div id="fileListDisplay" class="mt-2 text-success small fw-bold"></div>
                                    </div>

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex gap-3 justify-content-end">
                                            <button type="button" class="btn btn-light btn-action text-muted border" onclick="history.back()">
                                                ยกเลิก
                                            </button>
                                            <button type="submit" name="upload" class="btn btn-success btn-action shadow-sm">
                                                <i class="fas fa-save me-2"></i>บันทึกข้อมูล
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
        document.getElementById('BoardImg').addEventListener('change', function(e) {
            var files = e.target.files;
            var display = document.getElementById('fileListDisplay');
            if (files.length > 0) {
                display.innerHTML = '<i class="fas fa-check-circle me-1"></i> เลือกแล้ว ' + files.length + ' ไฟล์';
            } else {
                display.innerHTML = '';
            }
        });
    </script>

</body>
</html>