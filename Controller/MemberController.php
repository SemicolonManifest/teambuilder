<?php

namespace TeamBuilder\Controller;

use TeamBuilder\Model\Member;
use TeamBuilder\Model\Team;

class MemberController
{
    public function showMemberList(){
        $members = Member::all();
        $teamsByMember = [];
        foreach ($members as $member) {
            $teamsByMember[$member->id] = $member->teams();
        }

        if(isset($_SESSION['member'])){
            $user = unserialize($_SESSION['member']);
        }else{
            $sessionConstroller = new SessionController();
            $sessionConstroller->createSession();
            $user = unserialize($_SESSION['member']);
        }


        require 'views/MemberList.php';
    }

}