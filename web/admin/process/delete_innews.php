<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_GET['id'];
$sql = "UPDATE internalnews SET IntNewsStatus = 'Inactive' WHERE IntNewsID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: ../manage/manage_innews.php");
?>