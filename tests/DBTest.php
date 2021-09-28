<?php

namespace TeamBuilder\Model;
use PHPUnit\Framework\TestCase;

final class DBTest extends TestCase
{


    protected function setUp(): void
    {
        $sqlscript = file_get_contents(dirname(__DIR__,1).'/doc/sql/teambuilder.sql');
        DB::execute($sqlscript);

    }

    public function testSelectMany(): void
    {
        $this->assertNotNull(DB::selectMany("SELECT * FROM roles"),"Select many roles test");
    }




}