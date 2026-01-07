<?php
require_once '../../assets/connect_db/connect_db.php';

// รับข้อมูลจากฟอร์ม
$name       = $_POST['NoticeName'];
$startDate  = $_POST['NoticeStDate'];
$endDate    = $_POST['NoticeEnDate'];
$department = 'กลุ่มงานพัสดุ';
$agency     = 'โรงพยาบาลหล่มสัก';
$typeID     = 1; // กำหนดค่าหากใช้ประเภทเดียว (ปรับได้)
$methodID   = 1; // กำหนดค่าหากใช้วิธีเดียว (ปรับได้)
$status     = 'Active';
$fileName   = "";

// สร้างโฟลเดอร์ไฟล์ถ้ายังไม่มี
$uploadPath = "../../assets/images/proNotice/";
if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0775, true);
}

// จัดการอัปโหลดไฟล์
if (!empty($_FILES['NoticeFile']['name'])) {
    $fileName = time() . "_" . basename($_FILES['NoticeFile']['name']);
    move_uploaded_file($_FILES['NoticeFile']['tmp_name'], $uploadPath . $fileName);
}

// เตรียมคำสั่ง SQL
$sql = "INSERT INTO procurementnotice (
            NoticeName, NoticeStDate, NoticeEnDate, NoticeFile, 
            NoticeDepartment, NoticeAgency, NoticeTypeID, NoticeMethodID, NoticeStatus
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssssis",
    $name, $startDate, $endDate, $fileName,
    $department, $agency, $typeID, $methodID, $status
);

// บันทึกข้อมูล
mysqli_stmt_execute($stmt);

// กลับไปหน้าแสดงรายการ
header("Location: ../manage/manage_proNotice.php");
exit;
?>
