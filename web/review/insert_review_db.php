<?php include("../assets/connect_db/connect_db.php"); ?>
<?php

$topic = $_POST['topic'];

if (empty($topic)) {
    echo 'กรุณากรอกข้อมูล';
} else {

    $sql = "INSERT INTO `tb_forms` (`name`) VALUES ('$topic')";
    if ($conn->query($sql) != true) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>
    <script>
        alert("บันทึกสำเร็จ");
        window.location.href='insert_review.php';
    </script>
<?php
}
?>