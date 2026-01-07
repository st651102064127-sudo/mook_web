<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_POST['NoticeID'];
$name = $_POST['NoticeName'];
$startDate = $_POST['NoticeStDate'];
$endDate = $_POST['NoticeEnDate'];
$oldFile = $_POST['OldFile'];
$newFile = "";
$uploadPath = "../../assets/images/proNotice/";

// กรณีมีไฟล์ใหม่อัปโหลด
if (!empty($_FILES['NoticeFile']['name'])) {
    $newFile = time() . "_" . basename($_FILES['NoticeFile']['name']);
    move_uploaded_file($_FILES['NoticeFile']['tmp_name'], $uploadPath . $newFile);

    // ถ้าติ๊กลบไฟล์เก่า → ลบทิ้ง
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
    }

    // SQL พร้อมอัปเดตไฟล์ใหม่
    $sql = "UPDATE procurementnotice SET NoticeName=?, NoticeStDate=?, NoticeEnDate=?, NoticeFile=? WHERE NoticeID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $startDate, $endDate, $newFile, $id);
} else {
    // ไม่มีไฟล์ใหม่ แต่ลบไฟล์เก่า
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
        $sql = "UPDATE procurementnotice SET NoticeName=?, NoticeStDate=?, NoticeEnDate=?, NoticeFile=NULL WHERE NoticeID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $startDate, $endDate, $id);
    } else {
        // อัปเดตเฉพาะข้อความ
        $sql = "UPDATE procurementnotice SET NoticeName=?, NoticeStDate=?, NoticeEnDate=? WHERE NoticeID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $name, $startDate, $endDate, $id);
    }
}

mysqli_stmt_execute($stmt);
header("Location: ../manage/manage_proNotice.php");
exit;
?>
