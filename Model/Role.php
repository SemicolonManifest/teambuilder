<?php

namespace TeamBuilder\Model;

use PDO;

class Role
{

    public $id = null;
    public $name;
    public $slug;

    public function __construct()
    {
    }

    public function create(): bool
    {
        $check = DB::selectOne("SELECT * FROM roles WHERE slug = :slug",PDO::FETCH_CLASS,Role::class, ['slug' => $this->slug]);

        if (!empty($check)) {
            return false;
        }

        $this->id = DB::insert("INSERT INTO roles(id, slug, name) VALUES (:id, :name, :slug)", ['id' => $this->id, 'name' => $this->name, 'slug' => $this->slug]);

        return true;
    }

    static function make(array $params)
    {
        $role = new Role();

        if (isset($params['id'])) {
            $role->id = $params['id'];
        }

        $role->name = $params['name'];
        $role->slug = $params['slug'];

        return $role;
    }

    static function all(): array
    {
        return DB::selectMany("SELECT * FROM roles ", []);

    }

    static function find(int $id): ?Role
    {
        $res = DB::selectOne("SELECT * FROM roles where id = :id",PDO::FETCH_CLASS,Role::class, ['id' => $id]);

        // Si il n'y a rien, return null
        if (!isset($res->name)) {
            return null;
        }


        return self::make(['id' => $res->id, 'name' => $res->name, 'slug' => $res->slug]);
    }

    public function save(): bool
    {
        $check = DB::selectOne("SELECT * FROM roles WHERE name = :name",PDO::FETCH_CLASS,Role::class, ['name' => $this->name]);
        // si il n'est pas vide, alors return false, car le nom sera dupliqué
        if (!empty($check)) {
            return false;
        }

        return DB::execute("UPDATE roles set name = :name, slug = :slug WHERE id = :id", ['id' => $this->id, 'name' => $this->name, 'slug' => $this->slug]);
    }

    public function delete(): bool
    {
        return self::destroy($this->id);
    }

    static function destroy(int $id): bool
    {
        try {
            DB::execute("DELETE FROM roles WHERE id = :id", ['id' => $id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}