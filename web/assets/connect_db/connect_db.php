<?php
session_start();
error_reporting(error_reporting() && ~E_NOTICE);

date_default_timezone_set("Asia/Bangkok");
$name = "e-PMS";


$host = "db";          
$user = "root";
$pass = "123";          
$dbname = "db_supply";

$conn = new mysqli($host, $user, $pass, $dbname); //connect db
$conn->set_charset("utf8mb4"); //อักษร

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SESSION["user_id"]) {
    foreach ($conn->query("SELECT * FROM employee WHERE EmpID = $_SESSION[user_id] ") as $show_user_login);
}

if (isset($_GET["action"]) and $_GET["action"] == "login") {
    $user_username = $_POST["EmpCod"];
    $user_pass = $_POST["EmpPass"];
    $sql = "SELECT * FROM employee WHERE EmpCod = '$user_username' AND EmpPass = '$user_pass' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        foreach ($result as $row);
        $_SESSION["EmpID"] = $row["EmpID"];
        $_SESSION["EmpName"] = $row["EmpName"];
        $_SESSION["EmpEmail"] = $row["EmpEmail"];
        $_SESSION["EmpPhone"] = $row["EmpPhone"];

        // เพิ่มการเข้าชม
        $conn->query("INSERT INTO `tb_number_of_visitors`(`nov_id`, `nov_user_id`, `sale_time_slip`) VALUES (NULL,'$row[user_id]',NULL')");
    }
        
?> 

<script>
        history.back();
    </script> <?php
            }




                ?>
                