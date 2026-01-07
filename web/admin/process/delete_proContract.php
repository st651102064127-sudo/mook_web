<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_GET['id'] ?? 0;
$id = (int)$id;

// ดึงข้อมูลไฟล์เพื่อลบออกด้วย
$sql = "SELECT ContractFile FROM procurementcontract WHERE ContractID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$uploadPath = "../../uploads/contract/";

// ลบไฟล์จริง
if (!empty($row['ContractFile']) && file_exists($uploadPath . $row['ContractFile'])) {
    unlink($uploadPath . $row['ContractFile']);
}

// ลบข้อมูลทั้งแถว (hard delete)
$sqlDelete = "DELETE FROM procurementcontract WHERE ContractID = ?";
$stmtDel = mysqli_prepare($conn, $sqlDelete);
mysqli_stmt_bind_param($stmtDel, "i", $id);
mysqli_stmt_execute($stmtDel);

// redirect
header("Location: ../manage/manage_proContract.php");
exit;
?>
