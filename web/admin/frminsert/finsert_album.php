<?php
include "../../assets/connect_db/connect_db.php";
?>

<!DOCTYPE html>
<html lang="th">

<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">

    <?php include("../../admin/include/navbar.php"); ?>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">สร้างอัลบั้มรูปภาพ</h1>

                    <div class="card mb-4">

                        <div class="card-header">
                            <i class="fas fa-images me-1"></i>
                            เพิ่มอัลบั้มรูปภาพ
                        </div>

                        <div class="card-body">

                            <form action="../../admin/process/insert_album.php" method="post" enctype="multipart/form-data">

                                <!-- ชื่ออัลบั้ม -->
                                <label for="AlbumName">ชื่ออัลบั้ม</label>
                                <input type="text" name="AlbumName" id="AlbumName" required class="form-control"><br>

                                <!-- รายละเอียด -->
                                <label for="AlbumDetail">รายละเอียดเพิ่มเติม</label>
                                <textarea name="AlbumDetail" id="AlbumDetail" cols="30" rows="5" required class="form-control"></textarea><br>

                                <!-- Upload หลายไฟล์ -->
                                <div class="mb-3">
                                    <label for="AlbumImg" class="form-label">อัปโหลดรูปภาพ </label>
                                    <input type="file" class="form-control" id="AlbumImg" name="AlbumImg[]" multiple required>
                                </div>

                                <!-- ปุ่ม -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-warning" onclick="history.back()">กลับหน้าหลัก</button>
                                    <button type="submit" class="btn btn-success ms-2">บันทึกข้อมูล</button>
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
