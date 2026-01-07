<?php
include "../../assets/connect_db/connect_db.php";
// include "../../assets/check_login_admin/check_login_admin.php";
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
                    <h1 class="mt-4">เพิ่มกฎ/ระเบียบ/มติ ครม. และหนังสือเวียน</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-bullhorn me-1"></i>
                            เพิ่มรายการกฎ/ระเบียบ/มติ ครม. และหนังสือเวียน
                        </div>
                        <div class="card-body">
                            <form action="../../admin/process/insert_board.php" method="post" enctype="multipart/form-data">

                                <label for="BoardName">เรื่อง</label>
                                <input type="text" name="BoardName" id="BoardName" required class="form-control"><br>

                                <label for="BoardDetail">รายละเอียดเพิ่มเติม</label>
                                <textarea name="BoardDetail" id="BoardDetail" cols="30" rows="5" required class="form-control"></textarea><br>

                                <div class="mb-3">
                                    <label for="BoardImg" class="form-label">ไฟล์เอกสาร</label>
                                    <input type="file" class="form-control" id="BoardImg" name="BoardImg[]" multiple required>
                                </div>

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
