<?php include("assets/connect_db/connect_db.php"); ?>
<!DOCTYPE html>
<html lang="th">
<?php include("assets/head/head.php"); ?>

<style>
    /* --- MODERN THEME VARIABLES --- */
    :root {
        --primary: #10b981;       /* Emerald Green */
        --secondary: #f59e0b;     /* Amber */
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
    .procure-card {
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

    .procure-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    /* Thumbnail / Icon Area */
    .card-thumb-wrapper {
        height: 160px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.2rem;
        position: relative;
        background-color: #f8fafc;
    }
    
    .card-thumb-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .procure-card:hover .card-thumb-wrapper img { transform: scale(1.05); }

    /* Placeholder Icon if image is missing/PDF */
    .card-icon-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column;
        color: #94a3b8;
    }
    .card-icon-placeholder i { font-size: 3rem; margin-bottom: 10px; }

    /* Typography */
    .card-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limit to 2 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }

    .card-meta-group {
        background: #f8fafc;
        border-radius: 8px;
        padding: 0.8rem;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        border: 1px solid #e2e8f0;
    }
    .meta-row { display: flex; justify-content: space-between; margin-bottom: 4px; }
    .meta-row:last-child { margin-bottom: 0; }
    .meta-label { color: #64748b; }
    .meta-value { font-weight: 600; color: #334155; }
    .text-danger-custom { color: #ef4444; } /* Color for end date if needed */

    /* Badges */
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
        z-index: 2;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: 600;
    }

    /* Footer of card */
    .card-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px dashed #e2e8f0;
        padding-top: 1rem;
    }
    .btn-view {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
    }
    .btn-view:hover { text-decoration: underline; }

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
</style>

<body>

<?php include("assets/navbar/navbar.php"); ?>

<!-- Header Section -->
<div class="page-header">
    <div class="header-shape"></div>
    <div class="container header-content">
        <div class="row align-items-center">
            <div class="col-12">
                <a href="main.php" class="btn btn-light rounded-pill shadow-sm px-4 mb-3 text-muted text-decoration-none">
                    <i class="fas fa-arrow-left me-2"></i> กลับหน้าหลัก
                </a>
                <h1 class="page-title">ข่าวประกาศจัดซื้อจัดจ้าง</h1>
                <p class="page-desc">รวบรวมประกาศเชิญชวนดำเนินการจัดซื้อจัดจ้าง และประกาศราคากลาง</p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5 mb-5">
    <div class="row g-4">
        <?php
        // ===== functions =====
        function formatThaiDate($date) {
            if(!$date) return "-";
            $months = ["","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
                       "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."];
            $ts = strtotime($date);
            return date("j",$ts)." ".$months[date("n",$ts)]." ".(date("Y",$ts)+543);
        }

        function isNewBadge($date){
            return (time() - strtotime($date)) <= (7*24*60*60);
        }

        function getThumbnail($file){
            if(!$file) return ['type'=>'none'];
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if($ext === "pdf") return ['type'=>'pdf'];
            if(in_array($ext, ["jpg","jpeg","png","gif","webp"]))
                return ['type'=>'img', 'src'=>"assets/images/procurement/".$file];

            return ['type'=>'none'];
        }

        // ===== Pagination Logic =====
        $limit = 12; // แสดง 12 รายการต่อหน้า
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        // Count total
        $total = mysqli_fetch_assoc(
            mysqli_query($conn, "SELECT COUNT(*) AS total 
                                 FROM procurementnotice 
                                 WHERE NoticeStatus='Active'")
        )['total'];

        $pages = ceil($total / $limit);

        // Fetch data
        $sql = "SELECT * FROM procurementnotice 
                WHERE NoticeStatus='Active' 
                ORDER BY NoticeStDate DESC 
                LIMIT $start, $limit";

        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0):
            while($row = mysqli_fetch_assoc($result)):
                $thumb = getThumbnail($row['NoticeFile']);
        ?>
            <div class="col-lg-4 col-md-6">
                <a href="main.php?view_pronotice=<?= $row['NoticeID']; ?>" class="text-decoration-none">
                    <div class="procure-card">
                        <?php if(isNewBadge($row['NoticeStDate'])): ?>
                            <span class="badge-new">NEW</span>
                        <?php endif; ?>

                        <!-- Thumbnail / Icon -->
                        <div class="card-thumb-wrapper">
                            <?php if($thumb['type'] == 'img'): ?>
                                <img src="<?= $thumb['src'] ?>" alt="Document Image">
                            <?php elseif($thumb['type'] == 'pdf'): ?>
                                <div class="card-icon-placeholder" style="background: #fef2f2;">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <span class="small fw-bold text-danger">PDF Document</span>
                                </div>
                            <?php else: ?>
                                <div class="card-icon-placeholder">
                                    <i class="fas fa-file-alt"></i>
                                    <span class="small">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <h5 class="card-title text-dark">
                            <?= $row['NoticeName']; ?>
                        </h5>

                        <div class="card-meta-group">
                            <div class="meta-row">
                                <span class="meta-label"><i class="far fa-calendar-plus me-1 text-primary"></i> เริ่มประกาศ</span>
                                <span class="meta-value"><?= formatThaiDate($row['NoticeStDate']); ?></span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label"><i class="far fa-calendar-times me-1 text-danger-custom"></i> สิ้นสุด</span>
                                <span class="meta-value text-danger-custom"><?= formatThaiDate($row['NoticeEnDate']); ?></span>
                            </div>
                        </div>

                        <div class="card-footer">
                            <span class="status-badge bg-primary text-white">รับสมัครได้</span>
                            <span class="btn-view">รายละเอียด <i class="fas fa-chevron-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-clipboard-list text-muted fa-3x mb-3"></i>
                <p class="text-muted">ยังไม่มีประกาศจัดซื้อจัดจ้างในขณะนี้</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination (Smart Logic) -->
    <?php if ($pages > 1): ?>
    <nav aria-label="Page navigation" class="mt-5">
        <ul class="pagination justify-content-center custom-pagination">
            
            <!-- Previous -->
            <?php if($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page-1 ?>" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i> ก่อนหน้า
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i> ก่อนหน้า</span></li>
            <?php endif; ?>

            <?php
                if ($pages <= 7) {
                    for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor;
                } else {
                    // First page
                    if ($page > 1) { ?>
                        <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                    <?php }
                    if ($page > 3) { ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php }

                    $startPage = max(2, $page - 1);
                    $endPage = min($pages - 1, $page + 1);

                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor;

                    if ($page < $pages - 2) { ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php }
                    // Last page
                    if ($page < $pages) { ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $pages ?>"><?= $pages ?></a></li>
                    <?php }
                }
            ?>

            <!-- Next -->
            <?php if($page < $pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page+1 ?>" aria-label="Next">
                        ถัดไป <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled"><span class="page-link">ถัดไป <i class="fas fa-chevron-right"></i></span></li>
            <?php endif; ?>

        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include("assets/footer/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>