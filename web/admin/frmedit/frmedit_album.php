<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";

$id = $_GET['id'];
$sql = "SELECT * FROM photoalbum WHERE AlbumID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="th">

<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">

    <!-- Navbar ด้านบน -->
    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">แก้ไขอัลบั้มรูปภาพ</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-images me-1"></i>
                            แก้ไขอัลบั้ม
                        </div>

                        <div class="card-body">
                            <form action="../../admin/process/update_album.php" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="AlbumID" value="<?= $row['AlbumID'] ?>">

                                <!-- ชื่ออัลบั้ม -->
                                <label for="AlbumName">ชื่ออัลบั้ม</label>
                                <input type="text" class="form-control" name="AlbumName" id="AlbumName"
                                    value="<?= htmlspecialchars($row['AlbumName']) ?>"><br>

                                <!-- รายละเอียด -->
                                <label for="AlbumDetail">รายละเอียดเพิ่มเติม</label>
                                <textarea name="AlbumDetail" class="form-control" id="AlbumDetail"
                                    cols="30" rows="5"><?= htmlspecialchars($row['AlbumDetail']) ?></textarea><br>

                                <!-- แสดงรูปเดิม -->
                                <div class="mb-3">
                                    <label>รูปภาพเดิม:</label><br>
                                    <?php
                                    $images = explode(",", $row['AlbumImg']);
                                    foreach ($images as $img):
                                        $img = trim($img);
                                        if ($img && file_exists("../../assets/images/album/" . $img)):
                                    ?>
                                            <div style="margin-bottom:10px;">
                                                <img src="../../assets/images/album/<?= htmlspecialchars($img) ?>"
                                                    alt="<?= $img ?>" style="max-width: 150px; border:1px solid #ccc;"><br>
                                                <label>
                                                    <input type="checkbox" name="DeleteOldFiles[]" value="<?= $img ?>">
                                                    ลบไฟล์นี้ (<?= $img ?>)
                                                </label>
                                            </div>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>

                                <!-- อัปโหลดรูปใหม่ -->
                                <div class="mb-3">
                                    <label for="AlbumImg">เพิ่มรูปภาพใหม่</label>
                                    <input type="file" class="form-control" name="AlbumImg[]" id="AlbumImg" multiple>
                                </div>

                                <!-- ปุ่ม -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-warning" onclick="history.back()">กลับหน้าหลัก</button>
                                    <button type="submit" name="upload" class="btn btn-success">บันทึกข้อมูล</button>
                                </div>

                            </form>
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
