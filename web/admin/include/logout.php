<?php
session_start();
$_SESSION = []; // ล้างค่า Session
session_destroy(); // ทำลาย Session
header('Location: ../../index.php?logout=1');
exit;
?>