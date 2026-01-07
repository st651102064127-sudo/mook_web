<?php
//session_start();
include "assets/connect_db/connect_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // รับค่าจากฟอร์ม
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $tel        = trim($_POST['tel']);
    $position   = trim($_POST['position']);
    $department = trim($_POST['department']);
    $agency     = trim($_POST['agency']);
    $EmpCod     = trim($_POST['EmpCod']);
    $password   = trim($_POST['password']);

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ค่าพื้นฐาน
    $EmpRole       = "Member";
    $EmpLastLogin  = NULL;
    $ResetToken    = NULL;
    $ResetExpire   = NULL;

    // 🔍 ตรวจสอบข้อมูลซ้ำก่อน insert
    $check_sql = "SELECT EmpID FROM Employee WHERE EmpEmail = ? OR EmpCod = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $email, $EmpCod);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // ถ้ามีข้อมูลซ้ำ
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

    // ✅ ถ้าไม่ซ้ำ ให้บันทึกข้อมูล
    $sql = "INSERT INTO Employee (
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
                    alert('✅ สมัครสมาชิกสำเร็จ!');
                    window.location.href = 'frmlogin.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('❌ เกิดข้อผิดพลาดในการบันทึกข้อมูล');
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
            window.location.href = 'index.php';
        </script>
    ";
}
?>
