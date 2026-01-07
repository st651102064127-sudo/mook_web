<?php
include "assets/connect_db/connect_db.php";
if (isset($_SESSION["user_id"])) {  // ถ้าไม่มีการล็อกอิน
?>
    <script>
        history.back();
    </script>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include("assets/head/head.php"); ?>

<body style="background-color:#99CC99;">

    <section class="min-vh-100 d-flex align-items-center">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow" style="border-radius:1rem;">
                        <div class="card-body p-4 p-lg-5 text-black">

                            <h1 class="text-center mb-4">สมัครสมาชิก</h1>

                            <form action="insert.php" method="post" class="needs-validation" novalidate>

                                <div class="mb-3">
                                    <label for="name" class="form-label text-dark">ชื่อ-นามสกุล</label>
                                    <input type="text" name="name" id="name" required class="form-control" placeholder="กรุณากรอกชื่อ-นามสกุล">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label text-dark">อีเมล</label>
                                    <input type="email" name="email" id="email" required class="form-control" placeholder="กรุณากรอกอีเมล">
                                </div>

                                <div class="mb-3">
                                    <label for="tel" class="form-label text-dark">เบอร์โทร</label>
                                    <input type="text" name="tel" id="tel" required maxlength="10" class="form-control" placeholder="กรุณากรอกเบอร์โทร">
                                </div>

                                <div class="mb-3">
                                    <label for="position" class="form-label text-dark">ตำแหน่ง</label>
                                    <input type="text" name="position" id="position" required class="form-control" placeholder="กรุณากรอกตำแหน่ง">
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label text-dark">ฝ่ายงาน</label>
                                    <input type="text" name="department" id="department" required class="form-control" placeholder="กรุณากรอกฝ่ายงาน">
                                </div>

                                <div class="mb-3">
                                    <label for="agency" class="form-label text-dark">หน่วยงาน</label>
                                    <input type="text" name="agency" id="agency" required class="form-control" placeholder="กรุณากรอกหน่วยงาน">
                                </div>

                                <div class="mb-3">
                                    <label for="EmpCod" class="form-label text-dark">รหัสพนักงาน</label>
                                    <input type="text" name="EmpCod" id="EmpCod" required class="form-control" placeholder="กรุณากรอกรหัสพนักงาน">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label text-dark">รหัสผ่าน</label>
                                    <input type="password" name="password" id="password" required class="form-control" placeholder="กรุณากรอกรหัสผ่าน">
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="index.php" class="btn btn-outline-dark me-2">กลับหน้าหลัก</a>
                                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>