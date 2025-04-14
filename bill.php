<?php


ob_start();
include './templates/bill.html.php';
$page_content = ob_get_clean();
include './layout-mobile.html.php';
?>