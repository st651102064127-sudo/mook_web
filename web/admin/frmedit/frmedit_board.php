<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";

$id = $_GET['id'];
$sql = "SELECT * FROM announcementboard WHERE BoardID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<?php include("../../admin/include/header.php"); ?>

<body class="sb-nav-fixed" style="background-color: #EEEEEE;">

    <!-- Navbar ด้านบน -->
    <?php include("../../admin/include/navbar.php"); ?>

    <!-- Layout หลัก -->
    <div id="layoutSidenav">

        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <?php include("../../admin/include/sidebar.php"); ?>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">กฎ/ระเบียบ/มติ ครม. และหนังสือเวียน</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-bullhorn me-1"></i>
                            แก้ไขกฎ/ระเบียบ/มติ ครม. และหนังสือเวียน
                        </div>

                        <div class="card-body">
                            <form action="../../admin/process/update_board.php" method="post" enctype="multipart/form-data">

                                <!-- PRIMARY KEY -->
                                <input type="hidden" name="BoardID" value="<?= $row['BoardID'] ?>">
                                <input type="hidden" name="OldFile" value="<?= $row['BoardImg'] ?>">

                                <!-- ชื่อประกาศ -->
                                <label for="BoardName">เรื่อง</label>
                                <input type="text" class="form-control"
                                       name="BoardName" id="BoardName"
                                       value="<?= htmlspecialchars($row['BoardName']) ?>"><br>

                                <!-- รายละเอียด -->
                                <label for="BoardDetail">รายละเอียดเพิ่มเติม</label>
                                <textarea name="BoardDetail" class="form-control" id="BoardDetail"
                                          cols="30" rows="5"><?= htmlspecialchars($row['BoardDetail']) ?></textarea><br>

                                <!-- ไฟล์เดิม -->
                                <div class="mb-3">
                                    <label>ไฟล์เดิม:</label><br>

                                    <?php if (!empty($row['BoardImg'])): ?>
                                        <a href="../../assets/images/board/<?= $row['BoardImg'] ?>" target="_blank">
                                            <?= $row['BoardImg'] ?>
                                        </a>

                                        <input type="checkbox" name="DeleteOldFile" value="1"> ลบไฟล์เดิม
                                    <?php else: ?>
                                        <span>ไม่มีไฟล์เดิม</span>
                                    <?php endif; ?>

                                    <br><br>

                                    <input type="file" class="form-control" id="BoardImg" name="BoardImg">
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
