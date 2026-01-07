<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_POST['BoardID'];
$name = $_POST['BoardName'];
$detail = $_POST['BoardDetail'];
$oldFile = $_POST['OldFile'];
$newFile = "";
$uploadPath = "../../assets/images/board/";

// ถ้ามีอัปโหลดไฟล์ใหม่
if (!empty($_FILES['BoardImg']['name'])) {

    $newFile = time() . "_" . basename($_FILES['BoardImg']['name']);
    move_uploaded_file($_FILES['BoardImg']['tmp_name'], $uploadPath . $newFile);

    // ถ้าติ๊กลบไฟล์เดิม
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
    }

    // อัปเดตข้อมูลพร้อมชื่อไฟล์ใหม่
    $sql = "UPDATE announcementboard 
            SET BoardName = ?, BoardDetail = ?, BoardImg = ? 
            WHERE BoardID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $detail, $newFile, $id);

} else {

    // ไม่มีไฟล์ใหม่ → ถ้าต้องการลบไฟล์เก่า
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {

        unlink($uploadPath . $oldFile);

        $sql = "UPDATE announcementboard 
                SET BoardName = ?, BoardDetail = ?, BoardImg = NULL 
                WHERE BoardID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $detail, $id);

    } else {

        // ไม่มีไฟล์ใหม่และไม่มีการลบไฟล์ → update เฉพาะข้อความ
        $sql = "UPDATE announcementboard 
                SET BoardName = ?, BoardDetail = ? 
                WHERE BoardID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $detail, $id);
    }
}

mysqli_stmt_execute($stmt);

header("Location: ../manage/manage_board.php");
exit;
?>
