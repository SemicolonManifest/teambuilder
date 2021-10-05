<?php

namespace TeamBuilder\Model;

class Team
{
    public int $id;
    public string $name;
    public int $state_id;

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
        $res = DB::selectOne("select * from teams where id=:id;",["id"=>$id]);
        return isset($res['name']) ? Team::make($res) : null ;
    }

    static function all(): array
    {
        $results = DB::selectMany("select * from teams;");
        $return = [];
        foreach ($results as $result){
            $return[] = Team::make($result);
        }
        return $return;
    }


    public function save(): bool
    {
        if(isset($this->id) && isset($this->name) && isset($this->state_id)){
            try {
                DB::execute("Update teams set name = :name, state_id = :state_id where id = :id", ["id"=>$this->id, "name" => $this->name, "state_id" => $this->state_id]);
                return true;
            }catch (Exception $e){
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