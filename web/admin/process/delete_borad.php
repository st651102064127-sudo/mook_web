<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_GET['id'];
$sql = "UPDATE photoalbum SET AlbumStatus = 'Inactive' WHERE AlbumID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

// กลับไปหน้า manage อัลบั้ม
header("Location: ../manage/manage_album.php");
exit;
?>
