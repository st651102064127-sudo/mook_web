<?php
session_start(); // เปิด Session เผื่อไว้เช็ค Login
require_once '../../assets/connect_db/connect_db.php';

// ตรวจสอบว่ามีการส่งข้อมูลมาจริงหรือไม่
if (isset($_POST['upload'])) {

    // 1. รับค่าจากฟอร์ม
    $name = $_POST['InNewsName'];
    $detail = $_POST['InNewsDetail'];
    $date = date("Y-m-d H:i:s");
    $fileName = "";

    // 2. จัดการไฟล์อัปโหลด (เพิ่มความปลอดภัย)
    if (isset($_FILES['InNewsFile']) && $_FILES['InNewsFile']['error'] == 0) {
        
        // กำหนดนามสกุลไฟล์ที่อนุญาต (Whitelist)
        $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
        $file_ext = strtolower(pathinfo($_FILES['InNewsFile']['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed)) {
            // ตั้งชื่อไฟล์ใหม่: เวลา_เลขสุ่ม.นามสกุล (ป้องกันชื่อซ้ำ)
            $fileName = time() . "_" . mt_rand(100, 999) . "." . $file_ext;
            $upload_path = "../../assets/images/inNews/" . $fileName;

            // ย้ายไฟล์
            if (!move_uploaded_file($_FILES['InNewsFile']['tmp_name'], $upload_path)) {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('นามสกุลไฟล์ไม่ถูกต้อง อนุญาตเฉพาะรูปภาพ, PDF และไฟล์เอกสาร Office เท่านั้น'); window.history.back();</script>";
            exit;
        }
    }

    // 3. บันทึกลงฐานข้อมูล (Prepared Statement)
    $sql = "INSERT INTO internalnews (IntNewsName, IntNewsDetail, IntNewsFile, IntNewsDate, IntNewsStatus) 
            VALUES (?, ?, ?, ?, 'Active')";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $name, $detail, $fileName, $date);

        if (mysqli_stmt_execute($stmt)) {
            // บันทึกสำเร็จ
            echo "<script>
                alert('บันทึกข้อมูลข่าวประชาสัมพันธ์เรียบร้อยแล้ว');
                window.location.href = '../manage/manage_innews.php';
            </script>";
        } else {
            // บันทึกไม่สำเร็จ (Database Error)
            echo "<script>
                alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn) . "');
                window.history.back();
            </script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        // Prepare Statement Error
        echo "<script>alert('SQL Error'); window.history.back();</script>";
    }
    
    mysqli_close($conn);

} else {
    // ถ้าเข้าหน้านี้โดยไม่ได้กด submit
    header("Location: ../manage/manage_innews.php");
    exit;
}
?>