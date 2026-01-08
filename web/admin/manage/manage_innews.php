<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

// ดึงข่าวภายในที่สถานะ Active
$sql = "SELECT * FROM internalnews WHERE IntNewsStatus = 'Active' ORDER BY IntNewsDate DESC";
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
    <title>ระบบบริหารจัดการข่าวประชาสัมพันธ์ภายใน</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <?php include("../../admin/include/header.php"); ?>

    <style>
        /* Theme: ราชการทันสมัย (ชุดเดียวกับหน้าข่าวภายนอก) */
        body { 
            font-family: 'Kanit', sans-serif; 
            background-color: #f4f6f9; 
            color: #333; 
        }
        /* ปรับขนาดตัวหนังสือในตารางให้อ่านง่าย */
        table.dataTable td, table.dataTable th {
            font-size: 16px; 
            vertical-align: middle;
        }
        /* หัวข้อตารางสีเทาอ่อนสะอาดตา */
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
                                <h3 class="mb-1 fw-bold"><i class="fas fa-bullhorn me-2"></i>ข่าวประชาสัมพันธ์ภายใน</h3>
                                <p class="mb-0 opacity-75" style="font-size: 16px;">จัดการข่าวสารสำหรับแจ้งบุคลากรภายในหน่วยงาน</p>
                            </div>
                            <div>
                                <a href="../../admin/frminsert/finsert_innews.php" class="btn btn-light text-success fw-bold shadow-sm py-2 px-3">
                                    <i class="fas fa-plus-circle me-1"></i> เพิ่มข่าวใหม่
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card border mb-4 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <i class="fas fa-table me-1 text-success"></i>
                            รายการข่าวทั้งหมด
                        </div>
                        <div class="card-body">
                            <?php if(mysqli_num_rows($result) > 0): ?>
                                <table id="datatablesSimple" class="table table-striped table-hover border">
                                    <thead class="table-head-gov">
                                        <tr>
                                            <th class="text-center" width="5%">ลำดับ</th>
                                            <th width="55%">เรื่อง / หัวข้อข่าว</th>
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
                                                <span class="fw-medium text-dark"><?= htmlspecialchars($row['IntNewsName']) ?></span>
                                                <div class="small text-muted mt-1">Ref: #<?= $row['IntNewsID'] ?></div>
                                            </td>
                                            <td>
                                                <span data-order="<?= $row['IntNewsDate'] ?>">
                                                    <i class="far fa-calendar-alt me-1 text-muted"></i> <?= th_date($row['IntNewsDate']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="../../admin/frmedit/frmedit_innews.php?id=<?= $row['IntNewsID'] ?>" class="btn btn-warning btn-sm text-dark" title="แก้ไขข้อมูล">
                                                        <i class="fas fa-edit"></i> แก้ไข
                                                    </a>
                                                    <a href="../../admin/process/delete_innews.php?id=<?= $row['IntNewsID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข่าวนี้หรือไม่?');" title="ลบข้อมูล">
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
                                    <i class="fas fa-info-circle me-2"></i> ยังไม่มีข้อมูลข่าวประชาสัมพันธ์ภายใน
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
                order: [[2, 'desc']], // เรียงตามวันที่ล่าสุด
                columnDefs: [{ orderable: false, targets: [0, 3] }]
            });
        });
    </script>
</body>
</html>