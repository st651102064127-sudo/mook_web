<?php include("assets/connect_db/connect_db.php"); 
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
    <div class="container py-4 h-10 d-flex justify-content-center align-item-center h-100">
        <div class="col col-xl-5 container-p-y">
            <div class="authentication-inner py-4">

                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        
                        <!-- /Logo -->
                        <h4 class="mb-2">ลืมรหัสผ่าน? 🔒</h4>
                        <p class="mb-4">ป้อนอีเมลของคุณและเราจะส่งคำแนะนำในการรีเซ็ตรหัสผ่านของคุณ</p>
                        <form id="formforgot_password" class="mb-3" action="forgot_password.php" method="GET">
                            <div class="mb-3">
                                <label for="" class="form-label">อีเมล</label>
                                <input type="email" name="email" id="email" required class="form-control" placeholder="กรุณากรอกอีเมล" autofocus>
                                
                            </div>
                            <button type="button" class="btn btn-success d-grid w-100">ส่งลิงค์รีเซ็ต</button>
                        </form>
                        <div class="text-center">
                            <a href="frmlogin.php" class="d-flex align-items-center justify-content-center text-secondary">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                กลับไปที่หน้าเข้าสู่ระบบ
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>


</body>

</html>