<?php 
require_once "assets/connect_db/connect_db.php"; 

// --- Helper Functions ---
function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }
function thDate($date) {
    if(!$date) return "-";
    $m = ["","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];
    $t = strtotime($date);
    return date("j", $t)." ".$m[date("n", $t)]." ".(date("Y",$t)+543);
}
function isNew($date) {
    return (time() - strtotime($date)) <= (7*24*60*60);
}

// Helper กำหนดไอคอนและสีตามคำค้นหาหรือหัวข้อ (ถ้าต้องการแยกประเภทอัตโนมัติ)
function getDocTypeStyle($title) {
    $title = strtolower($title);
    if (strpos($title, 'มติ') !== false) return ['icon'=>'fa-gavel', 'bg'=>'bg-danger', 'text'=>'text-white'];
    if (strpos($title, 'กฎ') !== false || strpos($title, 'ระเบียบ') !== false) return ['icon'=>'fa-book', 'bg'=>'bg-primary', 'text'=>'text-white'];
    if (strpos($title, 'หนังสือเวียน') !== false) return ['icon'=>'fa-envelope-open-text', 'bg'=>'bg-info', 'text'=>'text-white'];
    // Default
    return ['icon'=>'fa-file-contract', 'bg'=>'bg-secondary', 'text'=>'text-white'];
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ศูนย์ข้อมูลกฎหมายและระเบียบ - โรงพยาบาลหล่มสัก</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <?php include("assets/head/head.php"); ?>

    <style>
        /* --- MODERN VARIABLES --- */
        :root {
            --primary: #10b981;       /* Emerald Green */
            --bg-body: #f1f5f9;       /* Slate Light */
            --card-bg: #ffffff;
            --text-main: #334155;
            --border-radius: 16px;
        }

        body { 
            font-family: 'Kanit', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-main);
            min-height: 100vh;
        }

        /* --- HEADER SECTION --- */
        .page-header {
            background: white;
            padding: 3rem 0;
            margin-bottom: 3rem;
            border-bottom: 1px solid #e2e8f0;
            position: relative;
        }
        .header-shape {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at top right, #ecfdf5 0%, transparent 40%);
            z-index: 0; pointer-events: none;
        }
        .header-content { position: relative; z-index: 1; }
        .page-title { font-size: 2.2rem; font-weight: 700; color: #065f46; margin-bottom: 0.5rem; }
        .page-desc { color: #64748b; font-size: 1.1rem; }

        /* --- CARD DESIGN --- */
        .doc-card {
            background: var(--card-bg);
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .doc-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        /* Icon Circle */
        .doc-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, #059669 100%);
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25);
        }

        /* Typography */
        .doc-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.8rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* Limit to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .doc-meta {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #64748b;
        }

        /* Badge New */
        .badge-new {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        /* Pagination */
        .custom-pagination .page-link {
            border: none;
            color: #64748b;
            font-weight: 500;
            margin: 0 5px;
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .custom-pagination .page-link:hover {
            background-color: #f1f5f9;
            color: var(--primary);
        }
        .custom-pagination .page-item.active .page-link {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.4);
        }

        /* Back Button */
        .btn-back {
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            transition: 0.2s;
        }
        .btn-back:hover { color: var(--primary); background: #ecfdf5; border-radius: 50px; }
    </style>
</head>
<body>

<?php include("assets/navbar/navbar.php"); ?>

<!-- Header Section -->
<div class="page-header">
    <div class="header-shape"></div>
    <div class="container header-content">
        <div class="row align-items-center">
            <div class="col-12">
                <a href="main.php" class="btn btn-back mb-3 d-inline-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i> กลับหน้าหลัก
                </a>
                <h1 class="page-title">ศูนย์ข้อมูลกฎหมายและระเบียบ</h1>
                <p class="page-desc">ค้นหากฎระเบียบ, มติคณะรัฐมนตรี และหนังสือเวียนที่เกี่ยวข้องกับการดำเนินงานโรงพยาบาล</p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5 mb-5">
    <div class="row g-4">
        <?php
        // Pagination Logic
        $limit = 12; // เพิ่มจำนวนรายการต่อหน้าให้ดูเต็มหน้าจอ
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        // Count
        $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM announcementboard WHERE BoardStatus='Active'"))['total'];
        $pages = ceil($total / $limit);

        // Query
        $sql = "SELECT * FROM announcementboard WHERE BoardStatus='Active' ORDER BY BoardDate DESC LIMIT $start, $limit";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0):
            while($row = mysqli_fetch_assoc($result)):
                // ดึงสไตล์ไอคอนตามชื่อเรื่อง (Auto Detect)
                $style = getDocTypeStyle($row['BoardName']);
        ?>
            <div class="col-lg-4 col-md-6">
                <a href="main.php?view_board=<?= $row['BoardID']; ?>" class="text-decoration-none">
                    <div class="doc-card">
                        <?php if(isNew($row['BoardDate'])): ?>
                            <span class="badge-new">NEW</span>
                        <?php endif; ?>
                        
                        <div class="doc-icon-wrapper <?= $style['bg'] ?>">
                            <i class="fas <?= $style['icon'] ?>"></i>
                        </div>

                        <h5 class="doc-title text-dark">
                            <?= h($row['BoardName']); ?>
                        </h5>

                        <div class="doc-meta">
                            <span><i class="far fa-calendar-alt me-1 text-success"></i> <?= thDate($row['BoardDate']); ?></span>
                            <span class="text-primary small fw-bold">อ่านรายละเอียด <i class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open text-muted fa-3x mb-3"></i>
                <p class="text-muted">ยังไม่มีข้อมูลประกาศในขณะนี้</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center custom-pagination">
            <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page-1 ?>"><i class="fas fa-chevron-left"></i></a>
            </li>
            <?php endif; ?>
            
            <?php 
                // แสดงเลขหน้าแบบ Smart (Limit display if too many pages)
                $startPage = max(1, $page - 2);
                $endPage = min($pages, $page + 2);
                for($i=$startPage; $i<=$endPage; $i++): 
            ?>
            <li class="page-item <?= ($i==$page?'active':'') ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <?php if($page < $pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page+1 ?>"><i class="fas fa-chevron-right"></i></a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include("assets/footer/footer.php"); ?>
    <!-- Pagination (Logic ใหม่ รองรับข้อมูลเยอะ) -->
    <?php if ($pages > 1): ?>
    <nav aria-label="Page navigation" class="mt-5">
        <ul class="pagination justify-content-center custom-pagination">
            
            <!-- ปุ่ม ก่อนหน้า (Previous) -->
            <?php if($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page-1 ?>" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i> ก่อนหน้า
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-left"></i> ก่อนหน้า</span>
                </li>
            <?php endif; ?>

            <?php
                // --- Logic การแสดงเลขหน้าแบบ Smart ---
                // ถ้าหน้าน้อยกว่า 7 หน้า ให้แสดงทั้งหมด
                if ($pages <= 7) {
                    for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor;
                } else {
                    // ถ้าหน้าเยอะกว่า 7 หน้า ให้ตัดหน้าด้วย ... (Ellipsis)
                    
                    // 1. แสดงหน้าแรก (1)
                    if ($page > 1) { ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1">1</a>
                        </li>
                    <?php }

                    // 2. แสดงจุดไข่ปลา (...) ก่อนหน้า
                    if ($page > 3) { ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php }

                    // 3. แสดงหน้ารอบๆ หน้าปัจจุบัน
                    $startPage = max(2, $page - 1);
                    $endPage = min($pages - 1, $page + 1);

                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor;

                    // 4. แสดงจุดไข่ปลา (...) หลังหน้าปัจจุบัน
                    if ($page < $pages - 2) { ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php }

                    // 5. แสดงหน้าสุดท้าย
                    if ($page < $pages) { ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pages ?>"><?= $pages ?></a>
                        </li>
                    <?php }
                }
            ?>

            <!-- ปุ่ม ถัดไป (Next) -->
            <?php if($page < $pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page+1 ?>" aria-label="Next">
                        ถัดไป <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">ถัดไป <i class="fas fa-chevron-right"></i></span>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
    <?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
