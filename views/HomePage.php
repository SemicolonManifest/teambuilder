<?php
ob_start();
?>

<div id="btnMemberList">
    <a href="?action=memberList"><button type="button" class="btn btn-primary">Liste des membres</button></a>
</div>

<?php
$headerPath = "views/components/header.php";
$contenu = ob_get_clean();
$pageTitle = "Home";

require "views/Layout.php";