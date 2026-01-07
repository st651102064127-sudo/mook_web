<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_admin.php";

// ------------------------------------------------------------------
// ส่วนที่ 1: เตรียมข้อมูลสำหรับ Dashboard (Backend Logic)
// ------------------------------------------------------------------

// 1. ดึงจำนวน "ประกาศจัดซื้อจัดจ้าง" ที่กำลังดำเนินการ (Active)
$sqlNotice = "SELECT COUNT(*) as total FROM procurementnotice WHERE NoticeStatus = 'Active'";
$resNotice = mysqli_fetch_assoc(mysqli_query($conn, $sqlNotice));

// 2. ดึงจำนวน "สัญญา" ที่จะหมดอายุใน 30 วัน (Critical Alert)
$sqlExp = "SELECT COUNT(*) as total FROM procurementcontract 
           WHERE ContractEndDate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)";
$resExp = mysqli_fetch_assoc(mysqli_query($conn, $sqlExp));

// 3. ดึงจำนวน "ข่าวประชาสัมพันธ์" ทั้งหมด (ภายนอก + ภายใน)
$sqlNews1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM externalnews"));
$sqlNews2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM internalnews"));
$totalNews = $sqlNews1['t'] + $sqlNews2['t'];

// 4. ดึงจำนวน "เจ้าหน้าที่" ในระบบ
$sqlEmp = "SELECT COUNT(*) as total FROM employee";
$resEmp = mysqli_fetch_assoc(mysqli_query($conn, $sqlEmp));

// ฟังก์ชันแปลงวันที่ไทย (สำหรับแสดงผลในตาราง)
function formatDateThai($datetime) {
    if ($datetime == '0000-00-00 00:00:00' || $datetime == null) return "-";
    $monthThai = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    $ts = strtotime($datetime);
    $day = date("j", $ts);
    $month = $monthThai[(int)date("n", $ts)];
    $year = date("Y", $ts) + 543;
    return "$day $month $year"; // แสดงแบบย่อ เช่น 12 ม.ค. 2569
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <?php include("../include/header.php"); ?>
    <style>
        .card-dashboard {
            border: none;
            border-radius: 15px;
            transition: transform 0.2s;
            overflow: hidden;
        }
        .card-dashboard:hover {
            transform: translateY(-5px); /* ขยับขึ้นเล็กน้อยเมื่อเอาเมาส์ชี้ */
        }
        .icon-dashboard {
            opacity: 0.3;
        }
    </style>
</head>

<body class="sb-nav-fixed" style="background-color: #f5f5f5;">

    <?php include("../include/navbar.php"); ?>

    <div id="layoutSidenav">
        
        <div id="layoutSidenav_nav">
            <?php include("../include/sidebar.php"); ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    
                    <div class="d-flex justify-content-between align-items-center my-4">
                        <div>
                            <h1 class="text-success fw-bold m-0">Dashboard</h1>
                            <p class="text-muted small m-0">ภาพรวมระบบบริหารงานพัสดุ โรงพยาบาลหล่มสัก</p>
                        </div>
                        <div class="text-end">
                             <span class="badge bg-white text-dark border shadow-sm px-3 py-2">
                                <i class="fas fa-calendar-alt me-2 text-success"></i>
                                <?= formatDateThai(date("Y-m-d H:i:s")); ?>
                             </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-dashboard bg-primary text-white mb-4 shadow">
                                <div class="card-body d-flex justify-content-between align-items-center p-4">
                                    <div>
                                        <h2 class="mb-0 fw-bold"><?= $resNotice['total']; ?></h2>
                                        <div class="small opacity-75">ประกาศ (กำลังดำเนินการ)</div>
                                    </div>
                                    <i class="fas fa-bullhorn fa-3x icon-dashboard"></i>
                                </div>
                                <div class="card-footer bg-primary border-0 d-flex align-items-center justify-content-between">
                                    <a class="small text-white text-decoration-none stretched-link" href="manage_proNotice.php">ดูรายละเอียด</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-dashboard bg-danger text-white mb-4 shadow">
                                <div class="card-body d-flex justify-content-between align-items-center p-4">
                                    <div>
                                        <h2 class="mb-0 fw-bold"><?= $resExp['total']; ?></h2>
                                        <div class="small opacity-75">สัญญาหมดอายุใน 30 วัน</div>
                                    </div>
                                    <i class="fas fa-file-contract fa-3x icon-dashboard"></i>
                                </div>
                                <div class="card-footer bg-danger border-0 d-flex align-items-center justify-content-between">
                                    <a class="small text-white text-decoration-none stretched-link" href="manage_proContract.php">จัดการด่วน</a>
                                    <div class="small text-white"><i class="fas fa-exclamation-circle"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-dashboard bg-success text-white mb-4 shadow">
                                <div class="card-body d-flex justify-content-between align-items-center p-4">
                                    <div>
                                        <h2 class="mb-0 fw-bold"><?= $totalNews; ?></h2>
                                        <div class="small opacity-75">ข่าวประชาสัมพันธ์ทั้งหมด</div>
                                    </div>
                                    <i class="fas fa-newspaper fa-3x icon-dashboard"></i>
                                </div>
                                <div class="card-footer bg-success border-0 d-flex align-items-center justify-content-between">
                                    <a class="small text-white text-decoration-none stretched-link" href="manage_exnews.php">ดูรายการข่าว</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-dashboard bg-dark text-white mb-4 shadow">
                                <div class="card-body d-flex justify-content-between align-items-center p-4">
                                    <div>
                                        <h2 class="mb-0 fw-bold"><?= $resEmp['total']; ?></h2>
                                        <div class="small opacity-75">เจ้าหน้าที่ในระบบ</div>
                                    </div>
                                    <i class="fas fa-users fa-3x icon-dashboard"></i>
                                </div>
                                <div class="card-footer bg-dark border-0 d-flex align-items-center justify-content-between">
                                    <a class="small text-white text-decoration-none stretched-link" href="manage_employee.php">จัดการข้อมูล</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4 shadow border-0 rounded-3">
                                <div class="card-header bg-white py-3 border-bottom">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <span class="fw-bold text-dark">สัญญาที่ต้องเร่งดำเนินการ (ใกล้หมดอายุ)</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="ps-4">ชื่อสัญญา</th>
                                                    <th>วันหมดอายุ</th>
                                                    <th>สถานะ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // ดึง 5 สัญญาที่ใกล้หมดอายุที่สุด
                                                $sqlAlert = "SELECT ContractName, ContractEndDate FROM procurementcontract 
                                                             WHERE ContractEndDate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY) 
                                                             ORDER BY ContractEndDate ASC LIMIT 5";
                                                $qAlert = mysqli_query($conn, $sqlAlert);
                                                
                                                if (mysqli_num_rows($qAlert) > 0) {
                                                    while($rowAlert = mysqli_fetch_assoc($qAlert)) {
                                                        echo "<tr>";
                                                        echo "<td class='ps-4'><div class='text-truncate' style='max-width: 200px;'>".htmlspecialchars($rowAlert['ContractName'])."</div></td>";
                                                        echo "<td class='text-danger fw-bold'>".formatDateThai($rowAlert['ContractEndDate'])."</td>";
                                                        echo "<td><span class='badge bg-warning text-dark rounded-pill'>ใกล้หมดอายุ</span></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3' class='text-center text-muted py-4'><i class='fas fa-check-circle text-success me-1'></i> ไม่มีสัญญาที่ใกล้หมดอายุ</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-white text-center border-0">
                                    <a href="manage_proContract.php" class="btn btn-sm btn-outline-secondary rounded-pill px-4">ดูทั้งหมด</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card mb-4 shadow border-0 rounded-3">
                                <div class="card-header bg-white py-3 border-bottom">
                                    <i class="fas fa-history text-primary me-2"></i>
                                    <span class="fw-bold text-dark">การเข้าใช้งานล่าสุดของเจ้าหน้าที่</span>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <?php
                                        // ดึงข้อมูล 5 คนล่าสุดที่ล็อกอิน
                                        $sqlLog = "SELECT EmpName, EmpLastLogin, EmpPosition FROM employee 
                                                   WHERE EmpLastLogin IS NOT NULL
                                                   ORDER BY EmpLastLogin DESC LIMIT 5";
                                        $qLog = mysqli_query($conn, $sqlLog);
                                        
                                        if (mysqli_num_rows($qLog) > 0) {
                                            while($rowLog = mysqli_fetch_assoc($qLog)) {
                                                // คำนวณเวลาที่ผ่านไป (เช่น "2 นาทีที่แล้ว") - แบบง่ายใช้แสดงวันที่แทน
                                                $loginTime = date("H:i", strtotime($rowLog['EmpLastLogin']));
                                                $loginDate = formatDateThai($rowLog['EmpLastLogin']);
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-3 border" style="width: 45px; height: 45px;">
                                                    <i class="fas fa-user text-secondary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($rowLog['EmpName']) ?></div>
                                                    <div class="small text-muted"><?= htmlspecialchars($rowLog['EmpPosition']) ?></div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="small fw-bold text-success"><?= $loginTime ?> น.</div>
                                                <div class="small text-muted" style="font-size: 0.75rem;"><?= $loginDate ?></div>
                                            </div>
                                        </li>
                                        <?php 
                                            } 
                                        } else {
                                            echo "<li class='list-group-item text-center text-muted py-4'>ยังไม่มีประวัติการเข้าใช้งาน</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
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