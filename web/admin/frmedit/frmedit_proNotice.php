<?php
include "../../assets/connect_db/connect_db.php";

$id = $_GET['id'] ?? 0;

// ดึงข้อมูลรายการจากฐานข้อมูล
$sql = "SELECT * FROM procurementnotice WHERE NoticeID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);


function formatDateThai($strDate)
{
    if (empty($strDate) || $strDate == "0000-00-00") {
        return "-";
    }

    // รายชื่อเดือนภาษาไทย
    $months = [
        "",
        "มกราคม",
        "กุมภาพันธ์",
        "มีนาคม",
        "เมษายน",
        "พฤษภาคม",
        "มิถุนายน",
        "กรกฎาคม",
        "สิงหาคม",
        "กันยายน",
        "ตุลาคม",
        "พฤศจิกายน",
        "ธันวาคม"
    ];

    // แปลงวันที่
    $timestamp = strtotime($strDate);
    if ($timestamp === false) {
        return "-";
    }

    $day   = (int)date("d", $timestamp);
    $month = (int)date("m", $timestamp);
    $year  = (int)date("Y", $timestamp) + 543;

    // คืนค่ารูปแบบ 15 พฤศจิกายน 2568
    return "{$day} {$months[$month]} {$year}";
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">
    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">การจัดซื้อจัดจ้าง</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> แก้ไขประกาศพัสดุ
                        </div>
                        <div class="card-body">
                            <form action="../../admin/process/updete_proNotice.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="NoticeID" value="<?= $row['NoticeID'] ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['NoticeFile'] ?>">

                                <div class="input-group mb-3">
                                    <label class="input-group-text">เรื่อง</label>
                                    <input type="text" name="NoticeName" id="NoticeName" class="form-control" value="<?= htmlspecialchars($row['NoticeName']) ?>">
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">วันที่ประกาศ</label>
                                            <input type="date" name="NoticeStDate" class="form-control"
                                                value="<?= date('Y-m-d', strtotime($row['NoticeStDate'])) ?>">
                                            <span class="input-group-text">
                                                <?= formatDateThai($row['NoticeStDate']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">วันที่สิ้นสุด</label>
                                            <input type="date" name="NoticeEnDate" class="form-control"
                                                value="<?= date('Y-m-d', strtotime($row['NoticeEnDate'])) ?>">
                                            <span class="input-group-text">
                                                <?= formatDateThai($row['NoticeEnDate']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">หน่วยงาน</label>
                                            <input type="text" name="NoticeDepartment" class="form-control" value="กลุ่มงานพัสดุ" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text">สังกัด</label>
                                            <input type="text" name="NoticeAgency" class="form-control" value="โรงพยาบาลหล่มสัก" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">ไฟล์เอกสารเดิม:</label><br>
                                    <?php if (!empty($row['NoticeFile'])): ?>
                                        <a href="../../assets/images/proNotice/<?= $row['NoticeFile'] ?>" target="_blank"><?= $row['NoticeFile'] ?></a><br>
                                        <input type="checkbox" name="DeleteOldFile" value="1"> ลบไฟล์เดิม
                                    <?php else: ?>
                                        <span>ไม่มีไฟล์แนบ</span>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="NoticeFile" class="form-label">อัปโหลดไฟล์ใหม่</label>
                                    <input type="file" name="NoticeFile" id="NoticeFile" class="form-control">
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" onclick="history.back()" class="btn btn-warning">กลับหน้าหลัก</button>
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

<style>
    .input-group-text {
        min-width: 120px;
    }
</style>