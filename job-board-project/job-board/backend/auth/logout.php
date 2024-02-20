<?php
session_start();
session_destroy();
header("Location: ../../frontend/homepage/index.php");
exit();
?>