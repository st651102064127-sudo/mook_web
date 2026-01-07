<?php
require_once '../../assets/connect_db/connect_db.php';

$ContractID         = $_POST['ContractID'];
$ContractName       = $_POST['ContractName'];
$ContractDate       = $_POST['ContractDate'];
$ContractEndDate    = $_POST['ContractEndDate'];
$ContractDepartment = $_POST['ContractDepartment'];
$ContractAgency     = $_POST['ContractAgency'];

$OldFile            = $_POST['OldFile'];
$deleteFile         = isset($_POST['del_file']) ? 1 : 0;

$uploadPath = "../../assets/images/proContract/";
$newFileName = $OldFile;

// ✔ ลบไฟล์เดิมหากติ๊ก checkbox
if ($deleteFile && !empty($OldFile)) {
    if (file_exists($uploadPath . $OldFile)) {
        unlink($uploadPath . $OldFile);
    }
    $newFileName = "";
}

// ✔ อัปโหลดไฟล์ใหม่
if (!empty($_FILES['ContractFile']['name'])) {

    // ลบไฟล์เดิมก่อน (ถ้ามี)
    if (!empty($OldFile) && file_exists($uploadPath . $OldFile)) {
        unlink($uploadPath . $OldFile);
    }

    $tmp  = $_FILES['ContractFile']['tmp_name'];
    $file = time() . "_" . basename($_FILES['ContractFile']['name']);

    if (move_uploaded_file($tmp, $uploadPath . $file)) {
        $newFileName = $file;
    }
}

$sql = "UPDATE procurementcontract
        SET ContractName=?, ContractDate=?, ContractEndDate=?, ContractFile=?, 
            ContractDepartment=?, ContractAgency=?
        WHERE ContractID=?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "ssssssi",
    $ContractName,
    $ContractDate,
    $ContractEndDate,
    $newFileName,
    $ContractDepartment,
    $ContractAgency,
    $ContractID
);

mysqli_stmt_execute($stmt);

// กลับหน้ารายการ
header("Location: ../manage/manage_proContract.php");
exit;
?>
