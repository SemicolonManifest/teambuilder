<?php

namespace TeamBuilder\Controller;

use TeamBuilder\Model\Member;
use TeamBuilder\Model\Status;
use TeamBuilder\Model\Team;

class MemberController
{

    public function getCurrentUser() : Member
    {

        if (isset($_SESSION['member'])) {
            $user = unserialize($_SESSION['member']);
        } else {
            $this->Login();
            $user = unserialize($_SESSION['member']);
        }

        return $user;
    }

    public function showMemberList()
    {
        $user = $this->getCurrentUser();
        $members = Member::all();
        $teamsByMember = [];
        foreach ($members as $member) {
            $teamsByMember[$member->id] = $member->teams();
        }



        require 'views/MemberList.php';
    }

    public function showUserProfile()
    {
        $user = $this->getCurrentUser();
        $teams = $user->teams();


        require 'views/userProfile.php';
    }

    /** This login is a temporary auto-login
     *
     */
    public function Login(){
        require_once "controller/.testCreds.php";

        if (APP_USER_ID !== null) {
            $member = new Member();
            $member = Member::find(APP_USER_ID);
            $_SESSION['member'] = serialize($member);
        }
    }


}