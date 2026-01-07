<?php include("assets/connect_db/connect_db.php"); ?>
<?php include("assets/check_not_login/check_not_login.php"); ?>

<!DOCTYPE html>
<html lang="th">

<?php include("assets/head/head.php"); ?>

<body style="background-color:#99CC99;">

    <section class="vh-10">
        <div class="container py-4 h-10">
            <div class="row d-flex justify-content-center align-item-center h-100">
                <div class="col col-xl-5">
                    <div class="card shadow" style="border-radius:1rem;">
                        <div class="row g-0">
                            <div class="col d-flex align-item-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="login.php" method="post">
                                        <center>
                                            <h1 class="mb-4">เข้าสู่ระบบ</h1>
                                        </center>

                                        <label class="text-dark">รหัสพนักงาน</label>
                                        <input type="text" name="EmpCod" id="EmpCod" required class="form-control" placeholder="กรุณากรอกรหัสพนักงาน">

                                        <label class="text-dark mt-3">รหัสผ่าน</label>
                                        <input type="password" name="password" id="password" required class="form-control" placeholder="กรุณากรอกรหัสผ่าน">

                                        <br>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                                            
                                        </div>
                                        
                                        <div class="mt-3 text-center">
                                            <a href="index.php" class="text-dark me-3">กลับหน้าหลัก</a>
                                            
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>

<style>
body {
  background: linear-gradient(to right, #9be15d, #00e3ae);
  font-family: 'Prompt', sans-serif;
}
.card {
  border-radius: 1rem;
  background-color: #ffffff;
}
.btn-success {
  background-color: #28a745;
  border: none;
}
.btn-success:hover {
  background-color: #218838;
}
</style>
