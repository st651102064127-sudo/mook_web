<?php
session_start();

// ถ้ายังไม่ได้ล็อกอิน
if (!isset($_SESSION['user_id'])) {
   echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location.href='../../frmlogin.php';</script>";
   exit();
}

// ถ้าไม่ใช่ Member
if (($_SESSION['user_role'] !== 'Member')) {
  echo "<script>alert('คุณไม่มีสิทธิ์เข้าถึงหน้านี้'); window.location.href='../../frmlogin.php';</script>";
   exit();
}
?>
