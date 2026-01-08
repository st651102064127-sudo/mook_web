<?php
// แก้ไข Session Error: เปิด Buffering เพื่อกันไม่ให้มี Output ส่งออกก่อน Session/Header
ob_start(); 

require_once '../../assets/connect_db/connect_db.php';

// รับค่าจาก Form
 $name = $_POST['ExtNewsName'];
 $detail = $_POST['ExtNewsDetail'];
 $date = date("Y-m-d H:i:s");
 $fileName = ""; // กำหนดค่าเริ่มต้นเป็นค่าว่าง

// ตรวจสอบการอัปโหลดไฟล์
if (isset($_FILES['ExtNewsFile']) && $_FILES['ExtNewsFile']['name'] != "") {
    $fileName = time() . "_" . $_FILES['ExtNewsFile']['name']; 
    move_uploaded_file($_FILES['ExtNewsFile']['tmp_name'], "../../assets/images/exNews/" . $fileName);
}

// แก้ไข SQL Error: 
// 1. เพิ่มคอลัมน์ 'ExtNewsStatus' (หรือชื่อคอลัมน์สถานะในฐานข้อมูลของคุณ) เข้าไปในวงเล็บชื่อคอลัมน์
// 2. จำนวนคอลัมน์ (5 ตัว) ตรงกับจำนวน Values (5 ตัว คือ ? 4 ตัว และ 'Active' 1 ตัว)
 $sql = "INSERT INTO externalnews (ExtNewsName, ExtNewsDetail, ExtNewsFile, ExtNewsDate, ExtNewsStatus) 
        VALUES (?, ?, ?, ?, 'Active')";

 $stmt = mysqli_prepare($conn, $sql);

// Bind parameters: s = string (จำนวน 4 ตัว ตรงกับเครื่องหมาย ? ใน SQL)
mysqli_stmt_bind_param($stmt, "ssss", $name, $detail, $fileName, $date);

if (mysqli_stmt_execute($stmt)) {
    // ถ้าสำเร็จให้ redirect
    header("Location: ../manage/manage_exnews.php");
    exit(); // ใส่ exit เพื่อหยุดการทำงาน script ถัดไป
} else {
    // แสดง error ถ้ามีปัญหา (สำหรับ debugging)
    echo "Error: " . mysqli_error($conn);
}
?>