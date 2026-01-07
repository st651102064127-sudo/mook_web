<?php
include "../../assets/connect_db/connect_db.php"; // ไฟล์เชื่อมฐานข้อมูล
include "../../assets/check_login_admin/check_login_admin.php";

$sql = "SELECT * FROM externalnews WHERE ExtNewsStatus = 'Active' ORDER BY ExtNewsDate DESC";

$result = mysqli_query($conn, $sql);

// ฟังก์ชันแปลงวันที่เป็นไทย
function th_date($datetime) {
    $months = [
        "", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];
    $timestamp = strtotime($datetime);
    $day = date("j", $timestamp);
    $month = $months[(int)date("n", $timestamp)];
    $year = date("Y", $timestamp) + 543;

    return "$day $month $year";
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">
    <div class="container-fluid">
        <div class="row ">
            <!-- Navbar ด้านบน -->
            <?php include("../../admin/include/navbar.php"); ?>

            <!-- Layout หลัก -->
            <div id="layoutSidenav">

                <!-- Sidebar -->
                <div id="layoutSidenav_nav">
                    <?php include("../../admin/include/sidebar.php"); ?>
                </div>

                <!-- Content -->
                <div id="layoutSidenav_content">
                    <main>
                        <h1 class="mt-4">ข่าวประชาสัมพันธ์ภายนอก</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                รายการข่าวประชาสัมพันธ์ภายนอก
                                <a href="../../admin/frminsert/finsert_exnews.php" class="btn btn-success btn-sm float-end">
                                    + เพิ่มข่าว
                                </a>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>หมายเลข</th>
                                            <th>เรื่อง</th>
                                            <th>วันที่</th>
                                            <th>แก้ไข</th>
                                            <th>ลบ</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        $i = 1; // เริ่มลำดับที่ 1
                                        while ($row = mysqli_fetch_assoc($result)):
                                        ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['ExtNewsName'] ?></td>
                                                <td><?= th_date($row['ExtNewsDate']) ?></td>

                                                <td><a class="btn btn-warning btn-sm" href="../../admin/frmedit/frmedit_exnews.php?id=<?= $row['ExtNewsID'] ?>"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                                <td>

                                                    <a class="btn btn-danger btn-sm" href="../../admin/process/delete_exnews.php?id=<?= $row['ExtNewsID'] ?>" onclick="return confirm('ยืนยันการลบ?')"><i class="fa-solid fa-trash-can"></i></a>
                                                </td>
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
        </div>
    </div>
    <?php include("../include/script.php"); ?>
</body>

</html>