<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_GET['id'];
$sql = "UPDATE externalnews SET ExtNewsStatus = 'Inactive' WHERE ExtNewsID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: ../manage/manage_exnews.php");
?>