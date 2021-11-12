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
        <?php if ($teamsWhereMember != []): ?>
            <div id="userTeamsMember" class="table table-striped">
                <table>
                    <thead>
                    <tr>
                        <th colspan="3">Membre de</th>
                    </tr>
                    <tr>

                        <th>Nom</th>
                        <th>Membres</th>
                        <th>Capitaine</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($teamsWhereMember as $team): ?>
                        <tr>
                            <td><?= $team->name ?></td>
                            <td><?= $team->memberCount() ?></td>
                            <td><?= $team->getCaptain() ?></td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($teamsWhereCaptain != []): ?>
            <div id="userTeamsCaptain" class="table table-striped">
                <table>
                    <thead>
                    <tr>
                        <th colspan="3">Capitaine de</th>
                    </tr>
                    <tr>

                        <th>Nom</th>
                        <th>Membres</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($teamsWhereCaptain as $team): ?>
                        <tr>
                            <td><?= $team->name ?></td>
                            <td><?= $team->memberCount() ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <?php if($teamsWhereMember == [] && $teamsWhereCaptain == [] ): ?>
            L'utilisateur ne fait parti d'aucune équipe.
        <?php endif; ?>
    </div>

<?php
$headerPath = "views/components/header.php";
$contenu = ob_get_clean();

require "views/Layout.php";
