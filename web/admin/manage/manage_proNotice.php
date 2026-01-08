<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

// ดึงประกาศจัดซื้อจัดจ้างที่สถานะ Active
$sql = "SELECT * FROM procurementnotice WHERE NoticeStatus = 'Active' ORDER BY NoticeStDate DESC";
$result = mysqli_query($conn, $sql);

// ฟังก์ชันแปลงวันที่เป็นไทย
function th_date($datetime) {
    $months = [
        "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
    ];
    $timestamp = strtotime($datetime);
    return date("j", $timestamp) . " " . $months[(int)date("n", $timestamp)] . " " . (date("Y", $timestamp) + 543);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการประกาศจัดซื้อจัดจ้าง</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <?php include("../../admin/include/header.php"); ?>

    <style>
        /* Theme: ราชการทันสมัย */
        body { 
            font-family: 'Kanit', sans-serif; 
            background-color: #f4f6f9; 
            color: #333; 
        }
        table.dataTable td, table.dataTable th {
            font-size: 16px; 
            vertical-align: middle;
        }
        .table-head-gov {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
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
                    
                    <div class="card border-0 shadow-sm mb-4" style="background-color: #198754; color: white;">
                        <div class="card-body d-flex justify-content-between align-items-center p-4">
                            <div>
                                <h3 class="mb-1 fw-bold"><i class="fas fa-bullhorn me-2"></i>ประกาศจัดซื้อจัดจ้าง</h3>
                                <p class="mb-0 opacity-75" style="font-size: 16px;">จัดการรายการประกาศ ประกาศผู้ชนะ และเอกสารที่เกี่ยวข้อง</p>
                            </div>
                            <div>
                                <a href="../../admin/frminsert/finsert_proNotice.php" class="btn btn-light text-success fw-bold shadow-sm py-2 px-3">
                                    <i class="fas fa-plus-circle me-1"></i> เพิ่มประกาศใหม่
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card border mb-4 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <i class="fas fa-list-alt me-1 text-success"></i>
                            รายการประกาศทั้งหมด
                        </div>
                        <div class="card-body">
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <table id="datatablesSimple" class="table table-striped table-hover border">
                                    <thead class="table-head-gov">
                                        <tr>
                                            <th class="text-center" width="5%">ลำดับ</th>
                                            <th width="55%">ชื่อประกาศ / เรื่อง</th>
                                            <th width="20%">วันที่ประกาศ</th>
                                            <th class="text-center" width="20%">การจัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1; 
                                        while ($row = mysqli_fetch_assoc($result)): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $i++ ?></td>
                                            <td>
                                                <span class="fw-medium text-dark"><?= htmlspecialchars($row['NoticeName']) ?></span>
                                                <div class="small text-muted mt-1">Ref: #<?= $row['NoticeID'] ?></div>
                                            </td>
                                            <td>
                                                <span data-order="<?= $row['NoticeStDate'] ?>">
                                                    <i class="far fa-calendar-alt me-1 text-muted"></i> <?= th_date($row['NoticeStDate']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="../../admin/frmedit/frmedit_proNotice.php?id=<?= $row['NoticeID'] ?>" class="btn btn-warning btn-sm text-dark" title="แก้ไข">
                                                        <i class="fas fa-edit"></i> แก้ไข
                                                    </a>
                                                    <a href="../../admin/process/delete_proNotice.php?id=<?= $row['NoticeID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูลประกาศนี้?');" title="ลบ">
                                                        <i class="fas fa-trash-alt"></i> ลบ
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-secondary text-center py-4" role="alert">
                                    <i class="fas fa-folder-open me-2"></i> ไม่พบข้อมูลประกาศในระบบ
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </main>
            <?php include("../../admin/include/footer.php"); ?>
        </div>
    </div>

    <?php include("../include/script.php"); ?>
    
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable({
                language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json" },
                pageLength: 10,
                order: [[2, 'desc']], // เรียงตามวันที่ (คอลัมน์ index 2) จากมากไปน้อย
                columnDefs: [{ orderable: false, targets: [0, 3] }] // ปิดการเรียงลำดับคอลัมน์ ลำดับ(0) และ จัดการ(3)
            });
        });
    </script>
</body>
</html>