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
                    <h1 class="mt-4">ประกาศสัญญาพัสดุ</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-file-contract me-1"></i>
                            เพิ่มประกาศสัญญาพัสดุ
                        </div>

                        <div class="card-body">
                            <form action="../../admin/process/insert_proContract.php" method="post" enctype="multipart/form-data">

                                <!-- ชื่อสัญญา -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text">เรื่อง</label>
                                    <input type="text" name="ContractName" class="form-control" required>
                                </div>

                                <!-- วันที่เริ่ม & วันที่สิ้นสุด -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">วันที่เริ่มสัญญา</label>
                                            <input type="date" name="ContractDate" value="<?= date('Y-m-d'); ?>" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">วันที่สิ้นสุดสัญญา</label>
                                            <input type="date" name="ContractEndDate" value="<?= date('Y-m-d'); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- หน่วยงาน -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">หน่วยงาน</label>
                                            <input type="text" name="ContractDepartment" class="form-control"
                                                value="กลุ่มงานพัสดุ" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">สังกัด</label>
                                            <input type="text" name="ContractAgency" class="form-control"
                                                value="โรงพยาบาลหล่มสัก" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- ไฟล์สัญญา -->
                                <div class="mb-3">
                                    <label class="form-label">ไฟล์เอกสารสัญญา</label>
                                    <input type="file" name="ContractFile" class="form-control" required>
                                </div>

                                <!-- ปุ่ม -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-warning" onclick="history.back()">ย้อนกลับ</button>
                                    <button type="submit" class="btn btn-success ms-2">บันทึกข้อมูล</button>
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
