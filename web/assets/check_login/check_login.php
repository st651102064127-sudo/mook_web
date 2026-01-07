<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบสิทธิ์เฉพาะกลุ่มงานพัสดุ
if ($_SESSION["user_dept"] !== "กลุ่มงานพัสดุ") {
    echo "
        <script>
            alert('ไม่มีสิทธิ์เข้าถึงหน้านี้');
            window.location.href = 'index.php';
        </script>
    ";
    exit();
}
?>
