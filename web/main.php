<?php
require_once "assets/connect_db/connect_db.php";

/* =====================================================
   HELPER FUNCTIONS
===================================================== */
function h($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

function formatThaiDate($date) {
    if (!$date || $date == "0000-00-00") return "-";
    $months = ["", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    $ts = strtotime($date);
    return date("j", $ts) . " " . $months[(int)date("n", $ts)] . " " . (date("Y", $ts) + 543);
}

function getThumbnail($file, $type = "default") {
    $path = "assets/images/";
    $map = [
        'external' => 'exNews/', 'internal' => 'inNews/', 'board' => 'board/',
        'procurement' => 'procurement/', 'proNotice' => 'proNotice/',
        'proContract' => 'proContract/', 'album' => 'album/', 'default' => 'default/'
    ];
    $folder = $map[$type] ?? 'default/';
    $realPath = $path . $folder . $file;

    if ($file && file_exists($realPath)) return $realPath;
    if ($file && strtolower(pathinfo($file, PATHINFO_EXTENSION)) == 'pdf') 
        return "https://cdn-icons-png.flaticon.com/512/337/337946.png"; 
    
    return "https://placehold.co/600x400/e9ecef/6c757d?text=Lom+Sak+Hosp";
}

function isNew($date) {
    return (time() - strtotime($date)) <= (7 * 24 * 60 * 60);
}

/* =====================================================
   ROUTER & CONTROLLER
===================================================== */
$mode = 'home';
$id = 0;

if (isset($_GET['view_ext'])) { $mode = 'read_ext'; $id = (int)$_GET['view_ext']; }
elseif (isset($_GET['view_int'])) { $mode = 'read_int'; $id = (int)$_GET['view_int']; }
elseif (isset($_GET['view_board'])) { $mode = 'read_board'; $id = (int)$_GET['view_board']; }
elseif (isset($_GET['view_pronotice'])) { $mode = 'read_pronotice'; $id = (int)$_GET['view_pronotice']; }
elseif (isset($_GET['view_pro'])) { $mode = 'read_contract'; $id = (int)$_GET['view_pro']; }
elseif (isset($_GET['view_photo'])) { $mode = 'read_photo'; $id = (int)$_GET['view_photo']; }
elseif (isset($_GET['external_all'])) { $mode = 'list_ext'; }
elseif (isset($_GET['internal_all'])) { $mode = 'list_int'; }

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โรงพยาบาลหล่มสัก - Lom Sak Hospital</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <?php include("assets/head/head.php"); ?>

    <style>
        /* --- THEME CONFIG --- */
        :root {
            --primary: #009b77; /* เขียวมรกต */
            --primary-dark: #007d60;
            --bg-body: #eaeff2; /* สีพื้นหลังเทาอมฟ้า (ช่วยดันให้ Card สีขาวเด่น) */
            --card-radius: 20px;
        }

        body { font-family: 'Kanit', sans-serif; background-color: var(--bg-body); color: #333; }
        a { text-decoration: none; transition: 0.2s; }

        /* Main Container Card */
        .main-card-wrapper {
            background: #fff;
            border-radius: var(--card-radius);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08); /* เงาฟุ้งสวยงาม */
            border: none;
            overflow: hidden;
        }

        /* Banner Header */
        .header-banner {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 3rem 1rem;
            color: white;
            text-align: center;
            position: relative;
        }
        .header-banner::after {
            content: '';
            position: absolute; bottom: -20px; left: 0; right: 0;
            height: 40px;
            background: #fff;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0; /* ทำโค้งเว้า */
        }

        /* News Card Item */
        .news-item {
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
            background: #fff;
        }
        .news-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-color: var(--primary);
        }
        
        .thumb-box {
            position: relative;
            padding-top: 60%;
            background: #f8f9fa;
            overflow: hidden;
        }
        .thumb-box img {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; transition: 0.5s;
        }
        .news-item:hover .thumb-box img { transform: scale(1.05); }

        /* Badges & Buttons */
        .badge-new {
            position: absolute; top: 10px; right: 10px;
            background: #ff4757; color: white; font-size: 0.7rem; font-weight: bold;
            padding: 4px 8px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .btn-more {
            border: 1px solid #ddd; border-radius: 50px; 
            padding: 5px 20px; font-size: 0.85rem; color: #666;
        }
        .btn-more:hover { background: var(--primary); color: white; border-color: var(--primary); }

        /* Section Header */
        .sec-title {
            border-left: 5px solid var(--primary);
            padding-left: 15px;
            font-weight: 600;
            margin: 0;
        }
    </style>
</head>
<body>

<?php include("assets/navbar/navbar.php"); ?>

<?php if ($mode == 'home'): ?>

    <div class="container py-4"> <div class="card main-card-wrapper">
            
            <div class="header-banner">
                <h1 class="fw-bold mb-1 display-5">โรงพยาบาลหล่มสัก</h1>
                <p class="mb-0 opacity-75 fs-5 font-weight-light">Lom Sak Hospital</p>
            </div>

            <div class="card-body p-4 p-md-5">

                <section class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="sec-title text-dark">
                            <i class="fas fa-bullhorn text-warning me-2"></i>ประชาสัมพันธ์ภายนอก
                        </h4>
                        <a href="?external_all=1" class="btn-more">ดูทั้งหมด <i class="fas fa-arrow-right"></i></a>
                    </div>
                    
                    <div class="row g-4">
                        <?php 
                        $sql = "SELECT * FROM externalnews WHERE ExtNewsStatus='Active' ORDER BY ExtNewsDate DESC LIMIT 4";
                        $res = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($res)):
                            $img = getThumbnail($row['ExtNewsFile'], 'external');
                            $isPDF = (strtolower(pathinfo($row['ExtNewsFile'], PATHINFO_EXTENSION)) == 'pdf');
                        ?>
                        <div class="col-md-6 col-lg-3">
                            <a href="?view_ext=<?= $row['ExtNewsID'] ?>" class="text-dark d-block h-100">
                                <div class="news-item">
                                    <div class="thumb-box">
                                        <?php if(isNew($row['ExtNewsDate'])): ?><span class="badge-new">NEW</span><?php endif; ?>
                                        <img src="<?= $img ?>" class="<?= $isPDF ? 'object-fit-contain p-4' : '' ?>">
                                    </div>
                                    <div class="p-3">
                                        <small class="text-muted d-block mb-1"><i class="far fa-clock text-success"></i> <?= formatThaiDate($row['ExtNewsDate']) ?></small>
                                        <h6 class="fw-bold mb-0 text-truncate-2" style="height: 2.8em; overflow: hidden;"><?= h($row['ExtNewsName']) ?></h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <hr class="my-5 opacity-10">

                <section class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="sec-title text-dark" style="border-color: #ffc107;">
                            <i class="fas fa-clipboard-list text-success me-2"></i>ประชาสัมพันธ์ภายใน
                        </h4>
                        <a href="?internal_all=1" class="btn-more">ดูทั้งหมด <i class="fas fa-arrow-right"></i></a>
                    </div>

                    <div class="row g-4">
                        <?php 
                        $sql = "SELECT * FROM internalnews WHERE IntNewsStatus='Active' ORDER BY IntNewsDate DESC LIMIT 4";
                        $res = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($res)):
                            $img = getThumbnail($row['IntNewsFile'], 'internal');
                            $isPDF = (strtolower(pathinfo($row['IntNewsFile'], PATHINFO_EXTENSION)) == 'pdf');
                        ?>
                        <div class="col-md-6 col-lg-3">
                            <a href="?view_int=<?= $row['IntNewsID'] ?>" class="text-dark d-block h-100">
                                <div class="news-item">
                                    <div class="thumb-box">
                                        <?php if(isNew($row['IntNewsDate'])): ?><span class="badge-new bg-warning text-dark">NEW</span><?php endif; ?>
                                        <img src="<?= $img ?>" class="<?= $isPDF ? 'object-fit-contain p-4' : '' ?>">
                                    </div>
                                    <div class="p-3">
                                        <small class="text-muted d-block mb-1"><i class="far fa-calendar-alt text-warning"></i> <?= formatThaiDate($row['IntNewsDate']) ?></small>
                                        <h6 class="fw-bold mb-0 text-truncate-2" style="height: 2.8em; overflow: hidden;"><?= h($row['IntNewsName']) ?></h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="frmPronotice.php" class="card border-0 bg-light p-4 d-flex flex-row align-items-center text-dark text-decoration-none rounded-4 hover-shadow">
                            <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-success">
                                <i class="fas fa-file-invoice-dollar fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold m-0">ประกาศจัดซื้อจัดจ้าง</h5>
                                <small class="text-muted">Procurement Notice</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="frmBoard.php" class="card border-0 bg-light p-4 d-flex flex-row align-items-center text-dark text-decoration-none rounded-4 hover-shadow">
                            <div class="bg-white p-3 rounded-circle shadow-sm me-3 text-warning">
                                <i class="fas fa-gavel fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold m-0">กฎระเบียบ/หนังสือเวียน</h5>
                                <small class="text-muted">Rules & Circulars</small>
                            </div>
                        </a>
                    </div>
                </div>

            </div> </div> </div> <style>
        .hover-shadow { transition: 0.3s; }
        .hover-shadow:hover { background: #fff !important; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transform: translateY(-3px); }
    </style>

<?php elseif (strpos($mode, 'read_') === 0): 
    $data = [];
    if($mode == 'read_ext') {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM externalnews WHERE ExtNewsID=$id"));
        $data = ['title'=>$r['ExtNewsName'], 'date'=>$r['ExtNewsDate'], 'detail'=>$r['ExtNewsDetail'], 'file'=>$r['ExtNewsFile'], 'type'=>'external'];
    } elseif($mode == 'read_int') {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM internalnews WHERE IntNewsID=$id"));
        $data = ['title'=>$r['IntNewsName'], 'date'=>$r['IntNewsDate'], 'detail'=>$r['IntNewsDetail'], 'file'=>$r['IntNewsFile'], 'type'=>'internal'];
    } elseif($mode == 'read_board') {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM announcementboard WHERE BoardID=$id"));
        $data = ['title'=>$r['BoardName'], 'date'=>$r['BoardDate'], 'detail'=>$r['BoardDetail'], 'file'=>$r['BoardImg'], 'type'=>'board'];
    } elseif($mode == 'read_pronotice') {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM procurementnotice WHERE NoticeID=$id"));
        $data = ['title'=>$r['NoticeName'], 'date'=>$r['NoticeStDate'], 'detail'=>$r['NoticeDetail'] ?? '', 'file'=>$r['NoticeFile'], 'type'=>'proNotice'];
    } elseif($mode == 'read_photo') {
        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM photoalbum WHERE AlbumID=$id"));
        $data = ['title'=>$r['AlbumName'], 'date'=>$r['AlbumDate'], 'detail'=>$r['AlbumDetail'], 'file'=>null, 'album'=>$r['AlbumImg']];
    }
?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card main-card-wrapper p-4 p-md-5">
                    <div class="mb-4">
                        <a href="main.php" class="btn btn-light rounded-pill px-3 text-muted"><i class="fas fa-arrow-left me-2"></i>หน้าหลัก</a>
                    </div>
                    
                    <h2 class="fw-bold mb-3 lh-base"><?= h($data['title']) ?></h2>
                    <div class="d-flex align-items-center text-muted mb-4 border-bottom pb-3">
                        <i class="far fa-clock text-success me-2"></i> <?= formatThaiDate($data['date']) ?>
                    </div>

                    <?php if($data['file']): 
                        $ext = strtolower(pathinfo($data['file'], PATHINFO_EXTENSION));
                        $path = "assets/images/".($mode == 'read_ext' ? 'exNews/' : ($mode == 'read_int' ? 'inNews/' : ($mode == 'read_board' ? 'board/' : 'proNotice/'))).$data['file'];
                    ?>
                        <div class="text-center mb-4 bg-light rounded-4 p-4 border border-light">
                            <?php if($ext == 'pdf'): ?>
                                <i class="fas fa-file-pdf text-danger fa-4x mb-3"></i><br>
                                <h6 class="fw-bold mb-3"><?= $data['file'] ?></h6>
                                <a href="<?= $path ?>" target="_blank" class="btn btn-danger rounded-pill px-4 shadow-sm"><i class="fas fa-download me-2"></i>เปิดเอกสาร PDF</a>
                            <?php else: ?>
                                <img src="<?= $path ?>" class="img-fluid rounded shadow-sm" style="max-height: 500px;">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="content-body text-secondary mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                        <?= nl2br(h($data['detail'])) ?>
                    </div>

                    <?php if(isset($data['album']) && !empty($data['album'])): 
                        $imgs = preg_split("/[,|]/", $data['album']);
                    ?>
                        <h5 class="fw-bold border-start border-4 border-success ps-3 mb-3">แกลเลอรี่รูปภาพ</h5>
                        <div class="row g-2">
                            <?php foreach($imgs as $img): if(trim($img)=='') continue; ?>
                            <div class="col-4 col-md-3">
                                <a href="assets/images/album/<?= trim($img) ?>" target="_blank">
                                    <img src="assets/images/album/<?= trim($img) ?>" class="w-100 rounded shadow-sm object-fit-cover" style="height: 120px;">
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($mode == 'list_ext' || $mode == 'list_int'): 
    $isExt = ($mode == 'list_ext');
    $title = $isExt ? "ข่าวประชาสัมพันธ์ภายนอกทั้งหมด" : "ข่าวประชาสัมพันธ์ภายในทั้งหมด";
    
    $limit = 12;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    
    $countSql = $isExt ? "SELECT COUNT(*) as t FROM externalnews WHERE ExtNewsStatus='Active'" : "SELECT COUNT(*) as t FROM internalnews WHERE IntNewsStatus='Active'";
    $total = mysqli_fetch_assoc(mysqli_query($conn, $countSql))['t'];
    $pages = ceil($total / $limit);
?>
    <div class="container py-5">
        <div class="card main-card-wrapper p-4 p-md-5">
            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                <a href="main.php" class="btn btn-light rounded-circle shadow-sm me-3" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-arrow-left"></i></a>
                <h3 class="fw-bold m-0"><?= $title ?></h3>
            </div>

            <div class="row g-4">
                <?php 
                $sql = $isExt ? "SELECT * FROM externalnews WHERE ExtNewsStatus='Active' ORDER BY ExtNewsDate DESC LIMIT $start, $limit" 
                              : "SELECT * FROM internalnews WHERE IntNewsStatus='Active' ORDER BY IntNewsDate DESC LIMIT $start, $limit";
                $res = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($res)):
                    $d = $isExt ? ['id'=>$row['ExtNewsID'], 'name'=>$row['ExtNewsName'], 'date'=>$row['ExtNewsDate'], 'file'=>$row['ExtNewsFile'], 'link'=>'view_ext']
                                : ['id'=>$row['IntNewsID'], 'name'=>$row['IntNewsName'], 'date'=>$row['IntNewsDate'], 'file'=>$row['IntNewsFile'], 'link'=>'view_int'];
                    $img = getThumbnail($d['file'], $isExt?'external':'internal');
                ?>
                <div class="col-md-6 col-lg-3">
                    <a href="?<?= $d['link'] ?>=<?= $d['id'] ?>" class="text-dark d-block h-100">
                        <div class="news-item h-100">
                            <div class="thumb-box">
                                <img src="<?= $img ?>">
                            </div>
                            <div class="p-3">
                                <small class="text-muted d-block mb-1"><?= formatThaiDate($d['date']) ?></small>
                                <h6 class="fw-bold text-truncate-2"><?= h($d['name']) ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>

            <?php if($pages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php for($i=1; $i<=$pages; $i++): ?>
                    <li class="page-item <?= ($i==$page?'active':'') ?>">
                        <a class="page-link rounded-circle mx-1 border-0 shadow-sm <?= ($i==$page?'bg-success text-white':'text-dark') ?>" href="?<?= $isExt?'external_all':'internal_all' ?>=1&page=<?= $i ?>" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php include("assets/footer/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>