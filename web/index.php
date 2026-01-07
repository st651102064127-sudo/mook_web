<?php
include("assets/connect_db/connect_db.php");

/* =====================================================
   ฟังก์ชันทั่วไป (ใช้ทุกโหมด)
===================================================== */

function formatThaiDate($date)
{
    if (!$date) return "-";
    $months = [
        "",
        "ม.ค.",
        "ก.พ.",
        "มี.ค.",
        "เม.ย.",
        "พ.ค.",
        "มิ.ย.",
        "ก.ค.",
        "ส.ค.",
        "ก.ย.",
        "ต.ค.",
        "พ.ย.",
        "ธ.ค."
    ];
    $ts = strtotime($date);
    return date("j", $ts) . " " . $months[date("n", $ts)] . " " . (date("Y", $ts) + 543);
}

function getThumbnail($file, $type = "external")
{
    if (!$file) return "assets/images/default/no-image.png";
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if ($ext === "pdf")
        return "assets/images/default/pdf-icon.png";

    if (in_array($ext, ["jpg", "jpeg", "png", "gif", "webp"])) {
        if ($type === "external") return "assets/images/exNews/$file";
        if ($type === "internal") return "assets/images/inNews/$file";
        if ($type === "board") return "assets/images/board/$file";
        if ($type === "procurement") return "assets/images/procurement/$file";
    }

    return "assets/images/default/no-image.png";
}

function isNewBadge($date)
{
    return (time() - strtotime($date)) <= (7 * 24 * 60 * 60);
}

/* =====================================================
   VIEW MODE – External News
===================================================== */
if (isset($_GET['view_ext'])) {
    $id = intval($_GET['view_ext']);
    $news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM externalnews WHERE ExtNewsID=$id"));
    $isPDF = strtolower(pathinfo($news['ExtNewsFile'], PATHINFO_EXTENSION)) === "pdf";
?>
    <!DOCTYPE html>
    <html lang="th">
    <?php include("assets/head/head.php"); ?>

    <body>
        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <div class="card shadow-sm p-4">

                <h3 class="fw-bold">
                    <?= $news['ExtNewsName']; ?>
                    <?php if (isNewBadge($news['ExtNewsDate'])): ?>
                        <span class="badge bg-danger">NEW!</span>
                    <?php endif; ?>
                </h3>

                <p class="text-muted"><?= formatThaiDate($news['ExtNewsDate']); ?></p>
                <hr>

                <?php if ($isPDF): ?>
                    <a href="assets/images/exNews/<?= $news['ExtNewsFile']; ?>"
                        target="_blank" class="btn btn-danger mb-3">เปิด PDF</a>
                <?php elseif ($news['ExtNewsFile']): ?>
                    <img src="assets/images/exNews/<?= $news['ExtNewsFile']; ?>" class="img-fluid rounded mb-3">
                <?php endif; ?>

                <p><?= nl2br($news['ExtNewsDetail']); ?></p>

                <a href="index.php" class="btn btn-secondary">ย้อนกลับ</a>
            </div>
        </div>

    </body>

    </html>
<?php exit;
} ?>



<!-- =====================================================
   VIEW MODE – Internal News
===================================================== -->
<?php
if (isset($_GET['view_int'])) {
    $id = intval($_GET['view_int']);
    $news = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM internalnews WHERE IntNewsID=$id"));
    $isPDF = strtolower(pathinfo($news['IntNewsFile'], PATHINFO_EXTENSION)) === "pdf";
?>
    <!DOCTYPE html>
    <html lang="th">
    <?php include("assets/head/head.php"); ?>

    <body>
        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <div class="card shadow-sm p-4">

                <h3 class="fw-bold">
                    <?= $news['IntNewsName']; ?>
                    <?php if (isNewBadge($news['IntNewsDate'])): ?>
                        <span class="badge bg-danger">NEW!</span>
                    <?php endif; ?>
                </h3>

                <p class="text-muted"><?= formatThaiDate($news['IntNewsDate']); ?></p>

                <hr>

                <?php if ($isPDF): ?>
                    <a href="assets/images/inNews/<?= $news['IntNewsFile']; ?>"
                        target="_blank" class="btn btn-danger mb-3">เปิด PDF</a>
                <?php elseif ($news['IntNewsFile']): ?>
                    <img src="assets/images/inNews/<?= $news['IntNewsFile']; ?>" class="img-fluid rounded mb-3">
                <?php endif; ?>

                <p><?= nl2br($news['IntNewsDetail']); ?></p>

                <a href="index.php" class="btn btn-secondary">ย้อนกลับ</a>
            </div>
        </div>

    </body>

    </html>
<?php exit;
} ?>



<!-- =====================================================
   VIEW MODE – BOARD (กฎ/ระเบียบ/หนังสือเวียน)
===================================================== -->
<?php
if (isset($_GET['view_board'])) {
    $id = intval($_GET['view_board']);
    $news = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT * FROM announcementboard WHERE BoardID=$id"
    ));

    $file = $news['BoardImg'];
    $isPDF = false;

    if ($file && pathinfo($file, PATHINFO_EXTENSION)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $isPDF = ($ext == "pdf");
    }
?>
    <!DOCTYPE html>
    <html lang="th">
    <?php include("assets/head/head.php"); ?>

    <body>

        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <div class="card shadow-sm p-4">

                <h3 class="fw-bold">
                    <?= $news['BoardName']; ?>
                    <?php if (isNewBadge($news['BoardDate'])): ?>
                        <span class="badge bg-danger">NEW!</span>
                    <?php endif; ?>
                </h3>

                <p class="text-muted"><?= formatThaiDate($news['BoardDate']); ?></p>

                <hr>
                <p><?= nl2br($news['BoardDetail']); ?></p>

                <?php if ($file): ?>
                    <?php if ($isPDF): ?>
                        <a href="assets/images/board/<?= $file ?>"
                            target="_blank" class="btn btn-danger mb-3">เปิด PDF</a>
                    <?php else: ?>
                        <img src="assets/images/board/<?= $file ?>" class="img-fluid rounded mb-3">
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted">ไม่มีไฟล์แนบ</p>
                <?php endif; ?>

                <a href="frmBoard.php" class="btn btn-secondary">ย้อนกลับ</a>

            </div>
        </div>

    </body>

    </html>
<?php exit;
} ?>




<!-- =====================================================
   VIEW MODE – Procurement Notice (ประกาศจัดซื้อ)
===================================================== -->
<?php
if (isset($_GET['view_pronotice'])) {
    $id = intval($_GET['view_pronotice']);
    $news = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT * FROM procurementnotice WHERE NoticeID=$id"
    ));
    $isPDF = strtolower(pathinfo($news['NoticeFile'], PATHINFO_EXTENSION)) === "pdf";
?>
    <!DOCTYPE html>
    <html lang="th">
    <?php include("assets/head/head.php"); ?>

    <body>
        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <div class="card shadow-sm p-4">

                <h3 class="fw-bold">
                    <?= $news['NoticeName']; ?>
                    <?php if (isNewBadge($news['NoticeStDate'])): ?>
                        <span class="badge bg-danger">NEW!</span>
                    <?php endif; ?>
                </h3>

                <p class="text-muted">
                    เริ่มประกาศ: <?= formatThaiDate($news['NoticeStDate']); ?><br>
                    สิ้นสุด: <?= formatThaiDate($news['NoticeEnDate']); ?>
                </p>

                <hr>

                <?php if ($isPDF): ?>
                    <a href="assets/images/proNotice/<?= $news['NoticeFile']; ?>"
                        target="_blank" class="btn btn-danger mb-3">เปิด PDF</a>
                <?php elseif ($news['NoticeFile']): ?>
                    <img src="assets/images/proNotice/<?= $news['NoticeFile']; ?>" class="img-fluid rounded mb-3">
                <?php endif; ?>

                <p><?= nl2br($news['NoticeDetail'] ?? ""); ?></p>

                <a href="frmPronotice.php" class="btn btn-secondary">ย้อนกลับ</a>

            </div>
        </div>

    </body>

    </html>
<?php exit;
} ?>



<!-- =====================================================
   MODE – External ALL
===================================================== -->
<?php
if (isset($_GET['external_all'])) {
    $limit = 10;
    $page = $_GET['page'] ?? 1;
    $start = ($page - 1) * $limit;

    $total = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT COUNT(*) as t FROM externalnews WHERE ExtNewsStatus='Active'"
    ))['t'];

    $pages = ceil($total / $limit);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM externalnews 
         WHERE ExtNewsStatus='Active'
         ORDER BY ExtNewsDate DESC
         LIMIT $start,$limit"
    );
?>
    <!DOCTYPE html>
    <html lang="th">
    <?php include("assets/head/head.php"); ?>

    <body>
        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <h4 class="fw-bold">📢 ข่าวประชาสัมพันธ์ภายนอก</h4>
            <hr>

            <?php while ($row = mysqli_fetch_assoc($result)):
                $thumb = getThumbnail($row['ExtNewsFile'], "external");
            ?>
                <div class="card mb-3">
                    <a href="index.php?view_ext=<?= $row['ExtNewsID']; ?>"
                        class="text-decoration-none text-dark">
                        <div class="row g-0">

                            <div class="col-md-2 p-2">
                                <img src="<?= $thumb ?>" class="img-fluid rounded">
                            </div>

                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="fw-bold">
                                        <?= $row['ExtNewsName']; ?>
                                        <?php if (isNewBadge($row['ExtNewsDate'])): ?>
                                            <span class="badge bg-danger">NEW!</span>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="text-muted"><?= formatThaiDate($row['ExtNewsDate']); ?></p>
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
                        <a class="page-link" href="?external_all=1&page=<?= $page - 1 ?>">ก่อนหน้า</a>
                    </li>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page ? 'active' : '') ?>">
                            <a class="page-link" href="?external_all=1&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $pages ? 'disabled' : '') ?>">
                        <a class="page-link" href="?external_all=1&page=<?= $page + 1 ?>">ถัดไป</a>
                    </li>
                </ul>
            </nav>

            <a href="index.php" class="btn btn-secondary mb-4">ย้อนกลับ</a>

        </div>

    </body>

    </html>
<?php exit;
} ?>



<!-- =====================================================
   MODE – Internal ALL
===================================================== -->
<?php
if (isset($_GET['internal_all'])) {
    $limit = 10;
    $page = $_GET['page'] ?? 1;
    $start = ($page - 1) * $limit;

    $total = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT COUNT(*) as t FROM internalnews WHERE IntNewsStatus='Active'"
    ))['t'];

    $pages = ceil($total / $limit);

    $result = mysqli_query(
        $conn,
        "SELECT * FROM internalnews 
         WHERE IntNewsStatus='Active'
         ORDER BY IntNewsDate DESC
         LIMIT $start,$limit"
    );
?>
    <!DOCTYPE html>
    <html lang="th">
    <?php include("assets/head/head.php"); ?>

    <body>
        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <h4 class="fw-bold">📢 ข่าวประชาสัมพันธ์ภายใน</h4>
            <hr>

            <?php while ($row = mysqli_fetch_assoc($result)):
                $thumb = getThumbnail($row['IntNewsFile'], "internal");
            ?>
                <div class="card mb-3">
                    <a href="index.php?view_int=<?= $row['IntNewsID']; ?>"
                        class="text-decoration-none text-dark">
                        <div class="row g-0">

                            <div class="col-md-2 p-2">
                                <img src="<?= $thumb ?>" class="img-fluid rounded">
                            </div>

                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="fw-bold">
                                        <?= $row['IntNewsName']; ?>
                                        <?php if (isNewBadge($row['IntNewsDate'])): ?>
                                            <span class="badge bg-danger">NEW!</span>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="text-muted"><?= formatThaiDate($row['IntNewsDate']); ?></p>
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
                        <a class="page-link" href="?internal_all=1&page=<?= $page - 1 ?>">ก่อนหน้า</a>
                    </li>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page ? 'active' : '') ?>">
                            <a class="page-link" href="?internal_all=1&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $pages ? 'disabled' : '') ?>">
                        <a class="page-link" href="?internal_all=1&page=<?= $page + 1 ?>">ถัดไป</a>
                    </li>
                </ul>
            </nav>

            <a href="index.php" class="btn btn-secondary mb-4">ย้อนกลับ</a>

        </div>

    </body>

    </html>
<?php exit;
} ?>

<?php
// =====================================================
// VIEW MODE – Procurement Contract (view_pro)
// =====================================================
if (isset($_GET['view_pro'])) {

    $id = intval($_GET['view_pro']);

    // ดึงข้อมูลจาก procurementcontract
    $sql = "SELECT * FROM procurementcontract WHERE ContractID = $id";
    $news = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // ตรวจสอบไฟล์
    $file = $news['ContractFile'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $isPDF = ($ext === "pdf");
?>
    <!DOCTYPE html>
    <html lang="th">

    <?php include("assets/head/head.php"); ?>

    <body>

        <?php include("assets/navbar/navbar.php"); ?>

        <div class="container mt-4 bg-news">
            <div class="card shadow-sm p-4">

                <!-- ชื่อเรื่อง -->
                <h3 class="fw-bold">
                    <?= $news['ContractName']; ?>
                    <?php if (isNewBadge($news['ContractDate'])): ?>
                        <span class="badge bg-danger">NEW!</span>
                    <?php endif; ?>
                </h3>

                <!-- วันที่ -->
                <p class="text-muted">
                    เริ่มสัญญา: <?= formatThaiDate($news['ContractDate']); ?><br>
                    สิ้นสุดสัญญา: <?= formatThaiDate($news['ContractEndDate']); ?>
                </p>

                <hr>

                <!-- ไฟล์แนบ -->
                <?php if ($file): ?>

                    <?php if ($isPDF): ?>
                        <a href="assets/images/proContract/<?= $file ?>"
                            target="_blank" class="btn btn-danger mb-3">เปิดไฟล์ PDF</a>
                    <?php else: ?>
                        <img src="assets/images/proContract/<?= $file ?>"
                            class="img-fluid rounded mb-3">
                    <?php endif; ?>

                <?php else: ?>
                    <p class="text-muted">ไม่มีไฟล์แนบ</p>
                <?php endif; ?>

                <hr>

                <!-- รายละเอียด -->
                <p><?= nl2br($news['ContractDetail'] ?? ""); ?></p>

                <a href="frmProContract.php" class="btn btn-secondary mt-3">ย้อนกลับ</a>

            </div>
        </div>

    </body>

    </html>
<?php exit;
} ?>

<?php
// =====================================================
// VIEW MODE – PHOTO ALBUM (view_photo)
// =====================================================
if (isset($_GET['view_photo'])) {

    $id = intval($_GET['view_photo']);

    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM photoalbum WHERE AlbumID = $id";
    $album = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // แตกไฟล์รูปเป็น array (รองรับ comma หรือ | )
    $files = [];
    if (!empty($album['AlbumImg'])) {
        $files = preg_split("/[,|]/", $album['AlbumImg']);
    }
?>
<!DOCTYPE html>
<html lang="th">

<?php include("assets/head/head.php"); ?>

<body>

<?php include("assets/navbar/navbar.php"); ?>

<div class="container mt-4 bg-news">
    <div class="card shadow-sm p-4">

        <!-- ชื่ออัลบั้ม -->
        <h3 class="fw-bold">
            <?= $album['AlbumName']; ?>
            <?php if (isNewBadge($album['AlbumDate'])): ?>
                <span class="badge bg-danger">NEW!</span>
            <?php endif; ?>
        </h3>

        <!-- วันที่ -->
        <p class="text-muted">วันที่โพสต์: <?= formatThaiDate($album['AlbumDate']); ?></p>

        <hr>

        <!-- รายละเอียด -->
        <p><?= nl2br($album['AlbumDetail']); ?></p>

        <hr>

        <h5 class="fw-bold mb-3">📷 รูปภาพทั้งหมด</h5>

        <!-- ไม่มีรูป -->
        <?php if (empty($files)): ?>
            <p class="text-muted">ไม่มีรูปภาพในอัลบั้มนี้</p>
        <?php else: ?>

        <div class="photo-grid">

            <?php foreach ($files as $img): 
                $img = trim($img);
                if ($img == "") continue;
                $path = "assets/images/album/" . $img;
            ?>
                <div class="photo-item">
                    <a href="<?= $path ?>" target="_blank">
                        <img src="<?= $path ?>" class="img-fluid rounded shadow-sm">
                    </a>
                </div>
            <?php endforeach; ?>

        </div>

        <?php endif; ?>

        <a href="frmPhotoAlbum.php" class="btn btn-secondary mt-4">ย้อนกลับ</a>

    </div>
</div>

</body>

<!-- CSS Gallery -->
<style>
.photo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.photo-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.photo-item img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}
</style>

</html>

<?php exit; } ?>




<!-- =====================================================
   หน้าแรก DEFAULT
===================================================== -->

<!DOCTYPE html>
<html lang="th">
<?php include("assets/head/head.php"); ?>

<body>

    <?php include("assets/navbar/navbar.php"); ?>

    <!-- ข่าวภายนอก -->
    <div class="all_webboard bg-news">
        <h5>📢 ประชาสัมพันธ์ภายนอก</h5>
        <hr>
        <div class="container">

            <?php
            $res = mysqli_query(
                $conn,
                "SELECT * FROM externalnews 
     WHERE ExtNewsStatus='Active' 
     ORDER BY ExtNewsDate DESC LIMIT 3"
            );
            while ($row = mysqli_fetch_assoc($res)):
                $thumb = getThumbnail($row['ExtNewsFile'], "external");
            ?>
                <div class="card mb-3">
                    <a href="index.php?view_ext=<?= $row['ExtNewsID']; ?>"
                        class="text-decoration-none text-dark">
                        <div class="row g-0">

                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="fw-bold">
                                        <?= $row['ExtNewsName']; ?>
                                        <?php if (isNewBadge($row['ExtNewsDate'])): ?>
                                            <span class="badge bg-danger">NEW!</span>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="text-muted"><?= formatThaiDate($row['ExtNewsDate']); ?></p>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            <?php endwhile; ?>

            <div class="d-flex justify-content-end">
                <a href="index.php?external_all=1" class="btn btn-light">ดูทั้งหมด</a>
            </div>

        </div>
    </div>


    <!-- ข่าวภายใน -->
    <div class="all_webboard bg-news mt-3">
        <h5>📢 ประชาสัมพันธ์ภายใน</h5>
        <hr>
        <div class="container">

            <?php
            $res = mysqli_query(
                $conn,
                "SELECT * FROM internalnews 
     WHERE IntNewsStatus='Active' 
     ORDER BY IntNewsDate DESC LIMIT 3"
            );
            while ($row = mysqli_fetch_assoc($res)):
                $thumb = getThumbnail($row['IntNewsFile'], "internal");
            ?>
                <div class="card mb-3">
                    <a href="index.php?view_int=<?= $row['IntNewsID']; ?>"
                        class="text-decoration-none text-dark">
                        <div class="row g-0">

                            <div class="col-md-10">
                                <div class="card-body">
                                    <h5 class="fw-bold">
                                        <?= $row['IntNewsName']; ?>
                                        <?php if (isNewBadge($row['IntNewsDate'])): ?>
                                            <span class="badge bg-danger">NEW!</span>
                                        <?php endif; ?>
                                    </h5>
                                    <p class="text-muted"><?= formatThaiDate($row['IntNewsDate']); ?></p>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            <?php endwhile; ?>

            <div class="d-flex justify-content-end">
                <a href="index.php?internal_all=1" class="btn btn-light">ดูทั้งหมด</a>
            </div>

        </div>
    </div>

    <?php include("assets/footer/footer.php"); ?>
</body>

</html>


<!-- CSS ส่วนกลาง -->
<style>
    .bg-news {
        background-color: #F2E9D3 !important;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .card:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        transition: 0.2s;
    }

    img {
        height: 110px;
        object-fit: cover;
        border-radius: 8px;
    }

    .badge-danger {
        font-size: 0.7rem;
    }
</style>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="style.css">
