<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_POST['IntNewsID'];
$name = $_POST['IntNewsName'];
$detail = $_POST['IntNewsDetail'];
$oldFile = $_POST['OldFile'];
$newFile = "";
$uploadPath = "../../assets/images/inNews/";

// ถ้ามีการอัปโหลดไฟล์ใหม่
if (!empty($_FILES['IntNewsFile']['name'])) {
    $newFile = time() . "_" . basename($_FILES['IntNewsFile']['name']);
    move_uploaded_file($_FILES['IntNewsFile']['tmp_name'], $uploadPath . $newFile);

    // ถ้ามี checkbox ลบไฟล์เดิม หรือต้องการแทนที่
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
    }

    // อัปเดตข้อมูลรวมชื่อไฟล์ใหม่
    $sql = "UPDATE internalnews SET IntNewsName=?, IntNewsDetail=?, IntNewsFile=? WHERE IntNewsID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $detail, $newFile, $id);
} else {
    // ไม่มีไฟล์ใหม่ → เช็คว่าจะลบไฟล์เก่าหรือไม่
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
        $sql = "UPDATE internalnews SET IntNewsName=?, IntNewsDetail=?, IntNewsFile=NULL WHERE IntNewsID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $detail, $id);
    } else {
        // ไม่มีการลบไฟล์ → อัปเดตแค่ชื่อและรายละเอียด
        $sql = "UPDATE internalnews SET IntNewsName=?, IntNewsDetail=? WHERE IntNewsID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $detail, $id);
    }
}

mysqli_stmt_execute($stmt);
header("Location: ../manage/manage_innews.php");
exit;
?>
