
<?php
require_once '../../assets/connect_db/connect_db.php';

// รับค่าจากฟอร์ม
$name = $_POST['InNewsName'];
$detail = $_POST['InNewsDetail'];
$date = date("Y-m-d H:i:s");
$fileName = "";

// ตรวจสอบและจัดการไฟล์ที่อัปโหลด
if ($_FILES['InNewsFile']['name']) {
    $fileName = time() . "_" . basename($_FILES['InNewsFile']['name']);
    move_uploaded_file($_FILES['InNewsFile']['tmp_name'], "../../assets/images/inNews/" . $fileName);
}

// เตรียม SQL และ bind parameter
$sql = "INSERT INTO internalnews (IntNewsName, IntNewsDetail, IntNewsFile, IntNewsDate, IntNewsStatus) 
        VALUES (?, ?, ?, ?, 'Active')";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $detail, $fileName, $date);
mysqli_stmt_execute($stmt);

// ไปยังหน้าแสดงผล
header("Location: ../manage/manage_innews.php");
exit;
?>
