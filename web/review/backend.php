<?php include("../assets/connect_db/connect_db.php"); ?>
<?php
$forms = $_POST['forms'];
$user_id = $_POST['user_id'];
$fname = $_POST['fname'];

if (empty($forms)) {
    echo 'กรุณากรอกข้อมูล';
} else {
    foreach ($forms as $key => $form) {
        $sql = "INSERT INTO `tb_transaction_forms` (`user_id`, `form_id`,`tf_username`) VALUES ('$key', '$form', '$fname')";
        if ($conn->query($sql) != true) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
?>
    <script>
        alert("บันทึกสำเร็จ");
        window.location.href='frontend.php';
    </script>
<?php
}
?>