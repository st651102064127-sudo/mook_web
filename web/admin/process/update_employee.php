<?php
include "../../assets/connect_db/connect_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. รับค่าจากฟอร์มตาม attribute 'name' ที่กำหนดไว้ใน frmedit_employee.php
    $EmpID      = $_POST['EmpID'];
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $tel        = trim($_POST['tel']);
    $EmpCod     = trim($_POST['EmpCod']); // ค่าจาก input readonly
    $position   = trim($_POST['position']);
    $role       = trim($_POST['role']);
    $department = trim($_POST['department']);
    $agency     = trim($_POST['agency']);
    $password   = trim($_POST['password']); // optional

    // 🔴 2. ตรวจสอบค่าว่าง (Validation) 🔴
    // ตรวจสอบฟิลด์สำคัญ (ยกเว้น password เพราะเป็นทางเลือก)
    if (empty($name) || empty($email) || empty($tel) || empty($EmpCod) || 
        empty($position) || empty($role) || empty($department) || empty($agency)) {
        echo "
            <script>
                alert('❗ กรุณากรอกข้อมูลให้ครบถ้วน ห้ามเว้นว่างในช่องที่กำหนด');
                history.back();
            </script>
        ";
        exit();
    }

    // 🔍 3. ตรวจสอบความซ้ำซ้อนของข้อมูล (ยกเว้น ID ของตัวเอง)
    $check_sql = "SELECT EmpID FROM employee WHERE (EmpEmail = ? OR EmpCod = ?) AND EmpID != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ssi", $email, $EmpCod, $EmpID);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "
            <script>
                alert('❗ ข้อมูลซ้ำ: มีอีเมลหรือรหัสพนักงานนี้ในระบบแล้ว');
                history.back();
            </script>
        ";
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    // ✅ 4. เริ่ม UPDATE ข้อมูลลง Database
    if (!empty($password)) {
        // กรณี : มีการเปลี่ยนรหัสผ่านใหม่
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE employee SET 
                    EmpName = ?, EmpCod = ?, EmpEmail = ?, EmpPhone = ?, 
                    EmpPosition = ?, EmpDepartment = ?, EmpAgency = ?, EmpRole = ?, 
                    EmpPass = ?
                WHERE EmpID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", 
            $name, $EmpCod, $email, $tel, 
            $position, $department, $agency, $role, 
            $hashedPassword, $EmpID);
    } else {
        // กรณี : ไม่มีการเปลี่ยนรหัสผ่าน
        $sql = "UPDATE employee SET 
                    EmpName = ?, EmpCod = ?, EmpEmail = ?, EmpPhone = ?, 
                    EmpPosition = ?, EmpDepartment = ?, EmpAgency = ?, EmpRole = ?
                WHERE EmpID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", 
            $name, $EmpCod, $email, $tel, 
            $position, $department, $agency, $role, $EmpID);
    }

    if ($stmt->execute()) {
        echo "
            <script>
                alert('✅ อัปเดตข้อมูลเจ้าหน้าที่สำเร็จ');
                window.location.href = '../manage/manage_employee.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('❌ เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error . "');
                history.back();
            </script>
        ";
    }

    $stmt->close();
    $conn->close();

} else {
    // กรณีเข้าถึงไฟล์โดยตรงโดยไม่ผ่านฟอร์ม
    echo "
        <script>
            alert('ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง');
            window.location.href = '../manage/manage_employee.php';
        </script>
    ";
}
?>