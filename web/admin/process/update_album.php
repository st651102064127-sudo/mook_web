<?php
require_once '../../assets/connect_db/connect_db.php';

$albumID = $_POST['AlbumID'];
$name    = $_POST['AlbumName'];
$detail  = $_POST['AlbumDetail'];
$date    = date("Y-m-d H:i:s");

$uploadPath = "../../assets/images/album/";

// อ่านข้อมูลเดิมก่อน
$sql = "SELECT AlbumImg FROM photoalbum WHERE AlbumID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $albumID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$oldImages = [];
if (!empty($row['AlbumImg'])) {
    $oldImages = explode(",", $row['AlbumImg']);
}

// ------------------------------------------
// 🔥 1) ลบไฟล์ที่ผู้ใช้ติ๊กเลือกให้ลบ
// ------------------------------------------
$deletedImages = $_POST['DeleteOldFiles'] ?? [];

foreach ($deletedImages as $delImg) {
    $filePath = $uploadPath . $delImg;

    if (file_exists($filePath)) {
        unlink($filePath); // ลบไฟล์จริง
    }

    // เอาออกจาก array
    $key = array_search($delImg, $oldImages);
    if ($key !== false) {
        unset($oldImages[$key]);
    }
}

// ------------------------------------------
// 🔥 2) อัปโหลดไฟล์ใหม่ (หลายไฟล์)
// ------------------------------------------
$newImages = [];

if (!empty($_FILES['AlbumImg']['name'][0])) {
    foreach ($_FILES['AlbumImg']['name'] as $key => $file) {

        if ($_FILES['AlbumImg']['error'][$key] === 0) {
            
            $fileName = time() . "_" . basename($file);
            $tmpName = $_FILES['AlbumImg']['tmp_name'][$key];

            if (move_uploaded_file($tmpName, $uploadPath . $fileName)) {
                $newImages[] = $fileName;
            }
        }
    }
}

// ------------------------------------------
// 🔥 3) รวมรูปเก่า (ที่ยังไม่ถูกลบ) + รูปใหม่
// ------------------------------------------
$allImages = array_merge(array_values($oldImages), $newImages);
$finalImageList = implode(",", $allImages);

// ------------------------------------------
// 🔥 4) UPDATE ข้อมูลกลับฐานข้อมูล
// ------------------------------------------
$sql = "UPDATE photoalbum 
        SET AlbumName = ?, AlbumDetail = ?, AlbumImg = ?, AlbumDate = ?
        WHERE AlbumID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $name, $detail, $finalImageList, $date, $albumID);
mysqli_stmt_execute($stmt);

// ------------------------------------------
// 🔥 5) Redirect กลับไปหน้า manage
// ------------------------------------------
header("Location: ../manage/manage_album.php");
exit;
?>
