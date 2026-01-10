<?php
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login/check_login.php";

// --- ส่วนของการดึงข้อมูลจริงจาก Database (อ้างอิงจากโครงสร้าง db_supply) ---

// 1. นับจำนวนสัญญาพัสดุทั้งหมด
$res_contract = mysqli_query($conn, "SELECT COUNT(ContractID) as total FROM procurementcontract");
$count_contract = mysqli_fetch_assoc($res_contract)['total'];

// 2. นับจำนวนสัญญาที่ใกล้หมดอายุ (สมมติว่าภายใน 30 วัน)
$res_expiring = mysqli_query($conn, "SELECT COUNT(ContractID) as total FROM procurementcontract WHERE ContractEndDate <= DATE_ADD(NOW(), INTERVAL 30 DAY)");
$count_expiring = mysqli_fetch_assoc($res_expiring)['total'];

// 3. นับจำนวนประกาศ (Notice)
$res_notice = mysqli_query($conn, "SELECT COUNT(NoticeID) as total FROM procurementnotice");
$count_notice = mysqli_fetch_assoc($res_notice)['total'];

// 4. จำนวนผู้เข้าชม (Visitors)
$res_visitors = mysqli_query($conn, "SELECT COUNT(nov_id) as total FROM tb_number_of_visitors");
$count_visitors = mysqli_fetch_assoc($res_visitors)['total'];

// 5. ข้อมูลสำหรับกราฟ Role (Member vs User)
$res_roles = mysqli_query($conn, "SELECT EmpRole, COUNT(*) as count FROM employee GROUP BY EmpRole");
$role_labels = [];
$role_data = [];
while($r = mysqli_fetch_assoc($res_roles)) {
    $role_labels[] = $r['EmpRole'];
    $role_data[] = $r['count'];
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ระบบจัดการพัสดุ</title>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php include("../../admin/include/header.php"); ?>

    <style>
        body { font-family: 'Kanit', sans-serif; background-color: #f4f6f9; }
        
        /* Dashboard Styling */
        .stat-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .bg-gradient-green { background: linear-gradient(45deg, #198754, #28a745); color: white; }
        .bg-gradient-blue { background: linear-gradient(45deg, #0d6efd, #0dcaf0); color: white; }
        .bg-gradient-orange { background: linear-gradient(45deg, #fd7e14, #ffc107); color: white; }
        .bg-gradient-purple { background: linear-gradient(45deg, #6610f2, #6f42c1); color: white; }
        
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            height: 100%;
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
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="fw-bold text-dark"><i class="fas fa-chart-line me-2 text-success"></i>ภาพรวมระบบ (Dashboard)</h2>
                        <div class="text-muted small"><?php echo date("d M Y H:i"); ?></div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-gradient-green shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="small opacity-75">สัญญาพัสดุทั้งหมด</div>
                                            <div class="display-6 fw-bold"><?= $count_contract ?></div>
                                        </div>
                                        <i class="fas fa-file-contract fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-gradient-orange shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="small opacity-75">สัญญาใกล้หมดอายุ</div>
                                            <div class="display-6 fw-bold"><?= $count_expiring ?></div>
                                        </div>
                                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-gradient-blue shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="small opacity-75">ประกาศจัดซื้อจัดจ้าง</div>
                                            <div class="display-6 fw-bold"><?= $count_notice ?></div>
                                        </div>
                                        <i class="fas fa-bullhorn fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card stat-card bg-gradient-purple shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="small opacity-75">จำนวนผู้เข้าชมสะสม</div>
                                            <div class="display-6 fw-bold"><?= $count_visitors ?></div>
                                        </div>
                                        <i class="fas fa-users fa-2x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-lg-8">
                            <div class="chart-container">
                                <h5 class="fw-bold mb-4"><i class="fas fa-history me-2 text-primary"></i>แนวโน้มผู้เข้าใช้งาน</h5>
                                <canvas id="visitorTrendChart" style="max-height: 300px;"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="chart-container text-center">
                                <h5 class="fw-bold mb-4">สัดส่วนเจ้าหน้าที่</h5>
                                <canvas id="roleDoughnutChart" style="max-height: 250px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <i class="fas fa-clock me-1 text-success"></i> สัญญาพัสดุล่าสุด
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ชื่อสัญญา</th>
                                            <th>หน่วยงาน</th>
                                            <th>วันที่สิ้นสุด</th>
                                            <th class="text-center">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $latest_sql = "SELECT * FROM procurementcontract ORDER BY ContractID DESC LIMIT 3";
                                        $latest_res = mysqli_query($conn, $latest_sql);
                                        while($row = mysqli_fetch_assoc($latest_res)):
                                        ?>
                                        <tr>
                                            <td class="fw-medium"><?= $row['ContractName'] ?></td>
                                            <td><?= $row['ContractDepartment'] ?></td>
                                            <td><span class="text-muted"><?= $row['ContractEndDate'] ?></span></td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3">Active</span>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <?php include("../../admin/include/footer.php"); ?>
        </div>
    </div>

    <?php include("../include/script.php"); ?>

    <script>
        // 1. กราฟเส้น (Visitor Trend)
        const ctxTrend = document.getElementById('visitorTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.', 'อา.'],
                datasets: [{
                    label: 'ผู้เข้าชม',
                    data: [12, 19, 15, 8, 22, 5, 10], // ข้อมูลตัวอย่าง
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { display: false }, x: { grid: { display: false } } }
            }
        });

        // 2. กราฟวงกลม (Role Distribution)
        const ctxRole = document.getElementById('roleDoughnutChart').getContext('2d');
        new Chart(ctxRole, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($role_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($role_data); ?>,
                    backgroundColor: ['#198754', '#0d6efd', '#ffc107'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
</body>
</html>