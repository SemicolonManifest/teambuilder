<?php

namespace TeamBuilder\Model;

use PDO;

class Status
{
    public int $id;
    public string $slug;
    public string $name;

    static function find($id): ?Status
    {
        $res = DB::selectOne("select * from status where id=:id;",PDO::FETCH_CLASS,Status::class,["id"=>$id]);
        return isset($res->name) ? $res : null ;
    }

}