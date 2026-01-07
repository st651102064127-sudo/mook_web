    <div class="text-center mb-1">
        <?php 
        foreach ($conn->query("SELECT * FROM `tb_category`") as $row) {
            ?>
            <span><a href="product.php?cate_id=<?php echo $row["cate_id"]; ?>" class="btn"><?php echo $row["cate_name"]; ?></a></span>
            <?php
        }
        ?>
    </div>