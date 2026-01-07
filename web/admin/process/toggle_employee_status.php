<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_GET['id'];
$status = ($_GET['status'] === 'Active') ? 'Active' : 'Inactive';

$sql = "UPDATE employee SET EmpStatus = ? WHERE EmpID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $status, $id);
mysqli_stmt_execute($stmt);

header("Location: ../manage/manage_employee.php");
exit;
?>
