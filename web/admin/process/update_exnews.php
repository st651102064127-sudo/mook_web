<?php
require_once '../../assets/connect_db/connect_db.php';

$id = $_POST['ExtNewsID'];
$name = $_POST['ExtNewsName'];
$detail = $_POST['ExtNewsDetail'];
$oldFile = $_POST['OldFile'];
$newFile = "";
$uploadPath = "../../assets/images/exNews/";

// ถ้ามีการอัปโหลดไฟล์ใหม่
if (!empty($_FILES['ExtNewsFile']['name'])) {
    $newFile = time() . "_" . basename($_FILES['ExtNewsFile']['name']);
    move_uploaded_file($_FILES['ExtNewsFile']['tmp_name'], $uploadPath . $newFile);

    // ถ้ามี checkbox ลบไฟล์เดิม หรือต้องการแทนที่
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
    }

    // อัปเดตข้อมูลรวมชื่อไฟล์ใหม่
    $sql = "UPDATE externalnews SET ExtNewsName=?, ExtNewsDetail=?, ExtNewsFile=? WHERE ExtNewsID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $detail, $newFile, $id);
} else {
    // ไม่มีไฟล์ใหม่ → เช็คว่าจะลบไฟล์เก่าหรือไม่
    if (!empty($_POST['DeleteOldFile']) && !empty($oldFile) && file_exists($uploadPath . $oldFile)) {
        unlink($uploadPath . $oldFile);
        $sql = "UPDATE externalnews SET ExtNewsName=?, ExtNewsDetail=?, ExtNewsFile=NULL WHERE ExtNewsID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $detail, $id);
    } else {
        // ไม่มีการลบไฟล์ → อัปเดตแค่ชื่อและรายละเอียด
        $sql = "UPDATE externalnews SET ExtNewsName=?, ExtNewsDetail=? WHERE ExtNewsID=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $detail, $id);
    }
}

mysqli_stmt_execute($stmt);
echo "
    <script>
    alert('เเก้ไขข้อมูลเรียบร้อย');
    window.location= '../manage/manage_exnews.php';

    </script>
";
?>