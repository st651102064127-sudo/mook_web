<?php
// include("assets/connect_db/connect_db.php");


// 
if (!empty($_GET["email"])) {



    $email = $_GET["email"];

    $conn = new mysqli("localhost", "root", "", "db_supply");
    $sql = "SELECT * FROM employee WHERE EmpEmail = '$email'  ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["EmpEmail"];
        }

        $random = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
        echo $random;
echo date("Y-m-d H:i:s", strtotime("+60 minutes"));
        echo $email;
    } else {
        echo "ไม่พบข้อมูล";
    }
}
