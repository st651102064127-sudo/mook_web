<?php
// session_start();
include "../../assets/connect_db/connect_db.php";
include "../../assets/check_login_admin/check_login_superAdmin.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. รับค่าและตัดช่องว่าง (Trim)
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $tel        = trim($_POST['tel']);
    $position   = trim($_POST['position']);
    $department = trim($_POST['department']);
    $agency     = trim($_POST['agency']);
    $EmpCod     = trim($_POST['EmpCod']);
    $password   = trim($_POST['password']);
    $role       = trim($_POST['role'] ?? ''); // ✅ รับค่า Role ที่เพิ่มมาจากฟอร์ม

    // 🔴 2. เพิ่ม Logic ตรวจสอบค่าว่าง (Validation) 🔴
    // เพิ่มการตรวจสอบ $role เข้าไปด้วย
    if (empty($name) || empty($email) || empty($tel) || empty($position) || 
        empty($department) || empty($agency) || empty($EmpCod) || empty($password) || empty($role)) {
        echo "
            <script>
                alert('❗ กรุณากรอกข้อมูลให้ครบถ้วน ห้ามเว้นว่าง');
                history.back();
            </script>
        ";
        exit();
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // กำหนดค่าบทบาทผู้ใช้งาน (EmpRole)
    // ✅ เปลี่ยนจากเดิมที่ Fix เป็น Member ให้ใช้ค่าที่เลือกมาจากฟอร์มโดยตรง
    $EmpRole = $role; 

    $EmpLastLogin  = NULL;
    $ResetToken    = NULL;
    $ResetExpire   = NULL;

    // 🔍 3. ตรวจสอบข้อมูลซ้ำ
    $check_sql = "SELECT EmpID FROM employee WHERE EmpEmail = ? OR EmpCod = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $email, $EmpCod);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "
            <script>
                alert('❗ ข้อมูลซ้ำ: มีอีเมลหรือรหัสพนักงานนี้อยู่แล้ว');
                history.back();
            </script>
        ";
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    // ✅ 4. บันทึกข้อมูล (Insert)
    $sql = "INSERT INTO employee (
                EmpName, EmpCod, EmpPass, EmpEmail, EmpPhone, 
                EmpPosition, EmpDepartment, EmpAgency, EmpRole, 
                EmpLastLogin, ResetToken, ResetExpire
            ) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param(
            "ssssssssssss",
            $name, $EmpCod, $hashed_password, $email, $tel,
            $position, $department, $agency, $EmpRole,
            $EmpLastLogin, $ResetToken, $ResetExpire
        );

        if ($stmt->execute()) {
            echo "
                <script>
                    alert('✅ เพิ่มเจ้าหน้าที่สำเร็จ!');
                    window.location = '../manage/manage_employee.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('❌ เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error . "');
                    history.back();
                </script>
            ";
        }

        $stmt->close();
    } else {
        echo "
            <script>
                alert('❌ ไม่สามารถเตรียมคำสั่ง SQL ได้');
                history.back();
            </script>
        ";
    }

    $conn->close();

} else {
    echo "
        <script>
            alert('ไม่อนุญาตให้เข้าถึงหน้านี้โดยตรง');
            window.location.href = '../manage/manage_employee.php';
        </script>
    ";
}
?>