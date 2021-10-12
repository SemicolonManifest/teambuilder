<?php

namespace TeamBuilder\Controller;

use TeamBuilder\Model\Member;
use TeamBuilder\Model\Team;

class MemberController
{

    public function getCurrentUser() : Member
    {

        if (isset($_SESSION['member'])) {
            $user = unserialize($_SESSION['member']);
        } else {
            $sessionConstroller = new SessionController();
            $sessionConstroller->createSession();
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


}