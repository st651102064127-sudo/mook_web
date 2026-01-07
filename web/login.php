<?php
//session_start();
include "assets/connect_db/connect_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $EmpCod   = trim($_POST['EmpCod']);
    $password = trim($_POST['password']);

    // ✅ ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM employee WHERE EmpCod = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST['EmpCod']);
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

                // ✅ เข้าสู่หน้า employee.php

                echo "
                    <script>
                        alert('ยินดีต้อนรับ {$row['EmpName']}!');
                        window.location.href = 'admin/manage/employee.php';
                    </script>
                ";
            } else {
                // ❌ ไม่ใช่ Member
                echo "
                    <script>
                        alert('สิทธิ์ไม่เพียงพอ: เข้าสู่ระบบได้เฉพาะสมาชิก (Member) เท่านั้น');
                        history.back();
                    </script>
                ";
            }
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); history.back();</script>";
        }
    } else {
        echo "<script>alert('ไม่พบรหัสพนักงานนี้ในระบบ'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง'); window.location.href='frmlogin.php';</script>";
}
