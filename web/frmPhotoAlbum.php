<?php include("assets/connect_db/connect_db.php"); ?>

<!DOCTYPE html>
<html lang="th">

<?php include("assets/head/head.php"); ?>

<body>

    <?php include("assets/navbar/navbar.php"); ?>

    <div class="all_webboard bg-news">

        <h5 class="fw-bold">📷 อัลบั้มรูปภาพ / Photo Album</h5>
        <hr>

        <div class="container">

            <?php
            // -------------------------
            // Pagination Settings
            // -------------------------
            $limit = 10;
            $page  = $_GET['page'] ?? 1;
            $start = ($page - 1) * $limit;

            // -------------------------
            // Count total rows
            // -------------------------
            $count = mysqli_fetch_assoc(
                mysqli_query($conn, "SELECT COUNT(*) AS total FROM photoalbum WHERE AlbumStatus='Active'")
            )['total'];

            $pages = ceil($count / $limit);

            // -------------------------
            // Fetch rows
            // -------------------------
            $sql = "SELECT * FROM photoalbum 
        WHERE AlbumStatus='Active'
        ORDER BY AlbumDate DESC
        LIMIT $start, $limit";

            $result = mysqli_query($conn, $sql);

            // -------------------------
            // Helper functions
            // -------------------------
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

            function isNewBadge($date)
            {
                return (time() - strtotime($date)) <= (7 * 24 * 60 * 60);
            }

            function getThumbnail($file)
            {
                if (!$file) return "assets/images/default/no-image.png";
                return "assets/images/album/" . $file;
            }
            ?>

            <?php while ($row = mysqli_fetch_assoc($result)):

                // -------------------------
                // เลือกรูปแรกจากหลายรูป
                // -------------------------
                $files = preg_split("/[,|]/", $row['AlbumImg']);
                $firstImg = trim($files[0] ?? "");
                $thumb = getThumbnail($firstImg);
            ?>

                <div class="card mb-3">
                    <a href="index.php?view_photo=<?= $row['AlbumID']; ?>"
                        class="text-decoration-none text-dark">
                        <div class="row g-0">

                            <!-- Thumbnail -->
                            <div class="col-md-2 p-2">
                                <img src="<?= $thumb ?>" class="img-fluid rounded">
                            </div>

                            <!-- Content -->
                            <div class="col-md-10">
                                <div class="card-body">

                                    <h5 class="fw-bold">
                                        <?= $row['AlbumName']; ?>
                                        <?php if (isNewBadge($row['AlbumDate'])): ?>
                                            <span class="badge bg-danger">NEW!</span>
                                        <?php endif; ?>
                                    </h5>

                                    <p class="text-muted">
                                        <?= formatThaiDate($row['AlbumDate']); ?>
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
                        <a class="page-link" href="?page=<?= $page - 1 ?>">ก่อนหน้า</a>
                    </li>

                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <li class="page-item <?= ($i == $page ? 'active' : '') ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $pages ? 'disabled' : '') ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">ถัดไป</a>
                    </li>

                </ul>
            </nav>

        </div>
    </div>

    <?php include("assets/footer/footer.php"); ?>

</body>

</html>