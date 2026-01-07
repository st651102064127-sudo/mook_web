<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_superAdmin.php";

$sql = "SELECT * FROM employee 
        WHERE EmpRole = 'Member'
        ORDER BY EmpID DESC";

$result = mysqli_query($conn, $sql);

// ฟังก์ชันแปลงวันที่ไทย
function th_date($datetime) {
    if (empty($datetime)) return ""; // ถ้าไม่มีค่าให้คืนเป็นช่องว่าง

    $months = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

    $ts = strtotime($datetime);
    return date("j", $ts) . " " . $months[(int)date("n", $ts)] . " " . (date("Y", $ts) + 543);
}

?>

<!DOCTYPE html>
<html lang="th">
<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">
<?php include("../../admin/include/navbar.php"); ?>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include("../../admin/include/sidebar.php"); ?>
    </div>

    <div id="layoutSidenav_content">
        <main class="container-fluid px-4">
            <h1 class="mt-4">จัดการเจ้าหน้าที่</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users me-1"></i> รายการเจ้าหน้าที่
                    <a href="../frminsert/finsert_employee.php" class="btn btn-success btn-sm float-end">+ เพิ่มเจ้าหน้าที่</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>ตำแหน่ง</th>
                                <th>หน่วยงาน</th>
                                <th>เข้าใช้งานล่าสุด</th>
                                <th>แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['EmpName']) ?></td>
                                <td><?= htmlspecialchars($row['EmpPosition']) ?></td>
                                <td><?= htmlspecialchars($row['EmpDepartment']) ?></td>
                                <td><?= th_date($row['EmpLastLogin']) ?></td>

                                
                                <td><a class="btn btn-warning btn-sm" href="../frmedit/frmedit_employee.php?id=<?= $row['EmpID'] ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                <td><a class="btn btn-danger btn-sm" href="../process/delete_employee.php?id=<?= $row['EmpID'] ?>" onclick="return confirm('ยืนยันลบเจ้าหน้าที่?')"><i class="fa-solid fa-trash-can"></i></a></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include("../../admin/include/footer.php"); ?>
    </div>
</div>
<style>
    td:empty::after {
        content: "-";
        color: #ccc;
        font-style: italic;
    }
</style>

<?php include("../include/script.php"); ?>
</body>
</html>
