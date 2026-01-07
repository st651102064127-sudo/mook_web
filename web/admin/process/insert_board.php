<?php
require_once '../../assets/connect_db/connect_db.php';

$name = $_POST['BoardName'];
$detail = $_POST['BoardDetail'];
$date = date("Y-m-d H:i:s");
$uploadPath = "../../assets/images/board/";
$uploadedFiles = [];

// ตรวจสอบและจัดการอัปโหลดหลายไฟล์
if (!empty($_FILES['BoardImg']['name'][0])) {
    foreach ($_FILES['BoardImg']['name'] as $key => $file) {
        if ($_FILES['BoardImg']['error'][$key] === 0) {
            $fileName = time() . "_" . basename($file);
            $tmpName = $_FILES['BoardImg']['tmp_name'][$key];

            if (move_uploaded_file($tmpName, $uploadPath . $fileName)) {
                $uploadedFiles[] = $fileName;
            }
        }
    }
}

// แปลง array เป็น string เพื่อเก็บในฟิลด์เดียว
$fileList = implode(",", $uploadedFiles);

// เตรียม SQL
$sql = "INSERT INTO announcementboard (BoardName, BoardDetail, BoardImg, BoardDate, BoardStatus)
        VALUES (?, ?, ?, ?, 'Active')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $detail, $fileList, $date);
mysqli_stmt_execute($stmt);

header("Location: ../manage/manage_board.php");
exit;
?>