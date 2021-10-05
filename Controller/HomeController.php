<?php
namespace TeamBuilder\Controller;

class HomeController
{

    public function __construct()
    {
    }

    public function showHome()
    {
        if(isset($_SESSION['member'])){
            $member = unserialize($_SESSION['member']);
        }else{
            $sessionConstroller = new SessionController();
            $sessionConstroller->createSession();
            $member = unserialize($_SESSION['member']);
        }

        require_once "views/HomePage.php";

    }

}