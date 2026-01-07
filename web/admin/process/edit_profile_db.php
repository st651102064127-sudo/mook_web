<?php
session_start();
include "../../assets/connect_db/connect_db.php";
// ตรวจสอบสิทธิ์ (ถ้าจำเป็นต้องเช็คซ้ำเพื่อความปลอดภัย)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$empID = $_SESSION['user_id'];

if (isset($_POST['save_profile'])) {
    // 1. รับค่าและป้องกัน SQL Injection
    $empName = mysqli_real_escape_string($conn, $_POST['EmpName']);
    $empEmail = mysqli_real_escape_string($conn, $_POST['EmpEmail']);
    $empPhone = mysqli_real_escape_string($conn, $_POST['EmpPhone']);

    // 2. ตัวแปรสำหรับรหัสผ่าน
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];
    $oldPass = $_POST['old_password'];

    // 3. ดึงรหัสผ่านเดิมจาก DB มาเช็ค
    $sqlCheck = "SELECT EmpPass FROM employee WHERE EmpID = '$empID'";
    $queryCheck = mysqli_query($conn, $sqlCheck);
    $resultCheck = mysqli_fetch_assoc($queryCheck);
    $dbPass = $resultCheck['EmpPass'];

    $errorMsg = "";
    $successMsg = "";

    // 4. ตรวจสอบเงื่อนไขการอัปเดต
    if (!empty($newPass)) {
        // กรณี : ต้องการเปลี่ยนรหัสผ่าน
        if (password_verify($oldPass, $dbPass)) { // เช็ครหัสเดิม
            if ($newPass === $confirmPass) { // เช็ครหัสใหม่ตรงกัน
                $hashNewPass = password_hash($newPass, PASSWORD_DEFAULT);
                $sql = "UPDATE employee SET 
                        EmpName = '$empName', 
                        EmpEmail = '$empEmail', 
                        EmpPhone = '$empPhone',
                        EmpPass = '$hashNewPass'
                        WHERE EmpID = '$empID'";
            } else {
                $errorMsg = "รหัสผ่านใหม่และการยืนยันรหัสผ่านไม่ตรงกัน";
            }
        } else {
            $errorMsg = "รหัสผ่านเดิมไม่ถูกต้อง";
        }
    } else {
        // กรณี : ไม่เปลี่ยนรหัสผ่าน (อัปเดตแค่ข้อมูลทั่วไป)
        $sql = "UPDATE employee SET 
                EmpName = '$empName', 
                EmpEmail = '$empEmail', 
                EmpPhone = '$empPhone'
                WHERE EmpID = '$empID'";
    }

    // 5. ประมวลผลคำสั่ง SQL (ถ้าไม่มี Error ก่อนหน้า)
    if ($errorMsg == "") {
        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = "success";
            $_SESSION['msg'] = "บันทึกข้อมูลสำเร็จ";
        } else {
            $_SESSION['status'] = "error";
            $_SESSION['msg'] = "เกิดข้อผิดพลาดจากฐานข้อมูล: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['status'] = "error";
        $_SESSION['msg'] = $errorMsg;
    }

    // 6. ส่งกลับไปหน้าฟอร์ม
    header("Location: edit_profile.php");
    exit();
} else {
    // ถ้าเข้าไฟล์นี้โดยไม่ได้กดปุ่ม submit
    header("Location: edit_profile.php");
    exit();
}
?>