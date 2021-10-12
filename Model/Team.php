<?php

namespace TeamBuilder\Model;

use PDOException;
use function PHPUnit\Framework\returnArgument;

class Team
{
    public int $id;
    public string $name;
    public int $state_id;

    public function getCapitain(){
        $result = DB::selectOne(Team::class,"select * from members join team_member on members.id = team_member.member_id where team_id=:team_id and is_captain=1",["team_id"=>$this->id]);
    }

    public function members() :array
    {
        return DB::selectMany(Member::class,"select * from members join team_member on members.id = team_member.member_id where team_id=:team_id",["team_id"=>$this->id]);
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
        $res = DB::selectOne(Team::class,"select * from teams where id=:id;",["id"=>$id]);
        return isset($res->name) ? $res : null ;
    }

    static function all(): array
    {
        return  DB::selectMany(Team::class,"select * from teams;");

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