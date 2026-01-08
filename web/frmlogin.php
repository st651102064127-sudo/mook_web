<?php
// เริ่มต้น Session
include "assets/connect_db/connect_db.php";

// ตัวแปรสำหรับเก็บข้อความตอบกลับ (Response)
 $response_message = "";
 $response_type = ""; // 'success' หรือ 'error'

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $EmpCod   = trim($_POST['EmpCod']);
    $password = trim($_POST['password']);

    // ตรวจสอบว่ามีการกรอกข้อมูลหรือไม่
    if (empty($EmpCod) || empty($password)) {
        $response_message = "กรุณากรอกรหัสพนักงานและรหัสผ่าน";
        $response_type = "error";
    } else {
        // ✅ ดึงข้อมูลจากฐานข้อมูล
        $sql = "SELECT * FROM employee WHERE EmpCod = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $EmpCod);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // ✅ ตรวจสอบรหัสผ่าน
                if (password_verify($password, $row['EmpPass'])) {

                    // ✅ ตรวจสอบ Role ว่าเป็น Member หรือไม่
                    if ($row['EmpRole'] === "Member") {

                        $_SESSION["user_id"]   = $row['EmpID'];
                        $_SESSION["user_name"] = $row['EmpName'];
                        $_SESSION["user_role"] = $row['EmpRole'];
                        $_SESSION["user_dept"] = $row['EmpDepartment'];

                        // ✅ อัปเดตเวลาล็อกอินล่าสุด
                        $update = $conn->prepare("UPDATE employee SET EmpLastLogin = NOW() WHERE EmpID = ?");
                        $update->bind_param("i", $row['EmpID']);
                        $update->execute();
                        $update->close();

                        // ✅ ตั้งค่าข้อความสำเร็จและ Redirect ผ่าน JS
                        $response_message = "ยินดีต้อนรับ {$row['EmpName']}!";
                        $response_type = "success";
                        $redirect_url = "admin/manage/employee.php";
                    } else {
                        // ❌ ไม่ใช่ Member
                        $response_message = "สิทธิ์ไม่เพียงพอ: เข้าสู่ระบบได้เฉพาะสมาชิก (Member) เท่านั้น";
                        $response_type = "error";
                    }
                } else {
                    $response_message = "รหัสผ่านไม่ถูกต้อง";
                    $response_type = "error";
                }
            } else {
                $response_message = "ไม่พบรหัสพนักงานนี้ในระบบ";
                $response_type = "error";
            }

            $stmt->close();
        } else {
            $response_message = "เกิดข้อผิดพลาดทางระบบฐานข้อมูล";
            $response_type = "error";
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>เข้าสู่ระบบสมาชิก | Company Login</title>
    <!-- Google Fonts: Kanit -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    
</head>
<body>

    <!-- Toast Notification Container -->
    <div id="toast" class="toast">
        <div class="toast-icon"></div>
        <div class="toast-message"></div>
    </div>

    <!-- Wrapper สำหรับ Mobile -->
    <div class="login-container">
        <div class="mobile-bg-card">
            
            <!-- โลโกบริษัท -->
            <div class="">
                <!-- เปลี่ยน src เป็น path รูปจริงของคุณ เช่น assets/images/logo.png -->
                <img src="assets/images/icon/logo.png " class="shadow"  width="180" alt="Company Logo">
            </div>

            <h2 class="login-title">เข้าสู่ระบบ</h2>
            <p class="login-subtitle">ระบบจัดการข้อมูลพนักงาน </p>

            <form id="loginForm" action="" method="POST">
                
                <div class="form-group">
                    <label for="EmpCod" class="form-label">รหัสพนักงาน (EmpCod)</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <input type="text" id="EmpCod" name="EmpCod" class="form-input" placeholder="เช่น EMP001" required autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">รหัสผ่าน</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text">เข้าสู่ระบบ</span>
                    <div class="spinner"></div>
                </button>
            </form>

            

        </div>
    </div>

    <script>
        // --- จัดการการแสดงผลแจ้งเตือน (Toast Logic) ---
        document.addEventListener("DOMContentLoaded", function() {
            const phpMessage = "<?php echo $response_message; ?>";
            const phpType = "<?php echo $response_type; ?>";
            const redirectUrl = "<?php echo isset($redirect_url) ? $redirect_url : ''; ?>";

            if (phpMessage && phpMessage !== "") {
                showToast(phpMessage, phpType);
            }

            if (redirectUrl) {
                setTimeout(function() {
                    window.location.href = redirectUrl;
                }, 500);
            }
        });

        function showToast(message, type) {
            const toast = document.getElementById('toast');
            const msgEl = toast.querySelector('.toast-message');
            const iconEl = toast.querySelector('.toast-icon');

            msgEl.textContent = message;
            toast.className = 'toast show ' + type;

            if(type === 'success') {
                iconEl.innerHTML = '✓';
            } else {
                iconEl.innerHTML = '!';
            }

            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }

        // --- จัดการการกดปุ่ม Submit (Loading State) ---
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const spinner = submitBtn.querySelector('.spinner');

        loginForm.addEventListener('submit', function(e) {
            const inputs = loginForm.querySelectorAll('input');
            let isValid = true;
            
            inputs.forEach(input => {
                if(!input.value) isValid = false;
            });

            if(isValid) {
                btnText.textContent = "กำลังตรวจสอบ...";
                spinner.style.display = 'block';
                submitBtn.disabled = true;
            }
        });
    </script>
</body>
</html>