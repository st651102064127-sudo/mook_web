<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

 $id = $_GET['id'];
 $sql = "SELECT * FROM externalnews WHERE ExtNewsID = ?";
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
    <title>แก้ไขข่าวประชาสัมพันธ์ภายนอก - โรงพยาบาลหล่มสัก</title>
    
    <!-- 1. Google Fonts: Kanit -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- 2. FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <?php include("../../admin/include/header.php"); ?>
    <link rel="stylesheet" href="style/exnews.css">
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
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3">
                                <i class="fas fa-edit fa-lg"></i>
                            </div>
                            <div>
                                <h2 class="page-title">แก้ไขข่าวประชาสัมพันธ์ภายนอก</h2>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0" style="font-size: 0.9rem;">
                                        <li class="breadcrumb-item"><a href="../manage/Employee.php" class="text-muted text-decoration-none">หน้าหลัก</a></li>
                                        <li class="breadcrumb-item"><a href="../manage/manage_exnews.php" class="text-muted text-decoration-none">ข่าวภายนอก</a></li>
                                        <li class="breadcrumb-item active text-success fw-bold">แก้ไขข้อมูล</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="main-card">
                        <div class="card-header-custom">
                            <h5 class="m-0 fw-bold text-dark"><i class="fas fa-pen me-2 text-warning"></i>แก้ไขรายละเอียดข่าว</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="../../admin/process/update_exnews.php" method="post" enctype="multipart/form-data">
                                
                                <input type="hidden" name="ExtNewsID" value="<?= $row['ExtNewsID'] ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['ExtNewsFile'] ?>">

                                <!-- หัวข้อข่าว -->
                                <div class="mb-4">
                                    <label for="ExtNewsName" class="form-label-custom">
                                        <i class="fas fa-heading me-1 text-muted"></i> เรื่อง
                                    </label>
                                    <input type="text" name="ExtNewsName" id="ExtNewsName" required class="form-control form-control-custom" value="<?= htmlspecialchars($row['ExtNewsName']) ?>">
                                </div>

                                <!-- รายละเอียด -->
                                <div class="mb-4">
                                    <label for="ExtNewsDetail" class="form-label-custom">
                                        <i class="fas fa-align-left me-1 text-muted"></i> รายละเอียดเพิ่มเติม
                                    </label>
                                    <textarea name="ExtNewsDetail" id="ExtNewsDetail" rows="5" required class="form-control form-control-custom"><?= htmlspecialchars($row['ExtNewsDetail']) ?></textarea>
                                </div>

                                <!-- ส่วนจัดการไฟล์ -->
                                <div class="mb-4">
                                    <label class="form-label-custom">
                                        <i class="fas fa-paperclip me-1 text-muted"></i> ไฟล์เอกสารแนบ
                                    </label>
                                    
                                    <!-- แสดงไฟล์เดิม -->
                                    <?php if (!empty($row['ExtNewsFile'])): ?>
                                        <div class="current-file-box d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info text-white rounded-circle p-2 me-3">
                                                    <i class="fas fa-file-alt"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark small">ไฟล์เดิม</div>
                                                    <a href="../../assets/images/exNews/<?= $row['ExtNewsFile'] ?>" target="_blank" class="text-decoration-none text-success small">
                                                        <?= $row['ExtNewsFile'] ?> <i class="fas fa-external-link-alt ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="DeleteOldFile" value="1" id="deleteFileCheck">
                                                <label class="form-check-label small text-muted fw-bold" for="deleteFileCheck">
                                                    ลบทิ้ง
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="text-muted small mb-2 mt-3">ต้องการเปลี่ยนไฟล์ใหม่หรือไม่?</div>
                                    
                                    <!-- Custom Upload UI -->
                                    <label for="ExtNewsFile" class="custom-file-upload d-block">
                                        <div class="mb-2">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-secondary"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 small">คลิกเพื่อเลือกไฟล์ใหม่</h6>
                                        <p class="text-muted small mb-0">(หากไม่เลือก จะใช้ไฟล์เดิม)</p>
                                        <input type="file" id="ExtNewsFile" name="ExtNewsFile" onchange="updateFileName(this)">
                                    </label>
                                    
                                    <!-- แสดงชื่อไฟล์ที่เลือกใหม่ -->
                                    <div id="fileNameDisplay" class="mt-2 text-success small fw-bold" style="display: none;">
                                        <i class="fas fa-check-circle me-1"></i> <span id="fileNameText"></span>
                                    </div>
                                </div>

                                <hr class="my-4 border-secondary opacity-25">

                                <!-- Buttons -->
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-custom-secondary" onclick="history.back()">
                                        <i class="fas fa-arrow-left me-2"></i> ยกเลิก
                                    </button>
                                    <button type="submit" name="upload" class="btn btn-custom-primary">
                                        <i class="fas fa-save me-2"></i> บันทึกการแก้ไข
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
                uploadBox.style.backgroundColor = '#ffffff';
            }
        }
    </script>
</body>
</html>