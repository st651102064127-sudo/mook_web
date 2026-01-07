<?php
include "../../assets/connect_db/connect_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // รับค่าและตัดช่องว่างหัวท้ายออก (trim)
    $EmpID         = $_POST['EmpID'];
    $EmpName       = trim($_POST['EmpName']);
    $EmpCod        = trim($_POST['EmpCod']);
    $EmpEmail      = trim($_POST['EmpEmail']);
    $EmpPhone      = trim($_POST['EmpPhone']);
    $EmpPosition   = trim($_POST['EmpPosition']);
    $EmpDepartment = trim($_POST['EmpDepartment']);
    $EmpAgency     = trim($_POST['EmpAgency']);
    $EmpRole       = trim($_POST['EmpRole']);
    $EmpPassword   = trim($_POST['EmpPassword']); // optional

    // 🔴 1. ตรวจสอบค่าว่าง (Validation) 🔴
    // หากฟิลด์ใดฟิลด์หนึ่งเป็นค่าว่าง ให้แจ้งเตือนและดีดกลับ
    if (empty($EmpName) || empty($EmpCod) || empty($EmpEmail) || empty($EmpPhone) || 
        empty($EmpPosition) || empty($EmpDepartment) || empty($EmpAgency) || empty($EmpRole)) {
        echo "
            <script>
                alert('❗ กรุณากรอกข้อมูลให้ครบถ้วน ห้ามเว้นว่างในช่องที่กำหนด');
                history.back();
            </script>
        ";
        exit();
    }

    // 🔍 2. ตรวจสอบว่ามี Email หรือ รหัสพนักงาน ซ้ำกับคนอื่นหรือไม่
    // เช็คโดยข้าม ID ตัวเองไป (EmpID != ?) เพราะถ้าไม่แก้ Email ตัวเอง มันจะฟ้องว่าซ้ำกับตัวเอง
    $check_sql = "SELECT EmpID FROM employee WHERE (EmpEmail = ? OR EmpCod = ?) AND EmpID != ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ssi", $EmpEmail, $EmpCod, $EmpID);
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

    // ✅ 3. เริ่ม UPDATE ข้อมูล
    if (!empty($EmpPassword)) {
        // กรณี : มีการเปลี่ยนรหัสผ่าน (กรอกช่องรหัสผ่านใหม่มา)
        $hashedPassword = password_hash($EmpPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE employee SET 
                    EmpName = ?, EmpCod = ?, EmpEmail = ?, EmpPhone = ?, 
                    EmpPosition = ?, EmpDepartment = ?, EmpAgency = ?, EmpRole = ?, 
                    EmpPass = ?
                WHERE EmpID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", 
            $EmpName, $EmpCod, $EmpEmail, $EmpPhone, 
            $EmpPosition, $EmpDepartment, $EmpAgency, $EmpRole, 
            $hashedPassword, $EmpID);
    } else {
        // กรณี : ไม่เปลี่ยนรหัสผ่าน (ไม่ได้กรอกช่องรหัสผ่านใหม่)
        $sql = "UPDATE employee SET 
                    EmpName = ?, EmpCod = ?, EmpEmail = ?, EmpPhone = ?, 
                    EmpPosition = ?, EmpDepartment = ?, EmpAgency = ?, EmpRole = ?
                WHERE EmpID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", 
            $EmpName, $EmpCod, $EmpEmail, $EmpPhone, 
            $EmpPosition, $EmpDepartment, $EmpAgency, $EmpRole, $EmpID);
    }

    if ($stmt->execute()) {
        echo "
            <script>
                alert('✅ อัปเดตข้อมูลสำเร็จ');
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
    // ถ้าเข้าหน้านี้โดยไม่ได้กด Submit Form
    echo "
        <script>
            alert('ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง');
            window.location.href = '../manage/manage_employee.php';
        </script>
    ";
}
?>