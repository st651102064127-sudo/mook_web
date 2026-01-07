
<?php
require_once '../../assets/connect_db/connect_db.php';

$name = $_POST['ExtNewsName'];
$detail = $_POST['ExtNewsDetail'];
$date = date("Y-m-d H:i:s");
$fileName = "";

if ($_FILES['ExtNewsFile']['name']) {
    $fileName = time() . "_" . $_FILES['ExtNewsFile']['name']; 
    move_uploaded_file($_FILES['ExtNewsFile']['tmp_name'], "../../assets/images/exNews/" . $fileName);
}

$sql = "INSERT INTO externalnews (ExtNewsName, ExtNewsDetail, ExtNewsFile, ExtNewsDate) 
        VALUES (?, ?, ?, ?, 'Active')";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $detail, $fileName, $date);
mysqli_stmt_execute($stmt);

header("Location: ../manage/manage_exnews.php");
?>