<?php
require_once '../../assets/connect_db/connect_db.php';
include "../../assets/check_login_admin/check_login_admin.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ใช้การ Soft Delete: ปรับสถานะเป็น 'Inactive' แทนการลบข้อมูลจริง (DELETE FROM)
    // เพื่อเก็บประวัติเอกสารราชการตาม พ.ร.บ.
    $sql = "UPDATE announcementboard SET BoardStatus = 'Inactive' WHERE BoardID = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // ลบสำเร็จ ให้กลับไปหน้าจัดการ
        header("Location: ../manage/manage_board.php");
        exit;
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); history.back();</script>";
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: ../manage/manage_board.php");
    exit;
}
?>