<?php
namespace TeamBuilder;
use TeamBuilder\Controller\HomeController;
use TeamBuilder\Controller\MemberController;


session_start();
date_default_timezone_set('Europe/Zurich');
require_once 'vendor\autoload.php';

$homeController = new HomeController();
$memberController = new MemberController();
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'home':
            $homeController->showHome();
            break;
        case 'memberList':
            $memberController->showMemberList();
            break;
        default:
            $homeController->showHome();
    }
}else{
    $homeController->showHome();
}


