<!doctype html>
<html>
<body>
Connecté en tant que <?= $user->name ?>
<table>
    <tr>
        <th>
            Name
        </th>
        <th>
            Teams
        </th>
    </tr>
    <?php foreach ($members as $member):?>
    <tr>
        <td><?=$member->name ?></td>
        <td>
            <?php foreach ($teamsByMember[$member->id] as $teamByMember): ?>
                <?=($teamByMember->name).", " ?>
            <?php endforeach;?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
