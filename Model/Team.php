<?php

namespace TeamBuilder\Model;

use PDO;
use PDOException;
use function PHPUnit\Framework\returnArgument;

class Team
{
    public int $team_id;
    public string $name;
    public int $state_id;

    public function getCaptain()
    {
        return DB::selectOne("select members.name from members join team_member on members.id = team_member.member_id where team_id=:team_id and is_captain=1",PDO::FETCH_ASSOC,null,["team_id"=>$this->id])["name"];
    }

    public function members() :array
    {
        return DB::selectMany("select * from members join team_member on members.id = team_member.member_id where team_id=:team_id",PDO::FETCH_CLASS,Member::class,["team_id"=>$this->id]);
    }

    public function memberCount() : int
    {
        return DB::selectOne("select count(team_member.member_id) count from team_member where team_id = :id;",PDO::FETCH_ASSOC,null,["id"=>$this->id])['count'];
    }



    public function create(): bool
    {
        if(isset($this->name)){
            try {
                $res = DB::insert("insert into teambuilder.teams (name) values (:name)", ["name" => $this->name]);
                $this->id = $res;
                return isset($this->id);
            }catch (PDOException $e){
                return false;
            }
        }else{
            return false;
        }

    }

    static function make(array $fields): Team
    {
        $team = new Team();
        $team->name = $fields['name'];

        if(isset($fields['id'])) $team->id =$fields['id'];
        if(isset($fields['state_id'])) $team->state_id =$fields['state_id'];

        return $team;
    }

    static function find($id): ?Team
    {
        $res = DB::selectOne("select * from teams where id=:id;",PDO::FETCH_CLASS,Team::class,["id"=>$id]);
        return isset($res->name) ? $res : null ;
    }

    static function all(): array
    {
        return  DB::selectMany("select * from teams;",PDO::FETCH_CLASS,Team::class);

    }


    public function save(): bool
    {
        if(isset($this->id) && isset($this->name) && isset($this->state_id)){
            try {
                DB::execute("Update teams set name = :name, state_id = :state_id where id = :id", ["id"=>$this->id, "name" => $this->name, "state_id" => $this->state_id]);
                return true;
            }catch (PDOException $e){
                return false;
            }
        }else{
            return false;
        }

    }

    public function delete(): bool
    {
        return self::destroy($this->id);
    }

    static function destroy($id): bool
    {
        try{
            DB::execute("DELETE FROM teams WHERE id=:id",["id"=>$id]);
            return true;
        }catch (PDOException $e){
            return false;
        }
    }
}