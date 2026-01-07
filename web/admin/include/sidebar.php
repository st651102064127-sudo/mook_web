<?php
// หาชื่อไฟล์ปัจจุบัน เพื่อทำเมนู Active
$current_page = basename($_SERVER['PHP_SELF']);
$current_id = $_SESSION['user_id']; // ดึง ID จาก Session

// --------------------------------------------------------
// ส่วนที่เพิ่ม: ดึงตำแหน่ง (EmpPosition) ของผู้ใช้ปัจจุบัน
// --------------------------------------------------------
$sql_user_sidebar = "SELECT EmpPosition, EmpName FROM employee WHERE EmpID = '$current_id'";
$query_user_sidebar = mysqli_query($conn, $sql_user_sidebar);
$row_user_sidebar = mysqli_fetch_assoc($query_user_sidebar);

$myPosition = $row_user_sidebar['EmpPosition']; // เก็บตำแหน่งไว้ตรวจสอบ
$myName = $row_user_sidebar['EmpName'];
$firstChar = mb_substr($myName, 0, 1, "UTF-8");

// ฟังก์ชันช่วยกำหนด Style
function getLinkStyle($isActive) {
    if ($isActive) {
        return 'background-color: #ffffff; color: #064020 !important; font-weight: 700; border-radius: 50px 0 0 50px; box-shadow: 0 4px 6px rgba(0,0,0,0.2); margin-left: 10px; margin-right: 10px;';
    } else {
        return 'color: rgba(255, 255, 255, 0.8); margin-left: 10px; margin-right: 10px;';
    }
}
?>

<style>
    /* ซ่อน Scrollbar */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion hide-scrollbar" id="sidenavAccordion" 
         style="background: linear-gradient(160deg, #198754 0%, #064020 100%); color: white; overflow-x: hidden; overflow-y: auto;">
        
        <div class="d-flex align-items-center p-3 mb-2" style="background: rgba(0,0,0,0.1); border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="rounded-circle bg-white d-flex justify-content-center align-items-center shadow-sm me-3" 
                 style="width: 50px; height: 50px; color: #198754; font-size: 1.4rem; font-weight: bold; flex-shrink: 0;">
                <?= $firstChar; ?>
            </div>
            <div style="overflow: hidden;">
                <h6 class="m-0 fw-bold text-white text-truncate"><?= $myName; ?></h6>
                <span style="font-size: 0.8rem; color: rgba(255,255,255,0.7);">
                    <i class="fas fa-circle text-warning me-1" style="font-size: 8px;"></i> <?= $myPosition; ?>
                </span>
            </div>
        </div>

        <div class="sb-sidenav-menu hide-scrollbar">
            <div class="nav">
                
                <div class="sb-sidenav-menu-heading text-uppercase opacity-50 small mt-3" style="letter-spacing: 1px;">ภาพรวมระบบ</div>
                
                <a class="nav-link py-3 transition-base" href="../manage/Employee.php" 
                   style="<?= getLinkStyle($current_page == 'Employee.php'); ?>">
                    <div class="sb-nav-link-icon me-2"><i class="fas fa-chart-line"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading text-uppercase opacity-50 small mt-3" style="letter-spacing: 1px;">การจัดการข้อมูล</div>

                <?php if ($myPosition == 'Admin') { ?>
                    
                    <?php $isActive = ($current_page == 'manage_employee.php'); ?>
                    <a class="nav-link collapsed py-3 transition-base" href="#" data-bs-toggle="collapse" data-bs-target="#collapsemployee" aria-expanded="false"
                       style="<?= getLinkStyle($isActive); ?>">
                        <div class="sb-nav-link-icon me-2"><i class="fas fa-user-tie"></i></div>
                        เจ้าหน้าที่พัสดุ
                        <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= $isActive ? 'show' : ''; ?>" id="collapsemployee" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav ms-3 border-start border-white border-opacity-25 ps-2">
                            <a class="nav-link text-white-50" href="../manage/manage_employee.php">รายชื่อเจ้าหน้าที่</a>
                        </nav>
                    </div>

                <?php } // จบเงื่อนไข Admin ?>
                <?php $isActive = in_array($current_page, ['manage_exnews.php', 'manage_innews.php', 'manage_board.php']); ?>
                <a class="nav-link collapsed py-3 transition-base" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNews" aria-expanded="false"
                   style="<?= getLinkStyle($isActive); ?>">
                    <div class="sb-nav-link-icon me-2"><i class="fas fa-bullhorn"></i></div>
                    ประชาสัมพันธ์
                    <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $isActive ? 'show' : ''; ?>" id="collapseNews" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav ms-3 border-start border-white border-opacity-25 ps-2">
                        <a class="nav-link text-white-50" href="../manage/manage_exnews.php">ข่าวภายนอก</a>
                        <a class="nav-link text-white-50" href="../manage/manage_innews.php">ข่าวภายใน</a>
                        <a class="nav-link text-white-50" href="../manage/manage_board.php">กฎ/ระเบียบ</a>
                    </nav>
                </div>

                <?php $isActive = in_array($current_page, ['manage_proNotice.php', 'manage_proContract.php']); ?>
                <a class="nav-link collapsed py-3 transition-base" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProcurement" aria-expanded="false"
                   style="<?= getLinkStyle($isActive); ?>">
                    <div class="sb-nav-link-icon me-2"><i class="fas fa-file-invoice-dollar"></i></div>
                    จัดซื้อ/จัดจ้าง
                    <div class="sb-sidenav-collapse-arrow ms-auto"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= $isActive ? 'show' : ''; ?>" id="collapseProcurement" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav ms-3 border-start border-white border-opacity-25 ps-2">
                        <a class="nav-link text-white-50" href="../manage/manage_proNotice.php">ประกาศพัสดุ</a>
                        <a class="nav-link text-white-50" href="../manage/manage_proContract.php">สัญญาพัสดุ</a>
                    </nav>
                </div>

                <a class="nav-link py-3 transition-base" href="../manage/manage_album.php"
                   style="<?= getLinkStyle($current_page == 'manage_album.php'); ?>">
                    <div class="sb-nav-link-icon me-2"><i class="fas fa-camera-retro"></i></div>
                    คลังภาพกิจกรรม
                </a>

                <hr class="my-3 border-white opacity-25 mx-3">

                <div class="sb-sidenav-menu-heading text-uppercase opacity-50 small" style="letter-spacing: 1px;">ตั้งค่าระบบ</div>
                
                <a class="nav-link py-3 transition-base" href="../manage/manage_profile.php"
                   style="<?= getLinkStyle($current_page == 'edit_profile.php'); ?>">
                    <div class="sb-nav-link-icon me-2"><i class="fas fa-id-card"></i></div>
                    ข้อมูลส่วนตัว
                </a>

                <a class="nav-link py-3 transition-base text-danger" href="../include/logout.php" onclick="return confirm('คุณต้องการออกจากระบบใช่หรือไม่?');"
                   style="margin-left: 10px; margin-right: 10px; color: #ffcccc;">
                    <div class="sb-nav-link-icon me-2"><i class="fas fa-power-off"></i></div>
                    ออกจากระบบ
                </a>

            </div>
        </div>
        
        <div class="sb-sidenav-footer py-2 px-3 small" style="background-color: rgba(0,0,0,0.2); color: rgba(255,255,255,0.5);">
            <div class="fw-bold">ระบบงานพัสดุ v1.0</div>
            Lomsak Hospital
        </div>
    </nav>
</div>