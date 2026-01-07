<?php
// session_start();
include "../../assets/connect_db/connect_db.php";

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

    // 🔴 2. เพิ่ม Logic ตรวจสอบค่าว่าง (Validation) 🔴
    // หากฟิลด์สำคัญเป็นค่าว่าง (หรือมีแค่เว้นวรรค) ให้แจ้งเตือนทันที
    if (empty($name) || empty($email) || empty($tel) || empty($position) || 
        empty($department) || empty($agency) || empty($EmpCod) || empty($password)) {
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

    // กำหนดค่าพื้นฐาน
    // หมายเหตุ: คุณอาจต้องปรับ Logic ตรงนี้ ถ้าอยากให้เลือก Role ได้จากฟอร์ม (ตอนนี้ Fix เป็น Member)
    $EmpRole       = "Member"; 
    
    // ถ้าตำแหน่งเป็น Admin อาจจะกำหนด Role เป็น Admin อัตโนมัติ (Optional Logic)
    if ($position === 'Admin') {
        $EmpRole = 'Admin';
    }

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