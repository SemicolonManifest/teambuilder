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
            $connectedUser = unserialize($_SESSION['member']);
        } else {
            $this->Login();
            $connectedUser = unserialize($_SESSION['member']);
        }

        return $connectedUser;
    }

    public function showMemberList()
    {
        $connectedUser = $this->getCurrentUser();

        $members = Member::all();
        $teamsByMember = [];
        foreach ($members as $member) {
            $teamsByMember[$member->id] = $member->teams();
        }



        require 'views/MemberList.php';
    }

    public function showOwnProfile()
    {
        $connectedUser = $this->getCurrentUser();
        $user = $this->getCurrentUser();
        $teamsWhereMember = $user->teamsWhereMember();
        $teamsWhereCaptain = $user->teamsWhereCaptain();


        $pageTitle = "Mon profil";
        require 'views/userProfile.php';
    }

    public function showUserProfile()
    {
        $connectedUser = $this->getCurrentUser();
        $userId = $_GET["id"];
        $user = Member::find($userId);
        $teamsWhereMember = $user->teamsWhereMember();
        $teamsWhereCaptain = $user->teamsWhereCaptain();


        $pageTitle = "Profil de ".$user->name;
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