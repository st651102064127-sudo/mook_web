<?php
require_once '../../assets/connect_db/connect_db.php';

// รับค่าจากฟอร์ม
$ContractName       = $_POST['ContractName'] ?? '';
$ContractDate       = $_POST['ContractDate'] ?? '';
$ContractEndDate    = $_POST['ContractEndDate'] ?? '';
$ContractDepartment = $_POST['ContractDepartment'] ?? 'กลุ่มงานพัสดุ';
$ContractAgency     = $_POST['ContractAgency'] ?? 'โรงพยาบาลหล่มสัก';
$ContractStatus     = 'Active';

// ถ้าคุณมีฟิลด์เลือกวิธีจัดซื้อ ให้ดึงจากฟอร์ม
// ถ้าไม่มี ให้กำหนดค่า default = 1
$ContractMethodID   = $_POST['ContractMethodID'] ?? 1;

// โฟลเดอร์เก็บไฟล์
$uploadPath = "../../assets/images/proContract/";
if (!is_dir($uploadPath)) {
    mkdir($uploadPath, 0775, true);
}

// จัดการไฟล์อัปโหลด
$ContractFile = "";

if (!empty($_FILES['ContractFile']['name'])) {
    $newFileName = time() . "_" . basename($_FILES['ContractFile']['name']);
    $fileTmp = $_FILES['ContractFile']['tmp_name'];
    
    if (move_uploaded_file($fileTmp, $uploadPath . $newFileName)) {
        $ContractFile = $newFileName;
    }
}

// SQL Insert
$sql = "INSERT INTO procurementcontract (
            ContractName,
            ContractDate,
            ContractEndDate,
            ContractFile,
            ContractDepartment,
            ContractAgency,
            ContractMethodID,
            ContractStatus
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "ssssssis",
    $ContractName,
    $ContractDate,
    $ContractEndDate,
    $ContractFile,
    $ContractDepartment,
    $ContractAgency,
    $ContractMethodID,
    $ContractStatus
);

// บันทึกลงฐานข้อมูล
mysqli_stmt_execute($stmt);

// กลับไปหน้าแสดงรายการ
header("Location: ../manage/manage_proContract.php");
exit;
?>
