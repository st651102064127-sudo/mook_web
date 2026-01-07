<?php include("../assets/connect_db/connect_db.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php

    $sql_forms = "SELECT * FROM tb_forms";
    $forms = $conn->query($sql_forms);

    $conn->close();
    ?>
    <div class="container">
        <br>
        <br>


        <form action="insert_review_db.php" method="post">
            <label for="">ชื่อหัวข้อแบบประเมิน</label>
            <input type="text" name="topic" class="form-control">
            <br>
            <button type="submit" class="btn btn-success">
                บันทึก
            </button>
        </form>

    </div>
</body>

</html>