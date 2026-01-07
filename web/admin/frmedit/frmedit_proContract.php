<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";

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
    echo "ไม่พบข้อมูลสัญญา";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">

    <!-- Navbar -->
    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">

        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">

                    <h1 class="mt-4">แก้ไขประกาศสัญญาพัสดุ</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-file-contract me-1"></i>
                            แก้ไขประกาศสัญญา
                        </div>

                        <div class="card-body">
                            <form action="../../admin/process/update_proContract.php" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="ContractID" value="<?= $row['ContractID']; ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['ContractFile']; ?>">

                                <!-- ชื่อสัญญา -->
                                <div class="input-group mb-3">
                                    <label class="input-group-text">เรื่อง</label>
                                    <input type="text" name="ContractName" class="form-control"
                                           value="<?= htmlspecialchars($row['ContractName']); ?>" >
                                </div>

                                <!-- วันที่เริ่ม - สิ้นสุด -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">วันที่เริ่มสัญญา</label>
                                            <input type="date" name="ContractDate"
                                                   value="<?= date('Y-m-d', strtotime($row['ContractDate'])); ?>"
                                                   class="form-control" >
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">วันที่สิ้นสุดสัญญา</label>
                                            <input type="date" name="ContractEndDate"
                                                   value="<?= date('Y-m-d', strtotime($row['ContractEndDate'])); ?>"
                                                   class="form-control" >
                                        </div>
                                    </div>
                                </div>

                                <!-- หน่วยงาน -->
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">หน่วยงาน</label>
                                            <input type="text" name="ContractDepartment" class="form-control"
                                                   value="<?= htmlspecialchars($row['ContractDepartment']); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">สังกัด</label>
                                            <input type="text" name="ContractAgency" class="form-control"
                                                   value="<?= htmlspecialchars($row['ContractAgency']); ?>" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- FILE -->
                                <div class="mb-3">
                                    <label class="form-label">ไฟล์สัญญาเดิม</label><br>

                                    <?php if (!empty($row['ContractFile'])): ?>
                                        <a href="../../assets/images/proContract/<?= $row['ContractFile']; ?>" target="_blank">
                                            <?= $row['ContractFile']; ?>
                                        </a>

                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" value="1" id="del_file" name="del_file">
                                            <label class="form-check-label" for="del_file">ลบไฟล์เดิม</label>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted">ไม่มีไฟล์เดิม</p>
                                    <?php endif; ?>

                                    <div class="mt-2">
                                        <label class="form-label">อัปโหลดไฟล์ใหม่</label>
                                        <input type="file" name="ContractFile" class="form-control">
                                    </div>
                                </div>

                                <!-- ปุ่ม -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-warning" onclick="history.back()">ย้อนกลับ</button>
                                    <button type="submit" class="btn btn-success ms-2">บันทึกการแก้ไข</button>
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
