<?php
namespace TeamBuilder\Model;
use \Exception;
use PDOException;

class Member
{
    public int $id;
    public string $name;
    public string $password;
    public int $role_id;

    public function teams():array
    {
        $results = DB::selectMany("select * from teams join team_member on teams.id = team_member.team_id where member_id=:member_id",["member_id"=>$this->id]);
        $return = [];
        foreach ($results as $result){
            $return[] = Team::make($result);
        }
        return $return;
    }

    public function create(): bool
    {
      if(isset($this->name) && isset($this->password) && isset($this->role_id)){
          try {
              $res = DB::insert("insert into teambuilder.members (name, password, role_id) values (:name, :password,:role_id )", ["name" => $this->name, "password" => $this->password, "role_id" => $this->role_id]);
              $this->id = $res;
              return isset($this->id);
          }catch (PDOException $e){
              return false;
          }
      }else{
          return false;
      }

    }

    static function make(array $fields): Member
    {
        $member = new Member();
        $member->name = $fields['name'];
        $member->password = $fields['password'];
        $member->role_id = $fields['role_id'];
        if(isset($fields['id'])) $member->id =$fields['id'];
        return $member;
    }

    static function find($id): ?Member
    {
        $res = DB::selectOne("select * from members where id=:id;",["id"=>$id]);
        return isset($res['name']) ? Member::make($res) : null ;
    }

    static function all(): array
    {
        $results = DB::selectMany("select * from members;");
        $return = [];
        foreach ($results as $result){
            $return[] = Member::make($result);
        }
        return $return;
    }

    static function where($field,$value): array
    {
       $res = DB::selectMany("select * from members where $field = :value;",["value"=>$value]);
       $return = [];
       foreach ($res as $reslut){
           $return[] = Member::make($reslut);
       }
        return $return;
    }

    public function save(): bool
    {
        if(isset($this->id) && isset($this->name) && isset($this->password) && isset($this->role_id)){
            try {
                DB::execute("Update members set name = :name, password = :password, role_id = :role_id where id = :id", ["id"=>$this->id, "name" => $this->name, "password" => $this->password, "role_id" => $this->role_id]);
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
            DB::execute("DELETE FROM members WHERE id=:id",["id"=>$id]);
            return true;
        }catch (PDOException $e){
            return false;
        }
    }
}