<?php
namespace TeamBuilder\Controller;

class HomeController
{

    public function __construct()
    {
    }

    public function showHome()
    {
        $memberController = new MemberController();
        $user = $memberController->getCurrentUser();

        require_once "views/HomePage.php";
    }

}