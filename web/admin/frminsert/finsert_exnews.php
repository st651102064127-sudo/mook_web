<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข่าวประชาสัมพันธ์ภายนอก - โรงพยาบาลหล่มสัก</title>
    
    <!-- 1. Google Fonts: Kanit -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- 2. FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <?php include("../../admin/include/header.php"); ?>

    <style>
        /* --- Global Styles --- */
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f0f2f5;
            color: #444;
        }

        /* --- Header Section --- */
        .page-header-container {
            background: linear-gradient(to right, #ffffff, #f8fff9);
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            margin-bottom: 1.5rem;
            border-left: 5px solid #198754;
        }

        .page-title {
            font-weight: 600;
            color: #064020;
            margin-bottom: 0;
        }

        /* --- Form Card --- */
        .main-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.04);
            background: white;
            overflow: hidden;
        }

        .card-header-custom {
            background-color: white;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.25rem 1.5rem;
        }

        /* --- Form Inputs --- */
        .form-label-custom {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control-custom {
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15);
            background-color: #fff;
        }

        /* --- Custom File Upload --- */
        .custom-file-upload {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .custom-file-upload:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        
        /* Hide default file input but keep functionality */
        input[type="file"] {
            display: none;
        }

        /* --- Buttons --- */
        .btn-custom-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-custom-secondary:hover {
            background-color: #5c636a;
            color: white;
            transform: translateY(-2px);
        }

        .btn-custom-primary {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            border: none;
            color: white;
            border-radius: 8px;
            padding: 0.6rem 2rem;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
            transition: all 0.3s ease;
        }
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(25, 135, 84, 0.3);
            color: white;
        }

    </style>
</head>

<body class="sb-nav-fixed">
    
    <!-- Navbar -->
    <?php include("../../admin/include/navbar.php"); ?>

    <!-- Layout -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    
                    <!-- Header -->
                    <div class="page-header-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                <i class="fas fa-bullhorn fa-lg"></i>
                            </div>
                            <div>
                                <h2 class="page-title">เพิ่มข่าวประชาสัมพันธ์ภายนอก</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0" style="font-size: 0.9rem;">
                                        <li class="breadcrumb-item"><a href="../manage/Employee.php" class="text-muted text-decoration-none">หน้าหลัก</a></li>
                                        <li class="breadcrumb-item"><a href="../manage/manage_exnews.php" class="text-muted text-decoration-none">ข่าวภายนอก</a></li>
                                        <li class="breadcrumb-item active text-success fw-bold">เพิ่มข่าว</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="main-card">
                        <div class="card-header-custom">
                            <h5 class="m-0 fw-bold text-dark"><i class="fas fa-edit me-2 text-success"></i>กรอกข้อมูลข่าว</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="../../admin/process/insert_exnews.php" method="post" enctype="multipart/form-data">
                                
                                <!-- หัวข้อข่าว -->
                                <div class="mb-4">
                                    <label for="ExtNewsName" class="form-label-custom">
                                        <i class="fas fa-heading me-1 text-muted"></i> เรื่อง
                                    </label>
                                    <input type="text" name="ExtNewsName" id="ExtNewsName" required class="form-control form-control-custom" placeholder="ระบุชื่อเรื่องข่าว...">
                                </div>

                                <!-- รายละเอียด -->
                                <div class="mb-4">
                                    <label for="ExtNewsDetail" class="form-label-custom">
                                        <i class="fas fa-align-left me-1 text-muted"></i> รายละเอียดเพิ่มเติม
                                    </label>
                                    <textarea name="ExtNewsDetail" id="ExtNewsDetail" rows="5" required class="form-control form-control-custom" placeholder="ระบุรายละเอียดเนื้อหาข่าว..."></textarea>
                                </div>

                                <!-- ไฟล์เอกสาร -->
                                <div class="mb-4">
                                    <label class="form-label-custom">
                                        <i class="fas fa-paperclip me-1 text-muted"></i> ไฟล์เอกสารแนบ
                                    </label>
                                    
                                    <!-- Custom Upload UI -->
                                    <label for="ExtNewsFile" class="custom-file-upload d-block">
                                        <div class="mb-2">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">คลิกเพื่ออัปโหลดไฟล์ หรือลากไฟล์มาวางที่นี่</h6>
                                        <p class="text-muted small mb-0">รองรับไฟล์ PDF, DOC, JPG (Max 10MB)</p>
                                        <input type="file" id="ExtNewsFile" name="ExtNewsFile" required onchange="updateFileName(this)">
                                    </label>
                                    
                                    <!-- แสดงชื่อไฟล์ที่เลือก -->
                                    <div id="fileNameDisplay" class="mt-2 text-success small fw-bold" style="display: none;">
                                        <i class="fas fa-check-circle me-1"></i> <span id="fileNameText"></span>
                                    </div>
                                </div>

                                <hr class="my-4 border-secondary opacity-25">

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-custom-secondary" onclick="history.back()">
                                        <i class="fas fa-arrow-left me-2"></i> กลับ
                                    </button>
                                    <button type="submit" name="upload" class="btn btn-custom-primary">
                                        <i class="fas fa-save me-2"></i> บันทึกข้อมูล
                                    </button>
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

    <!-- Script เสริมเพื่อแสดงชื่อไฟล์เมื่อเลือก -->
    <script>
        function updateFileName(input) {
            const display = document.getElementById('fileNameDisplay');
            const textSpan = document.getElementById('fileNameText');
            const uploadBox = document.querySelector('.custom-file-upload');
            
            if (input.files && input.files[0]) {
                textSpan.textContent = input.files[0].name;
                display.style.display = 'block';
                uploadBox.style.borderColor = '#198754';
                uploadBox.style.backgroundColor = '#e6f4ea';
            } else {
                display.style.display = 'none';
                uploadBox.style.borderColor = '#dee2e6';
                uploadBox.style.backgroundColor = '#f8f9fa';
            }
        }
    </script>
</body>
</html>