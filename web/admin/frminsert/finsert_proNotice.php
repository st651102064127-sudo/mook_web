<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">

    <!-- Navbar -->
    <?php include("../../admin/include/navbar.php"); ?>

    <!-- Layout -->
    <div id="layoutSidenav">

        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">การจัดซื้อจัดจ้าง</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            เพิ่มประกาศพัสดุ
                        </div>
                        <div class="card-body">
                            <form action="../../admin/process/insert_proNotice.php" method="post" enctype="multipart/form-data">

                                <!-- เรื่อง -->
                                <div class="input-group mb-3">
                                    <label for="name" class="input-group-text">เรื่อง</label>
                                    <input type="text" name="NoticeName" id="name" required class="form-control">
                                </div>

                                <!-- วันที่ -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="NoticeStDate">วันที่ประกาศ</label>
                                            <input type="date" name="NoticeStDate" id="NoticeStDate" value="<?= date('Y-m-d'); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="NoticeEnDate">วันที่สิ้นสุดประกาศ</label>
                                            <input type="date" name="NoticeEnDate" id="NoticeEnDate" value="<?= date('Y-m-d'); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- หน่วยงานและสังกัด -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">หน่วยงาน</label>
                                            <input type="text" name="NoticeDepartment" value="กลุ่มงานพัสดุ" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">สังกัด</label>
                                            <input type="text" name="NoticeAgency" value="โรงพยาบาลหล่มสัก" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- ไฟล์แนบ -->
                                <div class="mb-3">
                                    <label for="NoticeFile" class="form-label">ไฟล์เอกสาร</label>
                                    <input type="file" class="form-control" id="NoticeFile" name="NoticeFile" required>
                                </div>

                                <!-- ปุ่ม -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-warning" onclick="history.back()">กลับหน้าหลัก</button>
                                    <button type="submit" name="upload" class="btn btn-success">บันทึกข้อมูล</button>
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
