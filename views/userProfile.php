<?php
ob_start();
?>

In Building


<?php
$headerPath = "views/components/header.php";
$contenu = ob_get_clean();
$pageTitle = "Mon profil";

require "views/Layout.php";
