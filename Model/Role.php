<?php
namespace TeamBuilder\Model;

class Role
{
    private $id;
    private $slug;
    private $description;

    public function create(): bool
    {

    }

    public function make(array $fields): Role
    {

    }

    public function find($id): ?Role
    {

    }

    public function all(): array
    {

    }

    public function save(): bool
    {

    }

    public function delete(): bool
    {

    }

    static function destroy($id): bool
    {

    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }


}