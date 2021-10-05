<?php
namespace TeamBuilder\Controller;
use TeamBuilder\Model\Member;


class SessionController
{
    public function __construct()
    {
    }

    public function createSession()
    {
        require_once "controller/.testCreds.php";


        if (APP_USER_ID !== null) {
            $member = new Member();
            $member = Member::find(APP_USER_ID);
            $_SESSION['member'] = serialize($member);
        }

    }

}