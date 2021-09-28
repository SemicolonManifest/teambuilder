<?php

namespace TeamBuilder\Model;
use \Exception;

class Member
{
    public int $id;
    public string $name;
    public string $password;
    public int $role_id;

    public function create(): bool
    {
      if(isset($this->name) && isset($this->password) && isset($this->role_id)){
          try {
              $res = DB::insert("insert into teambuilder.members (name, password, role_id) values (:name, :password,:role_id )", ["name" => $this->name, "password" => $this->password, "role_id" => $this->role_id]);
              $this->id = $res;
              return isset($this->id);
          }catch (Exception $e){
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
        return DB::selectMany("select * from members;");
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

        return false;
    }

    static function destroy($id): bool
    {
        return false;
    }
}