<?php include("../assets/connect_db/connect_db.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        
       
        <form action="backend.php" method="POST">
           
        <h2>ชื่อผู้ประเมิน : <input type="text" name="fname" value="<?php echo $_SESSION['user_fname']; ?>" readonly> </h2>
            <table class="table table-bordered" style="text-align: center;">
                <thead>
                    <tr>
                        <th colspan="2">แบบประเมินความพึงพอใจการใช้เว็บไซต์</th>
                    </tr>
                    <tr>
                        <th>หัวข้อ</th>
                        <th>คะแนนการประเมิน</th>
                    </tr>
                </thead>
                <tbody>

               
                    <?php foreach ($forms as $form) {?>
                    <tr>
                        <td><?php echo $form['name'] ?></td>
                        <td>
                            <input type="hidden" name="user_id" value="1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tb_forms[<?php echo $form['id'] ?>]"
                                    id="inlineRadio1" value="5">
                                <label class="form-check-label" for="inlineRadio1">ดีมาก</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tb_forms[<?php echo $form['id'] ?>]"
                                    id="inlineRadio2" value="4">
                                <label class="form-check-label" for="inlineRadio2">ดี</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tb_forms[<?php echo $form['id'] ?>]"
                                    id="inlineRadio3" value="3">
                                <label class="form-check-label" for="inlineRadio3">ปานกลาง</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tb_forms[<?php echo $form['id'] ?>]"
                                    id="inlineRadio3" value="2">
                                <label class="form-check-label" for="inlineRadio4">พอใช้</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tb_forms[<?php echo $form['id'] ?>]"
                                    id="inlineRadio3" value="1">
                                <label class="form-check-label" for="inlineRadio5">ปรับปรุง</label>
                            </div>
                        </td>
                    </tr>
                    <?php }?>

                </tbody>
            </table>

            <br>
            <button type="submit" class="btn btn-success">
                บันทึก
            </button>
        </form>

    </div>
</body>

</html>