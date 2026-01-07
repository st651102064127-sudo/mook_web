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
                    <h1 class="mt-4">ข่าวประชาสัมพันธ์ภายนอก</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            เพิ่มข่าวประชาสัมพันธ์ภายนอก
                        </div>
                        <div class="card-body ">
                            <form action="../../admin/process/insert_exnews.php" method="post" enctype=multipart/form-data>

                                <label for="">เรื่อง</label>
                                <input type="text" name="ExtNewsName" id="ExtNewsName" required class="form-control"><br>

                                <label for="">รายละเอียดเพิ่มเติม</label>
                                <textarea name="ExtNewsDetail" id="ExtNewsDetail" cols="30" rows="5" required class="form-control"></textarea><br>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">ไฟล์เอกสาร</label>
                                    <input type="file" class="form-control" cols="30" rows="5" id="ExtNewsFile" name="ExtNewsFile" required>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" href="" class="btn btn-warning" onclick="history.back()">กลับหน้าหลัก</button> 
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