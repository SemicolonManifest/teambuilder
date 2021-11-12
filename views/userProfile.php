<?php
ob_start();
?>
    <div id="content">
        <div id="userInfos">
            Nom d'utilisateur: <?= $user->name ?>
            <br>
            Statut: <?= $user->status()->name ?>
            <br>
            Rôle: <?= $user->role()->name ?>

        </div>
        <div id="userTeams" class="table table-striped">
            <table>
                <thead>
                <tr>
                    <th colspan="3">Mes équipes</th>
                </tr>
                <tr>

                    <th>Nom</th>
                    <th>Membres</th>
                    <th>Capitaine</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($teams != []): ?>
                    <?php foreach ($teams as $team): ?>
                        <tr>
                            <td><?= $team->name ?></td>
                            <td><?= $team->memberCount() ?></td>
                            <td><?= $team->getCapitain() ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Vous ne faites parti d'aucune équipe</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
$headerPath = "views/components/header.php";
$contenu = ob_get_clean();
$pageTitle = "Mon profil";

require "views/Layout.php";
