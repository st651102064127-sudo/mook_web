<?php 
    if (isset($_SESSION["user_id"])) {  // ถ้ามีการล็อกอิน
        ?>
        <script>
            history.back();
        </script>
        <?php
    }
?>