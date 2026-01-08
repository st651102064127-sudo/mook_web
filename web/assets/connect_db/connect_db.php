<?php
session_start();
// ปิด Error Notice เพื่อไม่ให้กวนหน้าเว็บ แต่ยังแสดง Error ร้ายแรง
error_reporting(E_ALL & ~E_NOTICE);

date_default_timezone_set("Asia/Bangkok");
$name = "e-PMS";

$host = "db";
$user = "root";
$pass = "123";
$dbname = "db_supply";

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8mb4");

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. เช็ค Session (แก้ไขจาก user_id เป็น EmpID ให้ตรงกับตอน Login)
if (isset($_SESSION["EmpID"])) {
    $emp_id = $_SESSION["EmpID"];
    $sql_user = "SELECT * FROM employee WHERE EmpID = '$emp_id'";
    $result_user = $conn->query($sql_user);
    if ($result_user->num_rows > 0) {
        $show_user_login = $result_user->fetch_assoc();
    }
}

// 2. ฟังก์ชัน Login
if (isset($_GET["action"]) && $_GET["action"] == "login") {
    $user_username = $_POST["EmpCod"];
    $user_pass = $_POST["EmpPass"];

    // **แก้ไขความปลอดภัย: ใช้ Prepared Statement ป้องกัน SQL Injection**
    $stmt = $conn->prepare("SELECT * FROM employee WHERE EmpCod = ? AND EmpPass = ?");
    $stmt->bind_param("ss", $user_username, $user_pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // ใช้ fetch_assoc แทน foreach

        // ตั้งค่า Session
        $_SESSION["EmpID"] = $row["EmpID"];
        $_SESSION["EmpName"] = $row["EmpName"];
        $_SESSION["EmpEmail"] = $row["EmpEmail"];
        $_SESSION["EmpPhone"] = $row["EmpPhone"];

        // **แก้ไข Syntax Error ใน INSERT และใช้ตัวแปรให้ถูกต้อง**
        // สมมติว่า nov_user_id คือ EmpID และ sale_time_slip ต้องการเวลาปัจจุบัน
        $insert_sql = "INSERT INTO `tb_number_of_visitors` (`nov_id`, `nov_user_id`, `sale_time_slip`) 
                       VALUES (NULL, '" . $row["EmpID"] . "', NOW())";
        
        $conn->query($insert_sql);

        // Login สำเร็จ -> ไปหน้าแรก หรือหน้า Dashboard
        echo "<script>
            alert('เข้าสู่ระบบสำเร็จ');
            window.location.href = 'index.php'; 
        </script>";
    } else {
        // Login ไม่สำเร็จ
        echo "<script>
            alert('รหัสพนักงานหรือรหัสผ่านไม่ถูกต้อง');
            window.history.back();
        </script>";
    }
    
    $stmt->close(); // ปิด statement
}
?>