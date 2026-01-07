<?php
require_once '../../assets/connect_db/connect_db.php';

$name   = $_POST['AlbumName'];
$detail = $_POST['AlbumDetail'];
$date   = date("Y-m-d H:i:s");

$uploadPath = "../../assets/images/album/";
$uploadedFiles = [];

// ตรวจสอบและจัดการอัปโหลดหลายไฟล์
if (!empty($_FILES['AlbumImg']['name'][0])) {
    foreach ($_FILES['AlbumImg']['name'] as $key => $file) {

        if ($_FILES['AlbumImg']['error'][$key] === 0) {
            
            $fileName = time() . "_" . basename($file);
            $tmpName  = $_FILES['AlbumImg']['tmp_name'][$key];

            if (move_uploaded_file($tmpName, $uploadPath . $fileName)) {
                $uploadedFiles[] = $fileName;
            }
        }
    }
}

// แปลง array เป็น string
$fileList = implode(",", $uploadedFiles);

// INSERT ลงตาราง photoalbum
$sql = "INSERT INTO photoalbum (AlbumName, AlbumDetail, AlbumImg, AlbumDate, AlbumStatus)
        VALUES (?, ?, ?, ?, 'Active')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $detail, $fileList, $date);
mysqli_stmt_execute($stmt);

// กลับไปหน้า manage
header("Location: ../manage/manage_album.php");
exit;
?>
