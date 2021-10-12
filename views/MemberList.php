<?php
ob_start();
?>
<table class="table table-striped " id="memberList">
    <thead>
    <tr>
        <th>
            Name
        </th>
        <th>
            Teams
        </th>
    </tr>
    </thead>
    <?php foreach ($members as $member):?>
    <tr>
        <td><?=$member->name ?></td>
        <td>
            <?php foreach ($teamsByMember[$member->id] as $key => $teamByMember): ?>
                <?=($teamByMember->name). ($key == array_key_last($teamsByMember[$member->id]) ? "" : ", ") ?>
            <?php endforeach;?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>


<?php
$headerPath = "views/components/header.php";
$contenu = ob_get_clean();
$pageTitle = "Liste des membres";

require "views/Layout.php";
