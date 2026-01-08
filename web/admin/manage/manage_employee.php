<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_superAdmin.php";

$sql = "SELECT * FROM employee 
        WHERE EmpRole = 'Member'
        ORDER BY EmpID DESC";

$result = mysqli_query($conn, $sql);

// ฟังก์ชันแปลงวันที่ไทย
function th_date($datetime) {
    if (empty($datetime)) return "-"; // ถ้าไม่มีค่าให้คืนเป็น -
    $months = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    $ts = strtotime($datetime);
    return date("j", $ts) . " " . $months[(int)date("n", $ts)] . " " . (date("Y", $ts) + 543);
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการเจ้าหน้าที่ - ระบบจัดการ</title>

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
        .badge-role {
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 20px;
            background-color: #e3f2fd;
            color: #0d47a1;
            font-weight: 500;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #198754;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
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
                                <h3 class="mb-1 fw-bold"><i class="fas fa-users-cog me-2"></i>จัดการเจ้าหน้าที่</h3>
                                <p class="mb-0 opacity-75" style="font-size: 16px;">บริหารจัดการบัญชีผู้ใช้งานและสิทธิ์การเข้าถึง</p>
                            </div>
                            <div>
                                <a href="../frminsert/finsert_employee.php" class="btn btn-light text-success fw-bold shadow-sm py-2 px-3">
                                    <i class="fas fa-user-plus me-1"></i> เพิ่มเจ้าหน้าที่
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card border mb-4 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <i class="fas fa-list-ul me-1 text-success"></i>
                            รายชื่อเจ้าหน้าที่ (Member)
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped table-hover border">
                                <thead class="table-head-gov">
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th width="30%">ชื่อ - นามสกุล</th>
                                        <th width="20%">ตำแหน่ง / หน่วยงาน</th>
                                        <th width="15%" class="text-center">สถานะ</th>
                                        <th width="15%">ใช้งานล่าสุด</th>
                                        <th class="text-center" width="15%">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1; 
                                    while ($row = mysqli_fetch_assoc($result)): 
                                        // สร้างตัวอักษรย่อจากชื่อเพื่อทำ Avatar
                                        $initial = mb_substr($row['EmpName'], 0, 1, "UTF-8");
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                          
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['EmpName']) ?></div>
                                                    <div class="small text-muted"><i class="fas fa-envelope me-1"></i><?= htmlspecialchars($row['EmpEmail'] ?? '-') ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-medium text-dark"><?= htmlspecialchars($row['EmpPosition']) ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($row['EmpDepartment']) ?></div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge-role">
                                                <i class="fas fa-user-tag me-1"></i> <?php if($_SESSION['user_role'] === "Admin"){
                                                    echo "Admin";
                                                }else{
                                                    echo "Member";
                                                } ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($row['EmpLastLogin']): ?>
                                                <span class="text-success small"><i class="fas fa-clock me-1"></i> <?= th_date($row['EmpLastLogin']) ?></span>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="../frmedit/frmedit_employee.php?id=<?= $row['EmpID'] ?>" class="btn btn-warning btn-sm text-dark" title="แก้ไขข้อมูล">
                                                    <i class="fas fa-user-edit"></i>
                                                </a>
                                                <a href="../process/delete_employee.php?id=<?= $row['EmpID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันลบเจ้าหน้าที่ท่านนี้ออกจากระบบ?')" title="ลบข้อมูล">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
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
                columnDefs: [{ orderable: false, targets: [0, 5] }] // ปิด sort ที่ลำดับ(0) และจัดการ(5)
            });
        });
    </script>
</body>
</html>