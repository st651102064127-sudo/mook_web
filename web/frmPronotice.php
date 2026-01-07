<?php include("assets/connect_db/connect_db.php"); ?>
<!DOCTYPE html>
<html lang="th">
<?php include("assets/head/head.php"); ?>

<body>

<?php include("assets/navbar/navbar.php"); ?>

<div class="all_webboard bg-news">

    <h5 class="fw-bold">📢 ข่าวประกาศจัดซื้อจัดจ้าง</h5>
    <hr>

    <div class="container">

<?php
// Pagination
$limit = 10;
$page = $_GET['page'] ?? 1;
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
    if(!$file) return "assets/images/default/no-image.png";
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if($ext === "pdf") return "assets/images/default/pdf-icon.png";
    if(in_array($ext, ["jpg","jpeg","png","gif","webp"]))
        return "assets/images/procurement/".$file;

    return "assets/images/default/no-image.png";
}

// ===== loop display =====
while($row = mysqli_fetch_assoc($result)):
    $thumb = getThumbnail($row['NoticeFile']);
?>
        <div class="card mb-3">
            <a href="index.php?view_pronotice=<?= $row['NoticeID']; ?>"
               class="text-decoration-none text-dark">
                <div class="row g-0">

                    <!-- <div class="col-md-2 p-2">
                        <img src="<?= $thumb ?>" class="img-fluid rounded">
                    </div> -->

                    <div class="col-md-10">
                        <div class="card-body">

                            <h5 class="fw-bold">
                                <?= $row['NoticeName']; ?>
                                <?php if(isNewBadge($row['NoticeStDate'])): ?>
                                    <span class="badge bg-danger">NEW!</span>
                                <?php endif; ?>
                            </h5>

                            <p class="text-muted">
                                เริ่มประกาศ: <?= formatThaiDate($row['NoticeStDate']); ?><br>
                                สิ้นสุด: <?= formatThaiDate($row['NoticeEnDate']); ?>
                            </p>

                        </div>
                    </div>

                </div>
            </a>
        </div>
<?php endwhile; ?>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center mt-4">

                <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                    <a class="page-link" href="?page=<?= $page-1 ?>">ก่อนหน้า</a>
                </li>

                <?php for($i=1; $i<=$pages; $i++): ?>
                    <li class="page-item <?= ($i==$page?'active':'') ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $pages ? 'disabled' : '') ?>">
                    <a class="page-link" href="?page=<?= $page+1 ?>">ถัดไป</a>
                </li>

            </ul>
        </nav>

    </div>

</div>

<?php include("assets/footer/footer.php"); ?>
</body>
</html>
