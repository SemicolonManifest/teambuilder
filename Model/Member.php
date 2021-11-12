<?php
namespace TeamBuilder\Model;
use \Exception;
use PDO;
use PDOException;

class Member
{
    public int $id;
    public string $name;
    public string $password;
    public int $role_id;
    public int $status_id;

    public function teams():array
    {
        return   DB::selectMany("select teams.id, teams.name, teams.state_id from teams join team_member on teams.id = team_member.team_id where member_id=:member_id",PDO::FETCH_CLASS,Team::class,["member_id"=>$this->id]);
    }

    public function create(): bool
    {
      if(isset($this->name) && isset($this->password) && isset($this->role_id) && isset($this->status_id)){
          try {
              $res = DB::insert("insert into teambuilder.members (name, password, role_id,status_id) values (:name, :password,:role_id,:status_id )", ["name" => $this->name, "password" => $this->password, "role_id" => $this->role_id,"status_id"=>$this->status_id]);
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
        $member->status_id = $fields['status_id'];
        if(isset($fields['id'])) $member->id =$fields['id'];
        return $member;
    }

    static function find($id): ?Member
    {
        $res = DB::selectOne("select * from members where id=:id;",PDO::FETCH_CLASS,Member::class,["id"=>$id]);
        return isset($res->name) ? $res : null ;
    }

    static function all(): array
    {
        return  DB::selectMany("select * from members order by name;",PDO::FETCH_CLASS,Member::class);
    }

    static function where($field,$value): array
    {
        return DB::selectMany("select * from members where $field = :value;",PDO::FETCH_CLASS,Member::class,["value"=>$value]);

    }

    public function save(): bool
    {
        if(isset($this->id) && isset($this->name) && isset($this->password) && isset($this->role_id) && isset($this->status_id)){
            try {
                DB::execute("Update members set name = :name, password = :password, role_id = :role_id, status_id = :status_id where id = :id", ["id"=>$this->id, "name" => $this->name, "password" => $this->password, "role_id" => $this->role_id,"status_id"=>$this->status_id]);
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

    public function status(): Status
    {
        return Status::find($this->status_id);
    }

    public function role()
    {
        return Role::find($this->role_id);
    }
}